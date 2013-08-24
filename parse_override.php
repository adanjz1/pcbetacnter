<?php
//$sql_category = "select * from ".MANAGE_E_CATEGORY." order by cate_update desc";

//$res_category = mysql_query($sql_category);

//echo mapCategory($res_category, 'android phone');	//Second argument is title		  

function mapCategoryMain($title='',$categoryKeyword='', $description='', $type='d'){
	$sql_category = "select * from ".MANAGE_E_CATEGORY." WHERE `cat_id`=0 and type='".$type."' and is_active='1' order by cate_update desc";
	$res_category = mysql_query($sql_category);
	while($row_category  = mysql_fetch_array($res_category))
	{
		$keywords = explode(',', $row_category['keyword']);
		foreach($keywords as $keyword)
		{
			if(trim($title)!='' && trim($keyword)!='')
			{
				$pos = strpos($title, $keyword);
				if( $pos !== false)
				{
					return $row_category['id'];
				}
				else
				{
					$pos2 = strpos($categoryKeyword, $keyword);
					if( $pos2 !== false)
					{
						return $row_category['id'];
					}
					else
					{
						$pos3 = strpos($description, $keyword);
						if( $pos3 !== false)
						{
							return $row_category['id'];
						}
					}
				}
			}
		}
	}
	return 0;
}
function mapCategorySub($title='',$categoryKeyword='', $description='', $catId){
	$sql_category = "select * from ".MANAGE_E_CATEGORY." WHERE `cat_id`='".$catId."' and is_active='1' order by cate_update desc";
	$res_category = mysql_query($sql_category);
	while($row_category  = mysql_fetch_array($res_category))
	{
		$keywords = explode(',', $row_category['keyword']);
		foreach($keywords as $keyword)
		{
			if(trim($title)!='' && trim($keyword)!='')
			{
				$pos = strpos($title, $keyword);
				if( $pos !== false)
				{
					return $row_category['id'];
				}
				else
				{
					if(trim($categoryKeyword)!='' && trim($keyword)!='')
					{	
						$pos2 = strpos($categoryKeyword, $keyword);
						if( $pos2 !== false)
						{
							return $row_category['id'];
						}
						else
						{
							if(trim($description)!='' && trim($keyword)!='')
							{
								$pos3 = strpos($description, $keyword);
								if( $pos3 !== false)
								{
									return $row_category['id'];
								}
							}
						}
					}
				}
			}
		}
	}
	return 0;
}


function getSourceId($source){
	$sql_store_brand = "select * from ".MANAGE_DEAL_SOURCE." where deal_source_name = '".$source."'";
	$res_store_brand = mysql_query($sql_store_brand);
	$row_store_brand = mysql_fetch_array ($res_store_brand);
	return $row_store_brand['deal_source_id'];
}
