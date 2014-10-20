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

   //------------------
   //new logger to store record updated & deleted

      // Logging class initialization
      $log_dbchange = new Logging();

      // set path and name of log file
      $log_dbchange->lfile($config['log']['dir'].$config['log']['file_dbchange'].$datetime->format('Y-m-d H:i:s'));

   //------------------

   $data = $db->get($config['db']['table_news'], $where_clause);

   // delete old rows having the id
   $db->del($config['db']['table_news'], $where_clause);

   $log_dbchange->lwrite(print_r('Deleted items : ',true));
   $log_dbchange->lwrite(print_r($data,true));

//==============================================================================

// echo PHP_EOL;
// die;

//==============================================================================
// Get new feed & update db & imgs.

   // init array to hold inserted news for log
   $log_dbchange_data = [];

   //init feed
   $feed = new SimplePie();

   //enable caching
   $feed->enable_cache(true);

   //set the amount of seconds you want to cache the feed
   $feed->set_cache_duration(1800);

   //provide the caching folder
   $feed->set_cache_location('cache');

   // number of item
   $item_count = 0;


   //grab feed for each symbol & process & push into db
   foreach ($config['symbols_news'] as $symbol) {

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

         // store in db
         $db->insert($config['db']['table_news'],$data);

         $log_dbchange_data[] = $data;
      }
   }
   $log_dbchange->lwrite(print_r('Stored Data :',true));
   $log_dbchange->lwrite(print_r($log_dbchange_data,true));
//==============================================================================



