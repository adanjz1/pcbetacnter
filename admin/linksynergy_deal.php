<?php 
require_once("/var/chroot/home/content/75/9711075/html/admin/include/top_menu.php"); 
/*require("../config.inc.php");
require("../class/Database.class.php");
require("../class/SimpleLargeXMLParser.class.php");
require("../parse_override.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
$db->connect();*/
set_time_limit(0); 


	$keyword = array("DVD Player", "Computer", "Xerox", "Printer", "telephone", "ipaq");
	
	/*echo '<pre>';
	print_r($keyword);
	die(">>>>>>");*/
	
	for($k=0; $k<count($keyword); $k++)
	{
		$xml_1 = "http://productsearch.linksynergy.com/productsearch?token=9c572896dedff9f2f640edaceeff1e37ead2a7a844ceb2ca7360d19f89807f07&keyword=".$keyword[$k]."&MaxResults=100&pagenumber=1&sort=retailprice&sorttype=asc&sort=productname&sorttype=asc";
	}
	
	//exit;

	//$xml_1 = "http://productsearch.linksynergy.com/productsearch?token=9c572896dedff9f2f640edaceeff1e37ead2a7a844ceb2ca7360d19f89807f07&keyword=%22DVD%20Player%22&MaxResults=100&pagenumber=1&sort=retailprice&sorttype=asc&sort=productname&sorttype=asc";


		
	//=================================== Parsing xml 10 ===========================================
	
	$token_category = explode("=",$xml_1);
	
	
	$token_cat = explode("|",$token_category[2]);
	
	for($j=0; $j<count($token_cat); $j++)
	{
		$category = $token_cat[$j];	
		/*$sqlmain_category = "insert into ".MANAGE_E_MAIN_CATEGORY." (category_name,cat_image,is_active,cate_update) values('','','',NOW())";
		$resmain_category = mysql_query($sqlmain_category);	*/	
	}
	
	if($xml_1!='')

	{
		// create a new object
		$parser = new SimpleLargeXMLParser();
		
		// load the XML
		$parser->loadXML($xml_1);
		
		$pr= $parser->parseXML("//item");
		
		/*echo '<pre>';
		print_r($pr);
		die(">>>>>>>>");*/
		
		for($i=0; $i<count($pr); $i++)
		{
			$link_deal = $pr[$i];
			/*echo '<pre>';
			print_r($link_deal);*/
			
			$merchantname = $link_deal[merchantname][0];
			$merchantid = $link_deal[linkid][0];
			
			/*CHECKING AND INSERTING DEAL SOURCE STARTS*/
			
			$sqlcheck_dealsource = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_name = '".$merchantname."'";
			$rescheck_dealsource = mysql_query($sqlcheck_dealsource);
			$numcheck_dealsource = mysql_num_rows($rescheck_dealsource);
			$rowcheck_dealsource = mysql_fetch_array($rescheck_dealsource);
			
			if($numcheck_dealsource == 0)
			{
				$sqlinsert_dealsource = "insert into ".MANAGE_DEAL_SOURCE." (programId,deal_source_name,is_active,deal_source_date) values (".$merchantid.",'".$merchantname."',1,NOW())";
				$resinsert_dealsource = mysql_query($sqlinsert_dealsource);
			}
			
			/*CHECKING AND INSERTING DEAL SOURCE STOPS*/
			
			$deal_cat = $link_deal[category][0][primary][0];
			
			/*CHECKING AND INSERTING CATEGORY STARTS*/
			
			$catId=0;
			$catSubId=0;
			$catId=mapCategoryMain($product_name,$keyword,$product_description);
			if($catId!=0)
			{
				$catSubId=mapCategorySub($product_name,$keyword,$product_description,$catId);
			}
			
			/*CHECKING AND INSERTING CATEGORY STOPS*/
			
			$date = $link_deal[createdon][0];
			$deal_starting_date = explode("/",$date);
			$deal_start_date = $deal_starting_date[0]." ".$deal_starting_date[1];
			$deal_sku = $link_deal[sku][0];
			$deal_name = $link_deal[productname][0];
			$deal_price = $link_deal[price][0];
			$deal_description = $link_deal[description][0][long][0];
			$deal_keyword = $link_deal[keywords][0];
			$deal_url = $link_deal[linkurl][0];
			$deal_image_url = $link_deal[imageurl][0];
			
			/*CHECKING AND INSERTING PRODUCT STARTS*/
			
			$sqlcheck_deal = "select * from ".TABLE_PRODUCT." where deal_sources_id = ".$rowcheck_dealsource['deal_source_id']." and cat_id = ".$catId." and title = ".addslashes($deal_name)." and deal_coupon = 'd'";
			$rescheck_deal = mysql_query($sqlcheck_deal);
			$numcheck_deal = mysql_num_rows($rescheck_deal);
			$rowcheck_deal = mysql_fetch_array($rescheck_deal);
			
			if($numcheck_deal == 0)
			{
				$sqlinsert_deal = "insert into ".TABLE_PRODUCT." (deal_sources_id,cat_id,sub_cat_id,title,description,deal_url,image_url,deal_start_date,deal_end_date,actual_price,deal_price,sku,keywords,is_active,deal_coupon) values (".$rowcheck_dealsource['deal_source_id'].",".$catId.",".$catSubId.",'".addslashes($deal_name)."','".addslashes($deal_description)."','".$deal_url."','".$deal_image_url."','".$deal_start_date."','".$end_date."','".$fullprice."','".$deal_price."','".$deal_sku."','".$deal_keyword."',1,'d')";
				if($catId>0)
					$resinsert_deal = mysql_query($sqlinsert_deal);
				
			}
			else
			{
				$start_date = date("Y-m-d", strtotime($start_date1));
				$end_date = date("Y-m-d",strtotime($end_date1));
				$sqlupdate_coupon = " UPDATE ".TABLE_PRODUCT." SET
									description='".addslashes($deal_description)."',
									deal_url='".$deal_url."',
									image_url='".$deal_image_url."',
									deal_start_date='".$deal_start_date."',
									deal_end_date='".$end_date."',
									actual_price='".$fullprice."',
									deal_price='".$deal_price."',
									keywords='".$keyword."'
									where deal_sources_id = ".$rowcheck_dealsource['deal_source_id']." and cat_id = ".$catId." and title = '".addslashes($deal_name)."'";
									if($deal_sku!='')
										$sqlcheck_coupon.=" and `sku`='".$deal_sku."'";
				
				if($catId>0)
					$resupdate_coupon = mysql_query($sqlupdate_coupon);
			
			}
			
			/*CHECKING AND INSERTING PRODUCT STOPS*/
		}
		
	}
	
	
	

?>			
