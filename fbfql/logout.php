<?php
ob_start();
session_start();
include_once "fbmain.php";
define("SITE_URL","http://unifiedinfotech.net/fblogin/fbfql/index.php");
//setcookie ("c_user", "", time() - 3600, "/", ".facebook.com", 1);
session_destroy();

/*$past = time() - 3600;
foreach ( $_COOKIE as $key => $value )
{
    setcookie( $key, $value, $past, '/', '.facebook.com' );
}*/

/*unset($_COOKIE['c_user']);
return setcookie(c_user, NULL, -1); */

header("Location: " . $facebook->getLogoutUrl(array('next'=>SITE_URL."?bye=You've signed out. See you again soon")));



?>