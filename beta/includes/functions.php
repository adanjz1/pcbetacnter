<?php
function sourceCount()
{
$sq4 = "SELECT COUNT (DISTINCT item_num) FROM items";
}


function wrptxt($strtouse, $len) {
    if (strlen($strtouse) > $len) {
        $strtouse = substr($strtouse, 0, $len);

        if (substr($strtouse, -1) != " ")
            $strtouse = substr($strtouse, 0, strrpos($strtouse, " ")) . " ... ";
        else
            $strtouse = $strtouse . " ....";
        return $strtouse;
    }
    else
        return $strtouse;
}

function google_maping($address)
{
	if(strpos($address,"</adility:location>")==false)
	{
		$str = str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address))));
		$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	}
	else
	{
		$str_1 = str_replace("<%2Fadility:location>","",str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address)))));
		$str = substr(strrchr($str_1,">"),1);
		$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	}
	
	//$str = str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address))));
	//$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	//$str_1 = str_replace("<%2Fadility:location>","",str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address)))));
	//$str = substr(strrchr($str_1,">"),1);
	//$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	
	// create a new object
	$parser = new SimpleLargeXMLParser();
	// load the XML
	$parser->loadXML($xml);
	$pr= $parser->parseXML("//result/geometry/location");
	//print_r($pr);
	$location = $pr[0];
	//print_r($location);
	$loc = $location[lat][0];
	$lng = $location[lng][0];
	
	echo '<iframe  width="300" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='.$str.'&amp;aq=&amp;sll='.$loc.','.$lng.'&amp;ie=UTF8&amp;hnear='.$str.'&amp;ll='.$loc.','.$lng.'&amp;output=embed"></iframe>';
}

