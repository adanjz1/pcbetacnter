<?php require_once("include/top_menu.php"); 

if($_REQUEST['mode']=='delete')
{
	$id = $_REQUEST['id'];
	//echo $id;
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_TRACKER." where id='".$id."'"));
	mysql_query("delete from ".MANAGE_TRACKER." where id='".$id."'");
	$msg = "Successfully Delete ".$row_status['ipaddress'];
	$_REQUEST['mode']="";
}
?>

<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Requested Informations From User</h1>
		
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
			<td width="39%" align="left" id="cat_trh">IP</td>
			<td width="18%" align="center" id="cat_trh">Deal Name</td>
			<td width="18%" align="center" id="cat_trh">Total Count</td>
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
				
			$sql="select * from ".MANAGE_TRACKER;
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_TRACKER;

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
					
					$sqldealsource = mysql_fetch_array(mysql_query("SELECT * FROM ".TABLE_PRODUCT." WHERE product_id = '".$row['dealid']."'"));
		?>
		<tr class="<?=$id?>">
			<td width="9%" align="left"><?=$row['id']?></td>
			<td width="41%" align="left"><?=$row['ipaddress']?></td>
			<td width="18%" align="center"><?=$sqldealsource['title']?></td>
			<td width="18%" align="center"><?=$row['counter']?></td>
			<?php /*?><td width="16%" align="center"><a href="country_manager.php?country_id=<?=$row['id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td><?php */?>
			<td width="16%" align="center"><a href="clickuser.php?id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
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
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Country"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Country"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_COUNTRY." WHERE id='".$_REQUEST['country_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcountry" id="frm_addcountry" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_country();">
		<input type="hidden" name="country_id" id="country_id" value="<?=$_REQUEST['country_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="27%" align="left" class="cat_name">Country Name</td>
			<td width="73%" align="left"><input type="text" class="text" name="country_name" id="country_name" value="<?=$row['country_name']?>" size="40"/></td>
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

<?php require_once("include/footer.php"); ?>