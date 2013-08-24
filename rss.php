<?php

// THIS IS ABSOLUTELY ESSENTIAL - DO NOT FORGET TO SET THIS
@date_default_timezone_set("GMT");

$writer = new XMLWriter();
// Output directly to the user

$writer->openURI('php://output');
$writer->startDocument('1.0');

$writer->setIndent(4);

// declare it as an rss document
$writer->startElement('rss');
$writer->writeAttribute('version', '2.0');
$writer->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');


$writer->startElement("channel");
//----------------------------------------------------
//$writer->writeElement('ttl', '0');
$writer->writeElement('title', 'PC Counter');
$writer->writeElement('description', 'PC Counter Products, Categories, Stores and Brands');
$writer->writeElement('link', 'http://www.unifiedinfotech.net/pc_counter/');
$writer->writeElement('pubDate', date("D, d M Y H:i:s e"));
$writer->startElement('image');
$writer->writeElement('title', 'Product');
$writer->writeElement('link', 'http://www.unifiedinfotech.net/pc_counter/');
$writer->writeElement('url', 'http://www.unifiedinfotech.net/pc_counter/images/logo.png');
$writer->writeElement('width', '120');
$writer->writeElement('height', '60');
$writer->endElement();
//----------------------------------------------------

require("config.inc.php");
require("class/Database.class.php");
	
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
$db->connect();

$check_present_time=date("Y-m-d h:i:s");
$sql = "SELECT *
FROM `pc_counter_product` order by `product_id` desc limit 0,20";
$run=mysql_query($sql);
while($data=mysql_fetch_array($run)){
//----------------------------------------------------
$writer->startElement("item");
$writer->writeElement('title', $data['title']);
$writer->writeElement('link', 'http://www.unifiedinfotech.net/pc_counter/deal_detail.php?productid='.$data['product_id']);
$writer->writeElement('image', $data['image_url']);
$writer->writeElement('description', $data['description']);
$writer->writeElement('guid', 'http://www.unifiedinfotech.net/pc_counter/');

$writer->writeElement('pubDate', date("D, d M Y H:i:s e"));



$writer->startElement('category');
$writer->writeAttribute('domain', 'http://www.domain.com/link.htm');
$writer->text('April 2011');
$writer->endElement(); // Category

// End Item
$writer->endElement();
//----------------------------------------------------

}
// End channel
$writer->endElement();

// End rss
$writer->endElement();

$writer->endDocument();

$writer->flush();
?> 
