<?php

//==============================================================================
// Includes

   require('config/config.php');
   require('include/db.php');
   // require('quote/inc/simplepie.inc');
   // include('include/functions.php');
   // include('include/logging.php'); // loging class

//==============================================================================



//==============================================================================
// Init

   // // Logging class initialization
   // $log = new Logging();

   // // set path and name of log file
   // $log->lfile($config['log']['dir'].$config['log']['file']);


   // init db access
   $db = new Database($config['db']);

//==============================================================================



//==============================================================================
// Get news to be displayed in the homepage

   // get data from db
   $view_data['news'] = $db->get($config['db']['table_news'],' ORDER BY datetime DESC LIMIT 10 ');

   //------------------------------------------
   // get imgs from folder & shuffle them & assign them

     // path to news images compared to current file's location
     $imgdir = dirname(__FILE__).'/img/newsimg/';

     $images1 = scandir($imgdir.'/one');
     unset($images1[0]);
     unset($images1[1]);
     $images1 = array_values($images1);
     shuffle($images1);
     
     $images2 = scandir($imgdir.'/two');
     unset($images2[0]);
     unset($images2[1]);
     $images2 = array_values($images2);
     shuffle($images2);


     for($i=0;$i<count($view_data['news']);$i++){
        
        $image = ( ($i%2) ? ('one/'.$images1[$i]) : ('two/'.$images2[$i]) );

        $view_data['news'][$i]['image'] = $image;
     }
   // _print_r($view_data);   
   //------------------------------------------

//==============================================================================



//==============================================================================
// Get the last 5 queries

   $view_data['latest_symbols'] = $db->get( $config['db']['table_queries'],
                                            ' ORDER BY datetime DESC LIMIT 5 '
                                         );

//==============================================================================



//==============================================================================
// finally display
    
    require('template/index.tpl.php');

//==============================================================================