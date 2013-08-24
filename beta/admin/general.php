<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST["status"]!="")
{
	$general_id = $_REQUEST['general_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_GENERAL_SETTING." where country_id='".$country_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	mysql_query("update ".MANAGE_GENERAL_SETTING." set is_active='".$_REQUEST["status"]."' where id='".$general_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".MANAGE_GENERAL_SETTING." set is_active=1 where country_id='".$country_id."'");
	//}
	$msg = "Successfully Change Status of ".$row_status['sitename'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$general_id = $_REQUEST['general_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_GENERAL_SETTING." where id='".$general_id."'"));
	mysql_query("delete from ".MANAGE_GENERAL_SETTING." where id='".$general_id."'");
	$msg = "Successfully Delete ".$row_status['sitename'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['general_id']!='')
	{
		mysql_query("update ".MANAGE_GENERAL_SETTING." set sitename='".$_REQUEST['sitename']."',site_title='".$_REQUEST[site_title]."',character_set='".$_REQUEST[character_set]."',meta_keyword='".$_REQUEST[meta_keyword]."',meta_description='".$_REQUEST[meta_description]."',webmaster_email='".$_REQUEST[webmaster_email]."',support_email='".$_REQUEST[support_email]."',site_noreply_name='".$_REQUEST[site_noreply_name]."',site_noreply_email='".$_REQUEST[site_noreply_email]."' where id='1'");
		$msg = "Successfully Edit ".$_REQUEST['sitename'];
		header("location:general.php?general_id=1&mode=edit");
	}
	else
	{
		mysql_query("insert into ".MANAGE_GENERAL_SETTING." (sitename,site_title,character_set,meta_keyword,meta_description,webmaster_email,support_email,site_noreply_name,site_noreply_email) values('".$_REQUEST['sitename']."','".$_REQUEST[site_title]."','".$_REQUEST[character_set]."','".$_REQUEST[meta_keyword]."','".$_REQUEST[meta_description]."','".$_REQUEST[webmaster_email]."','".$_REQUEST[support_email]."','".$_REQUEST[site_noreply_name]."','".$_REQUEST[site_noreply_email]."')");
		$msg = "Successfully Add ".$_REQUEST['sitename'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['sitename']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Edit General Config Data </h1>
		
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
			<td width="39%" align="left" id="cat_trh">Site Name</td>
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
				
			$sql="select * from ".MANAGE_GENERAL_SETTING;
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_GENERAL_SETTING;

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
			<td width="41%" align="left"><?=$row['sitename']?></td>
			<td width="18%" align="center"><a href="general.php?general_id=<?=$row['id']?>&mode=status&status=<?php echo $status;?>&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="16%" align="center"><a href="general.php?general_id=<?=$row['id']?>&mode=edit">Edit</a></td>
			<td width="16%" align="center"><a href="general.php?general_id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
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
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit General"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add General"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_GENERAL_SETTING." WHERE id='".$_REQUEST['general_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcountry" id="frm_addcountry" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="javascript:return add_edit_country();">
		<input type="hidden" name="general_id" id="country_id" value="<?=$_REQUEST['general_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		
		<tr>
			<td width="27%" align="left" class="cat_name">Name of Your Site </td>
			<td width="73%" align="left"><input type="text" class="text" name="sitename" id="sitename" value="<?=$row['sitename']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Site Title</td>
			<td width="73%" align="left"><input type="text" class="text" name="site_title" id="site_title" value="<?=$row['site_title']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Character Set Used</td>
			<td width="73%" align="left"><input type="text" class="text" name="character_set" id="character_set" value="<?=$row['character_set']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Meta Keyword</td>
			<td width="73%" align="left"><input type="text" class="text" name="meta_keyword" id="meta_keyword" value="<?=$row['meta_keyword']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Meta Description</td>
			<td width="73%" align="left"><input type="text" class="text" name="meta_description" id="meta_description" value="<?=$row['meta_description']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Webmaster Email</td>
			<td width="73%" align="left"><input type="text" class="text" name="webmaster_email" id="webmaster_email" value="<?=$row['webmaster_email']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Support Email</td>
			<td width="73%" align="left"><input type="text" class="text" name="support_email" id="support_email" value="<?=$row['support_email']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Site No Reply Name for Email</td>
			<td width="73%" align="left"><input type="text" class="text" name="site_noreply_name" id="site_noreply_name" value="<?=$row['site_noreply_name']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">Site No Reply Email</td>
			<td width="73%" align="left"><input type="text" class="text" name="site_noreply_email" id="site_noreply_email" value="<?=$row['site_noreply_email']?>" size="40"/></td>
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