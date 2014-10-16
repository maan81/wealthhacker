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

   // get the ids of the rows to be deleted
   $ids = [];
   foreach($data as $key=>$val){
      $ids[] = $val['id'];
   }


   // generate where clause from ids
   $where_clause = ' AND id IN ('.implode(',', $ids).')';

   // delete old rows having the id
   $db->del($config['db']['table_news'], $where_clause);

   //delete old imgs of the ids
   foreach($data as $key=>$val){

      //but dont delete the no-image
      if(strpos($val['image'],'static') !== false) {
         continue;
      }

      unlink($src.'/img/newsimg/'.$val['image']);

   }

   print_r('Deleted Imgs : ');
   print_r($data);

//==============================================================================

// echo PHP_EOL;
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
      $files = scandir($src.'/'.$dir);
      unset($files[0]);
      unset($files[1]);
      shuffle($files);
      $files = array_values($files);
      $rand_img_id = 0;
   //-----------------------------------


   // number of item
   $item_count = 0;


   //grab feed for each symbol & process & push into db
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

            // current item
            $val = $item->feed->data['items'][$i]->data;

            // current subdir
            $subdir = ($i%2?'one':'two');

            $data = ['symbol'      => $symbol,
                     'title'       => $val['child']['']['title'][0]['data'],
                     'url'         => $val['child']['']['link'][0]['data'],
                     'description' => $val['child']['']['description'][0]['data'],
                     'datetime'    => date("Y-m-d H:i:s",$val['date']['parsed']),
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

            // do not store & process if current item is already in db
            $tmp = $db->get($config['db']['table_news'],' AND url="'.$data['url'].'" ');
            if(count($tmp)) continue;


   
            // img of current feed
            if(isset($val['child']['http://www.bing.com:80/news/search?format=rss&q='.$symbol]['Image'])){

               // get img from feed
               $img_url = $val['child']
                              ['http://www.bing.com:80/news/search?format=rss&q='.$symbol]
                              ['Image'][0]['data'];
               
               //corrected img url
               $img_url = urldecode( explode('&', explode("?q=",$img_url)[1] )[0] ); 
            

               //---------------------
               //download & store img. from external server into our server ...

                  // path of img to store
                  $img_path = dirname(dirname(__FILE__)).'/img/newsimg/'.$subdir.'/';

                  // get unique integer to set filename
                  while(true){
                     $item_count++;
                     $g = glob ($img_path.'/'.$item_count.'.*');
                     if(empty($g))
                        break;
                  }


                  // file extension
                  $ext = @$config['extensions'][exif_imagetype($img_url)];
                  
                  // if external img err, use our server's imgs.
                  if( ! $ext ){
   
                     // select a particular rand. img.
                     // $rand_img_id is from lines 97~105

                     $img_localurl='static/'.$files[$rand_img_id];
                     $rand_img_id++;
                     $rand_img_id =  ($rand_img_id > count($files))? 0 : $rand_img_id;

                  }else{

                     // rename the downloaded img to integer
                     $img = $img_path.$item_count.'.'.$ext;

                     // set url of img
                     $img_localurl = $subdir.'/'.$item_count.'.'.$ext;

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

               // select a particular rand. img.
               // $rand_img_id is from lines 97~105

               $img_localurl='static/'.$files[$rand_img_id];
               $rand_img_id++;
               $rand_img_id =  ($rand_img_id >= count($files))? 0 : $rand_img_id;

            }
            // set the img url to our data
            $data['image'] = $img_localurl;

            print_r('Stored Img :');
            print_r($data);
            // die;

            // store in db
            $db->insert($config['db']['table_news'],$data);
      }
   }

//==============================================================================



