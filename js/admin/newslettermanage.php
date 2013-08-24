<?php
require_once("include/top_menu.php");
require_once("include/function_search.php");
include("include/pagination.php");
	
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
function validate(){
	if(document.frm_addcontent.email.value==""){
		document.getElementById("err_email").innerHTML="Please Enter Email";
		document.frm_addcontent.email.focus();
		return false;
	}
	else{
		document.getElementById("err_email").innerHTML="";
	}
	
	if(document.frm_addcontent.joindate.value==""){
		document.getElementById("err_joindate").innerHTML="Please Enter Date";
		document.frm_addcontent.joindate.focus();
		return false;
	}
	else{
		document.getElementById("err_joindate").innerHTML="";
	}
	
	if(document.frm_addcontent.subject.value==""){
		document.getElementById("err_subject").innerHTML="Please Enter Newsletter Subject";
		document.frm_addcontent.subject.focus();
		return false;
	}
	else{
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
      <p>
        <?=$msg?>
      </p>
      <?php }else { ?>
      <p>&nbsp;</p>
      <?php } ?>
      <?php if($_REQUEST['mode']==''){
			SearchAlphabet(); 
			?>
      <div style="height:10px; clear:both">&nbsp;</div>
     <form name="frm_deal" id="frm_deal" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
        <table width="99%" align="center" border="0" class="border" cellpadding="5" cellspacing="1">
          <tr class="TDHEAD">
         	<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="30%" align="left" id="cat_trh">Subject</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="11%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
          </tr>
          <?php
			$items = 15;
			$page = 1;
					
			if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1){
				$limit = " LIMIT ".(($page-1)*$items).",$items";
				$i = $items*($page-1)+1;
			}
			else{
				$limit = " LIMIT $items";
				$i = 1;
			}
			if ($_REQUEST['action'] == "search")
			 $condition = " AND subject LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['action'] == "alpha") 
			 $condition = " AND subject like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="SELECT * FROM ".MANAGE_NEWSLETTERMANAGER." Where 1   ".$condition."  ORDER BY subject  asc";
			 $row_count = getRowCount($sql);
			$sql="SELECT * FROM ".MANAGE_NEWSLETTERMANAGER." Where 1  ".$condition." ORDER BY subject asc ".$GLOBALS[sql_page];
			$rs  = mysql_query($sql);
			if( mysql_num_rows($rs) > 0){
				$srl_no = $GLOBALS['start'] + 1;
						
				while($row = mysql_fetch_array($rs)){
					if($srl_no%2)
						$id = "table_record";
					else
						$id = "table_record_alt";
					if($row["is_active"] ==1)
						$status =0;
					else
						$status =1;
		?>
          <tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i?></td>
			<td width="30%" align="left"><?=substr($row['subject'],0,100)?></td>
			<td width="15%" align="center"><!--<a href="newslettermanage.php?id=<?=$row['id']?>&mode=status&page=<?=$_REQUEST['page']?>">--><?php if($row['is_active']==1){?>In-Active<?php } else { ?><font color="#FF0000">Send</font><?php }?><!--</a>--></td>
			<td width="11%" align="center"><a href="newslettermanage.php?id=<?=$row['id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="newslettermanage.php?id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Content?")'>Delete</a></td>
		</tr>
          <?php
					$srl_no=$srl_no+1;
				}
		?>
          <tr>
            <td colspan="7" align="center"><? if($row_count>0) pagination($row_count,"frmPaging"); ?></td>
          </tr>
          <?php
			}
			else{
		?>
          <tr>
            <td colspan="7" align="center" style="padding-top:10px;"><b>No  Data Found</b></td>
          </tr>
          <?php
			}
		?>
        </table>
        <br />
        <br />
      </form>
      </form>
      <form name="frmPaging" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
        <input 	type="hidden" 	name="search_txt"	value="<? echo $_REQUEST['search_txt']; ?>">
        <input 	type="hidden" 	name="mode" 		value="<? echo $GLOBALS['mode']; ?>">
        <input 	type="hidden" 	name="action" 	value="<? echo $_REQUEST['action']; ?>">
        <input 	type="hidden" 	name="pageNo"		value="<? echo $_REQUEST['pageNo']; ?>">
        <input 	type="hidden" 	name="row_id"		value="<? echo $_REQUEST['row_id']; ?>">
      </form>
      <div style="height:10px; clear:both">&nbsp;</div>
      <?php
			$search_fields = "Subject";
			$field_name = "subject";
			Search($search_fields,$field_name);
		?>
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
				/*$sw = new SPAW_Wysiwyg('message',$row['message']);
				$sw->show();*/
				
				$oFCKeditor = new FCKeditor('message');
				$oFCKeditor->BasePath = '../fckeditor/';
				$oFCKeditor->Value = stripslashes($row['message']) ;
				$oFCKeditor->Width = '100%' ;
				$oFCKeditor->Height = '500' ;
				$oFCKeditor->ToolbarSet = 'Default';
				$oFCKeditor->Create();
			?>
			</td>
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
</div>
<?php require_once("include/footer.php"); ?>
<!-- End of Footer --> 
