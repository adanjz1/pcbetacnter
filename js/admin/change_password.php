<?php
ob_start();
session_start();

require("../config.inc.php");
require("../class/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
$db->connect();

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id=intval($_SESSION['admin_id']);
$sql = mysql_fetch_array(mysql_query("SELECT admin_password FROM `".TABLE_ADMIN."` WHERE admin_id='$admin_id'"));
$password=$sql['admin_password'];

if(isset($_REQUEST['submit']))
{
	
	$adminid=intval($_SESSION['admin_id']);
	$data['admin_password']=md5($_POST['admin_cpassword']);	
	$db->query_update("admin", $data, "admin_id='$adminid'");
	//header("location:show_admin.php");
	
}

?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<!-- End of Meta -->
		
		<!-- Page title -->
		<title>Daily Deals::Admin::</title>
		<!-- End of Page title -->
		
		<!-- Libraries -->
		<link type="text/css" href="css/layout.css" rel="stylesheet" />		
		<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../js/easyTooltip.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="../js/jquery.wysiwyg.js"></script>
		<script type="text/javascript" src="../js/hoverIntent.js"></script>
		<script type="text/javascript" src="../js/superfish.js"></script>
		<script type="text/javascript" src="../js/custom.js"></script>
		<script type="text/javascript" src="../js/utf8_encode.js"></script>
		<script type="text/javascript" src="../js/md5.js"></script>

		<!-- End of Libraries -->
		
		<script language="javascript" type="text/javascript">
		
		function passvalidation()
		{
			var admin_password = document.getElementById('admin_password').value;
			var admin_pwd=md5(admin_password);
			var admin_npassword = document.getElementById('admin_npassword').value;
			var admin_cnpassword = document.getElementById('admin_cnpassword').value;
			var str="";
			
			if(admin_password=="")
			{
				document.getElementById('errpwd').innerHTML="Enter Current Password";
				str+="errmsg";
			}
			else if(admin_password!="")
			{
				var admin_pass="<?php echo $password;?>";
				
				if(admin_pass!=admin_pwd)
				{
					document.getElementById('errnpwd').innerHTML="Enter Correct Password";
					str+="errmsg";
				}
			}
			if(admin_npassword=="")
			{
				document.getElementById('errnpwd').innerHTML="Enter New Password";
				str+="errmsg";
			}
			if(admin_cnpassword=="")
			{
				document.getElementById('errcnpwd').innerHTML="Confirm New Password";
				str+="errmsg";
			}
			if(admin_cnpassword!=admin_npassword)
			{
				document.getElementById('errcnpwd').innerHTML="Password Mismatch";
				str+="errmsg";
			}
			
			if(str!="")
			{
				return false;
			}
			else
			{
				return true;
			}
	
		}
			
		</script>

		<script language="javascript" type="text/javascript">
			<!-- 
			//Browser Support Code
			function ajaxFunction(){
				var ajaxRequest;  // The variable that makes Ajax possible!
				
				try{
					// Opera 8.0+, Firefox, Safari
					ajaxRequest = new XMLHttpRequest();
				} catch (e){
					// Internet Explorer Browsers
					try{
						ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
					} catch (e) {
						try{
							ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
						} catch (e){
							// Something went wrong
							alert("Your browser broke!");
							return false;
						}
					}
				}
				// Create a function that will receive data sent from the server
				ajaxRequest.onreadystatechange = function(){
					if(ajaxRequest.readyState == 4){
						var ajaxDisplay = document.getElementById('errpwd');
						ajaxDisplay.innerHTML = ajaxRequest.responseText;
					}
				}
				var admin_password = document.getElementById('admin_password').value;
				var queryString = "?admin_password=" + admin_password;
				ajaxRequest.open("GET", "check_password.php" + queryString, true);
				ajaxRequest.send(null); 
			}
			
			//-->
		</script>
		
	</head>
	<body>
	
	<?php
			$admin_id=intval($_SESSION['admin_id']);
			$sql = "SELECT admin_name FROM `".TABLE_ADMIN."` WHERE admin_id='$admin_id'";
			$record = $db->query_first($sql);
			
			if($_REQUEST[mode]=="edit")
			{
				$adminid=intval($_REQUEST['id']);
				$row_deals=mysql_fetch_array(mysql_query("select * from admin where admin_id='$adminid'"));
			}
	
	?>
		<!-- Container -->
		<div id="container">
		
			<!-- Header -->
			<div id="header">
				
				<!-- Top -->
				<div id="top">
					<!-- Logo -->
					<div class="logo"> 
						<a href="#" title="Administration Home" class="tooltip"><img src="assets/logo.png" alt="Wide Admin" /></a> 
					</div>
					
					<!-- End of Logo -->
					
					<!-- Meta information -->
					<div class="meta">
						<p>Welcome, <?php echo $record['admin_name'];?>!</p>
						<ul>
							<li><a href="logout.php" title="End administrator session" class="tooltip"><span class="ui-icon ui-icon-power"></span>Logout</a></li>
										<li><a href="#" title="Change Password" class="tooltip"><span class="ui-icon ui-icon-person"></span>Change Password</a></li>
						</ul>	
					</div>
					<!-- End of Meta information -->
				</div>
				<!-- End of Top-->
			
			</div>
			<!-- End of Header -->
			
			<!-- Background wrapper -->
			<div id="bgwrap">
		
				<!-- Main Content -->
				<div id="content">
					<div id="main">

							<h1>Change Password</span></h1>
							<form method="post" enctype="multipart/form-data" name="change_pass" onSubmit="return passvalidation()">
										
										<!-- Fieldset -->
										<fieldset>

											<p>
												<label for="dropdown">Current Password: </label>
												<input class="lf" name="admin_password" type="password" value="" id="admin_password" onKeyUp="ajaxFunction()"  />
											</p>
											<p>
												<span class="validate_error" id="errpwd"></span>
											</p>																				
											
											<p>
												<label for="dropdown">New Password: </label>
												<input class="lf" name="admin_npassword" type="password" value="" id="admin_npassword" />
											</p>
											<p>
												<span class="validate_error" id="errnpwd"></span>
											</p>
											
											<p>
												<label for="dropdown">Confirm New Password: </label>
												<input class="lf" name="admin_cnpassword" type="password" value="" id="admin_cnpassword" />
											</p>
											<p>
												<span class="validate_error" id="errcnpwd"></span>
											</p>		
											
											<p align="center">
												<input class="button" type="submit" value="Change Password" name="submit" />
												<!--<input class="button" type="reset" value="Reset" />-->
											</p>
										</fieldset>
										<!-- End of fieldset -->
									</form>
				
					<hr />

					</div>
				</div>
				<!-- End of Main Content -->
				
				<!-- Sidebar -->
				
				<?php require_once("include/left_menu.php"); ?>				
				
				<!-- End of Sidebar -->
				
			</div>
			<!-- End of bgwrap -->
		</div>
		<!-- End of Container -->
		
		<!-- Footer -->
		
		<?php require_once("include/footer.php"); ?>			
		
		<!-- End of Footer -->

	</body>
</html>