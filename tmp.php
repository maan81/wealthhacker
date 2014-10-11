<?php
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
		  <p><?php echo $feed->error; ?></p>
		<?php endif; ?>
<ul>
		<?php $i=0; foreach ($feed->get_items() as $item): $i++; if($i == 6){break;} ?>
<li><?php print_r($item);?></li>
<li>
	<time class="timeline-time" datetime="">
		<span><?php echo $item->get_date('D, j M Y'); ?></span>
	</time>
	<i class="timeline-2-point"></i>
	<div class="panel panel-default">
		<div class="panel-heading">
			<a rel="nofollow" target="_blank" href="<?php echo $item->get_permalink(); ?>">
				<?php echo $item->get_title(); ?>
			</a>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
				<img src="img/newsimg/two/<?php echo $files[0]; unset($files[0]); 	shuffle($files); ?>" alt="symbol" class="img-responsive">
			</div>
			<div class="col-sm-8">
				<p><?php echo $item->get_description(); ?>	
					<img src="http://feeds.feedburner.com/~r/nasdaq/symbols/~4/hQO40hoAv3A" height="1" width="1">
				</p>
			</div>
			</div>
		</div>
	</div>

</li>	
 
		<?php endforeach; ?>
</ul>