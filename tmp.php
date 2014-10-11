<?php
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
//========================


$symbol = $_GET['symbol'];
// $symbol = 'AAPL';

//get the simplepie library
require_once('quote/inc/simplepie.inc');

//grab the feed
$feed = new SimplePie();

$feed->set_feed_url(array(
	'http://www.bing.com/news/search?q='.$symbol.'&format=rss',
	'http://articlefeeds.nasdaq.com/nasdaq/symbols?symbol='.$symbol,
));


//enable caching
$feed->enable_cache(true);

//provide the caching folder
$feed->set_cache_location('cache');

//set the amount of seconds you want to cache the feed
$feed->set_cache_duration(1800);

//init the process
$feed->init();

//let simplepie handle the content type (atom, RSS...)
$feed->handle_content_type();
if ($feed->error): ?>
	<p><?= $feed->error?></p>
	<?php die;?>
<?php endif; ?>




<ul>

<?php 	$i=-1; 
		foreach($feed->get_items() as $item): 

			if($i == 5){break;} 
			$i++; 
	

			$x = $item->feed->data['child']['']
									['rss'][0]['child']['']['channel'][0]['child']['']
									['item'][$i]
									['child']
									['http://www.bing.com:80/news/search?q='.$symbol.'&format=rss'];

			if(isset($x['Image'])){

				$x = $x['Image'][0]['data'];

				$img_url = urldecode( explode('&', explode("?q=",$x)[1] )[0] ); 
				$img_path = dirname(__FILE__).'/img/newsimg/'.($i%2?'one':'two').'/';

				$num_of_files = iterator_count(new FilesystemIterator($img_path, FilesystemIterator::SKIP_DOTS)) ;
				$img = $img_path.$num_of_files.'.'. pathinfo($img_url)['extension'];

				$img_localurl = 'http://localhost:8080'.
								'/img/newsimg/'.($i%2?'one':'two').'/'
								.$num_of_files.'.'. pathinfo($img_url)['extension'];

				copy($img_url, $img);



				// resize img
				Img_Resize($img,480,320);


// 				// $img = new Imagick($img);
// 				// $img->scaleImage(300, 0);

			}else{
				$img_url='none';
				$img_localurl='';
			}

// echo PHP_EOL.$img_localurl.PHP_EOL;
// continue;
// die;

echo '<hr/>';
echo 'url : '.urldecode(explode("=",explode("&",$item->get_link())[3])[1]);
echo '<br/>';
echo 'date : '.$item->get_date('D, j M Y');
echo '<br/>';
echo 'title : '.$item->get_title();
echo '<br/>';
echo 'desc : '.$item->get_description();
echo '<br/>';
echo 'server img path : '.$img;
echo '<br/>';
echo 'img src : '.$img_url;
echo '<br/>';
echo 'our img : '.$img_localurl;
echo '<hr/>';
echo PHP_EOL;

endforeach; ?>

</ul>