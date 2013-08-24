<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status')
{
	$help_id = $_REQUEST['help_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_HELP." where help_id='".$help_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_HELP." set is_active=0 where help_id='".$help_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_HELP." set is_active=1 where help_id='".$help_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['help_qus'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$help_id = $_REQUEST['help_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_HELP." where help_id='".$help_id."'"));
	mysql_query("delete from ".MANAGE_HELP." where help_id='".$help_id."'");
	$msg = "Successfully Delete ".$row_status['help_qus'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['help_id']!='')
	{
		mysql_query("update ".MANAGE_HELP." set help_qus='".$_REQUEST['ques']."', help_ans='".$_REQUEST['ans']."' where help_id='".$_REQUEST['help_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['ques'];
	}
	else
	{
		mysql_query("insert into ".MANAGE_HELP." (help_qus, help_ans, help_date) values('".$_REQUEST['ques']."', '".$_REQUEST['ans']."', '".date("Y-m-d")."')");
		$msg = "Successfully Add ".$_REQUEST['ques'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['ques']="";
	$_REQUEST['ans']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Help Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_help" id="frm_help" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="21%" align="left" id="cat_trh">Question</td>
			<td width="35%" align="left" id="cat_trh">Answare</td>
			<td width="14%" align="center" id="cat_trh">Status</td>
			<td width="10%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_HELP);
			while($row = mysql_fetch_array($sql))
			{
				if($i%2)
					$id = "cat_tr1";
				else
					$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i++?></td>
			<td width="21%" align="left"><?=$row['help_qus']?></td>
			<td width="35%" align="left"><?=$row['help_ans']?></td>
			<td width="14%" align="center"><a href="help_manager.php?help_id=<?=$row['help_id']?>&mode=status"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="10%" align="center"><a href="help_manager.php?help_id=<?=$row['help_id']?>&mode=edit">Edit</a></td>
			<td width="10%" align="center"><a href="help_manager.php?help_id=<?=$row['help_id']?>&mode=delete" onClick='return confirm("Are you sure to delete this FAQ?")'>Delete</a></td>
		</tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Help"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Help"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_HELP." WHERE help_id='".$_REQUEST['help_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addhelp" id="frm_addhelp" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_help();">
		<input type="hidden" name="help_id" id="help_id" value="<?=$_REQUEST['help_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Questions</td>
			<td width="71%" align="left"><input type="text" class="text" name="ques" id="ques" value="<?=$row['help_qus']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Answare</td>
			<td width="71%" align="left"><textarea class="text" rows="20" cols="5" name="ans" id="ans"><?=$row['help_ans']?></textarea></td>
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