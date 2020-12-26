<?php

class ModelException extends Exception {
}
;

/**
 * The Model abstraction. This impliments a transparent caching and cache dependency
 * tracking mechanism. To use this rename your function to load_foo, and put 'foo'
 * in the $cachable array in your class like:
 * class myModel extends Model {
 * 	public $cachable = array('foo');
 * 	public function load_foo($bar) {
 * 		return 'bar: '.$bar;
 * 	}
 * }
 *
 * Then to call this cached model in your controller you would do:
 * 	$my = $this->model('my');
 * 	$bar = $my->foo('hello world');
 *
 * And the model class takes care of all the magic for you :-)
 *
 * NOTE: the cache class used has build in cache stampeding protection,
 * so no need to do that in here.
 */
class Model {
  // A local scope cache per model, every cache hit is stored in
  // here so the next request doesn't have to fetch it
  private $local_cache = array();
  // A LIFO call stack to trace recursive dependencies
  private $call_stack = array();
  // The dependency maps (loaded on the demand, aka lazy loading)
  private $dep_map = array();
  // Model Classes override this and list the function names that can be cached
  // if a function name is not in this array, it won't be cached
  // (useful for things that would be inefficient to cache like searches etc)
  public $cachable = array();

  public function __destruct() {
    global $cache;
    // dep_map holds only modified entries, so store each entry
    if (is_object($cache)) {
      foreach ($this->dep_map as $key => $new_deps) {
        // retrieve the most uptodate map and merge them with our results
        if (($existing_deps = $cache->get($key)) !== false) {
          foreach ($existing_deps as $existing_dep) {
            if (! in_array($existing_dep, $new_deps)) {
              $new_deps[] = $existing_dep;
            }
          }
        }
        $cache->set(md5($key), $new_deps);
      }
    }
  }

  /**
   * Invalidate (remove) the cache a certain type-id relationship
   *
   * @param string $type the type (ie 'people')
   * @param string $id the ID of this entity
   */
  public function invalidate_dependency($type, $id) {
    global $cache;
    $key = $type . '_deps:' . $id;
    if (($data = $cache->get(md5($key))) !== false) {
      try {
        $cache->delete($key);
      } catch (CacheException $e) {}
      foreach ($data as $dep) {
        try {
          $cache->delete($dep);
        } catch (CacheException $e) {}
      }
    }
  }

  /**
   * Adds a dependency to your dependency chain, call this using $type = 'data_type', $id = id of the entity:
   *	$this->add_dependency('people', '$user_id);
   * Remember to call this multiple times if multiple id's are involved:
   * function load_friends() {
   * 	//.. get friends from db
   * 	foreach ($friends as $id) {
   * 		$this->add_dependency('people', $id);
   * 	}
   * @param string $type the data type, all dep checking is done within it's own type (ie: 'people')
   * @param string $id the ID of this entity, ie '1'
   */
  public function add_dependency($type, $id) {
    global $cache;
    $key = $type . '_deps:' . $id;
    // only load the dep map once per key, lazy loading style
    if (! isset($this->dep_map[$key])) {
      if (($deps = $cache->get(md5($key))) !== false) {
        $this->dep_map[$key] = $deps;
      } else {
        $this->dep_map[$key] = array();
      }
    }
    // add depedency relationship for the entire call stack (catches recursive dependencies)
    foreach ($this->call_stack as $request) {
      if (! in_array($request, $this->dep_map[$key])) {
        $this->dep_map[$key][] = $request;
      }
    }
  }

  /**
   * Returns the current top level request
   *
   * @return string request id
   */
  private function current_request() {
    return $this->call_stack[count($this->call_stack) - 1];
  }

  /**
   * Adds a request to the stack
   *
   * @param string $key the __call key which is the md5 of the method + its params
   */
  private function push_request($key) {
    $this->call_stack[count($this->call_stack)] = $key;
  }

  /**
   * Removes the most recent request from the top of the stack
   *
   */
  private function pop_request() {
    unset($this->call_stack[count($this->call_stack) - 1]);
  }

