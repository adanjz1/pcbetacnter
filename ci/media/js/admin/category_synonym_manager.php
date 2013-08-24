<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status_cat_syn')
{
	$syn_cat_id = $_REQUEST['syn_cat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CATEGORY." where syn_cat_id='".$syn_cat_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_SYNONYMS_CATEGORY." set is_active=0 where syn_cat_id='".$syn_cat_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_SYNONYMS_CATEGORY." set is_active=1 where syn_cat_id='".$syn_cat_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['synonyms_cat_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete_cat_syn')
{
	$syn_cat_id = $_REQUEST['syn_cat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CATEGORY." where syn_cat_id='".$syn_cat_id."'"));
	mysql_query("delete from ".MANAGE_SYNONYMS_CATEGORY." where syn_cat_id='".$syn_cat_id."'");
	$msg = "Successfully Delete ".$row_status['synonyms_cat_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update_cat_syn')
{
	if($_REQUEST['syn_cat_id']!='')
	{
		mysql_query("update ".MANAGE_SYNONYMS_CATEGORY." set category_name='".$_REQUEST['category_name']."', synonyms_cat_name='".$_REQUEST['synonyms_cat_name']."' where syn_cat_id='".$_REQUEST['syn_cat_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['synonyms_cat_name'];
	}
	else
	{
		mysql_query("insert into ".MANAGE_SYNONYMS_CATEGORY." (category_name, synonyms_cat_name) values('".$_REQUEST['category_name']."', '".$_REQUEST['synonyms_cat_name']."')");
		$msg = "Successfully Add ".$_REQUEST['synonyms_cat_name'];
	}
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='status_subcat_syn')
{
	$syn_subcat_id = $_REQUEST['syn_subcat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CATEGORY." where syn_cat_id='".$syn_subcat_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_SYNONYMS_CATEGORY." set is_active=0 where syn_cat_id='".$syn_subcat_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_SYNONYMS_CATEGORY." set is_active=1 where syn_cat_id='".$syn_subcat_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['synonyms_cat_name'];
	$_REQUEST['mode']="view_subcat_syn";
}
elseif($_REQUEST['mode']=='delete_subcat_syn')
{
	$syn_subcat_id = $_REQUEST['syn_subcat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CATEGORY." where syn_cat_id='".$syn_subcat_id."'"));
	mysql_query("delete from ".MANAGE_SYNONYMS_CATEGORY." where syn_cat_id='".$syn_subcat_id."'");
	$msg = "Successfully Delete ".$row_status['synonyms_cat_name'];
	$_REQUEST['mode']="view_subcat_syn";
}
elseif($_REQUEST['mode']=='update_subcat_syn')
{
	if($_REQUEST['syn_subcat_id']!='')
	{
		mysql_query("update ".MANAGE_SYNONYMS_CATEGORY." set category_name='".$_REQUEST['category_name']."', synonyms_cat_name='".$_REQUEST['synonyms_subcat_name']."', `check`='1' where syn_cat_id='".$_REQUEST['syn_subcat_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['synonyms_cat_name'];
	}
	else
	{
		mysql_query("insert into ".MANAGE_SYNONYMS_CATEGORY." (category_name, synonyms_cat_name, `check`) values('".$_REQUEST['category_name']."', '".$_REQUEST['synonyms_subcat_name']."', '1')");
		$msg = "Successfully Add ".$_REQUEST['synonyms_cat_name'];
	}
	$_REQUEST['mode']="view_subcat_syn";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Category Synonyms Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if(($_REQUEST['mode']=='view_cat_syn' || $_REQUEST['mode']=='') && $_REQUEST['cat_select_id']==''){?>
		<form name="frmview_cat_syn" id="frmview_cat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_cat_syn" />
		<input type="hidden" name="cat_select_id" id="cat_select_id" value="<?=$_REQUEST['cat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td align="right" class="cat_name" colspan="6">Category Name&nbsp;&nbsp;
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat_syn();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['category_name']?>"><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="11%" align="left" id="cat_trh">SL. No.</td>
			<td width="21%" align="left" id="cat_trh">Category Name</td>
			<td width="33%" align="left" id="cat_trh">Synonyms for Category</td>
			<td width="13%" align="center" id="cat_trh">Statu</td>
			<td width="12%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			//echo "SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." where check='0'";
			$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." where `check`='0'");
			while($row = mysql_fetch_array($sql))
			{
				if($i%2)
					$id = "cat_tr1";
				else
					$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="11%" align="left"><?=$i++?></td>
			<td width="21%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
			<td width="33%" align="left"><?=$row['synonyms_cat_name']?></td>
			<td width="13%" align="center"><a href="category_synonym_manager.php?syn_cat_id=<?=$row['syn_cat_id']?>&mode=status_cat_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="12%" align="center"><a href="category_synonym_manager.php?syn_cat_id=<?=$row['syn_cat_id']?>&mode=edit_cat_syn">Edit</a></td>
			<td width="10%" align="center"><a href="category_synonym_manager.php?syn_cat_id=<?=$row['syn_cat_id']?>&mode=delete_cat_syn" onClick='return confirm("Are you sure to delete this Category Synonyms?")'>Delete</a></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_cat_syn' && $_REQUEST['cat_select_id']!=''){?>
		<form name="frmview_cat_syn" id="frmview_cat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_cat_syn" />
		<input type="hidden" name="cat_select_id" id="cat_select_id" value="<?=$_REQUEST['cat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td align="right" class="cat_name" colspan="6">Category Name&nbsp;&nbsp;
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat_syn();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['category_name']?>" <?php if($row_cat['category_name']==$_REQUEST['cat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
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
			$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." WHERE category_name='".$_REQUEST['cat_select_id']."' AND`check`='0' ");
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
			<td width="28%" align="left"><?=$row['synonyms_cat_name']?></td>
			<td width="13%" align="center"><a href="category_synonym_manager.php?syn_cat_id=<?=$row['syn_cat_id']?>&mode=status_cat_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="12%" align="center"><a href="category_synonym_manager.php?syn_cat_id=<?=$row['syn_cat_id']?>&mode=edit_cat_syn">Edit</a></td>
			<td width="10%" align="center"><a href="category_synonym_manager.php?syn_cat_id=<?=$row['syn_cat_id']?>&mode=delete_cat_syn" onClick='return confirm("Are you sure to delete this Category Synonyms?")'>Delete</a></td>
		</tr>
		<?php
				}
			}else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Record found!</b></td></tr>
		<?php } ?>				
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit_cat_syn' || $_REQUEST['mode']=='add_cat_syn'){?>
		<?php if($_REQUEST['mode']=='edit_cat_syn'){ $mode = "Edit Category Synonyms"; } elseif($_REQUEST['mode']=='add_cat_syn'){ $mode = "Add Category Synonyms"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." WHERE syn_cat_id='".$_REQUEST['syn_cat_id']."' AND `check`='0'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcat_syn" id="frm_addcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_cat_syn();">
		<input type="hidden" name="syn_cat_id" id="syn_cat_id" value="<?=$_REQUEST['syn_cat_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_cat_syn" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="34%" align="left" class="cat_name">Category Name</td>
			<td width="66%" align="left">
			<select name="category_name" id="category_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['category_name']?>" <?php if($row_cat['category_name']==$row['category_name']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="34%" align="left" class="cat_name">Synonyms for Category</td>
			<td width="66%" align="left"><input type="text" class="text" name="synonyms_cat_name" id="synonyms_cat_name" value="<?=$row['synonyms_cat_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat_syn' && $_REQUEST['subcat_select_id']==''){?>
		<form name="frmview_subcat_syn" id="frmview_subcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_subcat_syn" />
		<input type="hidden" name="subcat_select_id" id="subcat_select_id" value="<?=$_REQUEST['subcat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td align="right" class="cat_name" colspan="6">Category Name&nbsp;&nbsp;
				<select name="subcat_select_id" id="subcat_select_id" class="select" onchange="javascript:return view_subcat_syn();">
				<option value="">Select Sub Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid!=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['category_name']?>"><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="11%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="34%" align="left" id="cat_trh">Synonyms for SubCategory</td>
			<td width="13%" align="center" id="cat_trh">Statu</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			//echo "SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." where check='0'";
			$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." where `check`='1'");
			while($row = mysql_fetch_array($sql))
			{
				if($i%2)
					$id = "cat_tr1";
				else
					$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="11%" align="left"><?=$i++?></td>
			<td width="24%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
			<td width="34%" align="left"><?=$row['synonyms_cat_name']?></td>
			<td width="13%" align="center"><a href="category_synonym_manager.php?syn_subcat_id=<?=$row['syn_cat_id']?>&mode=status_subcat_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="category_synonym_manager.php?syn_subcat_id=<?=$row['syn_cat_id']?>&mode=edit_subcat_syn">Edit</a></td>
			<td width="9%" align="center"><a href="category_synonym_manager.php?syn_subcat_id=<?=$row['syn_cat_id']?>&mode=delete_subcat_syn" onClick='return confirm("Are you sure to delete this SubCategory Synonyms?")'>Delete</a></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat_syn' && $_REQUEST['subcat_select_id']!=''){?>
		<form name="frmview_subcat_syn" id="frmview_subcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_subcat_syn" />
		<input type="hidden" name="subcat_select_id" id="subcat_select_id" value="<?=$_REQUEST['subcat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td align="right" class="cat_name" colspan="6">Category Name&nbsp;&nbsp;
				<select name="subcat_select_id" id="subcat_select_id" class="select" onchange="javascript:return view_subcat_syn();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid!=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['category_name']?>" <?php if($row_cat['category_name']==$_REQUEST['subcat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="11%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="34%" align="left" id="cat_trh">Synonyms for SubCategory</td>
			<td width="13%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." WHERE category_name='".$_REQUEST['subcat_select_id']."' AND`check`='1' ");
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
			<td width="11%" align="left"><?=$i++?></td>
			<td width="24%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
			<td width="34%" align="left"><?=$row['synonyms_cat_name']?></td>
			<td width="13%" align="center"><a href="category_synonym_manager.php?syn_subcat_id=<?=$row['syn_cat_id']?>&mode=status_subcat_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="category_synonym_manager.php?syn_subcat_id=<?=$row['syn_cat_id']?>&mode=edit_subcat_syn">Edit</a></td>
			<td width="9%" align="center"><a href="category_synonym_manager.php?syn_subcat_id=<?=$row['syn_cat_id']?>&mode=delete_subcat_syn" onClick='return confirm("Are you sure to delete this SubCategory Synonyms?")'>Delete</a></td>
		<?php
				}
			}else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Record found!</b></td></tr>
		<?php } ?>				
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit_subcat_syn' || $_REQUEST['mode']=='add_subcat_syn'){?>
		<?php if($_REQUEST['mode']=='edit_subcat_syn'){ $mode = "Edit SubCategory Synonyms"; } elseif($_REQUEST['mode']=='add_subcat_syn'){ $mode = "Add SubCategory Synonyms"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CATEGORY." WHERE syn_cat_id='".$_REQUEST['syn_subcat_id']."' AND `check`='1'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addsubcat_syn" id="frm_addsubcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_subcat_syn();">
		<input type="hidden" name="syn_subcat_id" id="syn_subcat_id" value="<?=$_REQUEST['syn_subcat_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_subcat_syn" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="40%" align="left" class="cat_name">SubCategory Name</td>
			<td width="60%" align="left">
			<select name="category_name" id="category_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid!=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['category_name']?>" <?php if($row_cat['category_name']==$row['category_name']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
		    </select></td>
		</tr>
		<tr>
			<td width="40%" align="left" class="cat_name">Synonyms for SubCategory</td>
			<td width="60%" align="left"><input type="text" class="text" name="synonyms_subcat_name" id="synonyms_subcat_name" value="<?=$row['synonyms_cat_name']?>" size="40"/></td>
		</tr>
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