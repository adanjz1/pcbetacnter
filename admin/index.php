<?php
session_start();
error_reporting(1);
ob_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<!-- End of Meta -->
		
		<!-- Page title -->
		<title>PC Counter::Administrator::</title>
		<!-- End of Page title -->
		
		<!-- Libraries -->
		<link type="text/css" href="css/login.css" rel="stylesheet" />	
		<link type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />			
		<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../js/easyTooltip.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script src="../js/jquery.validate.js" type="text/javascript"></script>
		
		<script type="text/javascript">
		
		$().ready(function() {
			
			// validate signup form on keyup and submit
			$("#signupForm").validate({
				rules: {
					username: "required",
					password: "required"
					
				},
				messages: {
					username: "Please enter your username",
					password: "Please enter your password"
				}
			});
		
		});
		</script>
		
		<!-- End of Libraries -->	
	</head>
	<body>
	
	<?php
	
		if(isset($_POST['login']))
		{
			require("../config.inc.php");
			require("../class/Database.class.php");
			$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
			$db->connect();
			$username=$_POST['username'];
			$password=md5($_POST['password']);
			//$password = $_POST["password"];
			$sql = "SELECT * FROM `".TABLE_ADMIN."`  WHERE admin_name='$username' and admin_password='$password' and status=1";
			$record = $db->query_first($sql);
			if($db->affected_rows > 0)
			{
				$_SESSION['admin_id']=$record['admin_id'];
				header("location:home.php");
			}

		}
	?>
		
	<div id="container">
		<div class="logo"><img src="../images/logo.png" width="249" alt="Hip Dealz Admin" /></div>
		<div id="box" style="padding:20px 0 0 0;">
			<form method="POST" id="signupForm">
			<p><label for="username">Username:</label><input id="username" name="username" /></p>
		    <p class="space"><label for="cemail">Password:&nbsp;</label><input id="password" name="password" type="password" /></p>
			<p class="space"><!--<span><input type="checkbox" />Remember me</span>--><input type="submit" value="Login" class="login" name="login" style="cursor:pointer;" /></p>
			</form>
		</div>
	</div>

	</body>
</html>
