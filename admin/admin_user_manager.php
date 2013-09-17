<?php require_once("include/top_menu.php"); ?>
<?php
$sadmin_id = $_SESSION['admin_id'];
if($_REQUEST['mode']=='status' && $_REQUEST["status"] !="")
{
	$admin_id = $_REQUEST['admin_id'];
	mysql_query("update ".TABLE_ADMIN." set is_active='".$_REQUEST["status"]."' where admin_id='".$admin_id."'");
	/*
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_ADMIN." where admin_id='".$admin_id."'"));
	
	if($row_status[status]==1)
	{
		mysql_query("update ".TABLE_ADMIN." set status=0 where admin_id='".$admin_id."'");
	}
	else
	{
		mysql_query("update ".TABLE_ADMIN." set status=1 where admin_id='".$admin_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['admin_name'];
	$_REQUEST['mode']="";
	*/
}
elseif($_REQUEST['mode']=='delete')
{
	$admin_id = $_REQUEST['admin_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TABLE_ADMIN." where admin_id='".$admin_id."'"));
	mysql_query("delete from ".TABLE_ADMIN." where admin_id='".$admin_id."'");
	$msg = "Successfully Delete ".$row_status['admin_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['admin_id']!='')
	{
		$adminid=$_REQUEST['admin_id'];
		$data['admin_password']=md5($_POST['admin_npassword']);	
		$data['admin_name']=$_POST['admin_user'];
		$data['update']=date("Y-m-d");		
		$db->query_update(TABLE_ADMIN, $data, "admin_id='$adminid'");
	}
	else
	{
		$data['admin_password']=md5($_POST['admin_npassword']);	
		$data['admin_name']=$_POST['admin_user'];
		$data['update']=date("Y-m-d");		
		$db->query_insert(TABLE_ADMIN, $data);
	}
	$_REQUEST['mode']="";
	$_REQUEST['admin_user']="";
	$_REQUEST['admin_npassword']="";
	$_REQUEST['admin_cnpassword']="";
}
?>			

<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Admin User Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_city" id="frm_city" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">User Name</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="11%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i =1;		
			$sql="select * from ".TABLE_ADMIN." where admin_id!='".$sadmin_id."'";
			$query = mysql_query($sql);			
			if(mysql_num_rows($query)>0)
			{
				while($row = mysql_fetch_array($query))
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
			<td width="10%" align="left"><?=$i?></td>
			<td width="24%" align="left"><?=$row['admin_name']?></td>
			<td width="15%" align="center"><a href="admin_user_manager.php?admin_id=<?=$row['admin_id']?>&mode=status&status=<?php echo $status; ?>"><?php if($row['status']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="11%" align="center"><a href="admin_user_manager.php?admin_id=<?=$row['admin_id']?>&mode=edit">Edit</a></td>
			<td width="10%" align="center"><a href="admin_user_manager.php?admin_id=<?=$row['admin_id']?>&mode=delete" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
		</tr>
		<?php
					$i++;
				}
			}
			else
			{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='add' || $_REQUEST['mode']=='edit'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit User"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add User"; }
				$sql = mysql_query("SELECT * FROM ".TABLE_ADMIN." WHERE admin_id='".$_REQUEST['admin_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_pass" id="frm_pass" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_user();">
		<input type="hidden" name="admin_id" id="admin_id" value="<?=$_REQUEST['admin_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="33%" align="left" class="cat_name">User Name</td>
			<td width="67%" align="left"><input type="text" class="text" name="admin_user" id="admin_user" value="<?=$row['admin_name']?>" size="20" onchange="ajaxFunction_admin()"/><br /><span class="validate_error" id="errpwd"></span></td>
		</tr>
		<tr>
			<td width="33%" align="left" class="cat_name">Password</td>
			<td width="67%" align="left"><input type="password" class="text" name="admin_npassword" id="admin_npassword" value="" size="20"/><!--<br /><span class="validate_error" id="errnpwd"></span>--></td>
		</tr>
		<tr>
			<td width="33%" align="left" class="cat_name">Confirm Password</td>
			<td width="67%" align="left"><input type="password" class="text" name="admin_cnpassword" id="admin_cnpassword" value="" size="20"/><!--<br /><span class="validate_error" id="errcnpwd"></span>--></td>
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