function google_maping_url($address)
{
	if(strpos($address,"</adility:location>")==false)
	{
		$str = str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address))));
		$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	}
	else
	{
		$str_1 = str_replace("<%2Fadility:location>","",str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address)))));
		$str = substr(strrchr($str_1,">"),1);
		$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	}
	
	//$str_1 = str_replace("<%2Fadility:location>","",str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address)))));
	//$str = substr(strrchr($str_1,">"),1);
	//$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	
	//$str = str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address))));
	//$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	
	// create a new object
	$parser = new SimpleLargeXMLParser();
	// load the XML
	$parser->loadXML($xml);
	$pr= $parser->parseXML("//result/geometry/location");
	//print_r($pr);
	$location = $pr[0];
	//print_r($location);
	$loc = $location[lat][0];
	$lng = $location[lng][0];
	
	echo 'http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q='.$str.'&aq=&sll='.$loc.','.$lng.'&ie=UTF8&hq=&hnear='.$str.'&z=16';
}
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function google_ip_track($ip)
{
	$xml = $ip;
	
	/*// create a new object
	$parser = new SimpleLargeXMLParser();
	// load the XML
	$parser->loadXML($xml);
	$pr= $parser->parseXML("//gml:featureMember/Hostip/gml:name");
	//print_r($pr);
	$city_name = $pr[0];
	return $city_name;
	//echo $city_name = "Austin";*/
	
	// create a new object
	$parser = new SimpleLargeXMLParser();
	// load the XML
	$parser->loadXML($xml);
	$pr= $parser->parseXML("City");
	//print_r($pr);
	$city_name = $pr[0];
	return $city_name;
	
}
function google_deal_maping($address)
{
	$str = str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($address))));
	$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
	
	// create a new object
	$parser = new SimpleLargeXMLParser();
	// load the XML
	$parser->loadXML($xml);
	$pr= $parser->parseXML("//result/geometry/location");
	//print_r($pr);
	$location = $pr[0];
	//print_r($location);
	$loc = $location[lat][0];
	$lng = $location[lng][0];
	
	echo '<iframe  width="200" height="200" frameborder="1" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='.$str.'&amp;aq=&amp;sll='.$loc.','.$lng.'&amp;ie=UTF8&amp;hnear='.$str.'&amp;ll='.$loc.','.$lng.'&amp;output=embed"></iframe>';
}
/* Notice that a deal may have more than one category, this function should be run for each of them */
/* Notice also that this function actually inserts the data into the table instead of returning the value for use */
function FindCategorySynonymID ($INPUT_CATEGORY, $INPUT_DEAL_SOURCE, $INPUT_DEAL_ID)
{
/*Check if we know this synonym for this spesific source */

	$sql_1 = mysql_query("SELECT (".MANAGE_E_SUB_CATEGORY_SYNONYMS.".sub_category_synonym_id) as ID FROM ".MANAGE_E_SUB_CATEGORY_SYNONYMS." INNER JOIN ".MANAGE_E_DEAL_SOURCES_SUB_CATEGORY_SYNONYMS." ON (".MANAGE_E_DEAL_SOURCES_SUB_CATEGORY_SYNONYMS.".sub_category_synonym_id = ".MANAGE_E_SUB_CATEGORY_SYNONYMS.".sub_category_synonym_id)	WHERE (".MANAGE_E_DEAL_SOURCES_SUB_CATEGORY_SYNONYMS.".deal_source_id = '".$INPUT_DEAL_SOURCE."') AND (".MANAGE_E_SUB_CATEGORY_SYNONYMS.".sub_category_synonym = '".$INPUT_CATEGORY."')");
	$row_1 = mysql_fetch_array($sql_1);
	if (mysql_num_rows($sql_1)>0)
	{
		
		$sql_1_in = mysql_query("INSERT INTO ".MANAGE_E_DEAL_SUB_CATEGORY_SYNONYMS." (deal_id, sub_category_synonym_id) VALUES ('".$INPUT_DEAL_ID."', '".$row_1['ID']."')");
		$sub_syn_id = $row_1['ID'];
	}
	else
	{
/*Else, Check if we at least know this synonym (from other source)*/

		$sql_2 = mysql_query("SELECT (".MANAGE_E_SUB_CATEGORY_SYNONYMS.".sub_category_synonym_id) as IDS FROM ". MANAGE_E_SUB_CATEGORY_SYNONYMS." WHERE (".MANAGE_E_SUB_CATEGORY_SYNONYMS.".sub_category_synonym = '".$INPUT_CATEGORY."')");
		$row_2 = mysql_fetch_array($sql_2);
		if(mysql_num_rows($sql_2)>0)
		{
			
			$sql_2_in = mysql_query("INSERT INTO ".MANAGE_E_DEAL_SOURCES_SUB_CATEGORY_SYNONYMS." (deal_source_id, sub_category_synonym_id) VALUES ('".$INPUT_DEAL_SOURCE."', '".$row_2['IDS']."')");
			$sql_2_ins = mysql_query("INSERT INTO ".MANAGE_E_DEAL_SUB_CATEGORY_SYNONYMS." (deal_id, sub_category_synonym_id) VALUES ('".$INPUT_DEAL_ID."', '".$row_2['IDS']."')");
			$sub_syn_id = $row_2['IDS'];
		}
		else
		{
/* Otherwise, it is a new synonym */

			$sql_3 = mysql_query("INSERT INTO ".MANAGE_E_SUB_CATEGORY." (category_id, sub_category_name) VALUES (7, '".$INPUT_CATEGORY."')");
			$id_3 = mysql_insert_id();

			$sql_4 = mysql_query("INSERT INTO ".MANAGE_E_SUB_CATEGORY_SYNONYMS." (sub_category_id, sub_category_synonym) VALUES ('".$id_3."', '".$INPUT_CATEGORY."')");
			$id_4 = mysql_insert_id();
			
			$sql_5 = mysql_query("INSERT INTO ".MANAGE_E_DEAL_SOURCES_SUB_CATEGORY_SYNONYMS." (deal_source_id, sub_category_synonym_id) VALUES ('".$INPUT_DEAL_SOURCE."', '".$id_4."')");
			$id_5 = mysql_insert_id();
			
			$sql_6 = mysql_query("INSERT INTO ".MANAGE_E_DEAL_SUB_CATEGORY_SYNONYMS." (deal_id, sub_category_synonym_id) VALUES ('".$INPUT_DEAL_ID."', '".$id_5."')");
			$sub_syn_id = $id_5;
		}
	}
return $sub_syn_id;
}
function news_letter($city_name, $email_id)
{
	ob_start();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="imagestoolbar" content="no" />
	<title>News Letter</title>
	<!--<link href="http://hirewebprogrammer.com/hipdealz/includes/base_new.css" rel="stylesheet" type="text/css" />
	<link type="http://hirewebprogrammer.com/hipdealz/includes/css_new" href="menu.css" rel="stylesheet" />-->	
<style type="text/css">
<!--css_new.css-->
/* -------------------general CSS------------------------- */
.right_align_new{
	text-align: right;
}
.center_align_new{
	text-align: center;
}
.vert_top_new{
	vertical-align:top;
}
.clear{
	clear: both;
	line-height: 0px;
}
/*.float_left{
	float: left;
}*/
.float_right_new{
	float: right;
}
.font11_new{
	font-size: 11px;
}
/*.main_box{
	width: 100%;
	height: auto;
}*/
.img1_new{
	border: 1px solid #e8e8eb;
	padding: 2px;
}
	
/* ------------------maincontainer_new CSS--------------------- */
div#maincontainer_new{
	width: 625px;
	height: auto;
	clear: both;
	float: none;
	margin: 0 auto;
	background: #cef1fd;
	border: 4px solid #cef1fd;
}


