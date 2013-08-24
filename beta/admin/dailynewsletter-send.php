<?php
ob_start();
session_start();
require("../config.inc.php");
require("../class/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);			
$db->connect();

if($_REQUEST['submit']=='Send')
{
$from="www.dealmist.com<".$_POST['from'].">";
 $subject=$_POST['subject'];
 $message=$_POST['message'];

mysql_query("INSERT INTO `dealmist_newsletter` (`newsletter` ,`subject`)VALUES ('$message', '$subject')");

$reg_id=explode('-',$_REQUEST['userid']);
	for($i=1;$i<count($reg_id);$i++)
	{
$row=mysql_fetch_object(mysql_query("SELECT * FROM ".MANAGE_NEWSLETTER." where user_email='".$reg_id[$i]."'"));
	  $to=$row->email;
	  
	mail($to, $subject, $message ,$from);
	}
	$_SESSION['msg']='The Newsletter Email Send successfully';
	header('Location: '.basename(__FILE__));
	exit();
}
if($_REQUEST['submit']=='Send & Save')
{
$from="www.dealmist.com<".$_POST['from'].">";
 $id=$_POST['id'];
 $message=$_POST['message'];
 

mysql_query("update `dealmist_newsletter` set `newsletter`='$message' where id='$id' ");

$reg_id=explode('-',$_REQUEST['userid']);
	for($i=1;$i<count($reg_id);$i++)
	{
$row=mysql_fetch_object(mysql_query("SELECT * FROM ".MANAGE_NEWSLETTER." where user_email='".$reg_id[$i]."'"));
	  $to=$row->email;
	  
	mail($to, "New Newsletter", $message ,$from);
	}
	$_SESSION['msg']='The Newsletter Email Send successfully';
	header('Location: '.basename(__FILE__));
	exit();
}

$rownews=mysql_fetch_array(mysql_query("select * from `dealmist_newsletter` where id='".$_REQUEST['id']."'"));
?>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<script language="javascript">
 function submitdata(val)
  {
  //alert("hh");
  document.location.href="newsletter-send.php?id="+val+"&reg_id=<?=$_REQUEST['reg_id']?>";
  }
</script>

<script language="javascript">
function prevdiv()
	{
	document.getElementById('previous').style.display='block';
	document.getElementById('new').style.display='none';
	}
function newdiv()
	{
	document.getElementById('new').style.display='block';
	document.getElementById('previous').style.display='none';
	}	
	
</script>
<form action="" method="post" enctype="multipart/form-data"  name="form1" id="form1">


<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
	<td  height="34" colspan="2" align="center" valign="middle" class="mnu_head">
	<font style="font-size:14px; font-weight:bold;">Newsletter Manage</font></td>
</tr>
   <tr>
	<td height="34" width="50%" valign="middle" align="right" class="normal_text" ><input type="radio" onclick="newdiv();" value=""  name="newsletter" id="newsletter" />New Newsletter</td>
    <td valign="middle" width="50%" class="normal_text"  align="left" ><input type="radio" checked="checked" value="" onclick="prevdiv();"   name="newsletter" id="newsletter"/>Previous</td>
  </tr>
   <tr>
	<td height="34" colspan="2" align="center" valign="middle"><?php echo $_SESSION['msg']; $_SESSION['msg']="";?></td>
</tr>
   <tr>
	<td height="34" colspan="2" align="center" valign="middle">
									<form name="sadns" action="newsletter-send.php" method="post">
									
									<div id="new" style="display:none">
									<input type="hidden" name="userid" value="<?=$_REQUEST['reg_id'];?>" />
									<table width="95%" border="0" cellspacing="0" cellpadding="5">
									<tr>
									<td width="9%" align="left" valign="top">From</td>
									<td  width="91%"><input name="from" value="info@dealmist.com" type="text" readonly></td>
									</tr>
									<tr>
									<td align="left" valign="top">Subject:</td>
									<td><input name="subject" size="90" value="" type="text" /></td>
									</tr>
									<tr>
									<td align="left" valign="top">Message</td>
									<td><textarea name="message" rows="25" cols="70" id="message"></textarea></td>
									</tr>
									<tr>
									<td align="left" valign="top">&nbsp;</td>
									<td><input type="submit" name="submit" class="butt" value="Send"  /></td>
									</tr>
									</table>
									</div>
									</form>
									<form name="sends" action="newsletter-send.php" method="post">
									
									<div id="previous" style="display:block">
									<input type="hidden" name="userid" value="<?=$_REQUEST['id'];?>" />
									<table width="95%" border="0" cellspacing="0" cellpadding="5">
									<tr>
									<td width="9%" align="left" valign="top" class="normal_text">From</td>
									<td  width="91%"><input name="from" value="info@dealmist.com" type="text" ></td>
									</tr>
									<tr>
									<td align="left" valign="top" class="normal_text">Subject</td>
									<td>
									<select onChange="submitdata(this.value);" name="id" id="id">
									<option value="">Select One</option>
									<?
									 $resn=mysql_query("select * from dealmist_newsletter");
									while($rown=mysql_fetch_array($resn))
									{
									 ?>
									 <option value="<?=$rown['id'];?>" <?php if($_REQUEST['id']== $rown['id']) echo "selected" ?>><?=$rown['subject'];?></option>
									 <? } ?>
									</select></td>
									</tr>
									<tr>
									  <td align="left" valign="top" class="normal_text">Massage</td>
									  <td><textarea name="message" rows="25" cols="70" id="message"><?=$rownews['newsletter'];?></textarea></td>
									  </tr>
									<tr>
									  <td align="left" valign="top">&nbsp;</td>
									  <td><input type="submit" name="submit" class="butt" value="Send & Save"/></td>
									  </tr>
									</table>
									</div>
									</form>
	</td>
	</tr>
	
	</table>

</form>
<?php include("includes/footer.php");?>