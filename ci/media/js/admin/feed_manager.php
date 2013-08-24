<?php 
	require_once("include/top_menu.php"); 
?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST['status'] != "")
{
	$feed_id = $_REQUEST['feed_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_FEED." where id='".$feed_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	$sql = "update ".MANAGE_FEED." set is_active='".$_REQUEST['status']."' where feed_id='".$feed_id."'";
	mysql_query($sql);
	//}
	//else
	//{
	//	$sql = "update ".MANAGE_FEED." set is_active=1 where id='".$feed_id."'";
	//	mysql_query($sql);
	//}
	$_SESSION['msg'] = "Successfully Change Status of ".$row_status['feed_site'];
	
	$_REQUEST['mode']="";
}
	
	
elseif($_REQUEST['mode']=='delete')
{
	$feed_id = $_REQUEST['feed_id'];
	$sql = "delete from ".MANAGE_FEED." where feed_id='".$feed_id."'";
	$row_status = mysql_fetch_array(mysql_query("select * from ".MANAGE_FEED." where feed_id='".$feed_id."'"));
	mysql_query($sql);
	$_SESSION['msg'] = "Successfully Delete ".$row_status['feed_site'];
	$_REQUEST['mode']="";
	header('location:feed_manager.php');
	exit;
}

elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['feed_id']!='')
	{
		mysql_query("update ".MANAGE_FEED." set feed_site='".$_REQUEST['feed_site']."', feed_url='".$_REQUEST['feed_url']."' where feed_id='".$_REQUEST['feed_id']."'");
		$_SESSION['msg'] = "Successfully Edit ".$_REQUEST['feed_site'];
	}
	else
	{
		//echo "insert into ".MANAGE_FEED." (feed_site, country_id) values('".$_REQUEST['feed_site']."', '".$_REQUEST['feed_url']."')";
		//exit;
		mysql_query("insert into ".MANAGE_FEED." (feed_site, feed_url) values('".$_REQUEST['feed_site']."', '".$_REQUEST['feed_url']."')");
		$_SESSION['msg'] = "Successfully Add ".$_REQUEST['feed_site'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['feed_site']="";
	$_REQUEST['feed_url']="";
	header('location:feed_manager.php');
	exit;
}
elseif($_REQUEST['mode']=='update_syn')
{
	$data['feed_site']=$_REQUEST['feed_site'];
	$data['synonyms_feed_site']=$_REQUEST['synonyms_feed_site'];
	if($_REQUEST['feed_id']!='')
	{
		$feed_id = $_REQUEST['feed_id'];
		$db->query_update(MANAGE_SYNONYMS_CITY, $data, "feed_id='$feed_id'");
		$_SESSION['msg'] = "Successfully Edit ".$_REQUEST['feed_site'];
	}
	else
	{
		$feed_id=$db->query_insert(MANAGE_SYNONYMS_CITY, $data);
		$_SESSION['msg'] = "Successfully Add ".$_REQUEST['feed_site'];
	}
	$_REQUEST['mode']="view_syn";
	header('location:feed_manager.php');
	exit;
}
elseif($_REQUEST['mode']=='status_syn')
{
	$feed_id = $_REQUEST['feed_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CITY." where feed_id='".$feed_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_SYNONYMS_CITY." set is_active=0 where feed_id='".$feed_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_SYNONYMS_CITY." set is_active=1 where feed_id='".$feed_id."'");
	}
	$_SESSION['msg'] = "Successfully Change Status of ".$row_status['feed_site'];
	$_REQUEST['mode']="view_syn";
	header('location:feed_manager.php');
	exit;
}
elseif($_REQUEST['mode']=='delete_syn')
{
	$feed_id = $_REQUEST['feed_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CITY." where feed_id='".$feed_id."'"));
	mysql_query("delete from ".MANAGE_SYNONYMS_CITY." where feed_id='".$feed_id."'");
	$_SESSION['msg'] = "Successfully Delete ".$row_status['feed_site'];
	$_REQUEST['mode']="view_syn";
	header('location:feed_manager.php');
	exit;
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm_addfeed.feed_site.value=="")
	{
		document.getElementById("err_feedname").innerHTML="Please Enter Feed Name";
		document.frm_addfeed.feed_site.focus();
		return false;
	}
	else
	{
		document.getElementById("err_feedname").innerHTML="";
	}
	if(document.frm_addfeed.feed_url.value=="")
	{
		document.getElementById("err_feedurl").innerHTML="Please Enter Feed Url";
		document.frm_addfeed.feed_url.focus();
		return false;
	}
	else
	{
		document.getElementById("err_feedurl").innerHTML="";
	}
return true;
}
</script>
<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Feed Manager</h1>
		
		<?php if($_SESSION['msg']!=''){?>
				<p><?=$_SESSION['msg']?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_feed" id="frm_feed" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">Feed Site Name</td>
			<td width="30%" align="left" id="cat_trh">Feed URL</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="11%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
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
				
			$sql="select * from ".MANAGE_FEED;
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_FEED;

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
					
					#Status	
					if($row["is_active"] == 1)
					$status = 0;
					else
					$status = 1;
					
					
					
		?>
		<tr class="<?=$id?>">
			<!--<td width="10%" align="left"><?=$row['feed_id']?></td>-->
			<td width="10%" align="left"><?=$i?></td>
			<td width="24%" align="left"><?=$row['feed_site']?></td>
			<td width="30%" align="left"><?=$row['feed_url']?></td>
			<td width="15%" align="center"><a href="feed_manager.php?feed_id=<?=$row['feed_id']?>&mode=status&status=<?php echo $status; ?>&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="11%" align="center"><a href="feed_manager.php?feed_id=<?=$row['feed_id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="feed_manager.php?feed_id=<?=$row['feed_id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Feed?")'>Delete</a></td>
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
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }
			elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add')
			{
				if($_REQUEST['mode']=='edit')
				{ 
					$mode = "Update Feed"; 
				} 
				elseif($_REQUEST['mode']=='add')
				{ 
					$mode = "Add Feed"; 
				}
				
				$sql = mysql_query("SELECT * FROM ".MANAGE_FEED." WHERE feed_id='".$_REQUEST['feed_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addfeed" id="frm_addfeed" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return validate();">
		<input type="hidden" name="feed_id" id="feed_id" value="<?=$_REQUEST['feed_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="27%" align="left" class="cat_name">Feed Name</td>
			<td width="73%" align="left">
			<select name="feed_site" id="feed_site" class="select">
				<option value="">Select</option>
				<option value="DealTicker.com" <?php if($row['feed_site']=='DealTicker.com'){echo 'selected';}?>>DealTicker.com</option>
				<option value="Moolala.com" <?php if($row['feed_site']=='Moolala.com'){echo 'selected';}?>>Moolala.com</option>
				<option value="Crowdsavings.com" <?php if($row['feed_site']=='Crowdsavings.com'){echo 'selected';}?> >Crowdsavings.com</option>
				<option value="Screamindailydeals.com" <?php if($row['feed_site']=='Screamindailydeals.com'){echo 'selected';}?>>Screamindailydeals.com</option>
				<option value="MyDailyDeals.com" <?php if($row['feed_site']=='MyDailyDeals.com'){echo 'selected';}?>>MyDailyDeals.com</option>
				<option value="Icoupononline.com" <?php if($row['feed_site']=='Icoupononline.com'){echo 'selected';}?>>Icoupononline.com</option>
				<option value="Tippr.com" <?php if($row['feed_site']=='Tippr.com'){echo 'selected';}?>>Tippr.com</option>
				<option value="DealFind.com" <?php if($row['feed_site']=='DealFind.com'){echo 'selected';}?>>DealFind.com</option>
				<option value="Dealster.com" <?php if($row['feed_site']=='Dealster.com'){echo 'selected';}?>>Dealster.com</option>
				<option value="KGBDeals.com" <?php if($row['feed_site']=='KGBDeals.com'){echo 'selected';}?>>KGBDeals.com</option>
				<option value="Juiceinthecity.com" <?php if($row['feed_site']=='Juiceinthecity.com'){echo 'selected';}?>>Juiceinthecity.com</option>
				<option value="Signpost.com" <?php if($row['feed_site']=='Signpost.com'){echo 'selected';}?>>Signpost.com</option>
				<option value="Yourbestdeals.com" <?php if($row['feed_site']=='Yourbestdeals.com'){echo 'selected';}?>>Yourbestdeals.com</option>
				<option value="Bloomspot.com" <?php if($row['feed_site']=='Bloomspot.com'){echo 'selected';}?> >Bloomspot.com</option>
				<option value="Scoutmob.com" <?php if($row['feed_site']=='Scoutmob.com'){echo 'selected';}?>>Scoutmob.com</option>
				<option value="Eversave.com" <?php if($row['feed_site']=='Eversave.com'){echo 'selected';}?>>Eversave.com</option>
				<option value="Offers.cbslocal.com" <?php if($row['feed_site']=='Offers.cbslocal.com'){echo 'selected';}?>>Offers.cbslocal.com</option>
				<option value="Townhog.com" <?php if($row['feed_site']=='Townhog.com'){echo 'selected';}?>>Townhog.com</option>
				<option value="Godailydeals.com" <?php if($row['feed_site']=='Godailydeals.com'){echo 'selected';}?>>Godailydeals.com</option>
				<option value="Ragingdailydeals.com" <?php if($row['feed_site']=='Ragingdailydeals.com'){echo 'selected';}?>>Ragingdailydeals.com</option>
				<option value="Everybodybuys.com" <?php if($row['feed_site']=='Everybodybuys.com'){echo 'selected';}?>>Everybodybuys.com</option>
				<option value="Groupon.com" <?php if($row['feed_site']=='Groupon.com'){echo 'selected';}?>>Groupon.com</option>
				<option value="Feedburner.com" <?php if($row['feed_site']=='Feedburner.com'){echo 'selected';}?>>Feedburner.com</option>
			</select>
			<span id="err_feedname"></span>
			</td>
		</tr>
		<tr>
			<td width="27%" align="left" class="cat_name">Feed URL</td>
			<td width="73%" align="left">
				<input type="text" class="text" name="feed_url" id="feed_url" value="<?=$row['feed_url']?>" size="80">
				
				<span id="err_feedurl"></span>
				</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }
		
		elseif($_REQUEST['mode']=='add_syn' || $_REQUEST['mode']=='edit_syn'){?>
		<?php if($_REQUEST['mode']=='edit_syn'){ $mode = "Edit Feed Synonyms"; } elseif($_REQUEST['mode']=='add_syn'){ $mode = "Add Feed Synonyms"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CITY." WHERE feed_id='".$_REQUEST['feed_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="add_syn" id="add_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_city_syn();">
		<input type="hidden" name="id" id="id" value="<?=$_REQUEST['feed_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_syn" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="27%" align="left" class="cat_name">Feed Name</td>
			<td width="73%" align="left">
			<select name="feed_site" id="feed_site" class="select">
				<option value="">Select Feed</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_FEED);
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['feed_site']?>" <?php if($row_city['feed_site']==$row['feed_site']){?> selected="selected" <?php } ?>><?=$row_city['feed_site']?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="27%" align="left" class="cat_name">Synonyms of Feed</td>
			<td width="73%" align="left"><input type="text" class="text" name="synonyms_feed_site" id="synonyms_feed_site" value="<?=$row['synonyms_feed_site']?>" size="40"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_syn' && $_REQUEST['city_select_id']==''){?>
		<form name="view_syn" id="view_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_syn" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td colspan="6" align="right" class="cat_name">Feed Name&nbsp;&nbsp;
				<select name="city_select_id" id="city_select_id" class="select" onchange="javascript:return view_syn_city();">
				<option value="">Select Feed</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_FEED);
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['feed_site']?>"><?=$row_city['feed_site']?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">Feed Name</td>
			<td width="28%" align="left" id="cat_trh">Synonyms for Feed</td>
			<td width="10%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CITY);
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i++?></td>
			<td width="28%" align="left"><?=$row['feed_site']?></td>
			<td width="28%" align="left"><?=$row['synonyms_feed_site']?></td>
			<td width="10%" align="center"><a href="feed_manager.php?feed_id=<?=$row['feed_id']?>&mode=status_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="feed_manager.php?feed_id=<?=$row['feed_id']?>&mode=edit_syn">Edit</a></td>
			<td width="9%" align="center"><a href="feed_manager.php?feed_id=<?=$row['feed_id']?>&mode=delete_syn" onClick='return confirm("Are you sure to delete this Synonyms?")'>Delete</a></td>
		</tr>
		<?php
				}
			}else{
		?>
		<tr><td align="center" colspan="6" style="padding-top:10px;"><b>No Record Found</b></td></tr>
		<?php } ?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_syn' && $_REQUEST['city_select_id']!=''){?>
		<form name="view_syn" id="view_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="mode" id="mode" value="view_syn" />
		<input type="hidden" name="city_select_id" id="city_select_id" value="<?=$_REQUEST['city_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td colspan="6" align="right" class="cat_name">Feed Name&nbsp;&nbsp;
				<select name="city_select_id" id="city_select_id" class="select" onchange="javascript:return view_syn_city();">
				<option value="">Select Feed</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_FEED);
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['feed_site']?>" <?php if($row_city['feed_site']==$_REQUEST['city_select_id']){?> selected="selected" <?php } ?>><?=$row_city['feed_site']?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">Feed Name</td>
			<td width="28%" align="left" id="cat_trh">Synonyms for Feed</td>
			<td width="10%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CITY." WHERE feed_site='".$_REQUEST['city_select_id']."'");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i++?></td>
			<td width="28%" align="left"><?=$row['feed_site']?></td>
			<td width="28%" align="left"><?=$row['synonyms_feed_site']?></td>
			<td width="10%" align="center"><a href="feed_manager.php?id=<?=$row['feed_id']?>&mode=status_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="feed_manager.php?id=<?=$row['feed_id']?>&mode=edit_syn">Edit</a></td>
			<td width="9%" align="center"><a href="feed_manager.php?id=<?=$row['feed_id']?>&mode=delete_syn" onClick='return confirm("Are you sure to delete this Synonyms?")'>Delete</a></td>
		</tr>
		<?php
				}
			}else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Record found!</b></td></tr>
		<?php } ?>				
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