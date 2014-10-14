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

   //-----------------------------------
   // prepare to randomize the existing imgs .... 
   // for news which which dones not contain its own img.
      $dir    = 'img/newsimg/static/';
      $files = scandir($dir);
      unset($files[0]);
      unset($files[1]);
      shuffle($files);
      $rand_img_id = 0;
   //-----------------------------------

   
$log_data = new Logging();
$log_data->lfile($config['log']['dir'].'data.log');

   // number of item
   $item_count = 0;


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


// $log_data->lwrite(  PHP_EOL.
               print_r($item->feed->data['items']/**/[0]/**/->data['child']['']);//.
               print_r($item->feed->data['items']/**/[0]/**/->data['child']['http://www.bing.com:80/news/search?format=rss&q='.$symbol]);//.
               // print_r($item->feed->data['items']/**/[0]/**/->data['child']['']);//.
//                PHP_EOL
//             );
die;


         $j=-1;

         // extract current item array & store into db
         foreach($item->feed->data['ordered_items'] as $val){
            $j++;
            if($j>=5){break;}

            $item_count++;
               // randomized img from stored imgs.
            $subdir = ($item_count%2?'one':'two');

            $data = ['symbol'      => $symbol,
                     'title'       => $val->data['child']['']['title'][0]['data'],
                     'url'         => $val->data['child']['']['link'][0]['data'],
                     'description' => $val->data['child']['']['description'][0]['data'],
                     'datetime'    => date("Y-m-d H:i:s",$val->data['date']['parsed']),
                  ];


            //the url decoded
            $data['url'] = urldecode(
                                       explode( "=",
                                                explode( "&",
                                                         explode(
                                                                  "?",
                                                                  $data['url']
                                                               )[1]
                                                      )[3]
                                             )[1]
                                    );


   
            // img of current feed
            if(isset($val->data['child']
                                 ['http://www.bing.com:80/news/search?format=rss&q='.$symbol]
                                 ['Image'])){
               //img from feed
               $img_url = $val->data['child']
                                 ['http://www.bing.com:80/news/search?format=rss&q='.$symbol]
                                 ['Image'][0]['data'];

               //corrected img url
               $img_url = urldecode( explode('&', explode("?q=",$img_url)[1] )[0] ); 
            

               //---------------------
               //download & store external img. into our server

                  // path of img to store
                  $img_path = dirname(dirname(__FILE__)).'/img/newsimg/'.$subdir.'/';

                  // rename img to integer
                  $num_of_files = iterator_count(
                                       new FilesystemIterator( $img_path, 
                                                               FilesystemIterator::SKIP_DOTS
                                                            )
                                       )+1;


                  // file extension
                  $ext = @$config['extensions'][exif_imagetype($img_url)];
                  if( ! $ext ){
                                    // $rand_img_id is from lines 102~111
                     $img_localurl='static/'.$files[$rand_img_id];
                     $rand_img_id++;
                     $rand_img_id =  ($rand_img_id > count($files))? 0 : $rand_img_id;

                  }else{


                  $img = $img_path.$num_of_files.'.'.$ext;

                  // set url of img
                  $img_localurl = $subdir.'/'.$num_of_files.'.'.$ext;

                  // store img from external url to local server
                  copy($img_url, $img);

                  // resize img to 480x320 
                  $image = new SimpleImage(); 
                  $image->load($img); 
                  $image->resize(480,320); 
                  $image->save($img);

               }

               //---------------------

            }else{

               // $rand_img_id is from lines 102~111
               $img_localurl='static/'.$files[$rand_img_id];
               $rand_img_id++;
               $rand_img_id =  ($rand_img_id > count($files))? 0 : $rand_img_id;

            }
            // set the img url to our data
            $data['image'] = $img_localurl;

            print_r($data);
            // die;

            // store in db
            $db->insert($config['db']['table_news'],$data);
         }
      }
   }

//==============================================================================



