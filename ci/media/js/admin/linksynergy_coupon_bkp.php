<?php 
require_once("include/top_menu.php"); 
require_once("testgz.php");
include 'xml/xml_regex.php';

set_time_limit(0); 

if($_REQUEST['parsing']!='')

{//mysql_query("TRUNCATE TABLE ".MANAGE_DEAL_SOURCE);

		

	mysql_query("TRUNCATE TABLE ".TABLE_PRODUCT);

	mysql_query("TRUNCATE TABLE ".TEMP_PRODUCT);

	

	$xml_1 = "http://pf.tradedoubler.com/export/export?myFeed=12989895961913301&myFormat=12989895961913301&sensor=false";

	//$xml_2 = "http://www.redribbon.ie/dow/";

	//$xml_3 = "http://pf.tradedoubler.com/export/export?myFeed=12996022421913301&myFormat=12996022421913301&sensor=false";

	

	//$xml_4 = "http://www.gruupy.com/deals/feed.rss?channel=www&locale=en&affiliate_id=3&sensor=false";

	//$xml_5 = file_get_contents("http://dublin.ratemyarea.com/deals/feed.atom?affiliate_id=2&sensor=false");
	
	//$xml_8 = "http://www.dolideals.ie/feed.php";
	//$xml_9 = "http://www.dealrush.ie/rss.xml";
	
	//$xml_10 = "http://www.wimzy.com.au/alldeals.xml?partner=3713";
   // $xml_11 = "http://www.whoseview.ie/deals.rss";
	//$xml_13 = file_get_contents("xml/18939525C1929432841.xml");
	
	//=================================== Parsing xml 13 ===========================================
	
	
	
	if($xml_13!='')

	{
		
		//mysql_query("TRUNCATE TABLE ".TABLE_PRODUCT." where deal_sources_id=13");
		
		$sql_dealsource_13=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=13");
		if(mysql_num_rows($sql_dealsource_13)>0)
		{
			$row_dealsource_13 = mysql_fetch_array($sql_dealsource_13);
			$data_13sd_id = $row_dealsource_13['deal_source_id'];
			//echo $data_13sd_id;
		}

		else

		{
			$data_13sd['deal_source_url']='http://productdata.zanox.com/exportservice/v1/rest/18939525C1929432841.xml?ticket=CCFC91472561713F8A35A466542E92402F82FE97D7983D4032E564DF510EC042&gZipCompress=null';
			$data_13sd['deal_source_date']=date("Y-m-d H:i:s");
			$data_13sd['deal_source_name']='zanox';
			$data_13sd['deal_source_logo_url']='http://hst.tradedoubler.com/file/193981/groupon_logos/groupon_100.png';
			$data_13sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_13sd);
		}
		

		$deal_items_13 = element_set('product', $xml_13);
		foreach($deal_items_13 as $item_13)

		{

			$data_13['deal_url']=value_in('deepLink', $item_13);
			$data_13['image_url']=value_in('mediumImage', $item_13);
			
			$data_13['title']=str_replace("&amp;","&",value_in('description', $item_13));
			$sql_deal_temp_13 = mysql_query('SELECT * FROM '.TABLE_PRODUCT.' WHERE is_active=1 AND (title="'.$data_13['description'].'" OR (deal_url="'.value_in('deepLink', $item_13).'" AND image_url="'.value_in('mediumImage', $item_13).'"))');

			if(@mysql_num_rows($sql_deal_temp_13)>0)

			{

				$row_deal_temp_13 = mysql_fetch_array($sql_deal_temp_13);
				$data_13_new['deal_sources_id']=$data_13sd_id;
				$data_13_new['title']=$data_13['description'];
				$prod_id_new13=$db->query_update(TABLE_PRODUCT, $data_13_new,"product_id='$row_deal_temp_13[product_id]'");
				$prod_id_new13_new=$db->query_insert(TEMP_PRODUCT, $data_13_new);	
								

			}

			else

			{

				$data_13['deal_sources_id']=$data_13sd_id;
				$data_13['description']=value_in('longDescription', $item_13);
				$data_13['merchantCategoryName']=value_in('merchantCategory', $item_13);
				$data_13['deal_price']=value_in('price', $item_13);
				$data_13['actual_price']=value_in('oldPrice', $item_13);
				$data_13['currency']='R$';
				$data_13['pupdate']=date("Y-m-d H:i:s",value_in('lastModified', $item_13));
				$data_13['deal_start_date']=date("Y-m-d H:i:s",value_in('lastModified', $item_13));
				$data_13['savings_amount']=value_in('oldPrice', $item_13) - value_in('price', $item_13);
				$data_13['discount_perc']=((value_in('oldPrice', $item_13) - value_in('price', $item_13))/value_in('oldPrice', $item_13))*100;
				$data_13['deal_site']='zanox';
				$city_name = value_in('name', $item_13);
				
				if(value_in('merchantCategory', $item_13)!='')

				{
					$sql_cat_13=mysql_query('select * from '.MANAGE_E_MAIN_CATEGORY.' where category_name="Others"');
					if(@mysql_num_rows($sql_cat_13)==0)

					{

						$data_13cat['category_name']="Others";
						$data_13cat['cate_update']=date("Y-m-d H:i:s");					
						$cat_id=$db->query_insert(MANAGE_E_MAIN_CATEGORY, $data_13cat);	
						$data_13['cat_id']=$cat_id;				

					}

					else

					{
						$row_cat_13 = mysql_fetch_array($sql_cat_13);
						$data_13['cat_id']=$row_cat_13['id'];
					}				

				}


			$sql_country_13=mysql_query("select * from ".MANAGE_COUNTRY." where country_name='Brazil'");
			if(@mysql_num_rows($sql_country_13)==0)
			{

				$data_13co['country_name']=$country_shortname;
				$country_id=$db->query_insert(MANAGE_COUNTRY, $data_13co);					
				$data_13['country']=$country_id;

			}

			else

			{
				$row_country_13=mysql_fetch_array($sql_country_13);
				$country_id=$row_country_13['id'];
				$data_13['country']=$country_id;

			}
			
				
				if(value_in('name', $item_13)!='')
			{
				
				$sql_city_13=mysql_query("select * from ".MANAGE_CITY." where city_name='".$city_name."'");
				if(@mysql_num_rows($sql_city_13)==0)
				{
					$data_13c['city_name']=$city_name;
					$data_13c['country_id']=$data_13['country'];	
					$city_id=$db->query_insert(MANAGE_CITY, $data_13c);					
					$data_13['market_city']=$city_name;

				}

				else

				{
					$row_city_13=mysql_fetch_array($sql_city_13);
					$city_name=$row_city_13['city_name'];
					$data_13['market_city']=$city_name;

				}

			}

				

					

				//$data_7['deal_end_date']=date("Y-m-d H:i:s",strtotime(value_in('g:expiration_date', $item_7)));

				//$data_7['deal_start_date']=date("Y-m-d H:i:s",value_in('updated', $item_7));

				
				$prod_id13=$db->query_insert(TEMP_PRODUCT, $data_13);			
				$prod_id_new13=$db->query_insert(TABLE_PRODUCT, $data_13);
				

			}
			//exit();

		}

	}
	
	
	//===============================================================================================
		
	//=================================== Parsing xml 10 ===========================================
	
	
	
	if($xml_10!='')

	{
		$A3 = 0;
		$sql_dealsource_10=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=10");
		if(mysql_num_rows($sql_dealsource_10)>0)
		{
			$row_dealsource_10 = mysql_fetch_array($sql_dealsource_10);
			$data_10sd_id = $row_dealsource_10['deal_source_id'];
		}

		else

		{
			$data_10sd['deal_source_url']='http://www.wimzy.com.au/alldeals.xml?partner=3713';
			$data_10sd['deal_source_date']=date("Y-m-d H:i:s");
			$data_10sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_10sd);
		}

		// create a new object
		$parser = new SimpleLargeXMLParser();
		// load the XML
		$parser->loadXML($xml_10);
		$pr= $parser->parseXML("//deal");
		
		foreach($pr as $product)
		{

			//$data_5sd['programId']=$product['programId'][0];
			$data_5sd['deal_source_name']='Wimzy';
			//$data_5sd['deal_source_logo_url']=$product['programLogoPath'][0];
			$data_5sd_id=$db->query_update(MANAGE_DEAL_SOURCE, $data_5sd, "deal_source_id=$data_10sd_id");	
			$data_5['deal_url']=$product['url'][0];					
			$data_5['deal_sources_id']=$data_10sd_id;
			$data_5['title']=$product['title'][0];
			$data_5['image_url']=$product['image'][0];	
			$dealprice =explode('$',$product['offer'][0]);
			$data_5['deal_price']=$dealprice[1];
			$data_5['currency']='$';
			$data_5['pupdate']=date("Y-m-d H:i:s");
			$city_name = $product['location'][0];
			$discount_desc = $product['percentage'][0];
			$dealvalue = explode('$',$product['value'][0]);
			$deal_value = $dealvalue[1];
						
			
			$sql_country_5=mysql_query("select * from ".MANAGE_COUNTRY." where country_name='Australia'");
			if(@mysql_num_rows($sql_country_5)==0)
			{

				$data_5co['country_name']=$country_shortname;
				$country_id=$db->query_insert(MANAGE_COUNTRY, $data_5co);					
				$data_5['country']=$country_id;

			}

			else

			{
				$row_country_5=mysql_fetch_array($sql_country_5);
				$country_id=$row_country_5['id'];
				$data_5['country']=$country_id;

			}

								
			if($city_name!='')
			{
				
				$sql_city_5=mysql_query("select * from ".MANAGE_CITY." where city_name='".$city_name."'");
				if(@mysql_num_rows($sql_city_5)==0)
				{
					$data_5c['city_name']=$city_name;
					$data_5c['country_id']=$data_5['country'];	
					$city_id=$db->query_insert(MANAGE_CITY, $data_5c);					
					$data_5['market_city']=$city_name;

				}

				else

				{
					$row_city_5=mysql_fetch_array($sql_city_5);
					$city_name=$row_city_5['city_name'];
					$data_5['market_city']=$city_name;

				}

			}
				
			$sql_deal_temp_10 = mysql_query("SELECT * FROM ".TABLE_PRODUCT." WHERE is_active=1 AND (title='".$product['title'][0]."' OR ( image_url='".$product['image'][0]."' AND deal_url='".$product['url'][0]."')) AND market_city='" .$city_name."'");

			if(mysql_num_rows($sql_deal_temp_10)>0)

			{
				$row_deal_temp_10 = mysql_fetch_array($sql_deal_temp_10);
				$data_5_new['deal_sources_id']=$data_10sd_id;
				$data_5_new['title']=$product['title'][0];
				$prod_id_new5=$db->query_update(TABLE_PRODUCT, $data_5_new,"product_id='$row_deal_temp_10[product_id]'");
				$prod_id_new6=$db->query_insert(TEMP_PRODUCT, $data_5_new);
				$A1 = 1;					
			}
			else
			{	 
				
				$data_5['TDProductId']=$product['TDProductId'][0];
				if($product['category'][0]!='')
				{
				
				
			
				
			//$deal['category'][0]="chiranjit,pritam";
				
				//echo $deal['category'][0];
				
			if(strstr($product['category'][0], ','))
				
				
				{
				
				$cat=explode(',',$product['category'][0]);
				
				
				
				   // echo $cat[0];
					//echo $cat[1];
					//echo $cat[2];
					}
					  
					 // exit;
				
				
				for($g=0;$g<count($cat);$g++)
				{
				
				      //echo  'select * from '.MANAGE_E_MAIN_CATEGORY.' where category_name='.$cat[$g];	
				
				

					$sql_cat_5=mysql_query("select * from ".MANAGE_E_MAIN_CATEGORY." where category_name='".$cat[$g]."'");				
						if(@mysql_num_rows($sql_cat_5)==0)

					{

						$data_5cat['category_name']=$cat[$g];

						
					   // echo $product['category'][0];
						
						//exit;
						
						$data_5cat['cate_update']=date("Y-m-d H:i:s");					
						$cat_id=$db->query_insert(MANAGE_E_MAIN_CATEGORY, $data_5cat);	
						$data_5['cat_id']=$cat_id;				

					}

					else

					{
						$row_cat_5 = mysql_fetch_array($sql_cat_5);
						$data_5['cat_id']=$row_cat_5['id'];

					}
					
					}

				}
					
				$data_5['deal_start_date']=date("Y-m-d H:i:s",strtotime($start));
				$date = explode(" ",$end);
				$date_day = explode("/",$date[0]);			
				$date_time = $date[1];
				$date_end = $date_day[2]."-".$date_day[0]."-".$date_day[1]." ".$date[1];
				$data_5['deal_end_date']=date("Y-m-d H:i:s",strtotime($date_end));	
				$data_5['actual_price']=$deal_value;			
			//	$data_5['savings_amount']=$dealsave;
				$data_5['discount_perc']=$discount_desc;
				$data_5['deal_site']='Wimzy';
				$prod_id5=$db->query_insert(TEMP_PRODUCT, $data_5);			
				$prod_id_new5=$db->query_insert(TABLE_PRODUCT, $data_5);

				$A3 = 1;

			}

			

		}		

	}
	
	
	//===============================================================================================
	
	


	/*$xml_3 = "http://pf.tradedoubler.com/export/export?myFeed=12996022421913301&myFormat=12996022421913301&sensor=false";*/

	if($xml_3!='')

	{

		$A3 = 0;

		$sql_dealsource_3=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=3");

		if(mysql_num_rows($sql_dealsource_3)>0)

		{

			$row_dealsource_3 = mysql_fetch_array($sql_dealsource_3);

			$data_4sd_id = $row_dealsource_3['deal_source_id'];

		}

		else

		{

			$data_4sd['deal_source_url']='http://pf.tradedoubler.com/export/export?myFeed=12996022421913301&myFormat=12996022421913301&sensor=false';

			$data_4sd['deal_source_date']=date("Y-m-d H:i:s");

			$data_4sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_4sd);

		}

				

		// create a new object

		$parser = new SimpleLargeXMLParser();

		// load the XML

		$parser->loadXML($xml_3);

		$pr= $parser->parseXML("//product");

		foreach($pr as $product)

		{

			

			$data_5sd['programId']=$product['programId'][0];

			$data_5sd['deal_source_name']=$product['programName'][0];

			$data_5sd['deal_source_logo_url']=$product['programLogoPath'][0];

			$data_5sd_id=$db->query_update(MANAGE_DEAL_SOURCE, $data_5sd, "deal_source_id=$data_4sd_id");	

			

			$data_5['deal_url']=$product['productUrl'][0];					

			$data_5['deal_sources_id']=$data_4sd_id;

			$data_5['title']=$product['name'][0];

			$data_5['description']=$product['description'][0];

			$data_5['merchantCategoryName']=$product['merchantCategoryName'][0];			

			$data_5['image_url']=$product['imageUrl'][0];			

			$data_5['deal_price']=$product['price'][0];

			$data_5['currency']=$product['currency'][0];

			$data_5['link']=$product['advertiserProductUrl'][0];

			$data_5['pupdate']=date("Y-m-d H:i:s");

			

			$location = $product['fields'][0];

			 $city_id = $location['city_id'][0];

			 $city_name = $location['city_name'][0];

			 $city_latitude = $location['city_latitude'][0];

			 $city_longitude = $location['city_longitude'][0];

			 

			 $country_id = $location['country_id'][0];

			 $country_shortname = $location['country_shortname'][0];

			 

			 $discount_desc = $location['DealDiscount'][0];

			 $deal_value =  $location['DealValue'][0];

			 $dealsave = $location['DealYouSave'][0];

			 $start = $location['StartDate'][0];

			 $end = $location['EndDate'][0];

			 $highlights = $location['highlights'][0];

			 $meta_description = $location['meta_description'][0];

			 $meta_keywords = $location['meta_keywords'][0]; 

			 $meta_title = $location['meta_title'][0];

			 $original_price = $location['original_price'][0];

			 $title_url = $location['title_url'][0];

			 $sold_count = $location['sold_count'][0];

			 

			//Start New on 11_03_2011

			$sql_deal_temp_3 = mysql_query('SELECT * FROM '.TABLE_PRODUCT.' WHERE is_active=1 AND (title="'.$product['name'][0].'" OR ( image_url="'.$product['imageUrl'][0].'" AND deal_url="'.$product['productUrl'][0].'"))');

			if(mysql_num_rows($sql_deal_temp_3)>0)

			{

				$row_deal_temp_3 = mysql_fetch_array($sql_deal_temp_3);

				$data_5_new['deal_sources_id']=$data_4sd_id;

				$data_5_new['title']=$product['name'][0];

				$data_5_new['no_available']=$location['sold_count'][0];

				$prod_id_new5=$db->query_update(TABLE_PRODUCT, $data_5_new,"product_id='$row_deal_temp_3[product_id]'");

				$prod_id_new6=$db->query_insert(TEMP_PRODUCT, $data_5_new);

				$A1 = 1;					

			}

			else

			{	 
				
				if($v!='')

				{

					$sql_country_5=mysql_query("select * from ".MANAGE_COUNTRY." where country_name='". $country_shortname."'");

					if(@mysql_num_rows($sql_country_5)==0)

					{

						$data_5co['country_name']=$country_shortname;

						$country_id=$db->query_insert(MANAGE_COUNTRY, $data_5co);					

						$data_5['country']=$country_id;

					}

					else

					{

						$row_country_5=mysql_fetch_array($sql_country_5);

						$country_id=$row_country_5['country_id'];


						$data_5['country']=$country_id;

					}

				}
				
				if($city_name!='')

				{

					$sql_city_5=mysql_query("select * from ".MANAGE_CITY." where city_name='". $city_name."'");

					if(@mysql_num_rows($sql_city_5)==0)

					{

						$data_5c['city_name']=$city_name;

						$data_5c['city_latitude']=$city_latitude;

						$data_5c['city_longitude']=$city_longitude;					

						$data_5c['country_id']=$data_5['country'];						

						$city_id=$db->query_insert(MANAGE_CITY, $data_5c);					

						$data_5['market_city']=$city_name;

					}

					else

					{

						$row_city_5=mysql_fetch_array($sql_city_5);

						$city_name=$sql_city_5['city_name'];

						$data_5['market_city']=$city_name;

					}

				}

				

				$data_5['TDProductId']=$product['TDProductId'][0];

				

				

				if($product['TDCategoryID'][0]!='')

				{

					$sql_cat_5=mysql_query('select * from '.MANAGE_E_CATEGORY.' where category_name="'.$product['TDCategoryName'][0].'"');

					if(@mysql_num_rows($sql_cat_5)==0)

					{

						$data_5cat['category_name']=$product['TDCategoryName'][0];

						$data_5cat['cate_update']=date("Y-m-d H:i:s");					

						$cat_id=$db->query_insert(MANAGE_E_CATEGORY, $data_5cat);	

						$data_5['cat_id']=$cat_id;				

					}

					else

					{

						$row_cat_5 = mysql_fetch_array($sql_cat_5);

						$data_5['cat_id']=$row_cat_5['id'];

					}

				}	

				

				$data_5['deal_start_date']=date("Y-m-d H:i:s",strtotime($start));

				

				$date = explode(" ",$end);

				$date_day = explode("/",$date[0]);			

				$date_time = $date[1];

				$date_end = $date_day[2]."-".$date_day[0]."-".$date_day[1]." ".$date[1];

				

				$data_5['deal_end_date']=date("Y-m-d H:i:s",strtotime($date_end));	

				$data_5['actual_price']=$deal_value;			

				

				$data_5['savings_amount']=$dealsave;

				$data_5['discount_perc']=$discount_desc;

				$data_5['meta_description']=$meta_description;

				$data_5['meta_keywords']=$meta_keywords;

				$data_5['meta_title']=$meta_title;

				$data_5['highlights']=$highlights;

				$data_5['title_url']=$title_url;

				$data_5['no_available']=$sold_count;

				$data_5['deal_site']='Pigsback';

				$prod_id5=$db->query_insert(TEMP_PRODUCT, $data_5);			

				$prod_id_new5=$db->query_insert(TABLE_PRODUCT, $data_5);

				$A3 = 1;

			}

			//End New on 11_03_2011

		}		

	}

	/*Start New Code Implement on 10_03_2011*/

	/*if($A3==1)

	{		

		$temp_1 = mysql_query("Delete from ".TABLE_PRODUCT." WHERE deal_sources_id=3 AND title not in (SELECT title from ".TEMP_PRODUCT." WHERE deal_sources_id=3 AND is_active=1)");

	}*/

			

	/*End New Code Implement on 10_03_2011*/

	

	/*$xml_4 = "http://www.gruupy.com/deals/feed.rss?channel=www&locale=en&affiliate_id=3&sensor=false";*/

	if($xml_4!='')

	{

		$A6 = 0;

		$sql_dealsource_6=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=4");

		if(mysql_num_rows($sql_dealsource_6)>0)

		{

			$row_dealsource_6 = mysql_fetch_array($sql_dealsource_6);

			$data_6sd_id = $row_dealsource_6['deal_source_id'];

		}

		else

		{

			$data_6sd['deal_source_url']='http://www.gruupy.com/deals/feed.rss?channel=www&locale=en&affiliate_id=3';

			$data_6sd['deal_source_name']="GruUpy";

			$data_6sd['deal_source_date']=date("Y-m-d H:i:s");

			$data_6sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_6sd);

		}		

		

		// create a new object

		$parser = new SimpleLargeXMLParser();

		// load the XML

		$parser->loadXML($xml_4);

		$pr= $parser->parseXML("//item");

		//print_r($pr);

		foreach($pr as $deal)

		{

			$data_6['deal_sources_id']=$data_6sd_id;

			$data_6['deal_url']=$deal['link'][0];

			$data_6['title']=$deal['title'][0];
			
			$data_6['image_url']=$deal['g:image_link'][0];			
			

			//Start New on 11_03_2011

			

			$sql_deal_temp_6 = mysql_query('SELECT * FROM '.TABLE_PRODUCT.' WHERE is_active=1 AND (title="'.addslashes($deal['title'][0]).'" OR (deal_url="'.$deal['link'][0].'" AND image_url="'.$deal['g:image_link'][0].'"))');

			if(mysql_num_rows($sql_deal_temp_6)>0)

			{

				$row_deal_temp_6 = mysql_fetch_array($sql_deal_temp_6);

				$data_6_new['deal_sources_id']=$data_6sd_id;

				$data_6_new['title']=addslashes($deal['title'][0]);

				$prod_id_new6=$db->query_update(TABLE_PRODUCT, $data_6_new,"product_id='$row_deal_temp_6[product_id]'");

				$prod_id_new6_new=$db->query_insert(TEMP_PRODUCT, $data_6_new);	

				$A6 = 1;				

			}

			else

			{

				

				

				if($deal['c:category'][0]!='')

				{

					$sql_cat_6=mysql_query('select * from '.MANAGE_E_CATEGORY.' where category_name="'.$deal['c:category'][0].'"');

					if(@mysql_num_rows($sql_cat_6)==0)

					{

						$data_6cat['category_name']=$deal['c:category'][0];

						$data_6cat['cate_update']=date("Y-m-d H:i:s");					

						$cat_id=$db->query_insert(MANAGE_E_CATEGORY, $data_6cat);	

						$data_6['cat_id']=$cat_id;				

					}

					else

					{

						$row_cat_6 = mysql_fetch_array($sql_cat_6);

						$data_6['cat_id']=$row_cat_6['id'];

					}				

				}

				

				$data_6['description']=$deal['c:unformatted_description'][0];							

				$data_6['deal_price']=$deal['g:price'][0];

				$data_6['actual_price']=$deal['c:list_price'][0];

				$data_6['currency']='EUR';

				$data_6['link']=$deal['link'][0];

				$data_6['deal_start_date']=date("Y-m-d H:i:s",strtotime($deal['pubDate'][0]));

				

				//$data_6['deal_end_date']=date("Y-m-d H:i:s",strtotime($deal['g:expiration_date'][0]));						
				/*Added by Sanjoy on 29-06_2011*/
				$data_6['deal_end_date']=date("Y-m-d H:i:s",strtotime("+5 hour +30 min",strtotime($deal['g:expiration_date'][0])));


				$data_6['pupdate']=date("Y-m-d H:i:s",strtotime($deal['pubDate'][0]));

				

				$data_6['savings_amount']=$deal['c:list_price'][0] - $deal['g:price'][0];

				$data_6['discount_perc']=$deal['c:discount'][0];

				$data_6['deal_site']='GruUpy';

				$prod_id6=$db->query_insert(TEMP_PRODUCT, $data_6);

				$prod_id_new6=$db->query_insert(TABLE_PRODUCT, $data_6);

				$A6 = 1;

			}

			//End New on 10_03_2011

		}

	}

	

	/*Start New Code Implement on 10_03_2011*/

	/*if($A6 == 1)

	{

		$temp_1 = mysql_query("Delete from ".TABLE_PRODUCT." WHERE deal_sources_id=4 AND title not in (SELECT title from ".TEMP_PRODUCT." WHERE deal_sources_id=4 AND is_active=1)");

	}*/

			

	/*End New Code Implement on 10_03_2011*/

	

		

	/*$xml_5 = "http://dublin.ratemyarea.com/deals/feed.atom?affiliate_id=2&sensor=false";*/

	if($xml_5!='')

	{

		$A7 = 0;

		$sql_dealsource_7=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=5");

		if(mysql_num_rows($sql_dealsource_7)>0)

		{

			$row_dealsource_7 = mysql_fetch_array($sql_dealsource_7);

			$data_7sd_id = $row_dealsource_7['deal_source_id'];

		}

		else

		{

			$data_7sd['deal_source_url']='http://dublin.ratemyarea.com/deals/feed.atom?affiliate_id=2';

			$data_7sd['deal_source_name']="RateMyArea";

			$data_7sd['deal_source_date']=date("Y-m-d H:i:s");

			$data_7sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_7sd);

		}

		

		$news_items_7 = element_set('entry', $xml_5);

		foreach($news_items_7 as $item_7)

		{

			$data_7['deal_url']=value_in('id', $item_7);
			
			$data_7['image_url']=str_replace("thumb","medium",value_in('g:image_link', $item_7));

			$data_7['title']=str_replace("&amp;","&",value_in('title', $item_7));

			//echo "<br><br>";

			//Start New on 04_03_77

			$sql_deal_temp_7 = mysql_query('SELECT * FROM '.TABLE_PRODUCT.' WHERE is_active=1 AND (title="'.$data_7['title'].'" OR (deal_url="'.value_in('id', $item_7).'" AND image_url="'.str_replace("thumb","medium",value_in('g:image_link', $item_7)).'"))');

			if(mysql_num_rows($sql_deal_temp_7)>0)

			{

				$row_deal_temp_7 = mysql_fetch_array($sql_deal_temp_7);

				$data_7_new['deal_sources_id']=$data_7sd_id;

				$data_7_new['title']=$data_7['title'];

				$prod_id_new7=$db->query_update(TABLE_PRODUCT, $data_7_new,"product_id='$row_deal_temp_7[product_id]'");

				$prod_id_new7_new=$db->query_insert(TEMP_PRODUCT, $data_7_new);	

				$A7 = 1;				

			}

			else

			{

				$data_7['deal_sources_id']=$data_7sd_id;
				

				$data_7['description']=value_in('c:unformatted_description', $item_7);


				$data_7['address']=value_in('g:location', $item_7);

								

				if(value_in('c:category', $item_7)!='')

				{

					$sql_cat_7=mysql_query('select * from '.MANAGE_E_CATEGORY.' where category_name="'.str_replace("&amp;","&",value_in('c:category', $item_7)).'"');

					if(@mysql_num_rows($sql_cat_7)==0)

					{

						$data_7cat['category_name']=str_replace("&amp;","&",value_in('c:category', $item_7));

						$data_7cat['cate_update']=date("Y-m-d H:i:s");					

						$cat_id=$db->query_insert(MANAGE_E_CATEGORY, $data_7cat);	

						$data_7['cat_id']=$cat_id;				

					}

					else

					{

						$row_cat_7 = mysql_fetch_array($sql_cat_7);

						$data_7['cat_id']=$row_cat_7['id'];

					}				

				}

				

				if(value_in('g:location', $item_7)!='')

				{

					$sql_city_7=mysql_query("select * from ".MANAGE_CITY." where city_name='Dublin'");

					if(@mysql_num_rows($sql_city_7)==0)

					{

						$data_7c['city_name']='Dublin';					

						$city_id=$db->query_insert(MANAGE_CITY, $data_7c);					

						$data_7['market_city']='Dublin';

					}

					else

					{

						$row_city_7=mysql_fetch_array($sql_city_7);

						$city_name=$row_city_7['city_name'];

						$data_7['market_city']=$city_name;

					}

				}

								

				$data_7['deal_end_date']=date("Y-m-d H:i:s",strtotime(value_in('g:expiration_date', $item_7)));

				$data_7['deal_start_date']=date("Y-m-d H:i:s",value_in('updated', $item_7));

				$data_7['deal_price']=value_in('g:price', $item_7);

				$data_7['actual_price']=value_in('c:list_price', $item_7);

				$data_7['currency']='EUR';

				$data_7['pupdate']=date("Y-m-d H:i:s",value_in('updated', $item_7));

				

				$data_7['savings_amount']=value_in('c:list_price', $item_7) - value_in('g:price', $item_7);

				$data_7['discount_perc']=value_in('c:discount', $item_7);

				

				$data_7['deal_site']='RateMyArea';

				$prod_id7=$db->query_insert(TEMP_PRODUCT, $data_7);			

				$prod_id_new7=$db->query_insert(TABLE_PRODUCT, $data_7);

				$A7 = 1;

			}

		}

	}

	/*Start New Code Implement on 04_03_207*/

	/*if($A7 == 1)

	{

		$temp_7 = mysql_query("Delete from ".TABLE_PRODUCT." WHERE deal_sources_id=5 AND title not in (SELECT title from ".TEMP_PRODUCT." WHERE deal_sources_id=5 AND is_active=1)");

	}*/			

	/*End New Code Implement on 04_03_2011*/


	/*$xml_1 = "http://pf.tradedoubler.com/export/export?myFeed=12989895961913301&myFormat=12989895961913301&sensor=false";*/

	if($xml_1!='')

	{

		$A1 = 0;

		$sql_dealsource_1=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=1");

		if(mysql_num_rows($sql_dealsource_1)>0)

		{

			$row_dealsource_1 = mysql_fetch_array($sql_dealsource_1);

			$data_1sd_id = $row_dealsource_1['deal_source_id'];

		}

		else

		{

			$data_1sd['deal_source_url']='http://pf.tradedoubler.com/export/export?myFeed=12989895961913301&myFormat=12989895961913301&sensor=false';

			$data_1sd['deal_source_date']=date("Y-m-d H:i:s");

			$data_1sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_1sd);

		}

				

		// create a new object

		$parser = new SimpleLargeXMLParser();

		// load the XML

		$parser->loadXML($xml_1);

		$pr= $parser->parseXML("//product");

		foreach($pr as $product)

		{

			

			$data_2sd['programId']=$product['programId'][0];

			$data_2sd['deal_source_name']=$product['programName'][0];

			$data_2sd['deal_source_logo_url']=$product['programLogoPath'][0];

			$data_2sd_id=$db->query_update(MANAGE_DEAL_SOURCE, $data_2sd, "deal_source_id=$data_1sd_id");	

			

			$data_1['deal_url']=$product['productUrl'][0];					

			$data_1['deal_sources_id']=$data_1sd_id;

			$data_1['title']=$product['name'][0];

			$data_1['description']=$product['description'][0];

			$data_1['merchantCategoryName']=$product['merchantCategoryName'][0];			

			$data_1['image_url']=$product['imageUrl'][0];			

			$data_1['deal_price']=$product['price'][0];

			$data_1['currency']=$product['currency'][0];

			$data_1['link']=$product['advertiserProductUrl'][0];

			$data_1['pupdate']=date("Y-m-d H:i:s");

			

			$location = $product['fields'][0];

			 $city_id = $location['city_id'][0];

			 $city_name = $location['city_name'][0];

			 $city_latitude = $location['city_latitude'][0];

			 $city_longitude = $location['city_longitude'][0];

			 

			 $country_id = $location['country_id'][0];

			 $country_shortname = $location['country_shortname'][0];

			 

			 $discount_desc = $location['discount_desc'][0];

			 $start = $location['start'][0];

			 $end = $location['end'][0];

			 $highlights = $location['highlights'][0];

			 $meta_description = $location['meta_description'][0];

			 $meta_keywords = $location['meta_keywords'][0]; 

			 $meta_title = $location['meta_title'][0];

			 $original_price = $location['original_price'][0];

			 $title_url = $location['title_url'][0];

			 $sold_count = $location['sold_count'][0];
			 
			 
			 $data_1['TDProductId']=$product['TDProductId'][0];
			 

			//Start New on 11_03_2011

			$sql_deal_temp_1 = mysql_query("SELECT * FROM ".TABLE_PRODUCT." WHERE is_active=1 AND title='".$data_1['title']."' AND TDProductId='".$product['TDProductId'][0]."' ");

			if(mysql_num_rows($sql_deal_temp_1)>0)

			{

				$row_deal_temp_1 = mysql_fetch_array($sql_deal_temp_1);

				$data_1_new['deal_sources_id']=$data_1sd_id;

				$data_1_new['deal_url']=$product['productUrl'][0];

				$data_1_new['no_available']=$location['sold_count'][0];

				$prod_id_new1=$db->query_update(TABLE_PRODUCT, $data_1_new,"product_id='$row_deal_temp_1[product_id]'");

				$prod_id_new2=$db->query_insert(TEMP_PRODUCT, $data_1_new);

				$A1 = 1;					

			}

			else

			{	 


				if($country_shortname!='')

				{

					$sql_country_1=mysql_query("select * from ".MANAGE_COUNTRY." where country_name='".$country_shortname."'");

					if(@mysql_num_rows($sql_country_1)==0)

					{

						$data_1co['country_name']=$country_shortname;

						$country_id=$db->query_insert(MANAGE_COUNTRY, $data_1co);					

						$data_1['country']=$country_id;

					}

					else

					{

						$row_country_2=mysql_fetch_array($sql_country_1);

						$country_id=$row_country_2['country_id'];

						$data_1['country']=$country_id;

					}

				}
				
				if($city_name!='')

				{

					$sql_city_1=mysql_query("select * from ".MANAGE_CITY." where city_name='".$city_name."'");

					if(@mysql_num_rows($sql_city_1)==0)

					{

						$data_1c['city_name']=$city_name;

						$data_1c['city_latitude']=$city_latitude;

						$data_1c['city_longitude']=$city_longitude;					

						$data_1c['country_id']=$data_1['country'];						

						$city_id=$db->query_insert(MANAGE_CITY, $data_1c);					

						$data_1['market_city']=$city_name;

					}

					else

					{

						$row_city_2=mysql_fetch_array($sql_city_1);

						$city_name=$row_city_2['city_name'];

						$data_1['market_city']=$city_name;

					}

				}

								

				if($product['TDCategoryID'][0]!='')

				{

					$sql_cat_1=mysql_query('select * from '.MANAGE_E_CATEGORY.' where category_name="'.$product['TDCategoryName'][0].'"');

					if(@mysql_num_rows($sql_cat_1)==0)

					{

						$data_1cat['category_name']=$product['TDCategoryName'][0];

						$data_1cat['cate_update']=date("Y-m-d H:i:s");					

						$cat_id=$db->query_insert(MANAGE_E_CATEGORY, $data_1cat);						

						$data_1['cat_id']=$cat_id;				

					}

					else

					{

						$row_cat_1 = mysql_fetch_array($sql_cat_1);

						$data_1['cat_id']=$row_cat_1['id'];

					}

				}	

				

				$data_1['deal_start_date']=date("Y-m-d H:i:s",strtotime($start));

				$data_1['deal_end_date']=date("Y-m-d H:i:s",strtotime($end));

				$data_1['actual_price']=$original_price;			

				

				$data_1['savings_amount']=$original_price - $data_1['deal_price'];

				$data_1['discount_perc']=substr($discount_desc,0,-1);

				$data_1['meta_description']=$meta_description;

				$data_1['meta_keywords']=$meta_keywords;

				$data_1['meta_title']=$meta_title;

				$data_1['highlights']=$highlights;

				$data_1['title_url']=$title_url;

				$data_1['no_available']=$sold_count;

				$data_1['deal_site']='CityDeal IE';

				$prod_id1=$db->query_insert(TEMP_PRODUCT, $data_1);			

				$prod_id_new1=$db->query_insert(TABLE_PRODUCT, $data_1);

				$A1 = 1;

			}

			//End New on 11_03_2011

		}		

	}

	/*Start New Code Implement on 10_03_2011*/

	/*if($A1==1)

	{		

		$temp_1 = mysql_query("Delete from ".TABLE_PRODUCT." WHERE deal_sources_id=1 AND title not in (SELECT title from ".TEMP_PRODUCT." WHERE deal_sources_id=1 AND is_active=1)");

	}*/

			

	/*End New Code Implement on 10_03_2011*/

	

	/*$xml_2 = "http://www.redribbon.ie/dow/";*/

	if($xml_2!='')

	{

		$A2 = 0;

		$sql_dealsource_2=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=2");

		if(mysql_num_rows($sql_dealsource_2)>0)

		{

			$row_dealsource_2 = mysql_fetch_array($sql_dealsource_2);

			$data_3sd_id = $row_dealsource_2['deal_source_id'];

		}

		else

		{

			$data_3sd['deal_source_url']='http://www.redribbon.ie/dow/';

			$data_3sd['deal_source_name']="RedRibbon";

			$data_3sd['deal_source_date']=date("Y-m-d H:i:s");

			$data_3sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_3sd);

		}		

		

		// create a new object

		$parser = new SimpleLargeXMLParser();

		// load the XML

		$parser->loadXML($xml_2);

		$pr= $parser->parseXML("//deal");

		//print_r($pr);

		foreach($pr as $deal)

		{

			$data_3['deal_sources_id']=$data_3sd_id;

			$data_3['deal_url']=$deal['link'][0];

			$data_3['title']=$deal['title'][0];
			
			$data_3['image_url']=$deal['imagelink'][0];	
			

			//Start New on 11_03_2011

			$sql_deal_temp_2 = mysql_query('SELECT * FROM '.TABLE_PRODUCT.' WHERE is_active=1 AND (title="'.$deal['title'][0].'" OR ( image_url="'.$deal['imagelink'][0].'" AND deal_url="'.$deal['link'][0].'"))');

			if(mysql_num_rows($sql_deal_temp_2)>0)

			{

				$row_deal_temp_2 = mysql_fetch_array($sql_deal_temp_2);

				$data_3_new['deal_sources_id']=$data_3sd_id;

				$data_3_new['title']=$deal['title'][0];

				$prod_id_new3=$db->query_update(TABLE_PRODUCT, $data_3_new,"product_id='$row_deal_temp_2[product_id]'");

				$prod_id_new4=$db->query_insert(TEMP_PRODUCT, $data_3_new);	

				$A2 = 1;				

			}

			else

			{

				

				if($deal['area'][0]!='')

				{

					$sql_city_3=mysql_query("select * from ".MANAGE_CITY." where city_name='".$deal['area'][0]."'");

					if(@mysql_num_rows($sql_city_3)==0)

					{

						$data_3c['city_name']=$deal['area'][0];					

						$city_id=$db->query_insert(MANAGE_CITY, $data_3c);					

						$data_3['market_city']=$deal['area'][0];

					}

					else

					{


						$row_city_4=mysql_fetch_array($sql_city_3);

						$city_name=$row_city_4['city_name'];

						$data_3['market_city']=$city_name;

					}

				}

				if($deal['category'][0]!='')

				{
				
			//$deal['category'][0]="chiranjit,pritam";
				
				//echo $deal['category'][0];
				
			if(strstr($deal['category'][0], ','))
				
				
				{
				
				$cat=explode(',',$deal['category'][0]);
				
				
				
				   // echo $cat[0];
					//echo $cat[1];
					//echo $cat[2];
					}
					  
					 // exit;
				
				
				for($g=0;$g<count($cat);$g++)
				{
				
				      //echo  'select * from '.MANAGE_E_MAIN_CATEGORY.' where category_name in'.$cat;	
				
				

					$sql_cat_2=mysql_query('select * from '.MANAGE_E_MAIN_CATEGORY.' where category_name='.$cat[$g]);				
						if(@mysql_num_rows($sql_cat_2)==0)

					{

						$data_2cat['category_name']=$cat[$g];

						$data_2cat['cate_update']=date("Y-m-d H:i:s");					

						$cat_id=$db->query_insert(MANAGE_E_MAIN_CATEGORY, $data_2cat);	

						$data_3['cat_id']=$cat_id;				

					}

					else

					{

						$row_cat_2 = mysql_fetch_array($sql_cat_2);

						$data_3['cat_id']=$row_cat_2['id'];

					}				

                      }

				}

				$data_3['merchand_name']=$deal['supplier'][0];

				$data_3['description']=$deal['description'][0];

				$data_3['short_description']=$deal['excerpt'][0];						

				$data_3['deal_price']=$deal['price'][0];

				$data_3['actual_price']=$deal['normalprice'][0];

				$data_3['currency']='EUR';

				$data_3['link']=$deal['link'][0];

				$data_3['deal_start_date']=date("Y-m-d H:i:s");

				

				$date = explode(" ",$deal['enddate'][0]);

				$date_day = explode("/",$date[0]);			

				$date_time = $date[1];

				$date_end = $date_day[2]."-".$date_day[1]."-".$date_day[0]." ".$date[1];

				$data_3['deal_end_date']=date("Y-m-d H:i:s",strtotime($date_end));						

				$data_3['pupdate']=date("Y-m-d H:i:s");

				

				$data_3['savings_amount']=$deal['normalprice'][0] - $deal['price'][0];

				$data_3['discount_perc']=($deal['normalprice'][0] - $deal['price'][0])*100/$deal['normalprice'][0];

				$data_3['deal_site']='RedRibbon';

				$prod_id3=$db->query_insert(TEMP_PRODUCT, $data_3);

				$prod_id_new3=$db->query_insert(TABLE_PRODUCT, $data_3);

				$A2 = 1;

			}

			//End New on 10_03_2011

		}

	}

	

	/*Start New Code Implement on 10_03_2011*/

	/*if($A2 == 1)

	{

		$temp_1 = mysql_query("Delete from ".TABLE_PRODUCT." WHERE deal_sources_id=2 AND title not in (SELECT title from ".TEMP_PRODUCT." WHERE deal_sources_id=2 AND is_active=1)");

	}*/

			

	/*End New Code Implement on 10_03_2011*/

	
	
	
	/*$xml_8 = "http://www.dolideals.ie/feed.php";*/
	if($xml_8!='')
	{
		$A8 = 0;
		$sql_dealsource_8=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=6");
		if(mysql_num_rows($sql_dealsource_8)>0)
		{
			$row_dealsource_8 = mysql_fetch_array($sql_dealsource_8);
			$data_8sd_id = $row_dealsource_8['deal_source_id'];
		}
		else
		{
			$data_8sd['deal_source_url']='http://www.dolideals.ie/feed.php';
			$data_8sd['deal_source_logo_url']='http://www.dolideals.ie/static/css/i/logo.gif';
			$data_8sd['deal_source_name']="DoliDeals";
			$data_8sd['deal_source_date']=date("Y-m-d H:i:s");
			$data_8sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_8sd);
		}		
		
		// create a new object
		$parser = new SimpleLargeXMLParser();
		// load the XML
		$parser->loadXML($xml_8);
		$pr= $parser->parseXML("//item");
		//print_r($pr);
		foreach($pr as $deal)
		{
			$data_8['deal_sources_id']=$data_8sd_id;
			$data_8['deal_url']=$deal['link'][0];
			$data_8['title']=str_replace("?","&euro;",utf8_decode($deal['title'][0]));
			//Start New on 02_06_2011
			
			$sql_deal_temp_8 = mysql_query('SELECT * FROM '.TABLE_PRODUCT.' WHERE is_active=1 AND title="'.$deal['title'][0].'"');
			if(mysql_num_rows($sql_deal_temp_8)>0)
			{
				$row_deal_temp_8 = mysql_fetch_array($sql_deal_temp_8);
				$data_8_new['deal_sources_id']=$data_8sd_id;
				$data_8_new['title']=$deal['title'][0];
				$prod_id_new8=$db->query_update(TABLE_PRODUCT, $data_8_new,"product_id='$row_deal_temp_8[product_id]'");
				$prod_id_new8_new=$db->query_insert(TEMP_PRODUCT, $data_8_new);	
				$A8 = 1;				
			}
			else
			{
				$title = utf8_decode($deal['title'][0]);
				$t1 = explode("?",$title);
				$t2 = explode(" ",$t1[1]);
				
				$price1 = substr($t1[2],0,-1);
				$price2 = $t2[0];
				
				$data_8['deal_price']=$price2;
				$data_8['actual_price']=$price1;
				$data_8['currency']='EUR';
				$data_8['savings_amount']=$price1 - $price2;
				$data_8['discount_perc']=($price1 - $price2)*100/$price1;
								
				$data_8['description']=$deal['description'][0];
				
				$des1 = explode("src='",$deal['description'][0]);
				$des2 = explode("'/>",$des1[1]);
				$image = $des2[0];
				$data_8['image_url']=$image;
				
				$data_8['link']=$deal['link'][0];
				
				$data_8['deal_start_date']=date("Y-m-d h:i:s");				
				$data_8['deal_end_date']=date("Y-m-d h:i:s");						
				$data_8['pupdate']=date("Y-m-d h:i:s");
				
				
				if($deal['c:category'][0]!='')
				{
					$sql_cat_8=mysql_query('select * from '.MANAGE_E_CATEGORY.' where category_name="'.$deal['c:category'][0].'"');
					if(@mysql_num_rows($sql_cat_8)==0)
					{
						$data_8cat['category_name']=$deal['c:category'][0];
						$data_8cat['cate_update']=date("Y-m-d h:i:s");					
						$cat_id=$db->query_insert(MANAGE_E_CATEGORY, $data_8cat);	
						$data_8['cat_id']=$cat_id;				
					}
					else
					{
						$row_cat_8 = mysql_fetch_array($sql_cat_8);
						$data_8['cat_id']=$row_cat_8['id'];
					}				
				}
				else
				{
					$data_8['cat_id']=20;
				}
				
				$data_8['deal_site']='DoliDeals';
				$prod_id8=$db->query_insert(TEMP_PRODUCT, $data_8);
				$prod_id_new8=$db->query_insert(TABLE_PRODUCT, $data_8);
				$A8 = 1;
			}
			//End New on 02_06_2011
		}
	}
	
	/*Start New Code Implement on 02_06_2011*/
	/*if($A8 == 1)
	{
		$temp_8 = mysql_query("Delete from ".TABLE_PRODUCT." WHERE deal_sources_id=6 AND title not in (SELECT title from ".TEMP_PRODUCT." WHERE deal_sources_id=6 AND is_active=1)");
	}*/
			
	/*End New Code Implement on 02_06_2011*/


	/*$xml_9 = "http://www.dealrush.ie/rss.xml";*/
	if($xml_9!='')
	{
	
	
	    
	
	
		$A9 = 0;
		$sql_dealsource_9=mysql_query("select * from ".MANAGE_DEAL_SOURCE." where is_active=1 AND deal_source_id=7");
		if(mysql_num_rows($sql_dealsource_9)>0)
		{
			$row_dealsource_9 = mysql_fetch_array($sql_dealsource_9);
			$data_9sd_id = $row_dealsource_9['deal_source_id'];
		}
		else
		{
			$data_9sd['deal_source_url']='http://www.dealrush.ie/rss.xml';
			$data_9sd['deal_source_logo_url']='https://www.dealrush.ie/resources/logo.png';
			$data_9sd['deal_source_name']="DealRush";
			$data_9sd['deal_source_date']=date("Y-m-d H:i:s");
			$data_9sd_id=$db->query_insert(MANAGE_DEAL_SOURCE, $data_9sd);
		}		
		
		// create a new object
		$parser = new SimpleLargeXMLParser();
		// load the XML
		$parser->loadXML($xml_9);
		$pr= $parser->parseXML("//item");
		//print_r($pr);
		foreach($pr as $deal)
	
		{
		
		//echo $deal['title'][0]."dwdw";
		//exit;
		
		
			$data_9['deal_sources_id']=$data_9sd_id;
			$data_9['deal_url']=$deal['guid'][0];
			$title = $deal['title'][0];
			$title1 = explode(":",$title); 
			$data_9['title']=trim($title1[1]);
			$city = $title1[0];
			//Start New on 02_06_2011
			
			$sql_deal_temp_9 = mysql_query('SELECT * FROM '.TABLE_PRODUCT.' WHERE is_active=1 AND title="'.$data_9['title'].'" AND market_city="'.$city.'"');
			if(mysql_num_rows($sql_deal_temp_9)>0)
			{
				$row_deal_temp_9 = mysql_fetch_array($sql_deal_temp_9);
				$data_9_new['deal_sources_id']=$data_9sd_id;
				$data_9_new['title']=$data_9['title'];
				$prod_id_new9=$db->query_update(TABLE_PRODUCT, $data_9_new,"product_id='$row_deal_temp_9[product_id]'");
				$prod_id_new9_new=$db->query_insert(TEMP_PRODUCT, $data_9_new);	
				$A9 = 1;				
			}
			else
			{
				if($city!='')
				{
					$sql_city_9=mysql_query("select * from ".MANAGE_CITY." where city_name='".$city."'");
					if(@mysql_num_rows($sql_city_9)==0)
					{
						$data_9c['city_name']=$city;	
						$city_id=$db->query_insert(MANAGE_CITY, $data_9c);
						$data_9['market_city']=$city;
					}
					else
					{
						$row_city_9=mysql_fetch_array($sql_city_9);
						$city_name=$row_city_9['city_name'];
						$data_9['market_city']=$city_name;
					}
				}
								
				$data_9['description']=$deal['description'][0];
				
				$des1 = explode("src='",$deal['description'][0]);
				$des2 = explode("'/>",$des1[1]);
				$image = $des2[0];
				$data_9['image_url']=$image;

				$data_9['deal_price']=substr($deal['dealrush:price'][0],6); //echo "---";
				$data_9['actual_price']=substr($deal['dealrush:value'][0],6);
				//echo "<br>";
				$data_9['currency']='EUR';
				$data_9['savings_amount']=$data_9['actual_price'] - $data_9['deal_price'];
				$data_9['discount_perc']=($data_9['actual_price'] - $data_9['deal_price'])*100/$data_9['actual_price'];
				
				$data_9['link']=$deal['link'][0];
				
				$data_9['deal_start_date']=date("Y-m-d h:i:s",strtotime($deal['pubDate'][0]));	
				
				/*Added by Sanjoy on 29_06_2011*/			
				//$data_9['deal_end_date']=date("Y-m-d h:i:s",strtotime($deal['dealrush:expiry'][0]));
				 $data_9['deal_end_date']=date("Y-m-d H:i:s",strtotime("+1 hour",strtotime($deal['dealrush:expiry'][0])));
										
				$data_9['pupdate']=date("Y-m-d h:i:s",strtotime($deal['pubDate'][0]));
				
				
				if($deal['c:category'][0]!='')
				{
				
				
				
			/*	echo $deal['c:category'][0];
				
				
				
				if(strstr($deal['c:category'][0], ','))
				
				
				{
				
				$cat=explode(',',$deal['c:category'][0]);
				
				
				
				    echo $cat[0];
					echo $cat[1];
					echo $cat[2];
					}
					  
					  exit;
					  */
					  
					  
					  
					$sql_cat_9=mysql_query('select * from '.MANAGE_E_MAIN_CATEGORY.' where category_name="'.$deal['c:category'][0].'"');
					if(@mysql_num_rows($sql_cat_9)==0)
					{
						$data_9cat['category_name']=$deal['c:category'][0];
						$data_9cat['cate_update']=date("Y-m-d h:i:s");					
						$cat_id=$db->query_insert(MANAGE_E_MAIN_CATEGORY, $data_9cat);	
						$data_9['cat_id']=$cat_id;				
					}
					else
					{
						$row_cat_9 = mysql_fetch_array($sql_cat_9);
						$data_9['cat_id']=$row_cat_9['id'];
					}				
				}
				else
				{
					$data_9['cat_id']=20;
				}
				
				$data_9['deal_site']='DealRush';
				$prod_id9=$db->query_insert(TEMP_PRODUCT, $data_9);
				$prod_id_new9=$db->query_insert(TABLE_PRODUCT, $data_9);
				$A9 = 1;
				//print_r($data_9);
				//echo "<br>";
			}
			//End New on 02_06_2011
		}
	}
	
	/*Start New Code Implement on 02_06_2011*/
	/*if($A9 == 1)
	{
		$temp_9 = mysql_query("Delete from ".TABLE_PRODUCT." WHERE deal_sources_id=7 AND title not in (SELECT title from ".TEMP_PRODUCT." WHERE deal_sources_id=7 AND is_active=1)");
	}*/
			
	/*End New Code Implement on 02_06_2011*/
	
	/*Start GEO Code Implement on 12_05_2011*/
	/*$sql_deal_city = mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE is_active=1");*/
	
	$sql_deal_city = mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE is_active=1");
	while($row_deal_city = mysql_fetch_array($sql_deal_city))
	{
		if($row_deal_city['city_longitude']=='' && $row_deal_city['city_latitude']=='')
		{
			$city = $row_deal_city['city_name'];
			if(strpos($city,",")==false)
			{
				$str = str_replace("/","%2F",str_replace("#","%23",str_replace(" ","+",trim($city))));
				$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
				//echo "<br>";
			}
			elseif(strpos($city,",")==true)
			{
				$str = substr(trim($city),0,-4);
				$xml = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$str."&sensor=false";
				//echo "<br>";
			}
				
			// create a new object
			$parser = new SimpleLargeXMLParser();
			// load the XML
			$parser->loadXML($xml);
			$pr1= $parser->parseXML("//result");
			$location1 = $pr1[0];
			$str1=$location1[formatted_address][0];
			$str1_new = explode(", ",$str1);
			$count1 = count($str1_new);
			$pos1 = $count1 - 1;
			$country_name1 = $str1_new[$pos1];
			//echo "<br>";
			
			if($country_name1!='')
			{
				$sql_country=mysql_query("select * from ".MANAGE_COUNTRY." where country_name like '%".$country_name1."%'");
				if(@mysql_num_rows($sql_country)==0)
				{
					$dataco['country_name']=$country_name1;
					$country_id=$db->query_insert(MANAGE_COUNTRY, $dataco);					
					$data_geo['country_id']=$country_id;
				}
				else
				{
					$row_country=mysql_fetch_array($sql_country);
					$country_id=$row_country['id'];
					$data_geo['country_id']=$country_id;
				}
			}
			
			$pr2= $parser->parseXML("//result/geometry/location");
			//print_r($pr);
			$location2 = $pr2[0];
			//print_r($location);
			$data_geo['city_latitude']=$location2[lat][0];
			$data_geo['city_longitude']=$location2[lng][0];
			
			$data_geo_id=$db->query_update(MANAGE_CITY, $data_geo,"id='$row_deal_city[id]'");
		}
		//print_r($data_geo);
	}
		
	$sql_product = mysql_query("SELECT * FROM ".TABLE_PRODUCT." WHERE country=''");
	while($row_product = mysql_fetch_array($sql_product))
	{
		$sql_update = mysql_query("UPDATE ".TABLE_PRODUCT." SET country=(SELECT country_id FROM ".MANAGE_CITY." WHERE city_name='".$row_product['market_city']."') WHERE market_city='".$row_product['market_city']."'");
	}
	
	
	/*End GEO Code Implement on 12_05_2011*/
	
	
	$sql_category_deal = mysql_query("SELECT count(*) as total, category_name FROM ".MANAGE_E_CATEGORY." GROUP BY category_name");

	while($row_category_deal = mysql_fetch_array($sql_category_deal))

	{

		if($row_category_deal['total']>1)

		{

			//echo "DELETE FROM ".MANAGE_E_CATEGORY." WHERE category_name='".$row_category_deal['category_name']."'";

			mysql_query("DELETE FROM ".MANAGE_E_CATEGORY." WHERE category_name='".$row_category_deal['category_name']."'");

		}

	}

	

	$sql_title_deal = mysql_query("SELECT count(*) as total, title, market_city FROM ".TABLE_PRODUCT." GROUP BY title, market_city");

	while($row_title_deal = mysql_fetch_array($sql_title_deal))

	{

		if($row_title_deal['total']>1)

		{

			//$query = "DELETE FROM ".TABLE_PRODUCT." WHERE title='".$row_title_deal['title']."' order by deal_id desc limit ".($row_title_deal['total'] - 1);

			$query = "DELETE FROM ".TABLE_PRODUCT." WHERE title='".$row_title_deal['title']."'";

			mysql_query($query);

		}

	}

	

	/*$sql_image_deal = mysql_query("SELECT count(*) as total, image_url FROM ".TABLE_PRODUCT." GROUP BY image_url");

	while($row_image_deal = mysql_fetch_array($sql_image_deal))

	{

		if($row_image_deal['total']>1)

		{

			//mysql_query('DELETE FROM '.TABLE_PRODUCT.' WHERE image_url="'.$row_image_deal['image_url'].'"');

			$query = "DELETE FROM ".TABLE_PRODUCT." WHERE image_url='".$row_image_deal['image_url']."' order by deal_id desc limit ".($row_image_deal['total'] - 1);

			mysql_query($query);

		}

	}*/
	
	
	/*Added for subcategory*/
	
	$sql_sub_cate = mysql_query("UPDATE ".TABLE_PRODUCT." SET sub_cat_id=6 WHERE sub_cat_id=0");
}