/* ------------------body_new CSS------------------------------- */
div#body_new{
	width: 100%;
	height: auto;
	background: #FFFFFF;
}
.innertable_new{
	width: 96%;
	height: auto;
	margin: 0 auto;
}
.innertable_new td{
	vertical-align: middle;
	font: normal 12px/19px Tahoma, Geneva, sans-serif;
}

.preference_new a{
	background: #fffecc;
	display: block;
	color: #d57d00;
	text-align: center;
	padding: 5px 0;
	border: 1px solid #fcf4d5;
}
/*.preference_new{
	background: #fffecc;
	display: block;
	color: #d57d00;
	text-align: center;
	padding: 5px 0;
	border: 1px solid #fcf4d5;
}*/
.green_txt_new{
	color:#669900;
}
.brown_txt_new{
	color:#b04539;
}

.gray_txt_new{
	color: #999999;
}
#blue_txt_new{
	color:#478fb3;
}
#blue_txt_new a{
	color:#478fb3;
	text-decoration:none;
}
#blue_txt_new a:hover{
	color:#478fb3;
	text-decoration:underline;
}
.gray_dot_new{
	background: url(images_news/gray_dot.gif) left center repeat-x;
	height: 12px;
}

.deal_list_new{
	width: 100%;
	height: auto;
	margin: 20px 0;
	
}

/*upper_header*/
.inner_header_new{
	width: 625px;
	height: 80px;
	margin: 0 auto;
	background: url(images_news/upper_header_bg.gif) left top repeat-x;
}

.inner_header_new table  td{
	color: #478fb3;
	font: normal 12px/80px Arial, Helvetica, sans-serif;
}
.inner_header_new div a{
	color: #478fb3;
}
.inner_header_new div a:hover{
	color: #478fb3;
}
.inner_header_new img{
	float: left;
	margin: 22px 0 0 0;
}
<!--base_new.css-->
@import URL('style.css');

