<?php
ob_start();
session_start();

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

require("../config.inc.php");
require("../class/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
$db->connect();

//$admin_id=intval($_SESSION['admin_id']);
$admin_user =$_GET['admin_user'];
//$admin_password=md5($_GET['admin_password']);
//echo "SELECT admin_password FROM `".TABLE_ADMIN."` WHERE admin_id='$admin_id' and admin_password='$admin_password'";
$sql = mysql_query("SELECT admin_name FROM `".TABLE_ADMIN."` WHERE admin_name='$admin_user'");
if(@mysql_num_rows($sql)>0)
{
	echo "User Name is Already Exist";
}
else
{
	echo "User Name is Available";
}


?>