?>			

<!-- Background wrapper -->

<div id="bgwrap">



<!-- Main Content -->

<div id="content">

	<div id="main">

		<h1>Welcome To XML and API Parsing Manager</h1>

		<form name="frm_pars" id="frm_pars" action="<?=$_SERVER['file:///E|/alldeals_client_server/modify_02_06_2011/admin/PHP_SELF']?>" method="post">

		<table border="0" cellpadding="0" cellspacing="10" align="left" width="100%">

		<tr>

			<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">1>http://pf.tradedoubler.com/export/export?myFeed=12989895961913301&myFormat=12989895961913301</td>

		</tr>

		<tr>

			<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">2>http://www.redribbon.ie/dow/</td>

		</tr>

		<tr>

			<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">3>http://pf.tradedoubler.com/export/export?myFeed=12996022421913301&myFormat=12996022421913301</td>

		</tr>

		<tr>

			<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">4>http://www.gruupy.com/deals/feed.rss?channel=www&locale=en&affiliate_id=3</td>

		</tr>

		<tr>

			<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">5>http://dublin.ratemyarea.com/deals/feed.atom?affiliate_id=2</td>

		</tr>

		<tr>
			<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">6>http://www.dolideals.ie/feed.php</td>
		</tr>
		
		<tr>
			<td align="left" style="font-family:Verdana, Arial, Helvetica, sans-serif;">7>http://www.dealrush.ie/rss.xml</td>
		</tr>
		
		<tr>

			<td align="left"><input type="submit" class="button" name="parsing" value="XML and API Parsing"/></td>

		</tr>

		</table>

		</form>

	</div>

</div>

<!-- End of Main Content -->



<!-- Sidebar -->



<?php require_once("include/left_menu.php"); ?>				



<!-- End of Sidebar -->



</div>

<!-- End of bgwrap -->



<!-- Footer -->

<?php require_once("include/footer.php"); ?>				

<!-- End of Footer -->