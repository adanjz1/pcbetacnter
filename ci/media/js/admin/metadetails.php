<?php require_once("include/top_menu.php"); ?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST["status"]!="")
{
	$meta_id = $_REQUEST['meta_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_METADETAILS_SETTING." where country_id='".$country_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	mysql_query("update ".MANAGE_METADETAILS_SETTING." set is_active='".$_REQUEST["status"]."' where id='".$meta_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".MANAGE_METADETAILS_SETTING." set is_active=1 where country_id='".$country_id."'");
	//}
	$msg = "Successfully Change Status of ".$row_status['meta_index_keywords'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$meta_id = $_REQUEST['meta_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_METADETAILS_SETTING." where id='".$meta_id."'"));
	mysql_query("delete from ".MANAGE_METADETAILS_SETTING." where id='".$meta_id."'");
	$msg = "Successfully Delete ".$row_status['meta_index_keywords'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['meta_id']!='')
	{
		mysql_query("update ".MANAGE_METADETAILS_SETTING." set meta_index_keywords='".$_REQUEST['meta_index_keywords']."',meta_index_description='".$_REQUEST[meta_index_description]."',meta_index_title='".$_REQUEST[meta_index_title]."',meta_getpreference_keywords='".$_REQUEST[meta_getpreference_keywords]."',meta_getpreference_description='".$_REQUEST[meta_getpreference_description]."',meta_getpreference_title='".$_REQUEST[meta_getpreference_title]."',meta_welcome_keywords='".$_REQUEST[meta_welcome_keywords]."',meta_welcome_description='".$_REQUEST[meta_welcome_description]."',meta_welcome_title='".$_REQUEST[meta_welcome_title]."',meta_finish_keywords='".$_REQUEST['meta_finish_keywords']."',meta_finish_description='".$_REQUEST['meta_finish_description']."',meta_finish_title='".$_REQUEST['meta_finish_title']."',meta_invite_keywords='".$_REQUEST['meta_invite_keywords']."',meta_invite_description='".$_REQUEST['meta_invite_description']."',meta_invite_title='".$_REQUEST['meta_invite_title']."',meta_deals_keywords='".$_REQUEST['meta_deals_keywords']."',meta_deals_description='".$_REQUEST['meta_deals_description']."',meta_deals_title='".$_REQUEST['meta_deals_title']."',meta_expired_keywords='".$_REQUEST['meta_expired_keywords']."',meta_expired_description='".$_REQUEST['meta_expired_description']."',meta_expired_title='".$_REQUEST['meta_expired_title']."',meta_myaccount_keywords='".$_REQUEST['meta_myaccount_keywords']."',meta_myaccount_description='".$_REQUEST['meta_myaccount_description']."',meta_myaccount_title='".$_REQUEST['meta_myaccount_title']."',meta_cities_keywords='".$_REQUEST['meta_cities_keywords']."',meta_cities_description='".$_REQUEST['meta_cities_description']."',meta_cities_title='".$_REQUEST['meta_cities_title']."',meta_login_keywords='".$_REQUEST['meta_login_keywords']."',meta_login_description='".$_REQUEST['meta_login_description']."',meta_login_title='".$_REQUEST['meta_login_title']."',meta_forgotpassword_keywords='".$_REQUEST['meta_forgotpassword_keywords']."',meta_forgotpassword_description='".$_REQUEST['meta_forgotpassword_description']."',meta_forgotpassword_title='".$_REQUEST['meta_forgotpassword_title']."',meta_staticpage_keywords='".$_REQUEST['meta_staticpage_keywords']."',meta_staticpage_description='".$_REQUEST['meta_staticpage_description']."',meta_staticpage_title='".$_REQUEST['meta_staticpage_title']."',meta_verifypasswordmail_keywords='".$_REQUEST['meta_verifypasswordmail_keywords']."',meta_verifypasswordmail_description='".$_REQUEST['meta_verifypasswordmail_description']."',meta_verifypasswordmail_title='".$_REQUEST['meta_verifypasswordmail_title']."',meta_alldeals_keywords='".$_REQUEST['meta_alldeals_keywords']."',meta_alldeals_description='".$_REQUEST['meta_alldeals_description']."',meta_alldeals_title='".$_REQUEST['meta_alldeals_title']."',meta_deal_keywords='".$_REQUEST['meta_deal_keywords']."',meta_deal_description='".$_REQUEST['meta_deal_description']."',meta_deal_title='".$_REQUEST['meta_deal_title']."',meta_categorydeals_keywords='".$_REQUEST['meta_categorydeals_keywords']."',meta_categorydeals_description='".$_REQUEST['meta_categorydeals_description']."',meta_categorydeals_title='".$_REQUEST['meta_categorydeals_title']."' where id='1'");
		$msg = "Successfully Edit ".$_REQUEST['meta_index_keywords'];
		header("location:metadetails.php?meta_id=1&mode=edit");
	}
	else
	{
		mysql_query("insert into ".MANAGE_METADETAILS_SETTING." (meta_index_keywords,site_title,character_set,meta_keyword,meta_description,webmaster_email,support_email,site_noreply_name,site_noreply_email) values('".$_REQUEST['meta_index_keywords']."','".$_REQUEST[site_title]."','".$_REQUEST[character_set]."','".$_REQUEST[meta_keyword]."','".$_REQUEST[meta_description]."','".$_REQUEST[webmaster_email]."','".$_REQUEST[support_email]."','".$_REQUEST[site_noreply_name]."','".$_REQUEST[site_noreply_email]."')");
		$msg = "Successfully Add ".$_REQUEST['meta_index_keywords'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['meta_index_keywords']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Meta Details File Editing  </h1>
		
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
				
			$sql="select * from ".MANAGE_METADETAILS_SETTING;
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_METADETAILS_SETTING;

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
			<td width="41%" align="left"><?=$row['meta_index_keywords']?></td>
			<td width="18%" align="center"><a href="general.php?meta_id=<?=$row['id']?>&mode=status&status=<?php echo $status;?>&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="16%" align="center"><a href="general.php?meta_id=<?=$row['id']?>&mode=edit">Edit</a></td>
			<td width="16%" align="center"><a href="general.php?meta_id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
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
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Meta"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Meta"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_METADETAILS_SETTING." WHERE id='".$_REQUEST['meta_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcountry" id="frm_addcountry" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="javascript:return add_edit_country();">
		<input type="hidden" name="meta_id" id="meta_id" value="<?=$_REQUEST['meta_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_index_keywords</td>
			<td width="73%" align="left"><textarea name="meta_index_keywords" class="text"><?=$row['meta_index_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_index_description</td>
			<td width="73%" align="left"><textarea name="meta_index_description" class="text"><?=$row['meta_index_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_index_title</td>
			<td width="73%" align="left"><textarea name="meta_index_title" class="text"><?=$row['meta_index_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_getpreference_keywords</td>
			<td width="73%" align="left"><textarea name="meta_getpreference_keywords" class="text"><?=$row['meta_getpreference_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_getpreference_description</td>
			<td width="73%" align="left"><textarea name="meta_getpreference_description" class="text"><?=$row['meta_getpreference_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_getpreference_title</td>
			<td width="73%" align="left"><textarea name="meta_getpreference_title" class="text"><?=$row['meta_getpreference_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_welcome_keywords</td>
			<td width="73%" align="left"><textarea name="meta_welcome_keywords" class="text"><?=$row['meta_welcome_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_welcome_description</td>
			<td width="73%" align="left"><textarea name="meta_welcome_description" class="text"><?=$row['meta_welcome_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_welcome_title</td>
			<td width="73%" align="left"><textarea name="meta_welcome_title" class="text"><?=$row['meta_welcome_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_finish_keywords</td>
			<td width="73%" align="left"><textarea name="meta_finish_keywords" class="text"><?=$row['meta_finish_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_finish_description</td>
			<td width="73%" align="left"><textarea name="meta_finish_description" class="text"><?=$row['meta_finish_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_finish_title</td>
			<td width="73%" align="left"><textarea name="meta_finish_title" class="text"><?=$row['meta_finish_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_invite_keywords</td>
			<td width="73%" align="left"><textarea name="meta_invite_keywords" class="text"><?=$row['meta_invite_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_invite_description</td>
			<td width="73%" align="left"><textarea name="meta_invite_description" class="text"><?=$row['meta_invite_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_invite_title</td>
			<td width="73%" align="left"><textarea name="meta_invite_title" class="text"><?=$row['meta_invite_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_deals_keywords</td>
			<td width="73%" align="left"><textarea name="meta_deals_keywords" class="text"><?=$row['meta_deals_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_deals_description</td>
			<td width="73%" align="left"><textarea name="meta_deals_description" class="text"><?=$row['meta_deals_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_deals_title</td>
			<td width="73%" align="left"><textarea name="meta_deals_title" class="text"><?=$row['meta_deals_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_expired_keywords</td>
			<td width="73%" align="left"><textarea name="meta_expired_keywords" class="text"><?=$row['meta_expired_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_expired_description</td>
			<td width="73%" align="left"><textarea name="meta_expired_description" class="text"><?=$row['meta_expired_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_expired_title</td>
			<td width="73%" align="left"><textarea name="meta_expired_title" class="text"><?=$row['meta_expired_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_myaccount_keywords</td>
			<td width="73%" align="left"><textarea name="meta_myaccount_keywords" class="text"><?=$row['meta_myaccount_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_myaccount_description</td>
			<td width="73%" align="left"><textarea name="meta_myaccount_description" class="text"><?=$row['meta_myaccount_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_myaccount_title</td>
			<td width="73%" align="left"><textarea name="meta_myaccount_title" class="text"><?=$row['meta_myaccount_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_cities_keywords</td>
			<td width="73%" align="left"><textarea name="meta_cities_keywords" class="text"><?=$row['meta_cities_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_cities_description</td>
			<td width="73%" align="left"><textarea name="meta_cities_description" class="text"><?=$row['meta_cities_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_cities_title</td>
			<td width="73%" align="left"><textarea name="meta_cities_title" class="text"><?=$row['meta_cities_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_login_keywords</td>
			<td width="73%" align="left"><textarea name="meta_login_keywords" class="text"><?=$row['meta_login_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_login_description</td>
			<td width="73%" align="left"><textarea name="meta_login_description" class="text"><?=$row['meta_login_description']?></textarea></td>
		</tr>
		
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_login_title</td>
			<td width="73%" align="left"><textarea name="meta_login_title" class="text"><?=$row['meta_login_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_forgotpassword_keywords</td>
			<td width="73%" align="left"><textarea name="meta_forgotpassword_keywords" class="text"><?=$row['meta_forgotpassword_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_forgotpassword_description</td>
			<td width="73%" align="left"><textarea name="meta_forgotpassword_description" class="text"><?=$row['meta_forgotpassword_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_forgotpassword_title</td>
			<td width="73%" align="left"><textarea name="meta_forgotpassword_title" class="text"><?=$row['meta_forgotpassword_title']?></textarea></td>
		</tr>
		
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_staticpage_keyword</td>
			<td width="73%" align="left"><textarea name="meta_staticpage_keyword" class="text"><?=$row['meta_staticpage_keyword']?></textarea></td>
		</tr>
		
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_staticpage_description</td>
			<td width="73%" align="left"><textarea name="meta_staticpage_description" class="text"><?=$row['meta_staticpage_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_staticpage_title</td>
			<td width="73%" align="left"><textarea name="meta_staticpage_title" class="text"><?=$row['meta_staticpage_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_verifypasswordmail_keywords</td>
			<td width="73%" align="left"><textarea name="meta_verifypasswordmail_keywords" class="text"><?=$row['meta_verifypasswordmail_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_verifypasswordmail_description</td>
			<td width="73%" align="left"><textarea name="meta_verifypasswordmail_description" class="text"><?=$row['meta_verifypasswordmail_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_verifypasswordmail_title</td>
			<td width="73%" align="left"><textarea name="meta_verifypasswordmail_title" class="text"><?=$row['meta_verifypasswordmail_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_alldeals_keywords</td>
			<td width="73%" align="left"><textarea name="meta_alldeals_keywords" class="text"><?=$row['meta_alldeals_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_alldeals_description</td>
			<td width="73%" align="left"><textarea name="meta_alldeals_description" class="text"><?=$row['meta_alldeals_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_alldeals_title</td>
			<td width="73%" align="left"><textarea name="meta_alldeals_title" class="text"><?=$row['meta_alldeals_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_deal_keywords</td>
			<td width="73%" align="left"><textarea name="meta_deal_keywords" class="text"><?=$row['meta_deal_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_deal_description</td>
			<td width="73%" align="left"><textarea name="meta_deal_description" class="text"><?=$row['meta_deal_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_deal_title</td>
			<td width="73%" align="left"><textarea name="meta_deal_title" class="text"><?=$row['meta_deal_title']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_categorydeals_keywords</td>
			<td width="73%" align="left"><textarea name="meta_categorydeals_keywords" class="text"><?=$row['meta_categorydeals_keywords']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_categorydeals_description</td>
			<td width="73%" align="left"><textarea name="meta_categorydeals_description" class="text"><?=$row['meta_categorydeals_description']?></textarea></td>
		</tr>
		
		<tr>
			<td width="27%" align="left" class="cat_name">meta_categorydeals_title</td>
			<td width="73%" align="left"><textarea name="meta_categorydeals_title" class="text"><?=$row['meta_categorydeals_title']?></textarea></td>
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