<?php
	error_reporting(E_ERROR);
ob_start();
session_start();
if($_SESSION['admin_id']=="")
{
	//header("location:index.php");
}
/* pagination control block starts */
$GLOBALS['show'] = 15;
if($_POST['pageNo']=="")
{
	$GLOBALS['start'] = 0;
	$_POST['pageNo'] = 1;
}
else 
	$GLOBALS['start']=($_POST['pageNo']-1) * $GLOBALS['show'];

$sql_page = " LIMIT ".$GLOBALS['start'].",".$GLOBALS['show'];

/* pagination control block ends */
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
		<link type="text/css" href="css/layout.css" rel="stylesheet" />	
		<link type="text/css" href="css/style.css" rel="stylesheet" />	
		
		<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../js/easyTooltip.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="../js/jquery.wysiwyg.js"></script>
		<script type="text/javascript" src="../js/hoverIntent.js"></script>
		<script type="text/javascript" src="../js/superfish.js"></script>
		<script type="text/javascript" src="../js/custom.js"></script>
		<script type="text/javascript" src="../js/common.js"></script>
		<script type="text/javascript" src="../js/countdown.js"></script>
		<!--<script type="text/javascript" src="../js/md5.js"></script>-->
		<!-- End of Libraries -->	
	</head>
	<body>
	
	<?php
			require("../config.inc.php");
			require("../fckeditor/fckeditor.php");
			require("../class/Database.class.php");
			require("../class/pagination.class.php");
			require("../spaw2/spaw_control.class.php");
			require("../class/SimpleLargeXMLParser.class.php");
			require("../includes/functions.php");
			$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
			$db->connect();
			$admin_id=intval($_SESSION['admin_id']);
			$sql = "SELECT admin_name FROM `".TABLE_ADMIN."`  WHERE admin_id='$admin_id'";
			$record = $db->query_first($sql);
			//echo getRealIpAddr();

	?>
		<!-- Container -->
		<div id="container">
		
			<!-- Header -->
			<div id="header">
				
				<!-- Top -->
				<div id="top">
					<!-- Logo -->
					<div class="logo"> 
						<a href="home.php" title="Administration Home" class="tooltip"><img src="assets/logo.png" width="360"  height="48" alt="Hip Dealz Admin" style="margin-top:20px;" /></a> 
					</div>
					<!-- End of Logo -->
					
					<!-- Meta information -->
					<div class="meta">
						<p>Welcome, <?php echo $record['admin_name'];?>!</p>
						<ul>
							<li><a href="logout.php" title="End administrator session" class="tooltip"><span class="ui-icon ui-icon-power"></span>Logout</a></li>
							<li><a href="admin_password.php" title="Change <?=$record['admin_name']?> Password" class="tooltip"><span class="ui-icon ui-icon-wrench"></span>Change <?=$record['admin_name']?> Password</a></li>
							<!--<li><a href="#" title="Change current settings" class="tooltip"><span class="ui-icon ui-icon-wrench"></span>Settings</a></li>
							<li><a href="#" title="Go to your account" class="tooltip"><span class="ui-icon ui-icon-person"></span>My account</a></li>-->
						</ul>	
					</div>
					<!-- End of Meta information -->
				</div>
				<!-- End of Top-->
				<!-- The navigation bar -->
				<div id="navbar">
					<ul class="nav">
						<li><a href="home.php" title="Dashboard" class="tooltip">Dashboard</a></li>
						<!--<li><a href="">Users</a></li>
						<li><a href="">Newsletter</a></li>
						<li><a href="">Modules</a></li>
						<li>
							<a href="">Multi Level Menu</a>
							<ul>
								<li><a href="">Menu Link 1</a></li>
								<li><a href="">Menu Link 2</a></li>
								<li><a href="">Menu Link 3</a>
									<ul>
										<li><a href="">Menu Link 1</a></li>
										<li><a href="">Menu Link 2</a>
											<ul>
												<li><a href="">Menu Link 1</a></li>
												<li><a href="">Menu Link 2</a></li>
												<li><a href="">Menu Link 3</a></li>
											</ul>
										</li>
										<li><a href="">Menu Link 3</a></li>
										<li><a href="">Menu Link 4</a></li>
										<li><a href="">Menu Link 5</a></li>
										<li><a href="">Menu Link 6</a></li>
									</ul>
								</li>
								<li><a href="">Menu Link 4</a></li>
								<li><a href="">Menu Link 5</a></li>
								<li><a href="">Menu Link 6</a></li>
							</ul>
						</li>-->
					</ul>
				</div>
				<!-- End of navigation bar" -->
				
				<!-- Search bar -->
				<!--<div id="search">
					<form action="/search/" method="POST">
						<p>
							<input type="submit" value="" class="but" />
							<input type="text" name="q" value="Search the admin panel" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;" />
						</p>
					</form>
				</div>-->
				<!-- End of Search bar -->
				
				</div>
				<!-- End of Header -->