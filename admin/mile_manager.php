<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST["status"]!="")
{
	$mile_id = $_REQUEST['mile_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_MILEMANAGER." where mile_id='".$mile_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	mysql_query("update ".MANAGE_MILEMANAGER." set is_active='".$_REQUEST["status"]."' where id='".$mile_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".MANAGE_MILEMANAGER." set is_active=1 where mile_id='".$mile_id."'");
	//}
	$msg = "Successfully Change Status of ".$row_status['mile'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$mile_id = $_REQUEST['mile_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_MILEMANAGER." where id='".$mile_id."'"));
	mysql_query("delete from ".MANAGE_MILEMANAGER." where id='".$mile_id."'");
	$msg = "Successfully Delete ".$row_status['mile'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['mile_id']!='')
	{
		mysql_query("update ".MANAGE_MILEMANAGER." set mile='".$_REQUEST['mile']."' where id='".$_REQUEST['mile_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['mile'];
	}
	else
	{
		mysql_query("insert into ".MANAGE_MILEMANAGER." (mile) values('".$_REQUEST['mile']."')");
		$msg = "Successfully Add ".$_REQUEST['mile'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['mile']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm_addcountry.mile.value=="")
	{
		document.getElementById("err_mile").innerHTML="Please Enter Mile";
		document.frm_addcountry.mile.focus();
		return false;
	}
	else
	{
		document.getElementById("err_mile").innerHTML="";
	}
return true;
}
</script>
<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Mile Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_country" id="frm_country" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="11%" align="left" id="cat_trh">SL. No.</td>
			<td width="39%" align="left" id="cat_trh">Miles</td>
			<td width="18%" align="center" id="cat_trh">Status</td>
			<td width="16%" align="center" id="cat_trh" >Edit</td>
			<td width="16%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$items = 25;
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
				
			$sql="select * from ".MANAGE_MILEMANAGER;
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_MILEMANAGER;

			$aux = mysql_fetch_assoc(mysql_query($sqlStrAux));
			$query = mysql_query($sql.$limit);
			
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
					if($row["is_active"] ==1)
					$status = 0;
					else
					$status = 1;
		?>
		<tr class="<?=$id?>">
			<td width="9%" align="left"><?=$row['id']?></td>
			<td width="41%" align="left"><?=$row['mile']?> Mile</td>
			<td width="18%" align="center"><a href="mile_manager.php?mile_id=<?=$row['id']?>&mode=status&status=<?php echo $status;?>&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="16%" align="center"><a href="mile_manager.php?mile_id=<?=$row['id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="16%" align="center"><a href="mile_manager.php?mile_id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
		</tr>
		<?php
					$i++;
				}
		?>
		<tr><td colspan="5" align="center" style="padding-top:10px;"><?php $p->show();?></td></tr>
		<?php
			}
			else
			{
		?>
		<tr><td colspan="5" align="center" style="padding-top:10px;"><b>No Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Mile"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Mile"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_MILEMANAGER." WHERE id='".$_REQUEST['mile_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcountry" id="frm_addcountry" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return validate();">
		<input type="hidden" name="mile_id" id="mile_id" value="<?=$_REQUEST['mile_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="27%" align="left" class="cat_name">Mile</td>
			<td width="73%" align="left"><input type="text" class="text" name="mile" id="mile" value="<?=$row['mile']?>" size="40"/>
			<span id="err_mile"></span>
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

<!-- End of Sidebar -->

</div>
<!-- End of bgwrap -->

<!-- Footer -->
<?php require_once("include/footer.php"); ?>				
<!-- End of Footer -->