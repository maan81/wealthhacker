<?php
/**
 * Setup
 * 
 */
$DOMAIN_NAME = 'http://www.wealthhacker.com';
$FEED_URL = $DOMAIN_NAME . 'rss/full.php';
$SITE_TITLE = 'Stock Market News';
$SITE_DESRIPTION = 'Stocks and market news daily';
$SITE_AUTHOR = 'Wealth Hacker';

$RSS_CACHE = "/tmp/rsscache";
$RSS_CACHE_EXP = 3600;

$FEED_LIST = array(
	'http://articlefeeds.nasdaq.com/nasdaq/symbols?symbol=AAPL',
	'http://feeds.finance.yahoo.com/rss/2.0/headline?s=AAPL&region=US&lang=en-US',
	'http://www.bing.com/news/search?q=AAPL&format=rss'
);


/**
 * Do not modify below this point
 * 
 */
define('MAGPIE_CACHE_DIR', $RSS_CACHE);
define('MAGPIE_CACHE_AGE', $RSS_CACHE_EXP);
define('MAGPIE_OUTPUT_ENCODING', 'utf-8');
 

// include required files 
require_once ('magpierss-0.72/rss_fetch.inc');
include ('feedcreator.class.php');

/* Set RSS properties */
$rss = new UniversalFeedCreator();
$rss->useCached();
$rss->title = $SITE_TITLE;
$rss->description = $SITE_DESRIPTION;
$rss->link = $DOMAIN_NAME;
$rss->syndicationURL = $FEED_URL;
$rss->encoding = 'utf8';

/* Set Image properties 
$image = new FeedImage();
$image->title = $SITE_TITLE . " Logo";
$image->url = $SITE_LOG_URL;
$image->link = $DOMAIN_NAME;
$image->description = "Feed provided by " . $SITE_TITLE . ". Click to visit.";
$rss->image = $image;
*/

function showSummary($url, $num = 10, $showfullfeed = false) {
	global $rss, $DOMAIN_NAME, $SITE_AUTHOR, $SITE_TITLE;
	$num_items = $num;
	@ $rss1 = fetch_rss($url);
	if ($rss1) {
		$items = array_slice($rss1->items, 0, $num_items);
		foreach ($items as $item) {
			$href = $item['link'];
			$title = $item['title'];
			if (!$showfullfeed) {
				$desc = $item['description'];
			} else {
				$desc = $item['content']['encoded'];
			}
			//                $desc .=  '
			//Copyright &copy; <a href="'.$DOMAIN_NAME.'">'.$SITE_TITLE.'</a>.  All Rights Reserved.
			//';
			$pdate = $item['pubdate'];
			$rss_item = new FeedItem();
			$rss_item->title = $item['title'];
			$rss_item->link = $item['link'];
			$rss_item->description = $item['content']['encoded'];
			$rss_item->date = $item['pubdate'];
			$rss_item->source = $DOMAIN_NAME;
			$rss_item->author = $SITE_AUTHOR;
			$rss->addItem($rss_item);
		}

	} else {
		echo "Error: Cannot fetch feed url - " . $url;
	}
}

// Fetch all feeds
foreach($FEED_LIST as $v) showSummary($v);

// Sort items by date
function __usort($ad, $bd) {return strtotime($bd->date) - strtotime($ad->date);}
usort($rss->items, '__usort');

// Display items
$rss->saveFeed("RSS1.0", $RSS_CACHE . "/feed.xml");
