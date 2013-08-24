<?php
ob_start();
session_unset($_SESSION['admin_id']);
session_destroy();

header("location:index.php");

?>