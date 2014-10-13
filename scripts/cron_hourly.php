<?php

//==============================================================================
// Includes

   require('config/config.php');
   require('include/db.php');
   require('quote/inc/simplepie.inc');
   include('include/functions.php');
   include('include/logging.php'); // loging class

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
   $where_clause = ' AND datetime>='.$datetime->format('Y-m-d H:i:s');;


   $data = $db->get($config['db']['table_news'], $where_clause);

   // get the ids of the rows to be deleted
   $ids = [];
   foreach($data as $key=>$val){
      $ids[] = $val['id'];
   }


   // generate where clause from ids
   $where_clause = ' AND id BETWEEN ('.implode(',', $ids).')';

   // delete old rows having the id
   $db->del($config['db']['table_news'], $where_clause);

   //delete old imgs of the ids
   foreach($data as $key=>$val){

      //but dont delete the no-image
      if($val['image']=='0.jpg') condinue;

      unlink($val['image']);
   }

//==============================================================================



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

         // extract current feed array
         $x = $item->feed->data['child']['']
                                 ['rss'][0]
                                 ['child']['']
                                 ['channel'][0]
                                 ['child']['']
                                 ['item'][$i]
                                 ['child']
                                 [$config['feed_url'].$symbol];

         // img of current feed
         if(isset($x['Image'])){

            $x = $x['Image'][0]['data'];

            // img url from the feed
            $img_url = urldecode( explode('&', explode("?q=",$x)[1] )[0] ); 

            // path of img to store
            $img_path = dirname(dirname(__FILE__)).'/img/newsimg/'.($i%2?'one':'two').'/';

            // rename img
            $num_of_files = iterator_count(
                                 new FilesystemIterator( $img_path, 
                                                         FilesystemIterator::SKIP_DOTS
                                                      )
                                 ) ;
            $img = $img_path.$num_of_files.'.'. pathinfo($img_url)['extension'];

            // set url of img
            $img_localurl = ($i%2?'one':'two').'/'
                              .$num_of_files.'.'. pathinfo($img_url)['extension'];


            // store img from external url to local server
            copy($img_url, $img);
            
            // _print_r($img_url,false);
            // _print_r($img,false);

            // !!! resize img not resizing !!!!
            Img_Resize($img,480,320);


            // Imageick not present on server
            // $img = new Imagick($img);
            // $img->scaleImage(300, 0);


         // no img present in feed - use no-image
         }else{

            // $img_url='';
            $img_localurl='0.jpg';
         }


         // init data to store
         $data = ['symbol'      => $symbol,
                  'title'       => $item->get_title(),
                  'description' => $item->get_description(),
                  'url'         => urldecode(
                                          explode( "=",
                                                   explode( "&",
                                                            $item->get_link()
                                                      ) [3]
                                                ) [1]
                                       ),
                  'datetime'    => $item->get_date('Y-m-d'),
                  'image'       => $img_localurl,
               ]; 


         // store in db
         $db->insert($config['db']['table_news'],$data);

      }

   }

//==============================================================================