/* -------------------Common CSS---------------------- */
/*body{
    margin: 0 auto;
	color: #515151;
	font: normal 12px/19px Tahoma, Arial, Helvetica, sans-serif;
	background: #abdbf3;
}
th, td, div{
 	text-align: left;
	vertical-align: top;		
}
h1, h2, h3, h4, h5, h6{
	padding: 0px;
	margin: 0px;
}
h1{
    font-size: 3em;    
    color: #58595b;
    margin: 5px 0px 5px 0px;
    padding:5px 0px 10px 0px;    
}
h1 span{
	font-weight: bold;  
    color: #009900;  
}
h1 a, h1 a:visited
{
    color: #009900;
}
ul, li, ol, li, dl, dt{
    margin: 0px;
    padding: 0px;
}
ul li, ol li, dl dt{
    margin: 0px;
    padding: 0px;
	list-style-type: none;
}
p{
    margin: 5px 0px;
    padding: 2px 4px;
}
img{
    border: none;
	outline: none;
}
a{
    color: #055e88;
    text-decoration: none;
	outline: none;
}
a:hover{
    color: #044665;
    text-decoration: none;
}*/
/*fieldset{
    margin: 10px;
	padding: 5px;
	border: 1px solid #cccccc;
}
fieldset legend{
    font-weight: bold;
    color:#cf3f10;
	margin: 0px;
	padding: 0 2px;
}
select, option, input{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 0.9em;
	border: 1px solid #cccccc;
}*/
</style>
</head>
<body>

<!--start maincontainer_new-->
<div style="width:625px; height:auto; clear:both; float:none; margin:0 auto; background:#cef1fd; border:4px solid #cef1fd;">
	<div class="inner_header_new">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="2%"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="10" height="1" alt="" /></td>
			<td width="37%"><a href="http://hirewebprogrammer.com/hipdealz/index_1.php"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/logo.png" width="180" height="52" alt="" border="0" style="margin: 15px 0 0 0;"/></a></td>
			<!--<td width="8%"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="120" height="1" alt="" /></td>-->
			<td width="25%" valign="top" style="color: #478fb3; font: normal 12px/80px Arial, Helvetica, sans-serif; line-height:20px; padding:15px 0 0 0; text-align: right;"><strong><?=$city_name?></strong> <br/>
		    <?=date("F d, Y")?></td>
			<td width="3%"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="10" height="1" alt="" /></td>
			<td width="13%"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/signup_btn.gif" width="76" height="36" alt="" /></td>
			<td width="3%"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="10" height="1" alt="" /></td>
			<td width="15%"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/signup_btn2.gif" width="76" height="36" alt="" /></td>
			<td width="2%"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="10" height="1" alt="" /></td>
		  </tr>
		   </table>
		<div class="clear"></div> 
	</div>
	<div style="width:100%; height:auto; background:#FFFFFF;">
<?php 
	$sql=mysql_query("SELECT P.*, E.* FROM ".TABLE_PRODUCT." as P, ".TABLE_PRODUCT_EXTRA." as E WHERE E.product_id=P.product_id AND P.market_city='".$city_name."' ORDER BY P.pupdate DESC LIMIT 0,1");
	$row = mysql_fetch_array($sql);
	
	$row_cate=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_SUB_CATEGORY_SYNONYMS." where sub_category_synonym_id='".$row['cat_id']."'"));
	
	if(strrpos($row['image_url'],".jpg?")==false)
	{
		$image = $row['image_url'];
	}
	else
	{
		$image = substr($row['image_url'],0,strrpos($row['image_url'],"?"));
	}
	
	if($row['deal_site']=='dailydeals')
		{
			$date = $row['deal_end_date'];
			$newdate = strtotime($date . ' - 12 hours');											
			$time1=explode("-",date('Y-m-d H:i:s',$newdate));
		}
		else
		{
			$date = $row['deal_end_date'];
			$newdate = strtotime($date . ' + 12 hours');											
			$time1=explode("-",date('Y-m-d H:i:s',$newdate));
		}
		$year=$time1[0];
		$month=$time1[1];												
		$time2=explode(" ",$time1[2]);
		$day=$time2[0];
		$time=$time2[1];
		$deal_end_date=$month."/".$day."/".$year." ".$time;		
		$time_now=date("m/d/Y H:i:s");
		
		$d2 = strtotime($deal_end_date);
		$d1 = strtotime($time_now);
		$days = floor(($d2-$d1)/86400);
		$days_t = floor(($d2-$d1)%86400);
		$hours = floor($days_t/3600);
		
		if($days>0)
		{
			$left_date = $days." Days, ".$hours." Hours left to buy";
		}
		else
		{
			$left_date = $hours." Hours left to buy";
		}
		$title = str_replace("é","e",str_replace("�","",str_replace("”"," ",str_replace("’","'",str_replace("</i>","",str_replace("<i>","",$row['title']))))));
		$share_url = "http://hirewebprogrammer.com/hipdealz/dailydeal.php?deal_id=".$row['product_id'];
		
