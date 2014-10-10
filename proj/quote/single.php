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
$objYahooStock->addStock("AAPL");

 
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

    <title>Artificial Reason</title>

    <link rel="shortcut icon" href="img/favicon.ico">

    <meta name="description" content="">

    <!-- CSS -->
    <link href="css/preload.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="css/animate.min.css" rel="stylesheet" media="screen">
    <link href="css/slidebars.css" rel="stylesheet" media="screen">
    <link href="css/lightbox.css" rel="stylesheet" media="screen">
    <link href="css/jquery.bxslider.css" rel="stylesheet">
    <link href="css/syntaxhighlighter/shCore.css" rel="stylesheet" media="screen">

    <link href="css/style-blue.css" rel="stylesheet" media="screen" title="default">
    <link href="css/width-full.css" rel="stylesheet" media="screen" title="default">

    <link href="css/buttons.css" rel="stylesheet" media="screen">

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
            <a class="navbar-brand" href="index.html">Wealth <span>Hacker</span></a>
        </div> <!-- navbar-header -->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="pull-right">
            <a href="javascript:void(0);" class="sb-icon-navbar sb-toggle-right"><i class="fa fa-bars"></i></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Home</a>
                     <ul class="dropdown-menu dropdown-menu-left">
                        <li><a href="index.html">Option 1: Default</a></li>
                        <li><a href="home_services.html">Option 2: Services</a></li>
                        <li><a href="home_full.html">Option 3: Full Intro</a></li>
                        <li><a href="home_only_full.html">Option 4: Only Full Intro</a></li>
                        <li><a href="home_news.html">Option 5: News</a></li>
                        <li><a href="home_profile.html">Option 6: Professional Profile</a></li>
                        <li role="presentation" class="dropdown-header">Header Options</li>
                        <li><a href="configurator.html">Configurator<span class="label label-success pull-right">New</span></a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">UI Elements</a>
                     <ul class="dropdown-menu dropdown-menu-left">
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">CSS</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="css_typography.html">Typography</a></li>
                                <li><a href="css_headers.html">Headers</a></li>
                                <li><a href="css_dividers.html">Dividers</a></li>
                                <li><a href="css_blockquotes.html">Blockquotes</a></li>
                                <li><a href="css_forms.html">Forms</a></li>
                                <li><a href="css_tables.html">Tables</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Buttons</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="btn_basic_buttons.html">Basic Buttons</a></li>
                                <li><a href="btn_library_buttons.html">Buttons Library</a></li>
                                <li><a href="btn_social_buttons.html">Social Buttons</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Icons</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="icons_artificial_reason.html">Artificial Reason Icons</a></li>
                                <li><a href="icons_glyph.html">Glyphicons Icons</a></li>
                                <li><a href="icons_awesome.html">Font Awesome</a></li>
                                <li><a href="icons_social.html">Social Icons</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Components</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="components_dropdowns.html">Components Dropdowns</a></li>
                                <li><a href="components_panels.html">Panels</a></li>
                                <li><a href="components_lists.html">Lists</a></li>
                                <li><a href="components_paginations.html">Paginations</a></li>
                                <li><a href="components_labels_badges.html">Labels and Badges</a></li>
                                <li><a href="components_alerts_wells.html">Alerts and Wells</a></li>
                                <li><a href="components_thumbnails.html">Thumbnails</a></li>
                                <li><a href="components_modals.html">Modals</a></li>
                                <li><a href="components_progress_bars.html">Progress Bars</a></li>
                                <li><a href="components_tooltip_popover.html">Tooltip & Popover</a></li>
                            </ul>
                        </li>
                        <li><a href="collapses_tabs.html">Collapses & Tabs</a></li>
                        <li><a href="content_box.html">Contents Box</a></li>
                        <li><a href="carousels.html">Carousels</a></li>
                        <li><a href="charts.html">Charts & CountDowns</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Pages</a>
                     <ul class="dropdown-menu dropdown-menu-left">
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">About us & Team</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_about.html">About us Option 1</a></li>
                                <li><a href="page_about2.html">About us Option 2</a></li>
                                <li><a href="page_about3.html">About us & Team</a></li>
                                <li class="divider"></li>                                        <li><a href="page_team.html">Our Team Option 1</a></li>
                                <li><a href="page_team2.html">Our Team Option 2</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Form</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_contact.html">Contact Option 1</a></li>
                                <li><a href="page_contact2.html">Contact Option 2</a></li>
                                <li class="divider"></li>                                        <li><a href="page_login.html">Login Integrated</a></li>
                                <li><a href="page_login_full.html">Login Full Page</a></li>
                                <li class="divider"></li>                                        <li><a href="page_login_register.html">Login and Register</a></li>
                                <li><a href="page_register.html">Register Option 1</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Profiles</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_profile.html">User Profile Option 1</a></li>
                                <li><a href="page_profile2.html">User Profile Option 2</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Error</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_404.html">Error 404 Full Page</a></li>
                                <li><a href="page_404_2.html">Error 404 Integrated</a></li>
                                <li><a href="page_500.html">Error 500 Full Page</a></li>
                                <li><a href="page_500_2.html">Error 500 Integrated</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Bussiness & Products</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_testimonial.html">Testimonials</a></li>
                                <li><a href="page_clients.html">Our Clients</a></li>
                                <li><a href="page_product.html">Products</a></li>
                                <li><a href="page_services.html">Services</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Pricing</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_pricing.html">Pricing Box</a></li>
                                <li><a href="page_pricing-mega.html">Pricing Mega Table</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">FAQ & Support</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_support.html">Support Center</a></li>
                                <li><a href="page_faq.html">FAQ Option 1</a></li>
                                <li><a href="page_faq2.html">FAQ Option 2</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Coming Soon</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_coming.html">Coming Soon Option 1</a></li>
                                <li><a href="page_coming2.html">Coming Soon Option 2</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                                <a href="javascript:void(0);" class="has_children">Timeline</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                <li><a href="page_timeline_left.html">Timeline Left</a></li>
                                <li><a href="page_timeline.html">Timeline Center</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Blog</a>
                     <ul class="dropdown-menu dropdown-menu-left">
                        <li><a href="blog.html">Blog Right Sidebar</a></li>
                        <li><a href="blog_left.html">Blog Left Sidebar</a></li>
                        <li><a href="blog_full.html">Blog Full</a></li>
                        <li><a href="blog2.html">Other Option</a></li>
                        <li class="divider"></li>
                        <li><a href="single.html" class="active">Blog Item</a></li>
                        <li><a href="single_full.html">Blog Item Full</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">E-commerce</a>
                     <ul class="dropdown-menu dropdown-menu-left">
                        <li><a href="e-commerce_home.html">E-commerce Home</a></li>
                        <li><a href="e-commerce.html">E-commerce Filters</a></li>
                        <li><a href="e-commerce_product.html">Product</a></li>
                        <li><a href="e-commerce_cart.html">Cart</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Portfolio</a>
                     <ul class="dropdown-menu dropdown-menu-left">
                        <li><a href="portfolio_sidebar.html">Portfolio sidebar filters</a></li>
                        <li><a href="portfolio_topbar.html">Portfolio topbar filters</a></li>
                        <li><a href="portfolio_caption_hover.html">Portfolio with captions</a></li>
                        <li class="divider"></li>
                        <li><a href="portfolio_item.html">Portfolio item</a></li>
                        <li><a href="portfolio_item_devices.html">Portfolio item device</a></li>
                    </ul>
                </li>
             </ul>
        </div><!-- navbar-collapse -->
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
          <!-- News Start -->
            <section>
              <div class="row">
        <div class="col-md-11 ">
		   <h2 class="section-title">Latest News</h2>
            <ul class="timeline-2">
                <li>
                    <time class="timeline-time" datetime="">5:56 AM<span>September 03</span></time>
                    <i class="timeline-2-point"></i>
                    <div class="panel panel-default">
                        <div class="panel-heading"><a href="" rel="nofollow" target="_blank">Is Apple&#39;s Supply Chain a Risk to the Company?</a></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="img/newsimg/two/stocktrading-2.jpg" alt="symbol" class="img-responsive">
                                </div>
                                <div class="col-sm-8">
                                    <p>Apple CEO Tim Cook. Source Wikimedia Commons. If the rumors are to be believed, Apple 's newest product, the iWatch, will be announced at its Sept. 9 event but possibly won't ship</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <time class="timeline-time" datetime="">02:34 PM<span>September 03</span></time>
                    <i class="timeline-2-point"></i>
                    <div class="panel panel-default">
                        <div class="panel-heading"><a href="" rel="nofollow" target="_blank">New Managers Revive Thrivent Large Cap Growth Fund</a></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="img/newsimg/two/stocktrading-3.jpg" alt="symbol" class="img-responsive">
                                </div>
                                <div class="col-sm-8">
                                    <p>Stocks surrendered most of Wednesday's early gains tied to a possible cease fire in Ukraine after a disappointing Federal Reserve Beige Book and doubts surrounding the sincerity of Moskow's agreement with Kiev caused equities to drift lower for most</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                 <li>
                    <time class="timeline-time" datetime="">02:30 PM<span>September 03</span></time>
                    <i class="timeline-2-point"></i>
                    <div class="panel panel-default">
                        <div class="panel-heading"><a href="" rel="nofollow" target="_blank">Why Apple, Inc. Pre-Announcing the iWatch Months in Advance Would Be Smart</a></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="img/newsimg/two/stocktrading-4.jpg" alt="symbol" class="img-responsive">
                                </div>
                                <div class="col-sm-8">
                                    <p>It seems increasingly likely that Apple 's expected iWatch won't ship this year . At the same time, reports suggest that the company is still planning on unveiling the device at its media event next Tuesday.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
				 <li>
                    <time class="timeline-time" datetime="">11:59 PM<span>September 03</span></time>
                    <i class="timeline-2-point"></i>
                    <div class="panel panel-default">
                        <div class="panel-heading"><a href="" rel="nofollow" target="_blank">Himax-Optinvent Partner to Create Advanced Smart Glasses - Analyst Blog</a></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="img/newsimg/two/stocktrading-6.jpg" alt="symbol" class="img-responsive">
                                </div>
                                <div class="col-sm-8">
                                    <p>Taiwanese chipmaker Himax Technologies, Inc. ( HIMX ) announced that its subsidiary, Himax Display Inc. will team up with Optinvent SA, a leading French producer of disruptive ORA Smart Glasses. The partnership will develop technologically advanced next generation augmented</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <time class="timeline-time" datetime="">22/10/2012 <span>October</span></time>
                    <i class="timeline-2-point"></i>
                    <blockquote class="blockquote-color-bg-primary">
                        <p><strong>Blockquote in timeline!</strong> consectetur adipiscing elit. Integer sodales sagittis magna. consectetur adipiscing elit sed consequat, quam semper libero.</p>
                        <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer>
                    </blockquote>
                </li>
               
            </ul>
        </div>
        
    </div>  
            </section> 
			<!-- End Main Column -->
        </div>

        <div class="col-md-4">
            <aside class="sidebar">
                <div class="block">
                    <div class="input-group">
                      <input type="text" placeholder="Search for stocks..." class="form-control">
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
                    <div class="panel-heading"><i class="fa fa-comments"></i> Latest AAPL Discussion</div>
                    <div class="panel-body">
                        <div id="stocktwits-widget-news"></div>
