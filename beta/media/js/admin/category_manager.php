<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status')
{
	$cat_id = $_REQUEST['cat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_CATEGORY." where cat_id='".$cat_id."'"));
	
	if($row_status[status]==1)
	{
		mysql_query("update ".TABLE_CATEGORY." set status=0 where cat_id='".$cat_id."'");
	}
	else
	{
		mysql_query("update ".TABLE_CATEGORY." set status=1 where cat_id='".$cat_id."'");
	}
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$cat_id = $_REQUEST['cat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_CATEGORY." where cat_id='".$cat_id."'"));
	mysql_query("delete from ".TABLE_CATEGORY." where cat_id='".$cat_id."'");
	$msg = "Successfully Delete ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update_cat')
{
	if($_REQUEST['cat_id']!='')
	{
		mysql_query("update ".TABLE_CATEGORY." set category_name='".$_REQUEST['cat_name']."' where cat_id='".$_REQUEST['cat_id']."'");
		$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['cat_name']));
	}
	else
	{
		mysql_query("insert into ".TABLE_CATEGORY." (category_name, parentid, catupdate) values('".$_REQUEST['cat_name']."', 0, '".date("Y-m-d")."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['cat_name']));
	}
	$_REQUEST['mode']="";
	$_REQUEST['cat_name']="";
}
elseif($_REQUEST['mode']=='update_subcat')
{
	if($_REQUEST['subcat_id']!='')
	{
		mysql_query("update ".TABLE_CATEGORY." set category_name='".$_REQUEST['subcat_name']."', parentid='".$_REQUEST['cat_name']."'  where cat_id='".$_REQUEST['subcat_id']."'");
		$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['subcat_name']));
	}
	else
	{
		mysql_query("insert into ".TABLE_CATEGORY." (category_name, parentid, catupdate) values('".$_REQUEST['subcat_name']."', '".$_REQUEST['cat_name']."', '".date("Y-m-d")."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['subcat_name']));
	}
	$_REQUEST['mode']="view_subcat";
	$_REQUEST['subcat_name']="";
	$_REQUEST['cat_name']="";
}
elseif($_REQUEST['mode']=='status_sub')
{
	$cat_id = $_REQUEST['subcat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_CATEGORY." where cat_id='".$cat_id."'"));
	
	if($row_status[status]==1)
	{
		mysql_query("update ".TABLE_CATEGORY." set status=0 where cat_id='".$cat_id."'");
	}
	else
	{
		mysql_query("update ".TABLE_CATEGORY." set status=1 where cat_id='".$cat_id."'");
	}
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="view_subcat";
}
elseif($_REQUEST['mode']=='delete_sub')
{
	$cat_id = $_REQUEST['subcat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_CATEGORY." where cat_id='".$cat_id."'"));
	mysql_query("delete from ".TABLE_CATEGORY." where cat_id='".$cat_id."'");
	$msg = "Successfully Delete ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="view_subcat";
}
/*elseif($_REQUEST['mode']=='view_subcat' && $_REQUEST['cat_select_id']!='')
{
	$_REQUEST['mode']="view_subcat";
	echo $_REQUEST['cat_select_id'];
}*/
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Categories Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_viewcat" id="frm_viewcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">Category Name</td>
			<td width="10%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
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
			<td width="10%" align="center"><a href="category_manager.php?cat_id=<?=$row['cat_id']?>&mode=status"><?php if($row['status']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="category_manager.php?cat_id=<?=$row['cat_id']?>&mode=edit">Edit</a></td>
			<td width="9%" align="center"><a href="category_manager.php?cat_id=<?=$row['cat_id']?>&mode=delete" onClick='return confirm("Are you sure to delete this Category?")'>Delete</a></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add_cat'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Category"; } elseif($_REQUEST['mode']=='add_cat'){ $mode = "Add Category"; }
				$sql = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE cat_id='".$_REQUEST['cat_id']."' AND parentid=0");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcat" id="frm_addcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_cat();">
		<input type="hidden" name="cat_id" id="cat_id" value="<?=$_REQUEST['cat_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_cat" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Category Name</td>
			<td width="71%" align="left"><input type="text" class="text" name="cat_name" id="cat_name" value="<?=$row['category_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='add_subcat' || $_REQUEST['mode']=='edit_subcat'){?>
		<?php if($_REQUEST['mode']=='add_subcat'){ $mode = "Add SubCategory"; } elseif($_REQUEST['mode']=='edit_subcat'){ $mode = "Edit SubCategory"; }
				$sql = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE cat_id='".$_REQUEST['subcat_id']."' AND parentid!=0");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addsubcat" id="frm_addsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_subcat();">
		<input type="hidden" name="subcat_id" id="subcat_id" value="<?=$_REQUEST['subcat_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_subcat" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Category Name</td>
			<td width="71%" align="left">
				<select name="cat_name" id="cat_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['cat_id']?>" <?php if($row_cat['cat_id']==$row['parentid']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
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
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['cat_id']?>" <?php if($row_cat['cat_id']==$row['parentid']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
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
			$sql = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid!=0");
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
				$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE cat_id='".$row['parentid']."'");
				$row_cat = mysql_fetch_array($sql_cat);
				echo ucwords(str_replace("_"," ",$row_cat['category_name']));
			?>
			</td>
			<td width="10%" align="center"><a href="category_manager.php?subcat_id=<?=$row['cat_id']?>&mode=status_sub"><?php if($row['status']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="category_manager.php?subcat_id=<?=$row['cat_id']?>&mode=edit_subcat">Edit</a></td>
			<td width="9%" align="center"><a href="category_manager.php?subcat_id=<?=$row['cat_id']?>&mode=delete_sub" onClick='return confirm("Are you sure to delete this Sub Category?")'>Delete</a></td>
		</tr>
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
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['cat_id']?>" <?php if($row_cat['cat_id']==$_REQUEST['cat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
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
			$sql = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid='".$_REQUEST['cat_select_id']."'");
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
				$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE cat_id='".$row['parentid']."'");
				$row_cat = mysql_fetch_array($sql_cat);
				echo ucwords(str_replace("_"," ",$row_cat['category_name']));
			?>
			</td>
			<td width="10%" align="center"><a href="category_manager.php?subcat_id=<?=$row['cat_id']?>&mode=status_sub"><?php if($row['status']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="category_manager.php?subcat_id=<?=$row['cat_id']?>&mode=edit_subcat">Edit</a></td>
			<td width="9%" align="center"><a href="category_manager.php?subcat_id=<?=$row['cat_id']?>&mode=delete_sub" onClick='return confirm("Are you sure to delete this Sub Category?")'>Delete</a></td>
		</tr>
		<?php
				}
			}else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Record found!</b></td></tr>
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