?>
		<div><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="12" alt="" /></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="innertable_new">
		  <tr>
			<td><strong>Found Your <?=ucwords(str_replace("_"," ",$row_cate['sub_category_synonyms']))?> Deal</strong></td>
			<td><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="120" height="1" alt="" /></td>
			<td style="background: #fffecc;	display: block;	color: #d57d00;	text-align: center;	padding: 5px 0;	border: 1px solid #fcf4d5;">Preferences</td>
		  </tr>
		  <tr>
			<td colspan="3" class="gray_dot_new">&nbsp;</td>            
		  </tr>
		   </tr>
		  <tr>
			<td colspan="3" style="color:#478fb3;"><strong><a href="http://hirewebprogrammer.com/hipdealz/dailydeal.php?deal_id=<?=$row['product_id']?>" style="color:#478fb3; text-decoration:none;"><?=$title?></a></strong><br /><font color="#999999"><?php if($row['address']!=''){ echo $row['address']; }elseif($row['address']=='' && $row['market_city']!=''){ echo $row['market_city']; } ?></font></td>            
		  </tr>
		   <tr>
			<td colspan="3" class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="10" alt="" /></td>            
		  </tr>
		   <tr>
			<td colspan="3">            	
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="185"><img src="<?=$image?>" width="185" border="0" height="216" alt="" style="border: 1px solid #e8e8eb; padding: 2px;"/></td>
					 <td><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="10" height="1" alt="" /></td>
				  <td style="vertical-align:top;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td style="color:#669900;"><strong>$<?=$row['deal_price']?>(<?=$row['discount_perc']?>%off)</strong></td>
						  </tr>
						  <tr>
							<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
						  </tr>
						   <tr>
							<td style="color:#b04539;"><?=$left_date?></strong></td>
						  </tr>
						  <tr>
							<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
						  </tr>
						  <tr>
							<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
						  </tr>
						  <tr>
							<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
						  </tr>
						   <tr>
							<td style="color: #999999;">Share this deal:<a href="http://www.facebook.com/sharer.php?u=<?php echo $share_url;?>&t=<?php echo $title;?>&Width=626&Height=436&Toolbar=0&Status=0" title="Click to send this Deal on Facebook!" target="_blank"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/social_01.png" width="20" height="21" border="0" alt="" class="float_right_new" style="margin:0 0 0 4px;"/></a>&nbsp;<a href="http://twitter.com/home?status=<?php echo $title; echo ":"; echo $share_url; ?>" title="Click to send this Deal to Twitter!" target="_blank"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/social_03.png" width="20" height="21" border="0" alt="" class="float_right_new"/></a></td>
						  </tr>
						  <tr>
							<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
						  </tr>
						</table>
					</td>
				  </tr>
				</table>            
			</td>            
		  </tr>
		</table>
		 <div><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="12" alt="" /></div>  
	</div>
	<div>&nbsp;</div>
