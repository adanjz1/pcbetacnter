<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST["status"] !="")
{
	$banner_id = $_REQUEST['banner_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_BANNER." where id='".$category_id."'"));
	
	//if($row_status['is_active']==1)
	//{
	mysql_query("update ".MANAGE_BANNER." set is_active='".$_REQUEST["status"]."' where banner_id='".$banner_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".MANAGE_BANNER." set is_active=1 where id='".$category_id."'");
	//}
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['banner_name']));
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$banner_id = $_REQUEST['banner_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_BANNER." where banner_id='".$banner_id."'"));
	mysql_query("delete from ".MANAGE_BANNER." where banner_id='".$banner_id."'");
	$msg = "Successfully Delete: ".ucwords(str_replace("_"," ",$row_status['banner_name']));
	
	if($row_status['banner_image'] != "")
		unlink("../upload/banner/".$row_status['banner_image']);
	
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update_banner')
{
	$image="";
	if($_FILES["banner_image"]["name"])
	{
		
		if ((($_FILES["banner_image"]["type"] == "image/gif")|| ($_FILES["banner_image"]["type"] == "image/jpeg")|| ($_FILES["banner_image"]["type"] == "image/pjpeg")|| ($_FILES["banner_image"]["type"] == "image/jpg")|| ($_FILES["banner_image"]["type"] == "image/png")))
		{
			$banner_id = $_REQUEST['banner_id'];
			$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_BANNER." where banner_id='".$banner_id."'"));
			if($row_status['banner_image'] != "")
				unlink("../upload/banner/".$row_status['banner_image']);
			$time = time();
		  	$image=$time.'_'.$_FILES["banner_image"]["name"];
		  	move_uploaded_file($_FILES["banner_image"]["tmp_name"],"../upload/banner/" .$image );		
		}
		else
		{
			echo "Invalid file";
	  	}
	}
	if($_REQUEST['banner_id']!='')
	{
		if($image)
			mysql_query("update ".MANAGE_BANNER." set banner_name='".$_REQUEST['banner_name']."',banner_image='".$image."'where banner_id='".$_REQUEST['banner_id']."'");
		else
			mysql_query("update ".MANAGE_BANNER." set banner_name='".$_REQUEST['banner_name']."' where banner_id='".$_REQUEST['banner_id']."'");
			$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['banner_name']));
	}
	else
	{
		mysql_query("insert into ".MANAGE_BANNER." (banner_name,banner_image, uptodate) values('".$_REQUEST['banner_name']."','".$image."', '".date("Y-m-d H:i:s")."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['banner_name']));
	}
	$_REQUEST['mode']="";
	$_REQUEST['banner_name']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Banner Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_viewcat" id="frm_viewcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="border">
		<tr class="TDHEAD">
			<td width="12%" align="left" id="cat_trh">SL. No.</td>
			<td width="17%" align="left" id="cat_trh">Banner Name</td>
			<td width="20%" align="left" id="cat_trh">Banner Image</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_BANNER." ORDER BY banner_id");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "table_record";
					else
						$id = "table_record_alt";
					if($row["is_active"] == 1)
					$status = 0;
					else
					$status = 1;
		?>
		<tr class="<?=$id?>">
			<td width="12%" align="left"><?=$i++?></td>
			<td width="17%" align="left"><?=ucwords(str_replace("_"," ",$row['banner_name']))?></td>
			<td width="20%" align="left"><img src="<?=(!$row['banner_image'])?"../images/noImage.jpg": SITE_URL.'upload/banner/'.$row['banner_image']?>" height="80" width="80" alt="" /></td>
			<td width="15%" align="center"><a href="banner.php?banner_id=<?=$row['banner_id']?>&mode=status&status=<?php echo $status; ?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="banner.php?banner_id=<?=$row['banner_id']?>&mode=edit">Edit</a></td>
			<td width="9%" align="center"><a href="banner.php?banner_id=<?=$row['banner_id']?>&mode=delete" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['banner_name']))?>?")'>Delete</a></td>
		</tr>
		<?php
				}
			}
			else
			{
		?>
		<tr>
		  <td colspan="5" align="center" style="padding-top:10px;"><b>No Banner found!</b></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add_banner'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Banner"; } elseif($_REQUEST['mode']=='add_banner'){ $mode = "Add Banner"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_BANNER." WHERE banner_id='".$_REQUEST['banner_id']."'");
				$row = mysql_fetch_array($sql);			
		?>
		<form name="frm_addbanner" id="frm_addbanner" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" onSubmit="javascript:return add_edit_banner();">
		<input type="hidden" name="banner_id" id="banner_id" value="<?=$_REQUEST['banner_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_banner" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Banner Name</td>
			<td width="71%" align="left"><input type="text" class="text" name="banner_name" id="banner_name" value="<?=$row['banner_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Banner Image</td>
			<td width="71%" align="left"><input type="file" class="text" name="banner_image" size="20"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>(Banner should be 1000 x 160)</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td ><img src="<?=(!$row['banner_image'])?"../images/noImage.jpg": SITE_URL.'upload/banner/'.$row['banner_image']?>" width="80" height="80" alt="No Image" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='add_subcat' || $_REQUEST['mode']=='edit_subcat'){?>
		<?php if($_REQUEST['mode']=='add_subcat'){ $mode = "Add SubCategory"; } elseif($_REQUEST['mode']=='edit_subcat'){ $mode = "Edit SubCategory"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$_REQUEST['subcategory_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addsubcat" id="frm_addsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="javascript:return add_edit_subcat();">
		<input type="hidden" name="subcategory_id" id="subcategory_id" value="<?=$_REQUEST['subcategory_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_subcat" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Banner Name</td>
			<td width="71%" align="left">
				<select name="cat_name" id="cat_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_BANNER." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['cat_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Sub Category Name</td>
			<td width="71%" align="left"><input type="text" class="text" name="subcat_name" id="subcat_name" value="<?=$row['category_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat' && $_REQUEST['cat_select_id']==''){?>
		<form name="frm_viewsubcat" id="frm_viewsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_subcat" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td colspan="6" align="right" class="cat_name">Category Name&nbsp;&nbsp;
				<select name="cat_select_id" id="cat_select_id" class="select" onChange="javascript:return view_cat();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_BANNER." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['cat_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="28%" align="left" id="cat_trh">Category Name</td>
			<td width="10%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." ORDER BY category_name");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
					if($row["is_active"] == 1)
					$status = 0;
					else
					$status = 1;
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i++?></td>
			<td width="28%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
			<td width="28%" align="left">
			<?php 
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_BANNER." WHERE id='".$row['cat_id']."'");
				$row_cat = mysql_fetch_array($sql_cat);
				echo ucwords(str_replace("_"," ",$row_cat['category_name']));
			?>
			</td>
			<td width="10%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['id']?>&mode=status_sub&status_sub=<?php echo $status;?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['id']?>&mode=edit_subcat">Edit</a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['id']?>&mode=delete_sub" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['category_name']))?>?")'>Delete</a></td>
		</tr>
		<?php
				}
			}
			else
			{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Sub Category found!</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat' && $_REQUEST['cat_select_id']!=''){?>
		<form name="frm_viewsubcat" id="frm_viewsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_subcat" />
		<input type="hidden" name="cat_select_id" id="cat_select_id" value="<?=$_REQUEST['cat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td colspan="6" align="right" class="cat_name">Category Name&nbsp;&nbsp;
				<select name="cat_select_id" id="cat_select_id" class="select" onChange="javascript:return view_cat();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_BANNER." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$_REQUEST['cat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="28%" align="left" id="cat_trh">Category Name</td>
			<td width="10%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE cat_id='".$_REQUEST['cat_select_id']."'");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i++?></td>
			<td width="28%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
			<td width="28%" align="left">
			<?php 
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_BANNER." WHERE banner_id='".$row['cat_id']."'");
				$row_cat = mysql_fetch_array($sql_cat);
				echo ucwords(str_replace("_"," ",$row_cat['category_name']));
			?>
			</td>
			<td width="10%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['sub_category_id']?>&mode=status_sub"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['sub_category_id']?>&mode=edit_subcat">Edit</a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['sub_category_id']?>&mode=delete_sub" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['sub_category_name']))?>?")'>Delete</a></td>
		</tr>
		<?php
				}
			}else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Sub Category found!</b></td></tr>
		<?php } ?>				
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