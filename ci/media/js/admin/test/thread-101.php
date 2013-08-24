<html>

<head>

<title>background php processes</title>

</head>

<body>

<?php

if(isset($_POST['pid'])&&($_POST['pid']!="")){

	$kill_cmd = "kill -9 ".$_POST['pid'];

	system($kill_cmd);

}

?>

<?php

/****

code to find PID of processes running

and allow to enter pid to kill the process

******/

$cmd = "ps -ef | grep php";

$out = array();

exec($cmd,$out);

$cnt = count($out);

?>

<table width="100%" cellpadding="5" cellspacing="0" >

<?php

for($i=0;$i<$cnt;$i++){

	?>

	<tr>

	<td>

	<?php echo $out[$i];?>

	</td>

	</tr>

	<?php

}

?>

</table>

<form method="post" action="">

<input type="text" name="pid" size="100" />

<input type="submit" value="Kill" />

</form>

</body>

</html>