<?php 
	$sql_all=mysql_query("SELECT P.*, E.* FROM ".TABLE_PRODUCT." as P, ".TABLE_PRODUCT_EXTRA." as E WHERE E.product_id=P.product_id AND P.market_city='".$city_name."' AND P.product_id!='".$row['product_id']."' ORDER BY P.pupdate DESC");
	if(mysql_num_rows($sql_all)>0)
	{
?>
	<div style="width:100%; height:auto; background:#FFFFFF;">
	<div><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="12" alt="" /></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="innertable_new">
	  <tr>
		<td><strong>More <?=$city_name?> deal expiring soon.</strong></td>
		<td><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="120" height="1" alt="" /></td>
		<td style="background: #fffecc;	display: block;	color: #d57d00;	text-align: center;	padding: 5px 0;	border: 1px solid #fcf4d5;">Preferences</td>
	  </tr>
	  <tr>
		<td colspan="3" class="gray_dot_new">&nbsp;</td>            
	  </tr>
	   </tr>
	   <tr>
		<td colspan="3">
<?php
		while($row_all = mysql_fetch_array($sql_all))
		{
		
			$row_cate_all=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_SUB_CATEGORY_SYNONYMS." where sub_category_synonym_id='".$row_all['cat_id']."'"));
			$title_all = str_replace("é","e",str_replace("�","",str_replace("”"," ",str_replace("’","'",str_replace("</i>","",str_replace("<i>","",$row_all['title']))))));
			$share_url_all = "http://hirewebprogrammer.com/hipdealz/dailydeal.php?deal_id=".$row_all['product_id'];
			
			if(strrpos($row_all['image_url'],".jpg?")==false)
			{
				$image_all = $row_all['image_url'];
			}
			else
			{
				$image_all = substr($row_all['image_url'],0,strrpos($row_all['image_url'],"?"));
			}
			
			if($row_all['deal_site']=='dailydeals')
			{
				$date = $row_all['deal_end_date'];
				$newdate = strtotime($date . ' - 12 hours');											
				$time1=explode("-",date('Y-m-d H:i:s',$newdate));
			}
			else
			{
				$date = $row_all['deal_end_date'];
				$newdate = strtotime($date . ' + 12 hours');											
				$time1=explode("-",date('Y-m-d H:i:s',$newdate));
			}
			$year=$time1[0];
			$month=$time1[1];												
			$time2=explode(" ",$time1[2]);
			$day=$time2[0];
			$time=$time2[1];
			$deal_end_date=$month."/".$day."/".$year." ".$time;		
			$time_now=date("m/d/Y H:i:s");
			
			$d2 = strtotime($deal_end_date);
			$d1 = strtotime($time_now);
			$days = floor(($d2-$d1)/86400);
			$days_t = floor(($d2-$d1)%86400);
			$hours = floor($days_t/3600);
			
			if($days>0)
			{
				$left_date_all = $days." Days, ".$hours." Hours left to buy";
			}
			else
			{
				$left_date_all = $hours." Hours left to buy";
			}
		