  /**
   * Magic __call function that is called for each unknown function, which checks if
   * load_{$method_name} exists, and wraps caching around it
   *
   *
   * @param string $method method name
   * @param array $arguments arguments (argv) array
   * @return unknown data returned from cache, or from load_{$method_name} function
   */
  public function __call($method, $arguments) {
    global $cache;
    $key = md5($method . serialize($arguments));
    // prevent double-loading of data
    if (isset($this->local_cache[$key])) {
      return $this->local_cache[$key];
    }
    if (in_array($method, $this->cachable)) {
      //if (in_array($method, $this->cachable) && false) { // use this line instead to disable caching
      $data = $cache->get($key);
      if ($data !== false) {
        return $data;
      } else {
        $function = "load_{$method}";
        if (is_callable(array($this, $function))) {
          // cache operations might call other cache operations again, so for dep tracking we need a call stack (LIFO style)
          $this->push_request($key);
          $data = call_user_func_array(array($this, $function), $arguments);
          $cache->set($key, $data);
          $this->local_cache[$key] = $data;
          $this->pop_request();
          return $data;
        } else {
          throw new ModelException("Invalid method: load_{$method}");
        }
      }
    } else {
      // non cachable information, always do a plain load
      $function = "load_{$method}";
      if (is_callable(array($this, $function))) {
        $data = call_user_func_array(array($this, $function), $arguments);
        $this->local_cache[$key] = $data;
        return $data;
      } else {
        throw new ModelException("Invalid method: load_{$method}");
      }
    }
    return false;
  }
  
  public function get_model($modelname) {
  	include_once PartuzaConfig::get('models_root') . "/$modelname/$modelname.php";
  	$modelname = "{$modelname}Model";
  	return new $modelname();
  }
  
  public function get_cur_lang(){
  	if(isset($_SESSION['lang']) and in_array($_SESSION['lang'],PartuzaConfig::get('languages'))){
  		//$_SESSION['lang']=$person['lang'];
  		return $_SESSION['lang'];
  	}
  	$_SESSION['lang']=PartuzaConfig::get('language');
  	//echo $_SESSION['lang'];
  	return $_SESSION['lang'];
  }

  //вызов REST API: GET, POST==PUT, DELETE
  public function api($method, $shop_id){

      if($method == "DELETE"){
        return $this->DELETEme($_REQUEST['id'], $shop_id);
      }

      switch ($method) {
          case "GET":
            if(isset($_REQUEST['list'])){
              return $this->GETlist($shop_id);
            }else {
              $data = $this->GET($_REQUEST['id'], $shop_id);
              if($data['shop_id'] == $shop_id){
                return $data;
              }
              return array("status"=>"fail", "error"=>"Object is not from your shop");
            }
            break;
          case 'POST':
            //проверить права
            if($_REQUEST['id']){
                $data = $this->GET($_REQUEST['id'], $shop_id);
                //echo var_dump($data);
                if($data['shop_id'] != $shop_id){
                  return array("status"=>"fail", "error"=>"Object is not from your shop");
                }
            }
            return $this->POST($shop_id);
            break;
          case 'PUT':
            return $this->POST($shop_id);
            break;

      }
  }

  public function get_controller($ctrlname) {
    include_once PartuzaConfig::get('controllers_root') . "/$ctrlname/$ctrlname.php";
    $ctrlname = "{$ctrlname}Controller";
    return new $ctrlname();
  }

  //update table where id=? and shop_id=$shop_id и вернуть json
  /*public function POST($shop_id){
  }*/

  //delete from table id=? and shop_id=$shop_id и вернуть json или $this->show
  public function DELETEme($id, $shop_id){
    global $db;
    $id = $db->addslashes($id);

    //из своего ли магазина объект
    $res = $db->query("select shop_id from ".$this->table." where id=$id" );
    $res = $db->fetch_row($res);
    $shop_id_db = (isset($res[0])?$res[0]:0);
    if($shop_id == $shop_id_db){
      $this->delete($id);
      return array("status"=>"ok");
    }

    return array("status"=>"fail", "error"=>"Object is not from your shop");      
  }

}
