<?php
/**
 send mail
 */

class MailException extends Exception {
}
;

/**
 *
 * @author sn
 *
 * $is_ok=$mail->send_mail(array(
 * 		"from"=>"...",
 * 		"to"=>"...",
 * 		"title"=>"...",
 * 		"body"=>"...",
 * 		"attach"=>"filename"
 * ));
 *
 */
class CMail {
    //const
    private $host = "mail.comiron.com";//"80.255.89.162";
    private $from = "no-reply@comiron.com";
    private $password = "ksX95tkv";

/*  public function send_mail($params) {
  	$filename=(isset($params['attach'])?$params['attach']:false);
  	$from=(isset($params['from'])?$params['from']:false);
  	$to=(isset($params['to'])?$params['to']:false);
  	$body=(isset($params['body'])?$params['body']:false);
  	$title=(isset($params['title'])?$params['title']:false);

  	if($filename){
  		$f         = fopen($filename,"rb");
  	}
  	$un        = strtoupper(uniqid(time()));
  	$head      = "From: $from\n";
#  	$head     .= "To: $to\n";
  	$head     .= "Subject: $title\n";
  	$head     .= "X-Mailer: Comiron.com mail tool\n";
  	$head     .= "Reply-To: $from\n";
  	$head     .= "Mime-Version: 1.0\n";
  	$head     .= "Content-Type:multipart/mixed;";
  	$head     .= "boundary=\"----------".$un."\"\n\n";

  	$zag       = "------------".$un."\nContent-Type:text/html;\n";
  	$zag      .= "Content-Transfer-Encoding: 8bit\n\n$body\n\n";
  	$zag      .= "------------".$un."\n";

  	if($filename){
	  	$zag      .= "Content-Type: application/octet-stream;";
	  	$zag      .= "name=\"".basename($filename)."\"\n";
	  	$zag      .= "Content-Transfer-Encoding:base64\n";
	  	$zag      .= "Content-Disposition:attachment;";
	  	$zag      .= "filename=\"".basename($filename)."\"\n\n";
	  	$zag      .= chunk_split(base64_encode(fread($f,filesize($filename))))."\n";
  	}

  	if (!@mail("$to", "$title", $zag, $head))
#  	if (!mail("$to", "$title", $zag, $head))
  		return 0;
  	else
  		return 1;

  }*/

  public function send_mail($params) {
	$filename=(isset($params['attach'])?$params['attach']:false);
	//$from=(isset($params['from'])?$params['from']:false);
	$to=(isset($params['to'])?$params['to']:false);
	$body=(isset($params['body'])?$params['body']:false);
	$title=(isset($params['title'])?$params['title']:false);
  $filepath=(isset($params['filepath'])?$params['filepath']:false);
	$filename=(isset($params['filename'])?$params['filename']:false);

  $filepath2=(isset($params['filepath2'])?$params['filepath2']:false);
	$filename2=(isset($params['filename2'])?$params['filename2']:false);

	require_once('class.phpmailer.php');
	require_once('class.smtp.php');

	$email = new PHPMailer();
  // $email->addCustomHeader("Content-type: text/html");
    $email->IsSMTP();
    $email->CharSet = 'UTF-8';
    $email->SMTPAuth   = true;
    $email->SMTPSecure = 'none';
//    $email->SMTPDebug  = true;
    $email->Port       = 25;
    $email->From       = $this->from;
    $email->Username	= $this->from;
    $email->Host      = $this->host;
//    $email->Debug     = true;
    $email->Password  = $this->password;
    $email->FromName  = 'Comiron.com';
    $email->Subject   = $title;
    $email->Body      = $body;
    $email->AddAddress( $to );

//var_dump($email);
//echo $body;
  if($filepath && $filename){
  //echo $filepath." ".$filename;
    $email->AddAttachment( $filepath , $filename );
  }
  if($filepath2 && $filename2){
  //echo $filepath." ".$filename;
    $email->AddAttachment( $filepath2 , $filename2 );
  }

	return $email->Send();
  }

  public function send_mail_html($params) {
    $filename=(isset($params['attach'])?$params['attach']:false);
    $from=(isset($params['from'])?$params['from']:false);
    $to=(isset($params['to'])?$params['to']:false);
    $body=(isset($params['body'])?$params['body']:false);
    $title=(isset($params['title'])?$params['title']:false);
    $filepath=(isset($params['filepath'])?$params['filepath']:false);
    $filename=(isset($params['filename'])?$params['filename']:false);

    require_once('class.phpmailer.php');

    $email = new PHPMailer(true);
    $email->IsSMTP();
    $email->addCustomHeader("Content-type: text/html");
    $email->CharSet = 'UTF-8';
    $email->SMTPAuth   = true;
    $email->From      = $this->from;
    $email->Host      = $this->host;
    $email->Debug     = true;
    $email->Password  = $this->password;
    $email->FromName  = 'Comiron.com';
    $email->Subject   = $title;
    $email->Body      = $body;
    $email->AddAddress( $to );
  //echo $body;
    if($filepath && $filename){
    //echo $filepath." ".$filename;
      $email->AddAttachment( $filepath , $filename );
    }
//    var_dump($email);

    return $email->Send();
    }
}
