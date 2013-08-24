<?php 
require_once("include/top_menu.php"); 

if ("cli" !== PHP_SAPI)
{
	echo "<pre>";
}



defined('AWS_API_KEY') or define('AWS_API_KEY', '1WM82JDV2BT6D0463KR2');
defined('AWS_API_SECRET_KEY') or define('AWS_API_SECRET_KEY', 'H+cJVfXUJZso/bN45anCLyKXkeqb9MIj+lafPTLL');
defined('AWS_ASSOCIATE_TAG') or define('AWS_ASSOCIATE_TAG', 'pcco05-20');

require 'lib/AmazonECS.class.php';

try
{
	$amazonEcs = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'COM', AWS_ASSOCIATE_TAG);

	// for the new version of the wsdl its required to provide a associate Tag
	// @see https://affiliate-program.amazon.com/gp/advertising/api/detail/api-changes.html?ie=UTF8&pf_rd_t=501&ref_=amb_link_83957571_2&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=&pf_rd_s=assoc-center-1&pf_rd_r=&pf_rd_i=assoc-api-detail-2-v2
	// you can set it with the setter function or as the fourth paramameter of ther constructor above
	$amazonEcs->associateTag(AWS_ASSOCIATE_TAG);

	// Looking up multiple items
	//$response = $amazonEcs->responseGroup('Large')->optionalParameters(array('Condition' => 'New'))->lookup('B0017TZY5Y', 'B004DULNPY');
	//var_dump($response);

	//$response = $amazonEcs->responseGroup('Images')->lookup('B0017TZY5Y');
	//var_dump($response);
	//$response = $amazonEcs->category('Books')->search('PHP 5');
	//var_dump($response);
	  //$response = $amazonEcs->responseGroup('Small')->category('Books')->search('PHP 5');  Music
	  //$delete_product = mysql_query("delete from ".PRODUCT." where value_from = 'Amazon'");
	  
	  $categories = array("VideoGames","Electronics");
	  
	  $today = date("Y-m-d");
	  
	  
	  /*CHECKING AND INSERTING DEAL SOURCE STARTS*/
			
		$sqlcheck_dealsource = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_name = 'Amazon'";
		$rescheck_dealsource = mysql_query($sqlcheck_dealsource);
		$numcheck_dealsource = mysql_num_rows($rescheck_dealsource);
		$rowcheck_dealsource = mysql_fetch_array($rescheck_dealsource);
		
		if($numcheck_dealsource == 0)
		{
			$sqlinsert_dealsource = "insert into ".MANAGE_DEAL_SOURCE." (deal_source_name,is_active,deal_source_date) values ('Amazon',1,NOW())";
			$resinsert_dealsource = mysql_query($sqlinsert_dealsource);
		}
		
		/*CHECKING AND INSERTING DEAL SOURCE STOPS*/
	  
	  
	  foreach($categories as $value)
	  {
	  	$response = $amazonEcs->responseGroup('Small,Offers,Images')->category($value)->search('all');
	  
	  
	    /*CHECKING AND INSERTING CATEGORY STARTS*/
			
		$sqlcategory_check = "select * from ".MANAGE_E_MAIN_CATEGORY." where category_name = '".$value."'";
		$rescategory_check = mysql_query($sqlcategory_check);
		$numcategory_check = @mysql_num_rows($rescategory_check);
		$rowcategory_check = @mysql_fetch_array($rescategory_check);
		
		if($numcategory_check == 0)
		{
			$sqlinsert_category = "insert into ".MANAGE_E_MAIN_CATEGORY." (category_name,is_active,cate_update) values ('".$value."',1,NOW())";
			$resinsert_category = mysql_query($sqlinsert_category);
		}	
		
		$sqlmaincategory_check = "select * from ".MANAGE_E_CATEGORY." where category_name = '".$value."'";	
		$resmaincategory_check = mysql_query($sqlmaincategory_check);	
		$nummaincategory_check = mysql_num_rows($resmaincategory_check);
		$rowmaincategory_check = mysql_fetch_array($resmaincategory_check);
		
		if($nummaincategory_check == 0)
		{
			$sqlinsertmain_category = "insert into ".MANAGE_E_CATEGORY." (category_name,is_active,cate_update) values('".$value."',1,NOW())";
			$resinsertmain_category = mysql_query($sqlinsertmain_category);
		}
		
		/*CHECKING AND INSERTING CATEGORY STOPS*/
	  
	    //echo $response->Items->Item;
	   //var_dump($response->Items->Item[4]->OfferSummary);
      //echo count($response->Items->Item);
	 //var_dump($response->Items->Item[4]->MediumImage);
	//echo $response->Items->Item[4]->DetailPageURL;
	
	/*print_r($response->Items->Item);
	die;*/
	
	
	for($i=0; $i<count($response->Items->Item); $i++)
	{
		
		/*echo "Title : {$response->Items->Item[$i]->ItemAttributes->Title}<br>";
		echo "Price : {$response->Items->Item[$i]->OfferSummary->LowestNewPrice->FormattedPrice}<br>";
		echo "ASIN : {$response->Items->Item->ASIN}<br>";
		echo "<br><a href=\"".$response->Items->Item[$i]->DetailPageURL." \" target=\"_blank\"><img src=\"" . $response->Items->Item[$i]->MediumImage->URL . "\" /></a><br>============================================================================================<br>";*/
		$productprice = explode("$","{$response->Items->Item[$i]->OfferSummary->LowestNewPrice->FormattedPrice}");
		echo $prod_price = $productprice[1];
		$product_sku = 'amazo-1-'.rand(1000, 9000);
		
		/*CHECKING AND INSERTING PRODUCT STARTS*/
			
		echo $sqlcheck_deal = "select * from ".TABLE_PRODUCT." where deal_sources_id = ".$rowcheck_dealsource['deal_source_id']." and cat_id = ".$rowmaincategory_check['id']." and title = '{$response->Items->Item[$i]->ItemAttributes->Title}' and deal_coupon = 'd'";
		$rescheck_deal = mysql_query($sqlcheck_deal);
		$numcheck_deal = mysql_num_rows($rescheck_deal);
		$rowcheck_deal = mysql_fetch_array($rescheck_deal);
		
		if($numcheck_deal == 0)
		{
			echo $sqlinsert_deal = "insert into ".TABLE_PRODUCT." (deal_sources_id,cat_id,title,description,deal_url,image_url,deal_start_date,deal_end_date,actual_price,deal_price,sku,is_active,deal_coupon) values (".$rowcheck_dealsource['deal_source_id'].",".$rowmaincategory_check['id'].",'{$response->Items->Item[$i]->ItemAttributes->Title}','{$response->Items->Item[$i]->ItemAttributes->Title}','{$response->Items->Item[$i]->DetailPageURL}','{$response->Items->Item[$i]->MediumImage->URL}','$today','0000-00-00 00:00:00','','".$prod_price."','".$product_sku."',1,'d')";
		die;
			$resinsert_deal = mysql_query($sqlinsert_deal);
			
		}
		
		/*CHECKING AND INSERTING PRODUCT STOPS*/
		
		/*$sel_cat = "select * from ".CATEGORIES." where cat_name = '$value'";
		$res_cat = mysql_query($sel_cat);
		while($row_cat = mysql_fetch_array($res_cat))
		{
		
		
		$productinsert = "insert into ".PRODUCT." (category_id, merchant_id, product_name, product_price, product_image, product_url, sku_code, date_added, value_from) values('".$row_cat['cat_id']."', '1', '{$response->Items->Item[$i]->ItemAttributes->Title}', '$prod_price', '{$response->Items->Item[$i]->MediumImage->URL}', '{$response->Items->Item[$i]->DetailPageURL}', '$product_sku', '$today', 'Amazon')";
		
		}*/
		
	}

}
}
catch(Exception $e)
{
  echo $e->getMessage();
}

if ("cli" !== PHP_SAPI)
{
	echo "</pre>";
}

?>



<!-- Footer -->

<?php require_once("include/footer.php"); ?>				

<!-- End of Footer -->