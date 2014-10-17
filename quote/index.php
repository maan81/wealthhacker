<?php
include_once('funct.php');

$objYahooStock = new YahooStock;
 
/**
    Add format/parameters to be fetched
     
    s = Symbol
    n = Name
    l1 = Last Trade (Price Only)
    d1 = Last Trade Date
    t1 = Last Trade Time
    c = Change and Percent Change
    v = Volume
 */
$objYahooStock->addFormat("snl1d1t1p2vmm3m4ee8djkhgj1j4p2qr1rym7m5oc1j6s6k1");
 
/**
    Add company stock code to be fetched
     
    msft = Microsoft
    amzn = Amazon
    yhoo = Yahoo
    goog = Google
    aapl = Apple   
 */

$objYahooStock->addStock($_GET['symbol']);


//-------------------------------------------
//update access log of symbols

  //validate & sanitaze variable
  $s = filter_var(
                  $_GET['symbol'], 
                  FILTER_VALIDATE_REGEXP,
                  array("options"=>array("regexp"=>"/^[a-zA-Z]{1,6}$/"))
                );

  //update for valid symbol
  if($s){
    //include settings
    include_once('../config/config.php');
    include_once('../include/db.php');

    // init current datetime
    $datetime = new DateTime(null, new DateTimeZone('UTC'));

    // init & exec db 
    (new Database($config['db']))
            ->queries_update_log( $config['db']['table_queries'],  //db table name
                                  $s,                              //symbol
                                  $datetime->format('Y-m-d H:i:s') //current datetime
                                );

    // clear declared variables
    unset($datetime);
    unset($config);
  }
  unset($s);

//-------------------------------------------
 
/**
 * Printing out the data
 */
