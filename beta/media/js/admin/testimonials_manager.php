<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status')
{
	$testm_id = $_REQUEST['testm_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_TESTIMONIALS." where testm_id='".$testm_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_TESTIMONIALS." set is_active=0 where testm_id='".$testm_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_TESTIMONIALS." set is_active=1 where testm_id='".$testm_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['testm_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$testm_id = $_REQUEST['testm_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_TESTIMONIALS." where testm_id='".$testm_id."'"));
	mysql_query("delete from ".MANAGE_TESTIMONIALS." where testm_id='".$testm_id."'");
	$msg = "Successfully Delete ".$row_status['testm_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['testm_id']!='')
	{
		mysql_query("update ".MANAGE_TESTIMONIALS." set testm_name='".$_REQUEST['tname']."', testm_desc='".$_REQUEST['tdesc']."' where testm_id='".$_REQUEST['testm_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['tname'];
	}
	else
	{
		mysql_query("insert into ".MANAGE_TESTIMONIALS." (testm_name, testm_desc, testm_date) values('".$_REQUEST['tname']."', '".$_REQUEST['tdesc']."', '".date("Y-m-d")."')");
		$msg = "Successfully Add ".$_REQUEST['tname'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['tname']="";
	$_REQUEST['tdesc']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Testimonials Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_testim" id="frm_testim" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="23%" align="left" id="cat_trh">Name</td>
			<td width="33%" align="left" id="cat_trh">Description</td>
			<td width="14%" align="center" id="cat_trh">Status</td>
			<td width="10%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_TESTIMONIALS);
			while($row = mysql_fetch_array($sql))
			{
				if($i%2)
					$id = "cat_tr1";
				else
					$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i++?></td>
			<td width="23%" align="left"><?=$row['testm_name']?></td>
			<td width="33%" align="left"><?=$row['testm_desc']?></td>
			<td width="14%" align="center"><a href="testimonials_manager.php?testm_id=<?=$row['testm_id']?>&mode=status"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="10%" align="center"><a href="testimonials_manager.php?testm_id=<?=$row['testm_id']?>&mode=edit">Edit</a></td>
			<td width="10%" align="center"><a href="testimonials_manager.php?testm_id=<?=$row['testm_id']?>&mode=delete" onClick='return confirm("Are you sure to delete this Testimonials?")'>Delete</a></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Testimonials"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Testimonials"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_TESTIMONIALS." WHERE testm_id='".$_REQUEST['testm_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addtestim" id="frm_addtestim" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_testim();">
		<input type="hidden" name="testm_id" id="testm_id" value="<?=$_REQUEST['testm_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="32%" align="left" class="cat_name">Name</td>
			<td width="68%" align="left"><input type="text" class="text" name="tname" id="tname" value="<?=$row['testm_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Description</td>
			<td width="68%" align="left"><textarea class="text" rows="20" cols="5" name="tdesc" id="tdesc"><?=$row['testm_desc']?></textarea></td>
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