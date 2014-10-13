<?php

/**
 * Resize image
 *
 * @param string -- current img, including its path
 * @param int ----- width of resultalt img
 * @param int ----- height of resultant img
 */
function Img_Resize($path,$rs_width,$rs_height) {

   $x = getimagesize($path);            
   $width  = $x['0'];
   $height = $x['1'];

   // $rs_width  = $width / 2;//resize to half of the original width.
   // $rs_height = $height / 2;//resize to half of the original height.

   switch ($x['mime']) {
      case "image/gif":
         $img = imagecreatefromgif($path);
         break;
      case "image/jpeg":
         $img = imagecreatefromjpeg($path);
         break;
      case "image/png":
         $img = imagecreatefrompng($path);
         break;
   }

   $img_base = imagecreatetruecolor($rs_width, $rs_height);
   imagecopyresized($img_base, $img, 0, 0, 0, 0, $rs_width, $rs_height, $width, $height);

   $path_info = pathinfo($path);    
   switch ($path_info['extension']) {
      case "gif":
         imagegif($img_base, $path);  
         break;
      case "jpeg":
         imagejpeg($img_base, $path);  
         break;
      case "png":
         imagepng($img_base, $path);  
         break;
   }

}



function validate($str){
	return true;
}


/**
 * Update symbol count
 *
 * @param int ---- symbol
 */
function update_symbol_count($symbol){

   require('config/config.php');
   require('include/db.php');


   // init db access
   $db = new Database($config['db']);

}