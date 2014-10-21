<?php


/**
 * Database connections
 */
$config['db']['server']   = 'localhost';
$config['db']['database'] = 'whacker_news';
// $config['db']['username'] = 'whacker_news';
// $config['db']['password'] = 'h7ml/_W!';
$config['db']['username'] = 'root';
$config['db']['password'] = 'password';


/**
 * Database tables
 */
$config['db']['table_news']    = 'news';
$config['db']['table_queries'] = 'queries';


/**
 * Delete news older than ...
 */
$config['db']['del'] = '-1 days';




/**
 * Base url
 */
// $config['baseurl'] = 'http://wealthhacker.com';
$config['baseurl'] = 'http://localhost/wealthhacker/src';



/**
 * Symbols list for news
 */
$config['symbols_news'] = [ 	
							'amd',
							'amzn',
							'att',
							'bidu',
							'bp',
							'cat',
							'csco',
							'cvs',
							'dal',
							'dis',
							'ford',
							'intc',
							'jnj',
							'jpm',
							'ko',
							'mcd',
							'mmm',
							'mrk',
							'msft',
							'mu',
							'orcl',
							'pfe',
							'pg',
							'qcom',
							'tsla',
							'vz',
							'wag',
							'xom',
							'yhoo',
							'wfc',
						];




$config['feed_url'] = 'http://www.bing.com:80/news/search?format=rss&q=';
// $config['feed_url'] = 'http://articlefeeds.nasdaq.com/nasdaq/symbols?symbol='.$symbol,



$config['extensions'] = [
						    IMAGETYPE_GIF => "gif",
						    IMAGETYPE_JPEG => "jpg",
						    IMAGETYPE_PNG => "png",
						    // IMAGETYPE_SWF => "swf",
						    // IMAGETYPE_PSD => "psd",
						    // IMAGETYPE_BMP => "bmp",
						    // IMAGETYPE_TIFF_II => "tiff",
						    // IMAGETYPE_TIFF_MM => "tiff",
						    // IMAGETYPE_JPC => "jpc",
						    // IMAGETYPE_JP2 => "jp2",
						    // IMAGETYPE_JPX => "jpx",
						    // IMAGETYPE_JB2 => "jb2",
						    // IMAGETYPE_SWC => "swc",
						    // IMAGETYPE_IFF => "iff",
						    // IMAGETYPE_WBMP => "wbmp",
						    // IMAGETYPE_XBM => "xbm",
						    // IMAGETYPE_ICO => "ico"
						];



$config['log']['dir']  = dirname(dirname(__FILE__)).'/logs/';
$config['log']['file'] = 'cron_hourly';
$config['log']['file_dbchange'] = 'db_change_';


/**
 * PHP's print_r fn customized for debugging.
 * should not be necessary for production
 *
 */
function _print_r($data,$end=true,$return=false){
	$str = '';
	if(!$return){
		$t = debug_backtrace();
		$str .= PHP_EOL.'<hr/>';
		$str .= '<pre>';
		$str .= print_r('file : '.$t[0]['file'],true);
		$str .= '</pre>';
		$str .= PHP_EOL.'<pre>';
		$str .= print_r('line : '.$t[0]['line'],true);
		$str .= '</pre>';
		$str .= PHP_EOL.'<pre>';
		$str .= print_r('data :'.print_r($data,true),true);
		$str .= '</pre>';
		$str .= PHP_EOL.'<hr/>';
	}
	if(!$end){
		echo $str;
		return;
	}
	echo $str;
	die;
}
