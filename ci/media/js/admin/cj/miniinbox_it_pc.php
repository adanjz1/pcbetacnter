<?php
ob_start();
error_reporting(E_ALL);
require("/var/chroot/home/content/75/9711075/html/config.inc.php");
require("/var/chroot/home/content/75/9711075/html/class/Database.class.php");
require("/var/chroot/home/content/75/9711075/html/class/SimpleLargeXMLParser.class.php");
require("/var/chroot/home/content/75/9711075/html/parse_override.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
$db->connect();
//require_once("include/top_menu.php");
//fopen("test.xml","w");
set_time_limit(0);

$arr = array("http://1805267:MAm+ZsAu@datatransfer.cj.com/datatransfer/files/1805267/outgoing/productcatalog/131365/MiniInTheBox_com-IT_PC.xml.gz");



/* gets the data from a URL */
function get_zip_data($url,$dest_zip_files)
{
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
$output = curl_exec($ch);

$fh = fopen($dest_zip_files, 'w');
fwrite($fh, $output);
fclose($fh);
}



function get_xml_dt($dest_xml,$dest_zip)
{
fopen($dest_xml,"w");
$handle = fopen($dest_xml, 'a');
 $zh = gzopen($dest_zip,'r')
   or die("can't open: $php_errormsg");
 while ($line = gzgets($zh,10240)) {
    // $line is the next line of uncompressed data, up to 1024 bytes 
    fwrite($handle, $line);
  }
 gzclose($zh) or die("can't close: $php_errormsg");
 fclose($handle);

}

//$file_dir = dirname($_SERVER['SCRIPT_FILENAME']);
$file_dir = DIRPATH;

foreach ($arr as $file)
{

############ Get File name ################
preg_match("|([^\/]+)$|",$file,$s);
list($file_s,$xml) = explode(".",$s[1]);

if(empty($file_s))
$file_s = uniqid();
$dest_zip_files = $file_dir."/gzip/".$file_s.".xml.gz";
$dest_xml = $file_dir."/xml/".$file_s.".xml";
//$dest_json = $file_dir."/xml/".$file_s.".json";
#######################################

$returned_zip_content = get_zip_data($file,$dest_zip_files);

get_xml_dt($dest_xml,$dest_zip_files);

}
	
$file = $dest_xml;

$curr_tag = "";
$curr_data = "";

$program_name = "";
$program_url = "";
$catalog_name = "";
$lastupdate = "";
$product_name = "";
$keyword = "";
$product_description = "";
$product_sku = "";
$deal_currency = "";

$deal_price = "";
//$deal_retailprice = "";
$deal_buyurl = "";
$deal_impressionurl = "";
$deal_imageurl = "";

//$start_date1 = "";

//$end_date1 = "";

$instock = "";

function startElement($parser, $name, $attrs) 
{
	global $curr_tag;
    $curr_tag = strtolower($name);
}

function endElement($parser, $name){
	global $curr_tag,$curr_data,$program_name,$program_url,$catalog_name,$lastupdate,$product_name,$keyword,$product_description,$product_sku,$deal_currency,$deal_price,$deal_retailprice,$deal_buyurl,$deal_impressionurl,$deal_imageurl,$start_date1,$end_date1,$instock;
	
	if("programname"==$curr_tag){
		$program_name = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("programurl"==$curr_tag){
		$program_url = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("catalogname"==$curr_tag){
		$catalog_name = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("lastupdated"==$curr_tag){
		$lastupdate = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("name"==$curr_tag){
		$product_name = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("keywords"==$curr_tag){
		$keyword = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("description"==$curr_tag){
		$product_description = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("sku"==$curr_tag){
		$product_sku = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("currency"==$curr_tag){
		$deal_currency = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("price"==$curr_tag){
		$deal_price = trim($curr_data);
		$curr_data = "";
		return;
	}
	
	/*if("retailprice"==$curr_tag){
		$deal_retailprice = trim($curr_data);
		$curr_data = "";
		return;
	}*/
	if("buyurl"==$curr_tag){
		$deal_buyurl = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("impressionurl"==$curr_tag){
		$deal_impressionurl = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("imageurl"==$curr_tag){
		$deal_imageurl = trim($curr_data);
		$curr_data = "";
		return;
	}
	
	/*if("startdate"==$curr_tag){
		$start_date1 = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("enddate"==$curr_tag){
		$end_date1 = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("instock"==$curr_tag){
		$instock = trim($curr_data);
		$curr_data = "";
		return;
	}*/
	//echo $name."++++++++++++++";
	$end_tag = strtolower($name);
	if("product"==$end_tag){
	
		/*echo "++++++++++++++++++++++++".$program_name;
	
		echo "Product<br>";
		
		echo "Program name: ".$program_name."<br>";
		echo "Program Url: ".$program_url."<br>";
		echo "Catalog Name: ".$catalog_name."<br>";
		echo "LAst Updated: ".$lastupdate."<br>";
		echo "Price: ".$deal_price."<br>";
		
		echo "Name: ".$product_name."<br>";
		echo "Description: ".$product_description."<br>";
		echo "sku: ".$product_sku."<br>";
		echo "Currency: ".$deal_currency."<br>";
		echo "Price: ".$deal_price."<br>";
		//echo "Retail: ".$deal_retailprice."<br>";
		echo "Buy URL: ".$deal_buyurl."<br>";
		echo "Impression URL: ".$deal_impressionurl."<br>";
		echo "Image URL: ".$deal_imageurl."<br>";
		die(">>>>>>>>>");*/
		
	######################### CATEGORY INSERT STARTS ######################### 
		
	/*$sqlcategory_check = "select * from ".MANAGE_E_MAIN_CATEGORY." where category_name = '".$catalog_name."'";
	$rescategory_check = mysql_query($sqlcategory_check);
	$numcategory_check = @mysql_num_rows($rescategory_check);
	$rowcategory_check = @mysql_fetch_array($rescategory_check);
	
	if($numcategory_check == 0)
	{
		$sqlinsert_category = "insert into ".MANAGE_E_MAIN_CATEGORY." (category_name,is_active,cate_update) values ('".$catalog_name."',1,NOW())";
		$resinsert_category = mysql_query($sqlinsert_category);
	}	
	
	$sqlmaincategory_check = "select * from ".MANAGE_E_CATEGORY." where category_name = '".$catalog_name."'";	
	$resmaincategory_check = mysql_query($sqlmaincategory_check);	
	$nummaincategory_check = mysql_num_rows($resmaincategory_check);
	$rowmaincategory_check = mysql_fetch_array($resmaincategory_check);
	
	if($nummaincategory_check == 0)
	{
		$sqlinsertmain_category = "insert into ".MANAGE_E_CATEGORY." (category_name,is_active,cate_update) values('".$catalog_name."',1,NOW())";
		$resinsertmain_category = mysql_query($sqlinsertmain_category);
	}*/
	
	######################### CATEGORY INSERT STOPS ######################### 
	
	######################### DEAL SOURCE INSERT STARTS ######################### 
	$catId=0;
	$catSubId=0;
	$catId=mapCategoryMain($product_name,$keyword,$product_description);
	if($catId!=0)
	{
		$catSubId=mapCategorySub($product_name,$keyword,$product_description,$catId);
	}
		
	$sqlcheck_dealsource = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_name = '".$program_name."'";
	$rescheck_dealsource = mysql_query($sqlcheck_dealsource);
	$numcheck_dealsource = mysql_num_rows($rescheck_dealsource);
	$rowcheck_dealsource = mysql_fetch_array($rescheck_dealsource);
	
	if($numcheck_dealsource == 0)
	{
		$sqlinsert_dealsource = "insert into ".MANAGE_DEAL_SOURCE." (deal_source_name,deal_source_url,is_active,deal_source_date) values ('".$program_name."','".$program_url."',1,NOW())";
		$resinsert_dealsource = mysql_query($sqlinsert_dealsource);
	}
	
	######################### DEAL SOURCE INSERT STOPS ######################### 
	
	######################### PRODUCT INSERT STARTS ######################### 
		//echo '<pre>';
		$sqlcheck_coupon = "select * from ".TABLE_PRODUCT." where deal_sources_id = ".$rowcheck_dealsource['deal_source_id']." and cat_id = ".$catId." and title = '".$product_name."'";
		if($product_sku!='')
			$sqlcheck_coupon.=" and `sku`='".$product_sku."'";
			
		$rescheck_coupon = mysql_query($sqlcheck_coupon);
		$numcheck_coupon = @mysql_num_rows($rescheck_coupon);
		$rowcheck_coupon = @mysql_fetch_array($rescheck_coupon);
		
		if($numcheck_coupon == 0)
		{
			$start_date = date("Y-m-d", strtotime($start_date1));
			$end_date = date("Y-m-d",strtotime($end_date1));
			$sqlinsert_coupon = "insert into ".TABLE_PRODUCT." 
								(deal_sources_id,
								cat_id,
								sub_cat_id,
								title,
								description,
								deal_url,
								image_url,
								deal_start_date,
								deal_end_date,
								actual_price,
								deal_price,
								currency,
								keywords,
								sku,
								instock,
								is_active,
								deal_coupon)
								values 
								
								(".$rowcheck_dealsource['deal_source_id'].",
								".$catId.",
								".$catSubId.",
								'".$product_name."',
								'".$product_description."',
								'".$deal_buyurl."',
								'".$deal_imageurl."',
								'".$start_date."',
								'".$end_date."',
								'".$deal_retailprice."',
								'".$deal_price."',
								'".$deal_currency."',
								'".$keyword."',
								'".$product_sku."',
								'".$instock."',
								1,
								'd')";
			if($catId>0)
				$resinsert_coupon = mysql_query($sqlinsert_coupon);
		}
		else
		{
			$start_date = date("Y-m-d", strtotime($start_date1));
			$end_date = date("Y-m-d",strtotime($end_date1));
			$sqlupdate_coupon = " UPDATE ".TABLE_PRODUCT." SET
								description='".$product_description."',
								deal_url='".$deal_buyurl."',
								image_url='".$deal_imageurl."',
								deal_start_date='".$start_date."',
								deal_end_date='".$end_date."',
								actual_price='".$deal_retailprice."',
								deal_price='".$deal_price."',
								currency='".$deal_currency."',
								keywords='".$keyword."',
								instock='".$instock."'
								where deal_sources_id = ".$rowcheck_dealsource['deal_source_id']." and cat_id = ".$catId." and title = '".$product_name."'";
								if($product_sku!='')
									$sqlcheck_coupon.=" and `sku`='".$product_sku."'";
			
			if($catId>0)
				$resupdate_coupon = mysql_query($sqlupdate_coupon);
		}	
		
		######################### PRODUCT INSERT STOPS ######################### 
		
		return;
	}}
function characterData($parser, $data) 
{
	global $curr_tag,$curr_data;
	
	
	if("programname"==$curr_tag){
		$program_name = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("programurl"==$curr_tag){
		$program_url = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("catalogname"==$curr_tag){
		$catalog_name = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("lastupdated"==$curr_tag){
		$lastupdate = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("name"==$curr_tag){
		$product_name = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("keywords"==$curr_tag){
		$keyword = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("description"==$curr_tag){
		$product_description = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("sku"==$curr_tag){
		$product_sku = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("currency"==$curr_tag){
		$deal_currency = trim($curr_data);
		$curr_data = "";
		return;
	}
	if("price"==$curr_tag){
		$deal_price = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	/*if("retailprice"==$curr_tag){
		$deal_retailprice = trim($curr_data);
		$curr_data.=$data;
		return;
	}*/
	if("buyurl"==$curr_tag){
		$deal_buyurl = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("impressionurl"==$curr_tag){
		$deal_impressionurl = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("imageurl"==$curr_tag){
		$deal_imageurl = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	/*if("startdate"==$curr_tag){
		$start_date1 = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("enddate"==$curr_tag){
		$end_date1 = trim($curr_data);
		$curr_data.=$data;
		return;
	}
	if("instock"==$curr_tag){
		$instock = trim($curr_data);
		$curr_data.=$data;
		return;
	}*/
}


$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "characterData");

if (!($fp = fopen($file, "r"))) {
    die("could not open XML input");
}

while ($data = fread($fp, 10000)) {
    if (!xml_parse($xml_parser, $data, feof($fp))) {
        die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    }
}
xml_parser_free($xml_parser);
	
unlink($dest_zip_files);
unlink($dest_xml);
	
?> 
