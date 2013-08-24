<?php

	ob_start();
	set_time_limit(0);
	error_reporting(E_ALL);
	include('../include/config.php');
	include('function.php');
	
	#Livingsocial
	$url_1 = 'http://1802631:8yiwZqQW@datatransfer.cj.com/datatransfer/files/1802631/outgoing/productcatalog/117785/LivingSocial-LivingSocial_Product_Catalog.xml.gz';
	//$products_1 = getData($url_1,1);
	// add Santanu
	$file_zip = 'abc_'.$id.'.xml.gz';
	$fp = fopen("download/$file_zip", "w"); 
	$request = curl_init();
	$headers = array('Content-type: application/x-gzip','Connection: Close');
	curl_setopt($request, CURLOPT_URL, $url);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($request, CURLOPT_TIMEOUT, 0);
	curl_setopt($request, CURLOPT_CONNECTTIMEOUT,0);
	curl_setopt($request, CURLOPT_HTTPHEADER,$headers);
	curl_setopt($request, CURLOPT_FAILONERROR, true);
	curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($request, CURLOPT_AUTOREFERER, true);
	curl_setopt($request, CURLOPT_BINARYTRANSFER,true);
	
	curl_setopt($request, CURLOPT_FILE, $fp);
	
	$zipFile = curl_exec($request);
	
	$dest_zip = 'download/'.$file_zip;
	$dest_xml = "download/file_".$id.".xml"; 
	fopen($dest_xml,"w");
	$handle = fopen($dest_xml, 'a');
	 $zh = gzopen($dest_zip,'r')
	   or die("can't open: $php_errormsg");
	 while ($line = gzgets($zh,12000)) {
		// $line is the next line of uncompressed data, up to 1024 bytes 
		fwrite($handle, $line);
	  }
	 gzclose($zh) or die("can't close: $php_errormsg");
	 fclose($handle);
	 //end santanu
	echo '<pre>'.print_r($products_1,true).'</pre>';
	exit;
	
	
	$products = array();
	for($i=0; $i<count($products_1)-1; $i++)
	{
		$date = date('Y-m-d H:i:s');
		#MANAGE_DEAL_SOURCE#
		$site_name = $products_1[$i]["site_name"];
		$site_url = $products_1[$i]["site_url"];
		$sql_deal_source = 'SELECT * FROM '.MANAGE_DEAL_SOURCE." WHERE deal_source_name='".$site_name."'";
		$result_deal_source = mysql_query($sql_deal_source);
		$count_deal_source = mysql_num_rows($result_deal_source);
		if($count_deal_source>0)
		{
			$row_deal_source = mysql_fetch_array($result_deal_source);
			$deal_source_id = $row_deal_source["deal_source_id"];
		}
		else
		{
			$sql_insert_deal_source = 'INSERT INTO '.MANAGE_DEAL_SOURCE."(deal_source_name,deal_source_url,is_active,deal_source_date) VALUES('".$site_name."','".$site_url."','1','".$date."')";
			mysql_query($sql_insert_deal_source);
			$deal_source_id = mysql_insert_id();
		}
		
		$products["deal_sources_id"] = $deal_source_id;
		
		#MANAGE_E_MAIN_CATEGORY#
		$category = $products_1[$i]["cat_name"];
		$sql_category = 'SELECT * FROM '.MANAGE_E_MAIN_CATEGORY." WHERE category_name='".$category."'";
		$result_category = mysql_query($sql_category);
		$count_category = mysql_num_rows($result_category);
		if($count_category>0)
		{
			$row_category = mysql_fetch_array($result_category);
			$cat_id = $row_category["id"];
		}
		else
		{
			$sql_insert_category = 'INSERT INTO '.MANAGE_E_MAIN_CATEGORY."(category_name,is_active,cate_update) VALUES('".$category."','1','".$date."')";
			mysql_query($sql_insert_category);
			$cat_id = mysql_insert_id();
		}
		
		$products["cat_id"] = $cat_id;
		
		#TABLE_PRODUCT#
		$products["title"] = mysql_escape_string($products_1[$i]["product_title"]);
		$products["description"] = mysql_escape_string($products_1[$i]["description"]);
		$products["deal_url"] = $products_1[$i]["buy_url"];
		$products["currency"] = $products_1[$i]["currency"];
		$products["deal_price"] = $products_1[$i]["deal_price"];
		$products["actual_price"] = $products_1[$i]["actual_price"];
		$products["savings_amount"] = $products["actual_price"] - $products["deal_price"];
		$products["discount_perc"] = number_format((100 * $products["savings_amount"])/$products["actual_price"], 0, '.', '');
		$products["image_url"] = $products_1[$i]["img_url"];
		$products["deal_start_date"] = $products_1[$i]["deal_start_time"];
		$products["deal_end_date"] = $products_1[$i]["deal_end_time"];
		$products["latitude"] = $products_1[$i]["latitude"];
		$products["longitude"] = $products_1[$i]["longitude"];
		$products["deal_site"] = $site_name;
		$products["is_active"] = 1;
		$products["pupdate"] = $date;
		$products["parsing_time"] = date('Y-m-d H:i:s');
		
		
		
		$sql_deal = 'INSERT INTO '.TABLE_PRODUCT."(
													deal_sources_id,
													cat_id,
													title, 
													description,
													deal_url,
													currency,
													deal_price,
													actual_price,
													savings_amount,
													discount_perc,
													image_url,
													deal_start_date,
													deal_end_date,
													latitude,
													longitude,
													deal_site,
													is_active,
													pupdate,
													parsing_time
												 )  VALUES(
													'".$products["deal_sources_id"]."',
													'".$products["cat_id"]."',
													'".$products["title"]."',
													'".$products["description"]."',
													'".$products["deal_url"]."',
													'".$products["currency"]."',
													'".$products["deal_price"]."',
													'".$products["actual_price"]."',
													'".$products["savings_amount"]."',
													'".$products["discount_perc"]."',
													'".$products["image_url"]."',
													'".$products["deal_start_date"]."',
													'".$products["deal_end_date"]."',
													'".$products["latitude"]."',
													'".$products["longitude"]."',
													'".$products["deal_site"]."',
													'".$products["is_active"]."',
													'".$products["pupdate"]."',
													'".$products["parsing_time"]."'
												 )";

			mysql_query($sql_deal);
		
	}
		
?>