<script type="text/javascript" src="http://stocktwits.com/addon/widget/2/widget-loader.min.js"></script>
<script type="text/javascript">
STWT.Widget({container: 'stocktwits-widget-news', symbol: 'AAPL', width: '100%', height: '450', limit: '15', scrollbars: 'true', streaming: 'true', title: 'AAPL Tweets', style: {link_color: '0099da', link_hover_color: '0099da', header_text_color: '0099da', border_color: 'ffffff', divider_color: 'cecece', divider_color: 'cecece', divider_type: 'solid', box_color: 'ffffff', stream_color: 'ffffff', text_color: '000000', time_color: '999999'}});
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
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3 class="footer-widget-title">Sitemap</h3>
                <ul class="list-unstyled three_cols">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="portfolio_sidebar.html">Portafolio</a></li>
                    <li><a href="portfolio_topvar.html">Works</a></li>
                    <li><a href="page_timeline_left.html">Timeline</a></li>
                    <li><a href="page_pricing.html">Pricing</a></li>
                    <li><a href="page_about2.html">About Us</a></li>
                    <li><a href="page_team.html">Our Team</a></li>
                    <li><a href="page_services.html">Services</a></li>
                    <li><a href="page_support.html">FAQ</a></li>
                    <li><a href="page_login_full.html">Login</a></li>
                    <li><a href="page_contact.html">Contact</a></li>
                </ul>
                <h3 class="footer-widget-title">Subscribe</h3>
                <p>Lorem ipsum Amet fugiat elit nisi anim mollit minim labore ut esse Duis ullamco ad dolor veniam velit.</p>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Email Adress">
                    <span class="input-group-btn">
                        <button class="btn btn-ar btn-primary" type="button">Subscribe</button>
                    </span>
                </div><!-- /input-group -->
            </div>
            <div class="col-md-4">
                <div class="footer-widget">
                    <h3 class="footer-widget-title">Recent Post</h3>
                    <div class="media">
                        <a class="pull-left" href="#"><img class="media-object" src="img/demo/m2.jpg" width="75" height="75" alt="image"></a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#">Lorem ipsum Duis quis occaecat minim lorem ipsum tempor officia labor</a></h4>
                            <small>August 18, 2013</small>
                        </div>
                    </div>
                    <div class="media">
                        <a class="pull-left" href="#"><img class="media-object" src="img/demo/m11.jpg" width="75" height="75" alt="image"></a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#">Lorem ipsum dolor excepteur sunt in lorem ipsum cillum tempor</a></h4>
                            <small>September 14, 2013</small>
                        </div>
                    </div>
                    <div class="media">
                        <a class="pull-left" href="#"><img class="media-object" src="img/demo/m4.jpg" width="75" height="75" alt="image"></a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#">Lorem ipsum Dolor cupidatat minim adipisicing et fugiat</a></h4>
                            <small>October 9, 2013</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-widget">
                    <h3 class="footer-widget-title">Recent Works</h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-3 col-xs-6">
                            <a href="#" class="thumbnail"><img src="img/demo/wf1.jpg" class="img-responsive" alt="Image"></a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-3 col-xs-6">
                            <a href="#" class="thumbnail"><img src="img/demo/wf2.jpg" class="img-responsive" alt="Image"></a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-3 col-xs-6">
                            <a href="#" class="thumbnail"><img src="img/demo/wf3.jpg" class="img-responsive" alt="Image"></a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-3 col-xs-6">
                            <a href="#" class="thumbnail"><img src="img/demo/wf4.jpg" class="img-responsive" alt="Image"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</aside> <!-- footer-widgets -->
