<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status')
{
	$id = $_REQUEST['id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_NEWSLETTERMANAGER." where id='".$id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_NEWSLETTERMANAGER." set is_active=0 where id='".$id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_NEWSLETTERMANAGER." set is_active=1 where id='".$id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['subject'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$id = $_REQUEST['id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_NEWSLETTERMANAGER." where id='".$id."'"));
	mysql_query("delete from ".MANAGE_NEWSLETTERMANAGER." where id='".$id."'");
	
	$msg = "Successfully Delete ".$row_status['subject'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{

	$data['email']=$_REQUEST['email'];
	$data['joindate']=$_REQUEST['joindate'];
	$data['subject']=$_REQUEST['subject'];
	$data['message']=str_replace("%5C%22","",$_REQUEST['message']);
	//$data['uptodate']=date("Y-m-d");
	
	if($_REQUEST['id']!='')
	{
		$id = $_REQUEST['id'];
		$db->query_update(MANAGE_NEWSLETTERMANAGER, $data, "id='$id'");
		$msg = "Successfully Edit ".$_REQUEST['subject'];
	}
	else
	{
		$id=$db->query_insert(MANAGE_NEWSLETTERMANAGER, $data);
		$data_1['id']=$id;		
		$msg = "Successfully Add ".$_REQUEST['subject'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['subject']="";
	$_REQUEST['message']="";
	
	
	$to      = $_REQUEST['email'];
	$subject = $_REQUEST['subject'];
	/*$message = 'Hi' .$rs[first_name]. '<br>';*/
	$message = 'Newsletter From the Dealmist Admin<br><br><br>';
	$message.= 'Message:'.$_REQUEST['message']. '<br><br>';
	$message.= 'Date Of Joining:'.$_REQUEST['joindate']. '<br><br>';
	//$message.= 'Phone:'.$_REQUEST[contact_phone]. '<br><br>';
	//$message.= 'Company:'.$_REQUEST[contact_company]. '<br><br>';
//		$message.= 'Hear About Jim:'.$_REQUEST[hearaboutjim]. '<br><br>';
	//$message.= 'Message:'.$_REQUEST[contact_message]. '<br><br>';
	//$message.= 'Date:'.$today. '<br><br>';
//		$message.= 'Gender:'.$_REQUEST[gender]. '<br><br>';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= 'To: Limegrip' .  "\r\n";
	$headers .= 'From: Dealmist Site admin <info@dealmist.com>' . "\r\n";
	
	mail($to, $subject, $message, $headers);
	
	
}
?>			
<!-- Background wrapper -->

<script language="javascript" src="js/prototype-1.6.0.2.js"></script>
<script language="javascript" src="js/prototype-base-extensions.js"></script>
<script language="javascript" src="js/prototype-date-extensions.js"></script>
<script language="javascript" src="js/datepicker.js"></script>
<link rel="stylesheet" href="css/datepicker.css"></script>

<div id="bgwrap">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm_addcontent.email.value=="")
	{
		document.getElementById("err_email").innerHTML="Please Enter Email";
		document.frm_addcontent.email.focus();
		return false;
	}
	else
	{
		document.getElementById("err_email").innerHTML="";
	}
	
	if(document.frm_addcontent.joindate.value=="")
	{
		document.getElementById("err_joindate").innerHTML="Please Enter Date";
		document.frm_addcontent.joindate.focus();
		return false;
	}
	else
	{
		document.getElementById("err_joindate").innerHTML="";
	}
	
	if(document.frm_addcontent.subject.value=="")
	{
		document.getElementById("err_subject").innerHTML="Please Enter Newsletter Subject";
		document.frm_addcontent.subject.focus();
		return false;
	}
	else
	{
		document.getElementById("err_subject").innerHTML="";
	}
return true;
}
</script>
<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Newsletter Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_deal" id="frm_deal" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">Email</td>
			<td width="30%" align="left" id="cat_trh">Subject</td>
			<td width="30%" align="left" id="cat_trh">Message</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="11%" align="center" id="cat_trh" >Send Date</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$items = 10;
			$page = 1;
			$i =1;		
			if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'])
			{
				$limit = " LIMIT ".(($page-1)*$items).",$items";
			}
			else
			{
				$limit = " LIMIT $items";
			}
			/*echo "select * from ".MANAGE_NEWSLETTERMANAGER." WHERE joindate BETWEEN CURDATE() and DATE_SUB(CURDATE(),INTERVAL 30 DAY) ORDER BY subject";*/
			$sql="select * from ".MANAGE_NEWSLETTERMANAGER." ORDER BY joindate DESC LIMIT 30";
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_NEWSLETTERMANAGER." ORDER BY subject";

			$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
			$query = mysql_query($sql);
			
			if($aux['total']>0)
			{
				$p = new pagination;
				$p->Items($aux['total']);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");				
				while($row = mysql_fetch_array($query))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i?></td>
			<td width="24%" align="left"><?=$row['email']?></td>
			<td width="30%" align="left"><?=$row['subject']?></td>
			<td width="30%" align="left"><?=$row['message']?></td>
			<td width="15%" align="center"><!--<a href="newslettermanage.php?id=<?=$row['id']?>&mode=status&page=<?=$_REQUEST['page']?>">--><?php if($row['is_active']==1){?>In-Active<?php } else { ?><font color="#FF0000">Send</font><?php }?><!--</a>--></td>
			<td width="11%" align="center"><?=$row['joindate']?></td>
			<td width="10%" align="center"><a href="newslettermanage.php?id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Content?")'>Delete</a></td>
		</tr>
		<?php
					$i++;
				}
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><?php $p->show();?></td></tr>
		<?php
			}
			else
			{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Content Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Newsletter"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Newsletter"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_NEWSLETTERMANAGER." WHERE id='".$_REQUEST['id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcontent" id="frm_addcontent" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return validate();">
		<input type="hidden" name="id" id="id" value="<?=$_REQUEST['id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="5" align="left" width="100%">
		<tr>
			<td width="23%" align="left" class="cat_name">Email</td>
			<td width="77%" align="left"><input type="text" class="text" name="email" id="email" value="<?=$row['email']?>" size="60"/>
			<span id="err_email"></span>
			</td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Joining Date </td>
			<td width="77%" align="left"><input type="text" class="text" name="joindate" id="joindate" value="<?=$row['joindate']?>" size="60"/>
			<script language="javascript">
			new Control.DatePicker('joindate', {timePicker: true, timePickerAdjacent: true});
			</script>
			<span id="err_joindate"></span>
			</td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Subject</td>
			<td width="77%" align="left"><input type="text" class="text" name="subject" id="subject" value="<?=$row['subject']?>" size="60"/>
			<span id="err_subject"></span>
			</td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Message</td>
			<td width="77%" align="left">
			<?php
				$sw = new SPAW_Wysiwyg('message',$row['message']);
				$sw->show();
			?></td>
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