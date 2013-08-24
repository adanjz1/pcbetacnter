<?php
require("/var/chroot/home/content/75/9711075/html/config.inc.php");
require("/var/chroot/home/content/75/9711075/html/class/Database.class.php");
require("/var/chroot/home/content/75/9711075/html/class/SimpleLargeXMLParser.class.php");
require("/var/chroot/home/content/75/9711075/html/parse_override.php");

/*require("../../config.inc.php");
require("../../class/Database.class.php");
require("../../class/SimpleLargeXMLParser.class.php");
require("../../parse_override.php");*/
set_time_limit(0); 
$myAffiliateID = '245502';
$APIToken = "BivqzQSsctdx648q";
$APISecretKey = "LGf0tk4t2KPcxz8jDTv0cf5j0YImni2z";


$myTimeStamp = gmdate(DATE_RFC1123);

$local_file = "shaeasale.xml";
$fp = fopen($local_file, 'w');

$APIVersion = 1.5;
$actionVerb = "couponDeals";
$sig = $APIToken.':'.$myTimeStamp.':'.$actionVerb.':'.$APISecretKey;

$sigHash = hash("sha256",$sig);

$myHeaders = array("x-ShareASale-Date: $myTimeStamp","x-ShareASale-Authentication: $sigHash");

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_URL, "https://shareasale.com/x.cfm?affiliateId=$myAffiliateID&token=$APIToken&version=$APIVersion&action=$actionVerb&approvedonly=1&XMLFormat=1");

curl_setopt($ch, CURLOPT_HTTPHEADER,$myHeaders);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);

$returnResult = curl_exec($ch);

if ($returnResult) {
	//parse HTTP Body to determine result of request
	if (stripos($returnResult,"Error Code ")) {
		// error occurred
		trigger_error($returnResult,E_USER_ERROR);
	}else{
		// success
		fwrite($fp,$returnResult);
	}
}else{
	// connection error
	trigger_error(curl_error($ch),E_USER_ERROR);
}

		$xml_1 = "http://www.pccounter.net/admin/sharesale/shaeasale.xml";
		
		if($xml_1!='')

		{
			// create a new object
			$parser = new SimpleLargeXMLParser();
			
			// load the XML
			$parser->loadXML($xml_1);
			
			$pr= $parser->parseXML("//dealcouponlistreportrecord");
			
			for($i=0; $i<count($pr); $i++)
			{
				$share_coupon = $pr[$i];
				
				/*echo '<pre>';
				print_r($share_coupon);*/
				$coupon_source_id = $share_coupon[merchantid][0];
				$coupon_merchant = $share_coupon[merchant][0];
				
				/*CHECKING AND INSERTING COUPON SOURCE STARTS*/
			
				$sqlcheck_couponsource = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_name = '".$coupon_merchant."'";
				$rescheck_couponsource = mysql_query($sqlcheck_couponsource);
				$numcheck_couponsource = mysql_num_rows($rescheck_couponsource);
				$rowcheck_couponsource = mysql_fetch_array($rescheck_couponsource);
				
				if($numcheck_couponsource == 0)
				{
					$sqlinsert_couponsource = "insert into ".MANAGE_DEAL_SOURCE." (programId,deal_source_name,is_active,deal_source_date) values (".$coupon_source_id.",'".$coupon_merchant."',1,NOW())";
					$resinsert_couponsource = mysql_query($sqlinsert_couponsource);
				}
				
				/*CHECKING AND INSERTING COUPON SOURCE STOPS*/
				
				$coupon_category = $share_coupon[category][0];
				
				/*CHECKING AND INSERTING CATEGORY STARTS*/
			
				
				
				
				/*CHECKING AND INSERTING CATEGORY STOPS*/
				
				$coupon_start = explode(".",$share_coupon[startdate][0]);
				$coupon_start_date = $coupon_start[0];
				
				$coupon_end = explode(".",$share_coupon[enddate][0]);
				$coupon_end_date = $coupon_end[0];
				
				$coupon_publish = explode(".",$share_coupon[publishdate][0]);
				$coupon_publish_date = $coupon_publish[0];
				
				$coupon_name = $share_coupon[title][0];
				
				$coupon_big_image = $share_coupon[bigimage][0];
				$coupon_small_image = $share_coupon[smallimage][0];
				
				$coupon_url = $share_coupon[trackingurl][0];
				$coupon_description = $share_coupon[description][0];
				$coupon_keyword = $share_coupon[keywords][0];
				$coupon_code = $share_coupon[couponcode][0];
				$coupon_edit = explode(".",$share_coupon[editdate][0]);
				$coupon_editdate = $coupon_edit[0];
				
				$catId=0;
				$catId=mapCategoryMain($coupon_name,'','','c');
				
				/*CHECKING AND INSERTING COUPON STARTS*/
			
				$sqlcheck_coupon = "select * from ".TABLE_PRODUCT." where deal_sources_id = ".$rowcheck_couponsource['deal_source_id']." and cat_id = ".$catId." and title = ".addslashes($coupon_name)." and deal_coupon = 'c'";
				$rescheck_coupon = mysql_query($sqlcheck_coupon);
				$numcheck_coupon = @mysql_num_rows($rescheck_coupon);
				$rowcheck_coupon = @mysql_fetch_array($rescheck_coupon);
				
				if($numcheck_coupon == 0)
				{
					$sqlinsert_coupon = "insert into ".TABLE_PRODUCT." (deal_sources_id,cat_id,title,description,deal_url,image_url,deal_start_date,deal_end_date,actual_price,deal_price,sku,keywords,is_active,deal_coupon) values (".$rowcheck_couponsource['deal_source_id'].",".$catId.",'".addslashes($coupon_name)."','".addslashes($coupon_description)."','".$coupon_url."','','".$coupon_start_date."','".$coupon_end_date."','','','".$coupon_code."','".$coupon_keyword."',1,'c')";
					if($catId>0)
						$resinsert_coupon = mysql_query($sqlinsert_coupon);
					
				}
				else
				{
					$sqlUp_coupon = "update ".TABLE_PRODUCT." set
					deal_sources_id='".$rowcheck_couponsource['deal_source_id']."',
					cat_id='".$catId."',
					title='".addslashes($coupon_name)."',
					description='".addslashes($coupon_description)."',
					deal_url='".$coupon_url."',
					image_url='".$impressionpixel."',
					deal_start_date='".$coupon_start_date."',
					deal_end_date='".$coupon_end_date."',
					sku='".$coupon_code."',
					keywords='".$coupon_keyword."',
					";
					if($catId>0)
						$resinsert_coupon = mysql_query($sqlUp_coupon);
				}
				
				/*CHECKING AND INSERTING COUPON STOPS*/
				
			}
			
		}
		
		unlink('shaeasale.xml');
		
		
curl_close($ch);
?>