?>            	
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%; height:auto; margin:20px 0;">
			  <tr>
				<td width="145" style="vertical-align:top;"><img src="<?=$image_all?>" width="141" height="70" alt="" style="border: 1px solid #e8e8eb;padding: 2px;"/></td>
				 <td width="5"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="10" height="1" alt="" /></td>
				<td width="190" style="vertical-align:top;">
					
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td style="color:#478fb3;"><strong><a href="http://hirewebprogrammer.com/hipdealz/dailydeal.php?deal_id=<?=$row_all['product_id']?>" style="color:#478fb3; text-decoration:none;"><?=$title_all?></a></strong></td>
					  </tr>
					  <tr>
						<td style="color: #999999;"><?php if($row_all['address']!=''){ echo $row_all['address']; }elseif($row_all['address']=='' && $row_all['market_city']!=''){ echo $row_all['market_city']; } ?></td>            
					  </tr>
					   <tr>
						<td style="color: #999999;">Share this deal:<a href="http://www.facebook.com/sharer.php?u=<?php echo $share_url_all;?>&t=<?php echo $title_all;?>&Width=626&Height=436&Toolbar=0&Status=0" title="Click to send this Deal on Facebook!" target="_blank"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/social_01.png" width="20" height="21" border="0" alt="" class="float_right_new" style="margin:0 0 0 4px;"/></a>&nbsp;<a href="http://twitter.com/home?status=<?php echo $title_all; echo ":"; echo $share_url_all; ?>" title="Click to send this Deal to Twitter!" target="_blank"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/social_03.png" width="20" height="21" alt="" border="0" class="float_right_new"/></a></td>
					  </tr>                          
					</table>
				
				</td>
				 <td><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="15" height="1" alt="" /></td>
				<td style="vertical-align:top;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					 <tr>
						<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
					  </tr>
					  <tr>
						<td style="color:#669900; text-align:center;"><strong><strong>$<?=$row_all['deal_price']?>(<?=$row_all['discount_perc']?>%off)</strong></td>
					  </tr>
					  <tr>
						<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
					  </tr>
					   <tr>
						<td style="color:#b04539; text-align:center;"><?=$left_date_all?></td>
					  </tr>
					  <tr>
						<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
					  </tr>
					</table>
				</td>
				<td><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="15" height="1" alt="" /></td>
				<td style="vertical-align:top; width:80px;">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td class="gray_dot_new"><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="1" alt="" /></td>            
					  </tr>
					  <tr>
						<td style="text-align:center;"><?=ucwords(str_replace("_"," ",$row_cate_all['sub_category_synonyms']))?></td>
					  </tr>
					  <tr>
						<td><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="12" alt="" /></td>            
					  </tr>
					  <tr>
						<td style="text-align:center;">
						<?php if($row['deal_site']=='bywithme'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/bywithme.png" border="0" width="50" height="14"/>
						<?php }elseif($row['deal_site']=='dailydeals'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/dailydeals.png" border="0" width="50" height="14" />
						<?php }elseif($row['deal_site']=='homerun'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/homerun.png" border="0" width="50" height="14" />
						<?php }elseif($row['deal_site']=='kgbdeals'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/kgbdeals.png" border="0" width="50" height="14" />
						<?php }elseif($row['deal_site']=='mamapedia'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/mamapedia.png" border="0"  width="50" height="14"/>
						<?php }elseif($row['deal_site']=='specialdeals'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/specialdeals.png" border="0" width="50" height="14" />
						<?php }elseif($row['deal_site']=='dealon'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/dealon.png" border="0" width="50" height="14" />
						<?php }elseif($row['deal_site']=='eversave'){?>
						<img src="http://hirewebprogrammer.com/hipdealz/deal_image/eversave.gif" border="0" width="50" height="14"/>
						<?php }?>
						</td>
					  </tr>
					</table>
				</td>
			  </tr>
			</table>
<?php
		}
?>
            </td>            
          </tr>
        </table>
         <div><img src="http://hirewebprogrammer.com/hipdealz/includes/images_news/spacer.gif" width="1" height="12" alt="" /></div>
      </div>
<?php
	}
?>     
	<div style="color: #999999; padding:12px;" class="font11_new">HipDealz brings you the hippest dealz in <b><?=$city_name?></b> each day. You can unsubscribe from it at any time by going to: <a href="http://hirewebprogrammer.com/hipdealz/unsubscribe.php?ID=<?=md5($email_id)?>" style="color:#478fb3; text-decoration:none;">unsubscribe</a>.</div>      
	<div class="clear"></div>
</div>	
<!--end maincontainer_new-->
</body>
</html>

<?php
	$strContent=ob_get_contents();
	ob_end_clean();
	return $strContent;
}

/*Added by Sanjoy De on 08_07_2011 for distance between two cities*/
function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
{
	$pi80 = 1.1515 / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;
 
	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
 
	return ($miles ? ($km * 0.621371192) : $km);
}/*function extImgCheck($file){	//$file = 'http://www.domain.com/somefile.jpg';	$file_headers = @get_headers($file);	$stat = strpos($file_headers[0], "HTTP/1.1 404 Not Found");			if( $stat === false){		return true;		exit;	}		return false;	}*/
?>