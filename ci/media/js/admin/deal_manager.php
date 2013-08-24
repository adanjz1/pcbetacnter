<?php 
	require_once("include/top_menu.php");
	require_once("include/function_search.php");
	include("include/pagination.php");

if($_REQUEST['mode']=='status' && $_REQUEST["status"]!="")
{
	$product_id = $_REQUEST['product_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_PRODUCT." where product_id='".$product_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	mysql_query("update ".TABLE_PRODUCT." set is_active='".$_REQUEST["status"]."' where product_id='".$product_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".TABLE_PRODUCT." set is_active=1 where product_id='".$product_id."'");
	//}
	$msg = "Successfully Change Status of ".$row_status['title'];
	$_REQUEST['mode']="";
}

elseif($_REQUEST['mode']=='dealtype')
{
	$product_id = $_REQUEST['product_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_PRODUCT." where product_id='".$product_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	mysql_query("update ".TABLE_PRODUCT." set deal_type='".$_REQUEST["dealtype_status"]."' where product_id='".$product_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".TABLE_PRODUCT." set is_active=1 where product_id='".$product_id."'");
	//}
	$msg = "Successfully Change Status of ".$row_status['title'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='dealdest')
{
	$product_id = $_REQUEST['product_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_PRODUCT." where product_id='".$product_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	mysql_query("update ".TABLE_PRODUCT." set deal_destination='".$_REQUEST["deal_status"]."' where product_id='".$product_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".TABLE_PRODUCT." set is_active=1 where product_id='".$product_id."'");
	//}
	$msg = "Successfully Change Status of ".$row_status['title'];
	$_REQUEST['mode']="";
}



elseif($_REQUEST['mode']=='delete'){
	$product_id = $_REQUEST['product_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_PRODUCT." where product_id='".$product_id."'"));
	$sql = "delete from ".TABLE_PRODUCT." where product_id='".$product_id."'";
	mysql_query($sql);
	
	$msg = "Successfully Delete ".$row_status['title'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update'){
	$data['cat_id']=$_REQUEST['cat_name'];
	$data['sub_cat_id']=$_REQUEST['subcat_name'];
	if(isset($_REQUEST['cat_name']) && $_REQUEST['cat_name']!='')
	{
		$catSubCat=explode("_",$_REQUEST['cat_name']);
		if(array_key_exists(0,$catSubCat))
			$data['cat_id']=$catSubCat[0];
		if(array_key_exists(1,$catSubCat))
			$data['sub_cat_id']=$catSubCat[1];
	}
	
	$data['deal_sources_id']=$_REQUEST['deal_sources_id'];
	$data['title']=stripslashes($_REQUEST['title']);
	$data['description']=stripslashes($_REQUEST['description']);
	$data['deal_url']=$_REQUEST['deal_url'];
	$data['address']=$_REQUEST['address'];
	$data['market_city']=$_REQUEST['market_city'];
	$data['deal_price']=$_REQUEST['deal_price'];	
	$data['merchand_name']=$_REQUEST['merchand_name'];
	$data['country']=$_REQUEST['country'];
	$data['actual_price']=$_REQUEST['actual_price'];
	$data['link']=$_REQUEST['link'];
	$data['currency']=$_REQUEST['currency'];
	$data['image_url']=$_REQUEST['image_url'];
	$data['deal_start_date']=$_REQUEST['deal_start_date'];
	$data['deal_end_date']=$_REQUEST['deal_end_date'];
	$data['fine_print']=$_REQUEST['fine_print'];
	$data['highlights']=$_REQUEST['highlights'];
	$data['deal_type']=$_REQUEST['deal_type'];
	$data['deal_destination']=$_REQUEST['deal_destination'];
	$data['slug']=$_REQUEST['slug'];	
	$data['partner']=$_REQUEST['partner'];
	$data['mechanic']=$_REQUEST['mechanic'];
	$data['sku']=$_REQUEST['sku'];
	$data['keywords']=$_REQUEST['keywords'];
	$data['deal_coupon'] = $_REQUEST['deal_coupon'];
	$data['longitude']=$_REQUEST['longitude'];
	$data['latitude']=$_REQUEST['latitude'];
	$data['zip_code']=$_REQUEST['zip_code'];
	$data['phone']=$_REQUEST['phone'];
	$data['display_name']=$_REQUEST['display_name'];
	
	$data['pupdate']=date("Y-m-d");
		
	if($_REQUEST['product_id']!=''){
		$product_id = $_REQUEST['product_id'];
		$db->query_update(TABLE_PRODUCT, $data, "product_id='$product_id'");
		$msg = "Successfully Edit ".$_REQUEST['title'];
	}
	else{
		$product_id=$db->query_insert(TABLE_PRODUCT, $data);
		$msg = "Successfully Add ".$_REQUEST['title'];
	}
	$_REQUEST['mode']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">
<link rel="stylesheet" title="Style CSS" href="js/cwcalendar.css" type="text/css" media="all" />
<script type="text/javascript">
	var saturdayOff = false;
	var sundayOff = false;
</script>
<script type="text/javascript" src="js/calendar.js"></script>
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm_adddeal.cat_name.value=="")
	{
		document.getElementById("err_catname").innerHTML="Please Enter Category Name";
		document.frm_adddeal.cat_name.focus();
		return false;
	}
	else
	{
		document.getElementById("err_catname").innerHTML="";
	}
	
	if(document.frm_adddeal.deal_sources_id.value=="")
	{
		document.getElementById("err_dealsourceid").innerHTML="Please Enter Deal Source Name";
		document.frm_adddeal.deal_sources_id.focus();
		return false;
	}
	else
	{
		document.getElementById("err_dealsourceid").innerHTML="";
	}
	
	if(document.frm_adddeal.title.value=="")
	{
		document.getElementById("err_title").innerHTML="Please Enter Deal Name";
		document.frm_adddeal.title.focus();
		return false;
	}
	else
	{
		document.getElementById("err_title").innerHTML="";
	}
	
	if(document.frm_adddeal.deal_url.value=="")
	{
		document.getElementById("err_dealurl").innerHTML="Please Enter Deal URL";
		document.frm_adddeal.deal_url.focus();
		return false;
	}
	else
	{
		document.getElementById("err_dealurl").innerHTML="";
	}
	
	if(document.frm_adddeal.deal_price.value=="")
	{
		document.getElementById("err_dealprice").innerHTML="Please Enter Deal Price";
		document.frm_adddeal.deal_price.focus();
		return false;
	}
	else
	{
		document.getElementById("err_dealprice").innerHTML="";
	}
	
	if(document.frm_adddeal.actual_price.value=="")
	{
		document.getElementById("err_actualprice").innerHTML="Please Enter Actual Price";
		document.frm_adddeal.actual_price.focus();
		return false;
	}
	else
	{
		document.getElementById("err_actualprice").innerHTML="";
	}
	
	if(document.frm_adddeal.currency.value=="")
	{
		document.getElementById("err_currency").innerHTML="Please Enter Currency";
		document.frm_adddeal.currency.focus();
		return false;
	}
	else
	{
		document.getElementById("err_currency").innerHTML="";
	}
	
	if(document.frm_adddeal.image_url.value=="")
	{
		document.getElementById("err_imageurl").innerHTML="Please Enter Image Url";
		document.frm_adddeal.image_url.focus();
		return false;
	}
	else
	{
		document.getElementById("err_imageurl").innerHTML="";
	}
return true;
}
</script>
<script language="javascript" type="text/javascript">
	function dealcheck()
	{
		if(document.dealsearch.Search_for.value.search(/\S/) == -1)
		{
			document.getElementById("err_dealsearch").innerHTML="Please enter something atleast to get a related Search Result.";
			document.dealsearch.Search_for.value="";
			document.dealsearch.Search_for.focus();
			return false;
		}
		else
		{
			document.getElementById("err_dealsearch").innerHTML="";
		}
	}
</script>
<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Manage Deal</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){
			SearchAlphabet(); 
			?>
		<div style="height:10px; clear:both">&nbsp;</div>
		<form name="frm_deal" id="frm_deal" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="action" value="<?=$_REQUEST['action']?>">
		 <table width="99%" align="center" border="0" class="border" cellpadding="5" cellspacing="1">
			<tr class="TDHEAD">
			  <td width="8%" align="center">SL</td>
			  <td width="42%" align="center">Deal Name</td>
			  <td width="10%" align="center">Home Deal</td>
			  <td width="10%" align="center">Hot Deal</td>
			  <td width="10%" align="center">Status</td>
			  <td width="10%" align="center">Edit</td>    
			  <td width="10%" align="center">Delete</td>
			</tr>
		<?php
			$items = 15;
			$page = 1;
					
			if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
			{
				$limit = " LIMIT ".(($page-1)*$items).",$items";
				$i = $items*($page-1)+1;
			}
			else
			{
				$limit = " LIMIT $items";
				$i = 1;
			}
			if ($_REQUEST['action'] == "search")
			 $condition = " AND ".$_REQUEST['search_field']." LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['action'] == "alpha") 
			 $condition = " AND title like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="select * from ".TABLE_PRODUCT." where deal_coupon = 'd'".$condition;
			$row_count = getRowCount($sql);
			$sql="select * from ".TABLE_PRODUCT." where deal_coupon = 'd'".$condition.$GLOBALS[sql_page];
			$rs  = mysql_query($sql);
			//echo $sql;
			if( mysql_num_rows($rs) > 0)
			{
				$srl_no = $GLOBALS['start'] + 1;		
				while($row = mysql_fetch_array($rs))
				{
					if($srl_no%2)
						$id = "table_record";
					else
						$id = "table_record_alt";
					if($row["is_active"] ==1)
					$status =0;
					else
					$status =1;
					if($row["deal_destination"] == "home")
					{
						$deal_status = "";
					}
					else
					{
						$deal_status = "home";
					}
					if($row["deal_type"] == "hot")
					{
						$dealtype_status = "";
					}
					else
					{
						$dealtype_status = "hot";
					}
		?>
		<tr class="<?=$id?>">
			<td width="8%" align="center"><?=$srl_no?></td>
			<td width="42%" align="left"><?=$row['title']?></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=dealdest&deal_status=<?php echo $deal_status;?>"><?php if($row['deal_destination'] == "home") { echo "ON"; } else { echo "OFF"; } ?></a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=dealtype&dealtype_status=<?php echo $dealtype_status;?>"><?php if($row['deal_type'] == "hot") { echo "ON"; } else { echo "OFF"; } ?></a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=status&status=<?php echo $status;?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=edit">Edit</a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=delete" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
		</tr>
		<?php
					$srl_no=$srl_no+1;
				}
		?>
		<tr>
		  <td colspan="7" align="center"><? if($row_count>0) pagination($row_count,"frmPaging"); ?>
		  </td>
		</tr>
		<?php
			}
			else
			{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><b>No Deal Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<form name="frmPaging" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
		  <input 	type="hidden" 	name="search_txt"	value="<? echo $_REQUEST['search_txt']; ?>">
		  <input 	type="hidden" 	name="mode" 		value="<? echo $GLOBALS['mode']; ?>">
		  <input 	type="hidden" 	name="action" 	value="<? echo $_REQUEST['action']; ?>">
		  <input 	type="hidden" 	name="pageNo"		value="<? echo $_REQUEST['pageNo']; ?>">
		  <input 	type="hidden" 	name="row_id"		value="<? echo $_REQUEST['row_id']; ?>">
		</form>
		<div style="height:10px; clear:both">&nbsp;</div>
		<?php
			$search_fields = "Deal";
			$field_name = "title";
			Search($search_fields,$field_name);
		?>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Deal"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Deal"; }
				
				$sql = mysql_query("SELECT * FROM ".TABLE_PRODUCT." WHERE product_id='".$_REQUEST['product_id']."'");
				$row = mysql_fetch_array($sql);
				
			
		?>
		<form name="frm_adddeal" id="frm_adddeal" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return validate();">
		<input type="hidden" name="product_id" id="product_id" value="<?=$_REQUEST['product_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="5" align="left" width="100%">
		<tr>
			<td width="23%" align="left" class="cat_name">Category Name</td>
			<td width="77%" align="left">
				<select name="cat_name" id="cat_name" class="select">
				<option value="">Select Category & Sub-Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id = 0 and type='d'");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
						<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['cat_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
					<?php
						$sqlsub_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id = ".$row_cat['id']."");
						while($rowsub_cat = mysql_fetch_array($sqlsub_cat))
						{
					?>
							<option value="<?=$row_cat['id']?>_<?=$rowsub_cat['id']?>" <?php if($row_cat['id']."_".$rowsub_cat['id']==$row['cat_id']."_".$row['sub_cat_id']){?> selected="selected" <?php } ?>>..<?=ucwords(str_replace("_"," ",$rowsub_cat['category_name']))?></option>
					<?php
						}
					?>
				<?php
					}
				?>
			</select>
			<span id="err_catname"></span>
			</td>
		</tr>
		
		<?php /*?><tr>
			<td width="23%" align="left" class="cat_name">Sub Category Name</td>
			<td width="77%" align="left">
				<select name="subcat_name" id="subcat_name" class="select">
				<option value="">Select Sub Category </option>
				<?php
				
				  
				
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id=".$row['cat_id']);
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['sub_cat_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
			</select></td>
		</tr><?php */?>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Source Name</td>
			<td width="77%" align="left">
				<select name="deal_sources_id" id="deal_sources_id" class="select">
				<option value="">Select Deal Source</option>
				<?php
					$sql_deal = mysql_query("SELECT * FROM ".MANAGE_DEAL_SOURCE);
					while($row_deal = mysql_fetch_array($sql_deal))
					{
					
					//$cat[]=$row_cat['id'];
					
				?>
				<option value="<?=$row_deal['deal_source_id']?>" <?php if($row_deal['deal_source_id']==$row['deal_sources_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_deal['deal_source_name']))?></option>
				<?php
					}
				?>
			</select>
			<span id="err_dealsourceid"></span>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="title" id="title" value="<?=$row['title']?>" size="60"/>
			<span id="err_title"></span>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Display Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="display_name" id="display_name" value="<?=$row['display_name']?>" size="60"/>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Description</td>
			<td width="77%" align="left">
			<?php
				/*$sw = new SPAW_Wysiwyg('description',$row['description']);
				$sw->show();*/
				$oFCKeditor = new FCKeditor('description');
				$oFCKeditor->BasePath = '../fckeditor/';
				$oFCKeditor->Value = stripslashes($row['description']) ;
				$oFCKeditor->Width = '100%' ;
				$oFCKeditor->Height = '500' ;
				$oFCKeditor->ToolbarSet = 'Default';
				$oFCKeditor->Create();
			?>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Url</td>
			<td width="77%" align="left"><input type="text" class="text" name="deal_url" id="deal_url" value="<?=$row['deal_url']?>" size="60"/>
			<span id="err_dealurl"></span>
			</td>
		</tr>
		
		<!--<tr>
			<td width="23%" align="left" class="cat_name">Address</td>
			<td width="77%" align="left"><input type="text" class="text" name="address" id="address" value="<?=$row['address']?>" size="60"/></td>
		</tr>-->
		
		<?php /*?><tr>
			<td width="23%" align="left" class="cat_name">Market City</td>
			<td width="77%" align="left"><select name="market_city" id="market_city" class="select">
				<option value="">Select City</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE is_active=1");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['city_name']?>" <?php if($row_cat['city_name']==$row['market_city']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['city_name']))?></option>
				<?php
					}
				?>
			</select>
			<span id="err_marketcity"></span>
			</td>
		</tr><?php */?>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Price</td>
			<td width="77%" align="left"><?php if($row['currency']=='US' || $row['currency']=='USD'){?><font size="4">$</font><?php } ?><input type="text" class="text" name="deal_price" id="deal_price" value="<?=$row['deal_price']?>" size="10"/>
			<span id="err_dealprice"></span>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Actual Price</td>
			<td width="77%" align="left"><?php if($row['currency']=='US' || $row['currency']=='USD'){?><font size="4">$</font><?php } ?><input type="text" class="text" name="actual_price" id="actual_price" value="<?=$row['actual_price']?>" size="10"/>
			<span id="err_actualprice"></span>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Currency</td>
			<td width="77%" align="left"><input type="text" class="text" name="currency" id="currency" value="<?=$row['currency']?>" size="10"/>
			<span id="err_currency"></span>
			</td>
		</tr>
		
		<?php /*?><tr>
			<td width="23%" align="left" class="cat_name">Merchand Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="merchand_name" id="merchand_name" value="<?=$row['merchand_name']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Link / Website</td>
			<td width="77%" align="left"><input type="text" class="text" name="link" id="link" value="<?=$row['link']?>" size="40"/></td>
		</tr><?php */?>
		
		<?php /*?><tr>
			<td width="23%" align="left" class="cat_name">Country</td>
			<td width="77%" align="left">
			<select name="country" id="country" class="select">
				<option value="">Select Country</option>
				<?php
					$sql_country = mysql_query("SELECT * FROM ".MANAGE_COUNTRY." WHERE is_active=1");
					while($row_country = mysql_fetch_array($sql_country))
					{
				?>
				<option value="<?=$row_country['country_name']?>" <?php if($row_country['country_name']==$row['country']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_country['country_name']))?></option>
				<?php
					}
				?>
			</select>
			<span id="err_country"></span>
		</td>
		</tr><?php */?>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Image URL</td>
			<td width="77%" align="left"><input type="text" class="text" name="image_url" id="image_url" value="<?=$row['image_url']?>" size="40"/>
			<span id="err_imageurl"></span>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Start Date</td>
			<td width="77%" align="left">
			<input type="text" class="text" name="deal_start_date" id="date" value="<?php if(!empty($row['deal_start_date'])){echo date("Y-m-d H:i:s",strtotime($row['deal_start_date']));}?>" size="40" onclick='fPopCalendar("date")'/>
			</td>
		</tr>
		
		<tr>
			<td width="23%" align="left" class="cat_name">Deal End Date</td>
			<td width="77%" align="left">
			<input type="text" class="text" name="deal_end_date"  id="date2" value="<?php if(!empty($row['deal_end_date'])){echo date("Y-m-d H:i:s",strtotime($row['deal_end_date']));}?>" size="40" onclick='fPopCalendar("date2")'/>
			</td>
		</tr>
				
		<?php /*?><tr>
			<td width="23%" align="left" class="cat_name">Fine Print</td>
			<td width="77%" align="left"><input type="text" class="text" name="fine_print" id="fine_print" value="<?=$row['fine_print']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Highlights</td>
			<td width="77%" align="left"><input type="text" class="text" name="highlights" id="highlights" value="<?=$row['highlights']?>" size="40"/></td>
		</tr><?php */?>
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Type</td>
			<td width="77%" align="left">
				<!--<input type="text" class="text" name="deal_type" id="deal_type" value="<?=$row['deal_type']?>" size="40"/>-->
				<?php /*?><select name="deal_type" id="deal_type" class="select">
					<option value="hot" <?php if($row['deal_type'] == "hot") { echo "selected"; }?>>Hot</option>
					<option value="home" <?php if($row['deal_type'] == "home") { echo "selected"; }?>>Home</option>
					<option value="normal" <?php if($row['deal_type'] == "") { echo "selected"; }?>>Normal</option>
				</select><?php */?>
				<input type="checkbox" name="deal_type" value="hot" <?php if($row['deal_type'] == "hot") { echo "checked"; } ?> />Hot	
				<input type="checkbox" name="deal_destination" value="home" <?php if($row['deal_destination'] == "home") { echo "checked"; } ?> />Home
			</td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">SKU</td>
			<td width="77%" align="left"><input type="text" class="text" name="sku" id="sku" value="<?=$row['sku']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Keywords</td>
			<td width="77%" align="left"><input type="text" class="text" name="keywords" id="keywords" value="<?=$row['keywords']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Deal/Coupon</td>
			<td width="77%" align="left">
				<?php /*?><input type="text" class="text" name="phone" id="phone" value="<?=$row['phone']?>" size="40"/><?php */?>
				<select name="deal_coupon">
					<option value="d" <?php if($row['deal_coupon'] == "d") { echo "selected"; } ?>>Deal</option>
					<option value="c" <?php if($row['deal_coupon'] == "c") { echo "selected"; } ?>>Coupon</option>
				</select>
			</td>
		</tr>
				
		<!--<tr>
			<td width="23%" align="left" class="cat_name">Country Name</td>
			<td width="77%" align="left">
				<select name="country_name" id="country_name" class="select">
				<option value="">Select Country</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_COUNTRY." WHERE is_active=1");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['country_name']?>" <?php if($row_cat['country_name']==$row['country_name']){?> selected="selected" <?php } ?>><?=$row_cat['country_name']?></option>
				<?php
					}
				?>
			</select></td>
		</tr>-->
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }?>
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