<?php 
	require_once("include/top_menu.php"); 
?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST['status'] != "")
{
	$city_id = $_REQUEST['city_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_CITY." where id='".$city_id."'"));
	
	//if($row_status[is_active]==1)
	//{
	$sql = "update ".MANAGE_CITY." set is_active='".$_REQUEST['status']."' where id='".$city_id."'";
	mysql_query($sql);
	//}
	//else
	//{
	//	$sql = "update ".MANAGE_CITY." set is_active=1 where id='".$city_id."'";
	//	mysql_query($sql);
	//}
	$msg = "Successfully Change Status of ".$row_status['city_name'];
	
	$_REQUEST['mode']="";
}
	
	
elseif($_REQUEST['mode']=='delete')
{
	$city_id = $_REQUEST['city_id'];
	$city_name = mysql_fetch_assoc(mysql_query("select city_name from ".MANAGE_CITY." where id=".$city_id));
	$rs_product = mysql_query("select product_id from ".TABLE_PRODUCT." where market_city='".$city_name['city_name']."'");
	if(mysql_num_rows($rs_product) > 0)
	{
		$msg = '<span style="color:#FF0000">You cannot delete this city because this city’s deals are available.</span>';
		$_REQUEST['mode']="";
	}
	else
	{
		$sql = "delete from ".MANAGE_CITY." where id='".$city_id."'";
		$row_status = mysql_fetch_array(mysql_query("select * from ".MANAGE_CITY." where id='".$city_id."'"));
		mysql_query($sql);
		$msg = '<span style="color:#003300">Successfully Delete '.$row_status['city_name'].'</span>';
		$_REQUEST['mode']="";
	}
	
}

elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['city_id']!='')
	{
		mysql_query("update ".MANAGE_CITY." set city_name='".$_REQUEST['city_name']."', country_id='".$_REQUEST['country_name']."' where id='".$_REQUEST['city_id']."'");
		$msg = '<span style="color:#003300">Successfully Edit '.$_REQUEST['city_name'].'</span>';
	}
	else
	{
		//echo "insert into ".MANAGE_CITY." (city_name, country_id) values('".$_REQUEST['city_name']."', '".$_REQUEST['country_name']."')";
		//exit;
		mysql_query("insert into ".MANAGE_CITY." (city_name, country_id) values('".$_REQUEST['city_name']."', '".$_REQUEST['country_name']."')");
		$msg = '<span style="color:#003300">Successfully Add '.$_REQUEST['city_name'].'</span>';
	}
	$_REQUEST['mode']="";
	$_REQUEST['city_name']="";
	$_REQUEST['country_name']="";
}
elseif($_REQUEST['mode']=='update_syn')
{
	$data['city_name']=$_REQUEST['city_name'];
	$data['synonyms_city_name']=$_REQUEST['synonyms_city_name'];
	if($_REQUEST['id']!='')
	{
		$id = $_REQUEST['id'];
		$db->query_update(MANAGE_SYNONYMS_CITY, $data, "id='$id'");
		$msg = '<span style="color:#003300">Successfully Edit '.$_REQUEST['city_name'].'<span>';
	}
	else
	{
		$id=$db->query_insert(MANAGE_SYNONYMS_CITY, $data);
		$msg = '<span style="color:#003300">Successfully Add '.$_REQUEST['city_name'].'</span>';
	}
	$_REQUEST['mode']="view_syn";
}
elseif($_REQUEST['mode']=='status_syn')
{
	$id = $_REQUEST['id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CITY." where id='".$id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_SYNONYMS_CITY." set is_active=0 where id='".$id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_SYNONYMS_CITY." set is_active=1 where id='".$id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['city_name'];
	$_REQUEST['mode']="view_syn";
}
elseif($_REQUEST['mode']=='delete_syn')
{
	$id = $_REQUEST['id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_SYNONYMS_CITY." where id='".$id."'"));
	mysql_query("delete from ".MANAGE_SYNONYMS_CITY." where id='".$id."'");
	$msg = "Successfully Delete ".$row_status['city_name'];
	$_REQUEST['mode']="view_syn";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm_addcity.city_name.value=="")
	{
		document.getElementById("err_cityname").innerHTML="Please Enter City Name";
		document.frm_addcity.city_name.focus();
		return false;
	}
	else
	{
		document.getElementById("err_cityname").innerHTML="";
	}
	if(document.frm_addcity.country_name.value=="")
	{
		document.getElementById("err_countryname").innerHTML="Please Enter Country Name";
		document.frm_addcity.country_name.focus();
		return false;
	}
	else
	{
		document.getElementById("err_countryname").innerHTML="";
	}
return true;
}
</script>
<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To City Manager</h1>
		
		<?php if($msg!=''){?>
				<p style=" text-align:center"><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_city" id="frm_city" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">City Name</td>
			<td width="30%" align="left" id="cat_trh">Country Name</td>
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
				
			$sql="select * from ".MANAGE_CITY." order by city_name";
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_CITY;

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
					
					#Get country name
					
					$result = mysql_query("select country_name from ".MANAGE_COUNTRY." where id='".$row["country_id"]."'");
					while($country = mysql_fetch_array($result))
					{
						$country_name = $country["country_name"];
					}
		?>
		<tr class="<?=$id?>">
			<!--<td width="10%" align="left"><?=$row['id']?></td>-->
			<td width="10%" align="left"><?=$i?></td>
			<td width="24%" align="left"><?=$row['city_name']?></td>
			<td width="30%" align="left"><?=$country_name?></td>
			<td width="15%" align="center"><a href="city_manager.php?city_id=<?=$row['id']?>&mode=status&status=<?php echo $status; ?>&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="11%" align="center"><a href="city_manager.php?city_id=<?=$row['id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="city_manager.php?city_id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this city?")'>Delete</a></td>
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
					$mode = "Edit City"; 
				} 
				elseif($_REQUEST['mode']=='add')
				{ 
					$mode = "Add City"; 
				}
				
				$sql = mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE id='".$_REQUEST['city_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcity" id="frm_addcity" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return validate();">
		<input type="hidden" name="city_id" id="city_id" value="<?=$_REQUEST['city_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="27%" align="left" class="cat_name">City Name</td>
			<td width="73%" align="left"><input type="text" class="text" name="city_name" id="city_name" value="<?=$row['city_name']?>" size="40"/>
			<span id="err_cityname"></span>
			</td>
		</tr>
		<tr>
			<td width="27%" align="left" class="cat_name">Country Name</td>
			<td width="73%" align="left">
				<select name="country_name" id="country_name" class="select">
				<option value="">Select Country</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_COUNTRY." WHERE is_active=1");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['country_id']){?> selected="selected" <?php } ?>><?=$row_cat['country_name']?></option>
				<?php
					}
				?>
				</select>
				<span id="err_countryname"></span>
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
		<?php if($_REQUEST['mode']=='edit_syn'){ $mode = "Edit City Synonyms"; } elseif($_REQUEST['mode']=='add_syn'){ $mode = "Add City Synonyms"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CITY." WHERE id='".$_REQUEST['id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="add_syn" id="add_syn" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_city_syn();">
		<input type="hidden" name="id" id="id" value="<?=$_REQUEST['id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_syn" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="27%" align="left" class="cat_name">City Name</td>
			<td width="73%" align="left">
			<select name="city_name" id="city_name" class="select">
				<option value="">Select City</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_CITY);
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['city_name']?>" <?php if($row_city['city_name']==$row['city_name']){?> selected="selected" <?php } ?>><?=$row_city['city_name']?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="27%" align="left" class="cat_name">Synonyms of City</td>
			<td width="73%" align="left"><input type="text" class="text" name="synonyms_city_name" id="synonyms_city_name" value="<?=$row['synonyms_city_name']?>" size="40"/></td>
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
			<td colspan="6" align="right" class="cat_name">City Name&nbsp;&nbsp;
				<select name="city_select_id" id="city_select_id" class="select" onchange="javascript:return view_syn_city();">
				<option value="">Select City</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_CITY);
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['city_name']?>"><?=$row_city['city_name']?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">City Name</td>
			<td width="28%" align="left" id="cat_trh">Synonyms for City</td>
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
			<td width="28%" align="left"><?=$row['city_name']?></td>
			<td width="28%" align="left"><?=$row['synonyms_city_name']?></td>
			<td width="10%" align="center"><a href="city_manager.php?id=<?=$row['id']?>&mode=status_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="city_manager.php?id=<?=$row['id']?>&mode=edit_syn">Edit</a></td>
			<td width="9%" align="center"><a href="city_manager.php?id=<?=$row['id']?>&mode=delete_syn" onClick='return confirm("Are you sure to delete this Synonyms?")'>Delete</a></td>
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
			<td colspan="6" align="right" class="cat_name">City Name&nbsp;&nbsp;
				<select name="city_select_id" id="city_select_id" class="select" onchange="javascript:return view_syn_city();">
				<option value="">Select City</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_CITY);
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['city_name']?>" <?php if($row_city['city_name']==$_REQUEST['city_select_id']){?> selected="selected" <?php } ?>><?=$row_city['city_name']?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">City Name</td>
			<td width="28%" align="left" id="cat_trh">Synonyms for City</td>
			<td width="10%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_SYNONYMS_CITY." WHERE city_name='".$_REQUEST['city_select_id']."'");
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
			<td width="28%" align="left"><?=$row['city_name']?></td>
			<td width="28%" align="left"><?=$row['synonyms_city_name']?></td>
			<td width="10%" align="center"><a href="city_manager.php?id=<?=$row['id']?>&mode=status_syn"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="city_manager.php?id=<?=$row['id']?>&mode=edit_syn">Edit</a></td>
			<td width="9%" align="center"><a href="city_manager.php?id=<?=$row['id']?>&mode=delete_syn" onClick='return confirm("Are you sure to delete this Synonyms?")'>Delete</a></td>
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