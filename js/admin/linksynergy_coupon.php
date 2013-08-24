<?php 
	require_once("/var/chroot/home/content/75/9711075/html/admin/include/top_menu.php"); 
	/*require("/var/chroot/home/content/75/9711075/html/config.inc.php");
require("/var/chroot/home/content/75/9711075/html/class/Database.class.php");
require("/var/chroot/home/content/75/9711075/html/class/SimpleLargeXMLParser.class.php");*/
/*require("../config.inc.php");
require("../class/Database.class.php");
require("../class/SimpleLargeXMLParser.class.php");
require("../parse_override.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
$db->connect();*/
	set_time_limit(0); 

	$xml_1 = "http://couponfeed.linksynergy.com/coupon?token=9c572896dedff9f2f640edaceeff1e37ead2a7a844ceb2ca7360d19f89807f07&category=4|3|5";


		
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
		
		$pr= $parser->parseXML("//link");
		
		/*echo '<pre>';
		print_r($pr);
		exit;*/
		
		
		for($i=0; $i<count($pr); $i++)
		{
			$deal_category = $pr[$i];
			
			$deal_cat = $deal_category['categories'];
			
			foreach($deal_cat as $product)
			{
				
				$prodcat = $product['category'];
				
				$catId=0;
				//$catSubId=0;
				
				for($k=0; $k<count($prodcat); $k++)
				{
					$catId=mapCategoryMain($prodcat[$k],'','','c');
					/*if($catId!=0)
					{
						$catSubId=mapCategorySub($prodcat,'','',$catId);
					}*/
				}
			}
			
			$promotions = $deal_category['promotiontypes'];
			
			foreach($promotions as $product_prom)
			{
				
				$promotion = $product_prom['promotiontype'];
				
				for($k=0; $k<count($promotion); $k++)
				{
					$promotion_spec = $promotion[$k];
				}
				
			}
			
			$description = $deal_category['offerdescription'][0];
			$first_price = explode("for ",$description);
			$second_price = explode(" ",$first_price[1]);
			$third_price = explode("$",$second_price[0]);	
			$fullprice = $third_price[1];
			
			
			$savings1 = explode("A $",$description);
			$savings2 = explode(" ",$savings1[1]);
			$final_savings = $savings2[0];
			
			
			$deal_price = ($final_savings - $fullprice);
			
			$start_date = $deal_category['offerstartdate'][0];
			$end_date = $deal_category['offerenddate'][0];
			
			$deal_url = $deal_category['clickurl'][0];
			
			$impressionpixel = $deal_category['impressionpixel'][0];
			
			$advertiseid = $deal_category['advertiserid'][0];
			
			$advertisername = $deal_category['advertisername'][0];
			
			$sqlcheck_dealsource = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_name = '".$advertisername."'";
			$rescheck_dealsource = mysql_query($sqlcheck_dealsource);
			$numcheck_dealsource = mysql_num_rows($rescheck_dealsource);
			$rowcheck_dealsource = mysql_fetch_array($rescheck_dealsource);
			
			if($numcheck_dealsource == 0)
			{
				$sqlinsert_dealsource = "insert into ".MANAGE_DEAL_SOURCE." (programId,deal_source_name,is_active,deal_source_date) values (".$advertiseid.",'".$advertisername."',1,NOW())";
				$resinsert_dealsource = mysql_query($sqlinsert_dealsource);
			}
			
			$sqlcheck_coupon = "select * from ".TABLE_PRODUCT." where deal_sources_id = ".$rowcheck_dealsource['deal_source_id']." and cat_id = ".$catId." and title = '".addslashes($description)."' and deal_coupon = 'c'";
			$rescheck_coupon = mysql_query($sqlcheck_coupon);
			$numcheck_coupon = mysql_num_rows($rescheck_coupon);
			$rowcheck_coupon = mysql_fetch_array($rescheck_coupon);
			
			if($numcheck_coupon == 0)
			{
				$sqlinsert_coupon = "insert into ".TABLE_PRODUCT." (deal_sources_id,cat_id,title,description,deal_url,image_url,deal_start_date,deal_end_date,actual_price,deal_price,is_active,deal_coupon) values (".$rowcheck_dealsource['deal_source_id'].",".$catId.",'".addslashes($description)."','".addslashes($description)."','".$deal_url."','".$impressionpixel."','".$start_date."','".$end_date."','".$fullprice."','".$deal_price."',1,'c')";
				if($catId>0)
					$resinsert_coupon = mysql_query($sqlinsert_coupon);
				
			}
			else
			{
				$sqlUp_coupon = "update ".TABLE_PRODUCT." set
				deal_sources_id='".$rowcheck_dealsource['deal_source_id']."',
				cat_id='".$catId."',
				title='".addslashes($description)."',
				description='".addslashes($description)."',
				deal_url='".$deal_url."',
				image_url='".$impressionpixel."',
				deal_start_date='".$start_date."',
				deal_end_date='".$end_date."',
				actual_price='".$fullprice."',
				deal_price='".$deal_price."',
				";
				if($catId>0)
					$resinsert_coupon = mysql_query($sqlUp_coupon);
			}
			
		}
	}
	

?>			
