<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST["status"] !="")
{
	$logo_id = $_REQUEST['logo_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_LOGO." where id='".$category_id."'"));
	
	//if($row_status['is_active']==1)
	//{
	mysql_query("update ".MANAGE_LOGO." set is_active='".$_REQUEST["status"]."' where id='".$logo_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".MANAGE_LOGO." set is_active=1 where id='".$category_id."'");
	//}
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['logo_name']));
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$logo_id = $_REQUEST['logo_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_LOGO." where id='".$logo_id."'"));
	mysql_query("delete from ".MANAGE_LOGO." where id='".$logo_id."'");
	$msg = "Successfully Delete ".ucwords(str_replace("_"," ",$row_status['logo_name']));
	//echo $row_status['logo_image'];
	$result = mysql_query("select * from ".MANAGE_LOGO. " where id='".logo_id."'");
	while($row = mysql_fetch_array($result))
	{
		$img = $row["logo_image"];
	}
	if($img != "")
	unlink("../upload/logo/".$row_status['logo_image']);
	
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update_logo')
{
	$image="";
	if($_FILES["logo_image"]["name"])
	{
		if ((($_FILES["logo_image"]["type"] == "image/gif")|| ($_FILES["logo_image"]["type"] == "image/jpeg")|| ($_FILES["logo_image"]["type"] == "image/pjpeg")|| ($_FILES["logo_image"]["type"] == "image/jpg")|| ($_FILES["logo_image"]["type"] == "image/png"))
	)
	  {

		  $time = time();
		  $image=$time.'_'.$_FILES["logo_image"]["name"];
		  move_uploaded_file($_FILES["logo_image"]["tmp_name"],"../upload/logo/" .$image );
		
	  }
	else
	  {
	  echo "Invalid file";
	  }
	}
	if($_REQUEST['logo_id']!='')
	{
		if($image)
			mysql_query("update ".MANAGE_LOGO." set logo_name='".$_REQUEST['logo_name']."',logo_image='".$image."', in_order='".$_REQUEST['in_order']."' where id='".$_REQUEST['logo_id']."'");
		else
			mysql_query("update ".MANAGE_LOGO." set logo_name='".$_REQUEST['logo_name']."', in_order='".$_REQUEST['in_order']."' where id='".$_REQUEST['logo_id']."'");
		$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['logo_name']));
	}
	else
	{
		mysql_query("insert into ".MANAGE_LOGO." (logo_name,logo_image, in_order, logo_update) values('".$_REQUEST['logo_name']."','".$image."', '".$_REQUEST['in_order']."', '".date("Y-m-d H:i:s")."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['logo_name']));
	}
	$_REQUEST['mode']="";
	$_REQUEST['logo_name']="";
	$_REQUEST['in_order']="";
}
elseif($_REQUEST['mode']=='update_subcat')
{
	if($_REQUEST['subcategory_id']!='')
	{
		
		mysql_query('update '.MANAGE_E_CATEGORY.' set category_name="'.$_REQUEST['subcat_name'].'", cat_id="'.$_REQUEST['cat_name'].'"  where id="'.$_REQUEST['subcategory_id'].'"');
		$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['subcat_name']));
	}
	else
	{
		mysql_query("insert into ".MANAGE_E_CATEGORY." (category_name, cat_id) values('".$_REQUEST['subcat_name']."', '".$_REQUEST['cat_name']."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['subcat_name']));
	}
	$_REQUEST['mode']="view_subcat";
	$_REQUEST['subcat_name']="";
	$_REQUEST['cat_name']="";
}
elseif($_REQUEST['mode']=='status_sub' && $_REQUEST["status_sub"] !="")
{
	$subcategory_id = $_REQUEST['subcategory_id'];
	$sql = "update ".MANAGE_E_CATEGORY." set is_active='".$_REQUEST["status_sub"]."' where id='".$subcategory_id."'";
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_LOGO." where id='".$category_id."'"));
	
	//if($row_status['is_active']==1)
	//{
	mysql_query($sql);
	//}
	//else
	//{
	//	mysql_query("update ".MANAGE_LOGO." set is_active=1 where id='".$category_id."'");
	//}
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="view_subcat";
	
}
elseif($_REQUEST['mode']=='delete_sub')
{
	$subcategory_id = $_REQUEST['subcategory_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_CATEGORY." where id='".$subcategory_id."'"));
	mysql_query("delete from ".MANAGE_E_CATEGORY." where id='".$subcategory_id."'");
	$msg = "Successfully Delete ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="view_subcat";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Logo Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_viewcat" id="frm_viewcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td width="12%" align="left" id="cat_trh">SL. No.</td>
			<td width="17%" align="left" id="cat_trh">Logo Name</td>
			<td width="20%" align="left" id="cat_trh">Logo Image</td>
			<td width="18%" align="left" id="cat_trh">Order Number</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_LOGO." ORDER BY in_order");
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
			<td width="12%" align="left"><?=$i++?></td>
			<td width="17%" align="left"><?=ucwords(str_replace("_"," ",$row['logo_name']))?></td>
			<td width="20%" align="left"><img src="../upload/logo/<?=$row['logo_image']?>" height="80" width="80" alt="" /></td>
			<td width="18%" align="center"><?=$row['in_order']?></td>
			<td width="15%" align="center"><a href="logo.php?logo_id=<?=$row['id']?>&mode=status&status=<?php echo $status; ?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="logo.php?logo_id=<?=$row['id']?>&mode=edit">Edit</a></td>
			<td width="9%" align="center"><a href="logo.php?logo_id=<?=$row['id']?>&mode=delete" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['logo_name']))?>?")'>Delete</a></td>
		</tr>
		<?php
				}
			}
			else
			{
		?>
		<tr>
		  <td colspan="5" align="center" style="padding-top:10px;"><b>No Logo found!</b></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add_logo'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Logo"; } elseif($_REQUEST['mode']=='add_logo'){ $mode = "Add Logo"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_LOGO." WHERE id='".$_REQUEST['logo_id']."'");
				$row = mysql_fetch_array($sql);			
		?>
		<form name="frm_addlogo" id="frm_addlogo" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" onSubmit="javascript:return add_edit_logo();">
		<input type="hidden" name="logo_id" id="logo_id" value="<?=$_REQUEST['logo_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_logo" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Logo Name</td>
			<td width="71%" align="left"><input type="text" class="text" name="logo_name" id="logo_name" value="<?=$row['logo_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Order Number</td>
			<td width="71%" align="left"><input type="text" class="text" name="in_order" id="in_order" value="<?=$row['in_order']?>" size="10"/></td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Logo Image</td>
			<td width="71%" align="left"><input type="file" class="text" name="logo_image" size="20"/></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td ><img src="../upload/logo/<?=$row['logo_image']?>" width="80" height="80" alt="No Image" /></td>
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
			<td width="29%" align="left" class="cat_name">Logo Name</td>
			<td width="71%" align="left">
				<select name="cat_name" id="cat_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_LOGO." ORDER BY category_name");
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
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_LOGO." ORDER BY category_name");
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
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_LOGO." WHERE id='".$row['cat_id']."'");
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
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_LOGO." ORDER BY category_name");
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
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_LOGO." WHERE id='".$row['cat_id']."'");
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