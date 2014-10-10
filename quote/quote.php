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
$objYahooStock->addFormat("snl1d1t1p2vmm3m4ee8djkhgj1j4p2qr1rym7m5oc1");
 
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
    ?>
    Code: <?php $str = $stock[0]; echo trim($str, '"'); ?> <br />
    Name: <?php echo $stock[1]; ?> <br />
    Last Trade Price: <?php echo $stock[2]; ?> <br />
    Last Trade Date: <?php echo $stock[3]; ?> <br />
    Last Trade Time: <?php echo $stock[4]; ?> <br />
    Percent Change: <?php echo $stock[5]; ?> <br />
	Change: <?php echo $stock[27]; ?> <br />
	Open: <?php echo $stock[26]; ?> <br />
    Volume: <?php echo $stock[6]; ?> <br /><br />
	Days Range: <?php echo $stock[7]; ?> <br />
	50 MA: <?php echo $stock[8]; ?> <br />
	200 MA: <?php echo $stock[9]; ?> <br /><br />
	EPS: <?php echo $stock[10]; ?> <br />
	EPS estimate next year : <?php echo $stock[11]; ?> <br /><br />
	Dividend Per Share: <?php echo $stock[12]; ?> <br /><br />
	52 Week High: <?php echo $stock[13]; ?> <br />
	52 Week Low: <?php echo $stock[14]; ?> <br /><br />
	Day High: <?php echo $stock[15]; ?> <br />
	Day Low: <?php echo $stock[16]; ?> <br /><br />
	Market Cap: <?php echo $stock[17]; ?> <br />
	EBITDA: <?php echo $stock[18]; ?> <br /><br />
	Percent Change: <?php echo $stock[19]; ?> <br />
	Ex Dividend Date: <?php echo $stock[20]; ?> <br /><br />
	Dividend Pay Date: <?php echo $stock[21]; ?> <br />
	P/E Ratio: <?php echo $stock[22]; ?> <br />
	Dividend Yield: <?php echo $stock[23]; ?> <br /><br />
	Distance from 50 MA: <?php echo $stock[24]; ?> <br />
	Distance from 200 MA: <?php echo $stock[25]; ?> <br />
    <?php
}
?>