foreach( $objYahooStock->getQuotes() as $code => $stock)
{
    ?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title><?php $str = $stock[0]; echo trim($str, '"'); ?> Stock Price was <?php echo $stock[2]; ?> - See Real Time Quote</title>

    <link rel="shortcut icon" href="img/favicon.ico">

    <meta name="description" content="See the live <?php $str = $stock[0]; echo trim($str, '"'); ?> Stock Price today, and loads of other important data, tweets and news related to <?php $str = $stock[1]; echo trim($str, '"'); ?>."/>

    <!-- CSS -->
    <link href="css/preload.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
  
    <link href="css/slidebars.css" rel="stylesheet" media="screen">
    <link href="css/lightbox.css" rel="stylesheet" media="screen">
    <link href="css/jquery.bxslider.css" rel="stylesheet">
    <link href="css/syntaxhighlighter/shCore.css" rel="stylesheet" media="screen">

    <link href="css/style-blue.css" rel="stylesheet" media="screen" title="default">
    <link href="css/width-full.css" rel="stylesheet" media="screen" title="default">

    <link href="css/buttons.css" rel="stylesheet" media="screen">

    <!-- Autocomplete css -->
    <!-- <link rel="stylesheet" type="text/css" href="http://localhost/stayplay/public/user/claim/common/css/jquery-ui-1.8.5.custom.css"> -->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.5.custom.css">
    <style type="text/css">
      .ui-autocomplete{font-size: 14px; z-index: 1;}
      .ui-autocomplete ul{
        border-color: #ccc #aaa #aaa #ccc
        font-size : 12px;
      }
      .ui-autocomplete .ui-autocomplete-category{
        color: #012950
      }
    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<body>

<div id="sb-site">
<div class="boxed">


<nav class="navbar navbar-static-top navbar-default navbar-dark" role="navigation" id="header">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/">Wealth <span>Hacker</span></a>
        </div> <!-- navbar-header -->

        <!-- Collect the nav links, forms, and other content for toggling -->
        
		
        <?php include_once('../template/menu.php'); ?>
		
		
    </div><!-- container -->
</nav>

<header class="main-header">
  
</header>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <section>
                <h2 class="page-header no-margin-top"><?php $str = $stock[0]; echo trim($str, '"'); ?> Stock Price</h2>
                <div id="tv-medium-widget-70354"></div>
<script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
<script type="text/javascript">
new TradingView.MediumWidget({
  "container_id": "tv-medium-widget-70354",
  "symbols": [
    [
      '<?php echo $stock[1]; ?>',
      '<?php $str = $stock[0]; echo trim($str, '"'); ?>'
    ],
  
  ],
  "gridLineColor": "#CCC",
  "fontColor": "#83888D",
  "underLineColor": "#F0F0F0",
  "timeAxisBackgroundColor": "#E9EDF2",
  "trendLineColor": "#0099da",
  "width": "100%",
  "height": "350px"
});
</script>


		<div class="row">
                  
                     <div class="col-md-3">
                        <h3>Today</h3>
                        <p>Open: <?php echo $stock[26]; ?></p>
                        <p>High: <?php echo $stock[15]; ?></p>
						<p>Low:  <?php echo $stock[16]; ?></p>
						<p>Vol: <?php echo $stock[6]; ?></p>
                    </div>
				
					  <div class="col-md-9">
                        <h3>Statistics for <?php $str = $stock[1]; echo trim($str, '"'); ?></h3>
                        <p><?php $str = $stock[0]; echo trim($str, '"'); ?> stock price today is at <?php $str = $stock[30]; echo trim($str, '"N/A -"'); ?>, which is <?php echo round($total=$stock[14]-$stock[2],2); ?> below the 52 week high of <?php echo round($stock[14],2); ?>, and <?php echo round($total=$stock[2]-$stock[13],2); ?> above the 52 week low of <?php echo round($stock[13],2); ?>. 
						The price is currently <?php echo round($total=$stock[2]-$stock[8],2); ?> points from the 50 day moving average at <?php echo round($stock[8],2); ?>, and is <?php echo round($total=$stock[2]-$stock[9],2); ?> points from the 200 day moving average which is <?php echo round($stock[9],2); ?>. Over the last 52 weeks <?php $str = $stock[0]; echo trim($str, '"'); ?> has moved <?php echo round($stock[28],2); ?>% from the year lows.</p>
                        <p>Did you know that <?php $str = $stock[1]; echo trim($str, '"'); ?> has a market cap of <?php echo $stock[17]; ?> and a P/E ratio of <?php echo $stock[22]; ?>? Their ex-dividend date is <?php $str = $stock[20]; echo trim($str, '"'); ?>, and they will pay dividends on <?php $str = $stock[21]; echo trim($str, '"'); ?>.</p>																						
                    </div>
                </div>

	   <h2 class="section-title">Technical Analysis Chart</h2>
	   <p>
	   <script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
<script type="text/javascript">
new TradingView.widget({
  "width": "100%",
  "height": 500,
  "symbol": "<?php $str = $stock[0]; echo trim($str, '"'); ?>",
  "interval": "1",
  "timezone": "exchange",
  "theme": "White",
  "style": "1",
  "toolbar_bg": "#f1f3f6",
  "save_image": false,
  "hideideas": true,
  "show_popup_button": true,
  "popup_width": "100%",
  "popup_height": "650"
});
</script>
	   </p>
               </section>
          <!-- News Srat -->
            <section>
              <div class="row">
        <div class="col-md-11 ">
		   <h2 class="section-title">Latest News</h2>
		 
            <ul class="timeline-2">
<?php
$dir    = 'img/newsimg/two';
$files = scandir($dir);
unset($files[0]);
unset($files[1]);
shuffle($files);
    //get the simplepie library
    require_once('inc/simplepie.inc');
    
    //grab the feed
    $feed = new SimplePie();
    
    $feed->set_feed_url(array(
    	'http://www.bing.com/news/search?q='.$_GET['symbol'].'&format=rss',
    	'http://articlefeeds.nasdaq.com/nasdaq/symbols?symbol='.$_GET['symbol'],
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
  
		<?php $i=0; foreach ($feed->get_items() as $item): $i++; if($i == 6){break;} ?>
<li>
	<time class="timeline-time" datetime=""><span><?php echo $item->get_date('D, j M Y'); ?></span></time>
	<i class="timeline-2-point"></i><div class="panel panel-default">
	<div class="panel-heading">
		<a rel="nofollow" target="_blank" href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-4">
			<img src="img/newsimg/two/<?php echo $files[0]; unset($files[0]); 	shuffle($files); ?>" alt="symbol" class="img-responsive">
		</div>
		<div class="col-sm-8">
			<p><?php echo $item->get_description(); ?>	<img src="http://feeds.feedburner.com/~r/nasdaq/symbols/~4/hQO40hoAv3A" height="1" width="1">
			</p>
		</div>
		</div>
	</div>
	</div>
</li>	
 
		<?php endforeach; ?>

               
            </ul>
        </div>	

    </div>  
            </section> 
			<!-- End Main Column -->
        </div>

        <div class="col-md-4">
            <aside class="sidebar">
                <div class="block">
                    <div id="search_div" class="input-group">
                      <input id="search_input" type="text" placeholder="Search for stocks..." class="form-control">
                      <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                      </span>
                    </div><!-- /input-group -->
                </div>

				
	 <div class="panel">			
 <!-- Widget BEGIN -->
<div id="tv-miniwidget-346d8"></div>
<script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
<script type="text/javascript">
new TradingView.MiniWidget({
  "container_id": "tv-miniwidget-346d8",
  "tabs": [
    "Indices",
    "Commodities",
    "Bonds",
    "Forex"
  ],
  "symbols": {
    "Indices": [
      [
        "S&P500",
        "SPX500"
      ],
      [
        "NQ100",
        "NAS100"
      ],
      [
        "Dow30",
        "FX:US30"
      ],
      [
        "Nikkei225",
        "JPN225"
      ],
	  [
        "FTSE 100",
        "FX:UK100"
      ],
	  [
        "DAX 30",
        "FX:GER30"
      ],
     
    ],
    "Commodities": [
      [
        "Emini",
        "ES1!"
      ],
      [
        "Euro",
        "E61!"
      ],
      [
        "Gold",
        "GC1!"
      ],
      [
        "Oil",
        "CL1!"
      ],
      [
        "Gas",
        "NG1!"
      ],
      [
        "Corn",
        "ZC1!"
      ]
    ],
    "Bonds": [
      [
        "US 2YR",
        "TUZ2013"
      ],
      [
        "US 10YR",
        "TYZ2013"
      ],
      [
        "US 30YR",
        "USZ2013"
      ],
      [
        "Euro Bund",
        "FX:BUND"
      ],
      [
        "Euro BTP",
        "EUREX:II1!"
      ],
      [
        "Euro BOBL",
        "EUREX:HR1!"
      ]
    ],
    "Forex": [
      "FX:EURUSD",
      "FX:GBPUSD",
      "FX:USDJPY",
      "FX:USDCHF",
      "FX:AUDUSD",
      "FX:USDCAD"
    ]
  },
  "gridLineColor": "#E9E9EA",
  "fontColor": "#83888D",
  "underLineColor": "#F0F0F0",
  "timeAxisBackgroundColor": "#F3F2F3",
  "trendLineColor": "#0099da",
  "activeTickerBackgroundColor": "#FFFFFF",
  "large_chart_url": "https://www.tradingview.com/e/",
  "noGraph": false,
  "width": "360px",
  "height": "400px"
});
</script>
<!-- Widget END -->

</div>
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-play-circle"></i>CNBC Latest Video</div>
                    <div class="video">
                       <iframe src="http://www.youtube.com/embed/?listType=user_uploads&list=cnbc" width="360" height="250"></iframe>

                    </div>
                </div>
				<div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-play-circle"></i>Bloomberg Latest Video</div>
                    <div class="video">
                       <iframe src="http://www.youtube.com/embed/?listType=user_uploads&list=Bloomberg" width="360" height="250"></iframe>

                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-comments"></i> Latest <?php $str = $stock[0]; echo trim($str, '"'); ?> Discussion</div>
                    <div class="panel-body">
                        <div id="stocktwits-widget-news"></div>
<script type="text/javascript" src="http://stocktwits.com/addon/widget/2/widget-loader.min.js"></script>
<script type="text/javascript">
STWT.Widget({container: 'stocktwits-widget-news', symbol: '<?php $str = $stock[0]; echo trim($str, '"'); ?>', width: '100%', height: '450', limit: '15', scrollbars: 'true', streaming: 'true', title: '<?php $str = $stock[0]; echo trim($str, '"'); ?> Tweets', style: {link_color: '0099da', link_hover_color: '0099da', header_text_color: '0099da', border_color: 'ffffff', divider_color: 'cecece', divider_color: 'cecece', divider_type: 'solid', box_color: 'ffffff', stream_color: 'ffffff', text_color: '000000', time_color: '999999'}});
</script>

                    </div>
                </div>
				<!-- End Quote php -->
				
 <?php
}
?>
            </aside> <!-- Sidebar -->
        </div>
    </div>
</div> <!-- container  -->

<aside id="footer-widgets">

     <?php include_once('../template/footer.php'); ?>
	 
	 
</aside> <!-- footer-widgets -->
<footer id="footer">
    <p>&copy; 2014 <a href="/">Wealth Hacker</a>, inc. All rights reserved.</p>
</footer>

</div> <!-- boxed -->
</div> <!-- sb-site -->

<div id="back-top">
    <a href="#header"><i class="fa fa-chevron-up"></i></a>
</div>

<!-- Scripts -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script type="text/javascript" src="http://localhost/jquery/jquery-latest.js"></script>
<!-- <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script> -->
<!-- <script type="text/javascript" src="http://localhost/jquery/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="http://localhost/stayplay/public/js/jquery-ui.min.js"></script>

<script src="js/jquery.cookie.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/slidebars.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script src="js/holder.js"></script>
<script src="js/buttons.js"></script>

<script src="js/jquery.mixitup.min.js"></script>
<script src="js/circles.min.js"></script>

<!-- Syntaxhighlighter -->
<script src="js/syntaxhighlighter/shCore.js"></script>
<script src="js/syntaxhighlighter/shBrushXml.js"></script>
<script src="js/syntaxhighlighter/shBrushJScript.js"></script>

<script src="js/app.js"></script>

<!-- Autocomplete dropdown on search -->
<script type="text/javascript" src="js/autocomplete.js"></script>

</body>

</html>
