<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status_subcat_syn')
{
	$syn_subcat_id = $_REQUEST['syn_subcat_id'];

	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_SUB_CATEGORY_SYNONYMS." where sub_category_synonym_id='".$syn_subcat_id."'"));
	
	if($row_status['is_active']==1)
	{
		mysql_query("update ".MANAGE_E_SUB_CATEGORY_SYNONYMS." set is_active=0 where sub_category_synonym_id='".$syn_subcat_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_E_SUB_CATEGORY_SYNONYMS." set is_active=1 where sub_category_synonym_id='".$syn_subcat_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['sub_category_synonym'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete_subcat_syn')
{
	$syn_subcat_id = $_REQUEST['syn_subcat_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_SUB_CATEGORY_SYNONYMS." where sub_category_synonym_id='".$syn_subcat_id."'"));
	mysql_query("delete from ".MANAGE_E_SUB_CATEGORY_SYNONYMS." where sub_category_synonym_id='".$syn_subcat_id."'");
	$msg = "Successfully Delete ".$row_status['sub_category_synonym'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update_subcat_syn')
{
	if($_REQUEST['syn_subcat_id']!='')
	{
		mysql_query("update ".MANAGE_E_SUB_CATEGORY_SYNONYMS." set sub_category_synonym='".$_REQUEST['synonyms_subcat_name']."', sub_category_id='".$_REQUEST['category_name']."' where sub_category_synonym_id='".$_REQUEST['syn_subcat_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['synonyms_subcat_name'];
	}
	else
	{
		mysql_query("insert into ".MANAGE_SYNONYMS_CATEGORY." (sub_category_synonym, sub_category_id) values('".$_REQUEST['synonyms_subcat_name']."', '".$_REQUEST['category_name']."')");
		$msg = "Successfully Add ".$_REQUEST['sub_category_synonym'];
	}
	$_REQUEST['mode']="";
}

?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Sub Category Synonyms Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>		
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frmview_subcat_syn" id="frmview_subcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_subcat_syn" />
		<input type="hidden" name="subcat_select_id" id="subcat_select_id" value="<?=$_REQUEST['subcat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td align="right" class="cat_name" colspan="6">Sub Category Name&nbsp;&nbsp;
				<select name="subcat_select_id" id="subcat_select_id" class="select" onchange="javascript:return view_subcat_syn();">
				<option value="">Select Sub Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY." ORDER BY sub_category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['sub_category_id']?>"><?=ucwords(str_replace("_"," ",$row_cat['sub_category_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="11%" align="left" id="cat_trh">SL. No.</td>
			<td width="35%" align="left" id="cat_trh">Synonyms for SubCategory</td>
			<td width="23%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="13%" align="center" id="cat_trh">Statu</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY_SYNONYMS);
			while($row = mysql_fetch_array($sql))
			{
				if($i%2)
					$id = "cat_tr1";
				else
					$id = "cat_tr2";
				
				$sql_sub_syn = mysql_fetch_array(mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY." WHERE sub_category_id='".$row['sub_category_id']."'" ));
		?>
		<tr class="<?=$id?>">
			<td width="11%" align="left"><?=$i++?></td>
			<td width="35%" align="left"><?=ucwords(str_replace("_"," ",$row['sub_category_synonym']))?></td>
			<td width="23%" align="left"><?=ucwords(str_replace("_"," ",$sql_sub_syn['sub_category_name']))?></td>
			<td width="13%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=status_subcat_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=edit_subcat_syn">Edit</a></td>
			<td width="9%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=delete_subcat_syn" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['sub_category_synonym']))?>?")'>Delete</a></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat_syn' && $_REQUEST['subcat_select_id']==''){?>
		<form name="frmview_subcat_syn" id="frmview_subcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_subcat_syn" />
		<input type="hidden" name="subcat_select_id" id="subcat_select_id" value="<?=$_REQUEST['subcat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td align="right" class="cat_name" colspan="6">Sub Category Name&nbsp;&nbsp;
				<select name="subcat_select_id" id="subcat_select_id" class="select" onchange="javascript:return view_subcat_syn();">
				<option value="">Select Sub Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY." ORDER BY sub_category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['sub_category_id']?>" <?php if($row_cat['sub_category_id']==$_REQUEST['subcat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['sub_category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="11%" align="left" id="cat_trh">SL. No.</td>
			<td width="35%" align="left" id="cat_trh">Synonyms for SubCategory</td>
			<td width="23%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="13%" align="center" id="cat_trh">Statu</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY_SYNONYMS." WHERE sub_category_id='".$_REQUEST['subcat_select_id']."'");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
						
					$sql_sub_syn = mysql_fetch_array(mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY." WHERE sub_category_id='".$row['sub_category_id']."'" ));
		?>
		<tr class="<?=$id?>">
			<td width="11%" align="left"><?=$i++?></td>
			<td width="35%" align="left"><?=ucwords(str_replace("_"," ",$row['sub_category_synonym']))?></td>
			<td width="23%" align="left"><?=ucwords(str_replace("_"," ",$sql_sub_syn['sub_category_name']))?></td>
			<td width="13%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=status_subcat_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=edit_subcat_syn">Edit</a></td>
			<td width="9%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=delete_subcat_syn" onClick='return confirm("Are you sure to delete this <?=ucwords(str_replace("_"," ",$row['sub_category_synonym']))?>?")'>Delete</a></td>
		<?php
				}
			}else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Record found!</b></td></tr>
		<?php } ?>				
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat_syn' && $_REQUEST['subcat_select_id']!=''){?>
		<form name="frmview_subcat_syn" id="frmview_subcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_subcat_syn" />
		<input type="hidden" name="subcat_select_id" id="subcat_select_id" value="<?=$_REQUEST['subcat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td align="right" class="cat_name" colspan="6">Sub Category Name&nbsp;&nbsp;
				<select name="subcat_select_id" id="subcat_select_id" class="select" onchange="javascript:return view_subcat_syn();">
				<option value="">Select Sub Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY." ORDER BY sub_category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['sub_category_id']?>" <?php if($row_cat['sub_category_id']==$_REQUEST['subcat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['sub_category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="11%" align="left" id="cat_trh">SL. No.</td>
			<td width="35%" align="left" id="cat_trh">Synonyms for SubCategory</td>
			<td width="23%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="13%" align="center" id="cat_trh">Statu</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY_SYNONYMS." WHERE sub_category_id='".$_REQUEST['subcat_select_id']."'");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
						
					$sql_sub_syn = mysql_fetch_array(mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY." WHERE sub_category_id='".$row['sub_category_id']."'" ));
		?>
		<tr class="<?=$id?>">
			<td width="11%" align="left"><?=$i++?></td>
			<td width="35%" align="left"><?=ucwords(str_replace("_"," ",$row['sub_category_synonym']))?></td>
			<td width="23%" align="left"><?=ucwords(str_replace("_"," ",$sql_sub_syn['sub_category_name']))?></td>
			<td width="13%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=status_subcat_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=edit_subcat_syn">Edit</a></td>
			<td width="9%" align="center"><a href="deal_sub_category_synonym_manager.php?syn_subcat_id=<?=$row['sub_category_synonym_id']?>&mode=delete_subcat_syn" onClick='return confirm("Are you sure to delete this <?=ucwords(str_replace("_"," ",$row['sub_category_synonym']))?>?")'>Delete</a></td>
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
				$sql = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY_SYNONYMS." WHERE sub_category_synonym_id='".$_REQUEST['syn_subcat_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addsubcat_syn" id="frm_addsubcat_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_subcat_syn();">
		<input type="hidden" name="syn_subcat_id" id="syn_subcat_id" value="<?=$_REQUEST['syn_subcat_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_subcat_syn" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="40%" align="left" class="cat_name">Sub Category Name</td>
			<td width="60%" align="left">
			<select name="category_name" id="category_name" class="select">
				<option value="">Select Sub Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_SUB_CATEGORY." ORDER BY sub_category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['sub_category_id']?>" <?php if($row_cat['sub_category_id']==$row['sub_category_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['sub_category_name']))?></option>
				<?php
					}
				?>
		    </select></td>
		</tr>
		<tr>
			<td width="40%" align="left" class="cat_name">Synonyms for Sub Category</td>
			<td width="60%" align="left"><input type="text" class="text" name="synonyms_subcat_name" id="synonyms_subcat_name" value="<?=$row['sub_category_synonym']?>" size="40"/></td>
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