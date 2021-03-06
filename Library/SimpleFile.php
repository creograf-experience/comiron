<?php
 
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleFile {
 
   var $file;
   var $file_type;
 
/*   function createfromfile($file) {
	  $this->file=$file;
   }
   
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->file_type = $file_info[2];
   }
*/   
   function save($tempFile, $filename, $permissions=null) {
      move_uploaded_file($tempFile,$filename);
      
      if( $permissions != null) {
      	chmod($filename,$permissions);
      }
      
   }
   
   function output($file_type) {
      //   imagepng($this->image);
   }
}
?>