<footer id="footer">
    <p>&copy; 2014 <a href="#">Artificial Reason</a>, inc. All rights reserved.</p>
</footer>

</div> <!-- boxed -->
</div> <!-- sb-site -->

<div class="sb-slidebar sb-right">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
        </span>
    </div><!-- /input-group -->

    <h2 class="slidebar-header no-margin-bottom">Navigation</h2>
    <ul class="slidebar-menu">
        <li><a href="index.html">Home</a></li>
        <li><a href="portfolio_topbar.html">Portfolio</a></li>
        <li><a href="page_about3.html">About us</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="page_contact.html">Contact</a></li>
    </ul>

    <h2 class="slidebar-header">Social Media</h2>
    <div class="slidebar-social-icons">
        <a href="#" class="social-icon-ar rss"><i class="fa fa-rss"></i></a>
        <a href="#" class="social-icon-ar facebook"><i class="fa fa-facebook"></i></a>
        <a href="#" class="social-icon-ar twitter"><i class="fa fa-twitter"></i></a>
        <a href="#" class="social-icon-ar pinterest"><i class="fa fa-pinterest"></i></a>
        <a href="#" class="social-icon-ar instagram"><i class="fa fa-instagram"></i></a>
        <a href="#" class="social-icon-ar wordpress"><i class="fa fa-wordpress"></i></a>
        <a href="#" class="social-icon-ar linkedin"><i class="fa fa-linkedin"></i></a>
        <a href="#" class="social-icon-ar flickr"><i class="fa fa-flickr"></i></a>
        <a href="#" class="social-icon-ar vine"><i class="fa fa-vine"></i></a>
        <a href="#" class="social-icon-ar dribbble"><i class="fa fa-dribbble"></i></a>
    </div>
</div> <!-- sb-slidebar sb-right -->
<div id="back-top">
    <a href="#header"><i class="fa fa-chevron-up"></i></a>
</div>
<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/slidebars.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script src="js/holder.js"></script>
<script src="js/buttons.js"></script>
<script src="js/styleswitcher.js"></script>
<script src="js/jquery.mixitup.min.js"></script>
<script src="js/circles.min.js"></script>

<!-- Syntaxhighlighter -->
<script src="js/syntaxhighlighter/shCore.js"></script>
<script src="js/syntaxhighlighter/shBrushXml.js"></script>
<script src="js/syntaxhighlighter/shBrushJScript.js"></script>

<script src="js/app.js"></script>

</body>

</html>
