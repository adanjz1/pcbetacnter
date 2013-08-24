<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status')
{
	$product_id = $_REQUEST['product_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_PRODUCT." where product_id='".$product_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".TABLE_PRODUCT." set is_active=0 where product_id='".$product_id."'");
	}
	else
	{
		mysql_query("update ".TABLE_PRODUCT." set is_active=1 where product_id='".$product_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['title'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$product_id = $_REQUEST['product_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_PRODUCT." where product_id='".$product_id."'"));
	mysql_query("delete from ".TABLE_PRODUCT." where product_id='".$product_id."'");
	
	mysql_query("delete from ".TABLE_PRODUCT_EXTRA." where product_id='".$product_id."'");
	
	$msg = "Successfully Delete ".$row_status['title'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	$data['cat_id']=$_REQUEST['cat_name'];
	$data['title']=$_REQUEST['title'];
	$data['description']=$_REQUEST['description'];
	$data['deal_url']=$_REQUEST['deal_url'];
	$data['address']=$_REQUEST['address'];
	$data['market_city']=$_REQUEST['market_city'];
	$data['geo_location']=$_REQUEST['geo_location'];
	$data['deal_price']=$_REQUEST['deal_price'];	
	$data['merchand_name']=$_REQUEST['merchand_name'];
	$data['country']=$_REQUEST['country'];
	$data['actual_price']=$_REQUEST['actual_price'];
	$data['link']=$_REQUEST['link'];
	$data['currency']=$_REQUEST['currency'];
	
	$data_1['fine_print']=$_REQUEST['fine_print'];
	$data_1['highlights']=$_REQUEST['highlights'];
	$data_1['deal_type']=$_REQUEST['deal_type'];
	$data_1['slug']=$_REQUEST['slug'];	
	$data_1['partner']=$_REQUEST['partner'];
	$data_1['mechanic']=$_REQUEST['mechanic'];
	$data_1['sku']=$_REQUEST['sku'];
	$data_1['keywords']=$_REQUEST['keywords'];
	$data_1['longitude']=$_REQUEST['longitude'];
	$data_1['latitude']=$_REQUEST['latitude'];
	$data_1['zip_code']=$_REQUEST['zip_code'];
	$data_1['phone']=$_REQUEST['phone'];
	
	$data['pupdate']=date("Y-m-d");
		
	if($_REQUEST['product_id']!='')
	{
		$product_id = $_REQUEST['product_id'];
		$db->query_update(TABLE_PRODUCT, $data, "product_id='$product_id'");
		$db->query_update(TABLE_PRODUCT_EXTRA, $data_1, "product_id='$product_id'");
		$msg = "Successfully Edit ".$_REQUEST['title'];
	}
	else
	{
		$product_id=$db->query_insert(TABLE_PRODUCT, $data);
		$data_1['product_id']=$product_id;		
		$db->query_insert(TABLE_PRODUCT_EXTRA, $data_1);
		$msg = "Successfully Add ".$_REQUEST['title'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['cat_name']="";
	$_REQUEST['description']="";
	$_REQUEST['deal_url']="";
	$_REQUEST['address']="";
	$_REQUEST['market_city']="";
	$_REQUEST['geo_location']="";
	$_REQUEST['deal_price']="";
	$_REQUEST['title']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Deal Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_deal" id="frm_deal" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">Deal Name</td>
			<td width="30%" align="left" id="cat_trh">Deal Url</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="11%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$items = 10;
			$page = 1;
			$i =1;		
			if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'])
			{
				$limit = " LIMIT ".(($page-1)*$items).",$items";
			}
			else
			{
				$limit = " LIMIT $items";
			}
				
			$sql="select * from ".TABLE_PRODUCT;
			$sqlStrAux = "SELECT count(*) as total FROM ".TABLE_PRODUCT;

			$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
			$query = mysql_query($sql.$limit);
			
			if($aux['total']>0)
			{
				$p = new pagination;
				$p->Items($aux['total']);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");				
				while($row = mysql_fetch_array($query))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$row['product_id']?></td>
			<!--<td width="10%" align="left"><?=$i?></td>-->
			<td width="24%" align="left"><?=$row['title']?></td>
			<td width="30%" align="left"><?=$row['deal_url']?></td>
			<td width="15%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=status&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="11%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
		</tr>
		<?php
					$i++;
				}
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><?php $p->show();?></td></tr>
		<?php
			}
			else
			{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Deal Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Deal"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Deal"; }
				
				$sql = mysql_query("SELECT P.*, E.* FROM ".TABLE_PRODUCT." as P, ".TABLE_PRODUCT_EXTRA." as E WHERE P.product_id='".$_REQUEST['product_id']."' AND E.product_id=P.product_id");
				$row = mysql_fetch_array($sql);
				
				$row_cate=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_SUB_CATEGORY_SYNONYMS." where sub_category_synonym_id='".$row['cat_id']."'"));
			
		?>
		<form name="frm_adddeal" id="frm_adddeal" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_deal();">
		<input type="hidden" name="product_id" id="product_id" value="<?=$_REQUEST['product_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="5" align="left" width="100%">
		<tr>
			<td width="23%" align="left" class="cat_name">Category Name</td>
			<td width="77%" align="left">
				<select name="cat_name" id="cat_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY_SYNONYMS);
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['sub_category_synonym_id']?>" <?php if($row_cat['sub_category_synonym_id']==$row_cate['sub_category_synonym_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['sub_category_synonym']))?></option>
				<?php
					}
				?>
			</select></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="title" id="title" value="<?=$row['title']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Description</td>
			<td width="77%" align="left">
			<?php
				$sw = new SPAW_Wysiwyg('description',$row['description']);
				$sw->show();
			?></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Url</td>
			<td width="77%" align="left"><input type="text" class="text" name="deal_url" id="deal_url" value="<?=$row['deal_url']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Address</td>
			<td width="77%" align="left"><input type="text" class="text" name="address" id="address" value="<?=$row['address']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Market City</td>
			<td width="77%" align="left"><select name="market_city" id="market_city" class="select">
				<option value="">Select City</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_CITY);
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['city_name']?>" <?php if($row_cat['city_name']==$row['market_city']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['city_name']))?></option>
				<?php
					}
				?>
			</select></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">GEO Location</td>
			<td width="77%" align="left"><input type="text" class="text" name="geo_location" id="geo_location" value="<?=$row['geo_location']?>" size="20"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Price</td>
			<td width="77%" align="left"><?php if($row['currency']=='US' || $row['currency']=='USD'){?><font size="4">$</font><?php } ?><input type="text" class="text" name="deal_price" id="deal_price" value="<?=$row['deal_price']?>" size="10"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Actual Price</td>
			<td width="77%" align="left"><?php if($row['currency']=='US' || $row['currency']=='USD'){?><font size="4">$</font><?php } ?><input type="text" class="text" name="actual_price" id="actual_price" value="<?=$row['actual_price']?>" size="10"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Currency</td>
			<td width="77%" align="left"><input type="text" class="text" name="currency" id="currency" value="<?=$row['currency']?>" size="10"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Merchand Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="merchand_name" id="merchand_name" value="<?=$row['merchand_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Link / Website</td>
			<td width="77%" align="left"><input type="text" class="text" name="link" id="link" value="<?=$row['link']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Country</td>
			<td width="77%" align="left"><input type="text" class="text" name="country" id="country" value="<?=$row['country']?>" size="10"/></td>
		</tr>		
		<tr>
			<td width="23%" align="left" class="cat_name">Fine Print</td>
			<td width="77%" align="left"><input type="text" class="text" name="fine_print" id="fine_print" value="<?=$row['fine_print']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Highlights</td>
			<td width="77%" align="left"><input type="text" class="text" name="highlights" id="highlights" value="<?=$row['highlights']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Deal Type</td>
			<td width="77%" align="left"><input type="text" class="text" name="deal_type" id="deal_type" value="<?=$row['deal_type']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Slug</td>
			<td width="77%" align="left"><input type="text" class="text" name="slug" id="slug" value="<?=$row['slug']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Partner</td>
			<td width="77%" align="left"><input type="text" class="text" name="partner" id="partner" value="<?=$row['partner']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Mechanic</td>
			<td width="77%" align="left"><input type="text" class="text" name="mechanic" id="mechanic" value="<?=$row['mechanic']?>" size="40"/></td>
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
			<td width="23%" align="left" class="cat_name">Longitude</td>
			<td width="77%" align="left"><input type="text" class="text" name="longitude" id="longitude" value="<?=$row['longitude']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Latitude</td>
			<td width="77%" align="left"><input type="text" class="text" name="latitude" id="latitude" value="<?=$row['latitude']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Zip Code</td>
			<td width="77%" align="left"><input type="text" class="text" name="zip_code" id="zip_code" value="<?=$row['zip_code']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Phone Number</td>
			<td width="77%" align="left"><input type="text" class="text" name="phone" id="phone" value="<?=$row['phone']?>" size="40"/></td>
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