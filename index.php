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

   $view_data['news'] = $db->get($config['db']['table_news'],' ORDER BY datetime DESC LIMIT 10 ');
   // _print_r($view_data);   

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