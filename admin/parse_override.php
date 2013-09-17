<?php
require("../config.inc.php");
require("../class/Database.class.php");
require("../class/pagination.class.php");
require("../includes/functions.php");
require("../class/SimpleLargeXMLParser.class.php");
require("../includes/pagination.php");
ini_set("display_errors","0");


$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$sql_category = "select * from ".MANAGE_E_CATEGORY." order by cate_update desc";

$res_category = mysql_query($sql_category);

mapCategory($res_category, 'android phone');			  

function mapCategory(&$categoryKeyword, $title='')
   {
	while($row_category  = mysql_fetch_array($categoryKeyword))
	{
		$keywords = explode(',', $row_category['keyword']);
		foreach($keywords as $keyword){
			$pos = stripos($title, $keyword);
			if( $pos !== false){
				return $row_category;
			}
		}
	
	}
	return false;
}


