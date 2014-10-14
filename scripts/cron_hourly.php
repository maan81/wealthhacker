<?php

//==============================================================================
// Includes
   
   // path to root of the proj
   $src = dirname(dirname(__FILE__));

   require($src.'/config/config.php');
   require($src.'/include/db.php');
   require($src.'/quote/inc/simplepie.inc');
   include($src.'/include/functions.php');
   include($src.'/include/logging.php');     // loging class
   include($src.'/include/simpleimage.php'); // img resizing

//==============================================================================



//==============================================================================
// Init

   // Logging class initialization
   $log = new Logging();

   // set path and name of log file
   $log->lfile($config['log']['dir'].$config['log']['file']);

   $log->lwrite('Hourly cronjob');

   // init db access
   $db = new Database($config['db']);

//==============================================================================




//==============================================================================
// Delete old (unnecessary) data


   // generate where clause
   $datetime = new DateTime(null, new DateTimeZone('UTC'));
   $datetime->modify($config['db']['del']);
   $where_clause = ' AND datetime<="'.$datetime->format('Y-m-d H:i:s').'"';


   $data = $db->get($config['db']['table_news'], $where_clause);
// _print_r($data,false);
// die;
// _print_r($db->sql,false);
   // get the ids of the rows to be deleted
   $ids = [];
   foreach($data as $key=>$val){
      $ids[] = $val['id'];
   }


   // generate where clause from ids
   $where_clause = ' AND id IN ('.implode(',', $ids).')';

   // delete old rows having the id
   $db->del($config['db']['table_news'], $where_clause);

// _print_r($db->sql);
   //delete old imgs of the ids
   foreach($data as $key=>$val){

      //but dont delete the no-image
      if($val['image']=='0.jpg') continue;
// _print_r($val['image'],false);
      if(unlink($src.'/img/newsimg/'.$val['image'])){
echo PHP_EOL;
print_r($val['image'].' : Deleted');
      }else{
echo PHP_EOL;
print_r($val['image'].' : NOT Deleted');
      }
   }

//==============================================================================

echo PHP_EOL;
// die;

//==============================================================================
// Get new feed & update db & imgs.

   //init feed
   $feed = new SimplePie();

   //enable caching
   $feed->enable_cache(true);

   //set the amount of seconds you want to cache the feed
   $feed->set_cache_duration(1800);

   //provide the caching folder
   $feed->set_cache_location('cache');


   // prepare to randomize the existing imgs .... 
   // for news which which dones not contain its own img.
   $dir    = 'img/newsimg/static/';
   $files = scandir($dir);
   unset($files[0]);
   unset($files[1]);
   shuffle($files);
   $rand_img_id = 0;

   
$log_data = new Logging();
$log_data->lfile($config['log']['dir'].'data.log');


   //grab feed for each symbol & push into db
   foreach ($config['symbols'] as $symbol) {

      $feed->set_feed_url(array(
         $config['feed_url'].$symbol,
      ));


      //init the process
      $feed->init();

      //let simplepie handle the content type (atom, RSS...)
      $feed->handle_content_type();
      if ($feed->error){ 
         $log->lwrite('Error accessing feed : '.$config['feed_url'].$symbol);
         $log->lwrite('Error : '.$feed->error);
         die;
      }


      // loop thu obtained feed
      $i=-1; 
      foreach($feed->get_items() as $item){
         $i++; 
         if($i == 5){break;} 


$log_data->lwrite(  PHP_EOL.
               print_r($item->feed->data['ordered_items'],true).
               PHP_EOL
            );
die;


         $subdir = ($i%2?'one':'two');

//          // extract current feed array
//          $x = $item->feed->data['child']['']
//                                  ['rss'][0]
//                                  ['child']['']
//                                  ['channel'][0]
//                                  ['child']['']
//                                  ['item'][$i]
//                                  ['child']
//                                  [$config['feed_url'].$symbol];

//          // img of current feed
//          if(isset($x['Image'])){

//             $x = $x['Image'][0]['data'];

//             // img url from the feed
//             $img_url = urldecode( explode('&', explode("?q=",$x)[1] )[0] ); 

//             // path of img to store
//             $img_path = dirname(dirname(__FILE__)).'/img/newsimg/'.$subdir.'/';

//             // rename img
//             $num_of_files = iterator_count(
//                                  new FilesystemIterator( $img_path, 
//                                                          FilesystemIterator::SKIP_DOTS
//                                                       )
//                                  ) ;

//             // file extension
//             $ext = $config['extensions'][exif_imagetype($img_url)];

//             $img = $img_path.$num_of_files.'.'.$ext;

//             // set url of img
//             $img_localurl = $subdir.'/'.$num_of_files.'.'.$ext;


//             // store img from external url to local server
//             copy($img_url, $img);
            
// echo PHP_EOL;
// print_r($img_url);
// echo PHP_EOL;
// print_r($img);

//             // resize img to 480x320 
//             $image = new SimpleImage(); 
//             $image->load($img); 
//             $image->resize(480,320); 
//             $image->save($img);

//          // no img present in feed - use rand. imgs from seperate directory
//          }else{
            

// echo PHP_EOL;
// print_r('---');
// echo PHP_EOL;
// print_r('---');
//             // $img_url='';
//             $img_localurl='static/'.$files[$rand_img_id];
//             $rand_img_id++;
//          }


//          // init data to store
//          $data = ['symbol'      => $symbol,
//                   'title'       => $item->get_title(),
//                   'description' => $item->get_description(),
//                   'url'         => urldecode(
//                                           explode( "=",
//                                                    explode( "&",
//                                                             $item->get_link()
//                                                       ) [3]
//                                                 ) [1]
//                                        ),
//                   'datetime'    => $item->get_date('Y-m-d'),
//                   'image'       => $img_localurl,
//                ]; 
// echo PHP_EOL;
// print_r($data);
// echo PHP_EOL;

//          // store in db
//          $db->insert($config['db']['table_news'],$data);

      }

   }

//==============================================================================



