<?php require_once("include/top_menu.php"); ?>
<?php
$admin_id=intval($_SESSION['admin_id']);
$sql = mysql_fetch_array(mysql_query("SELECT admin_password FROM `".TABLE_ADMIN."` WHERE admin_id='$admin_id'"));
$password=$sql['admin_password'];

if($_REQUEST['pass']!='')
{
	
	$adminid=intval($_SESSION['admin_id']);
	$data['admin_password']=md5($_POST['admin_npassword']);	
	$db->query_update(TABLE_ADMIN, $data, "admin_id='$adminid'");
	$_REQUEST['mode']="";
	$_REQUEST['admin_password']="";
	$_REQUEST['admin_npassword']="";
	$_REQUEST['admin_cnpassword']="";
	$msg = "Admin Password has been changed";
}
?>			

<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Admin Password Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_pass" id="frm_pass" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return passvalidation();">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="33%" align="left" class="cat_name">Current Password</td>
			<td width="67%" align="left"><input type="password" class="text" name="admin_password" id="admin_password" value="" size="20" onKeyUp="ajaxFunction()"/><br /><span class="validate_error" id="errpwd"></span></td>
		</tr>
		<tr>
			<td width="33%" align="left" class="cat_name">New Password</td>
			<td width="67%" align="left"><input type="password" class="text" name="admin_npassword" id="admin_npassword" value="" size="20"/><!--<br /><span class="validate_error" id="errnpwd"></span>--></td>
		</tr>
		<tr>
			<td width="33%" align="left" class="cat_name">Confirm New Password</td>
			<td width="67%" align="left"><input type="password" class="text" name="admin_cnpassword" id="admin_cnpassword" value="" size="20"/><!--<br /><span class="validate_error" id="errcnpwd"></span>--></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="pass" value="Change Password"/></td>
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