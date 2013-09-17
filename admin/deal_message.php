<?php require_once("include/top_menu.php"); ?>
<?php
echo $_REQUEST['deal_user'];
if($_REQUEST['mode']=='status')
{
	$city_id = $_REQUEST['city_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_CITY." where city_id='".$city_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_CITY." set is_active=0 where city_id='".$city_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_CITY." set is_active=1 where city_id='".$city_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['city_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$city_id = $_REQUEST['city_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_CITY." where city_id='".$city_id."'"));
	mysql_query("delete from ".MANAGE_CITY." where city_id='".$city_id."'");
	$msg = "Successfully Delete ".$row_status['city_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['city_id']!='')
	{
		mysql_query("update ".MANAGE_CITY." set city_name='".$_REQUEST['city_name']."', country_name='".$_REQUEST['country_name']."' where city_id='".$_REQUEST['city_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['city_name'];
	}
	else
	{
		mysql_query("insert into ".MANAGE_CITY." (city_name, country_name) values('".$_REQUEST['city_name']."', '".$_REQUEST['country_name']."')");
		$msg = "Successfully Add ".$_REQUEST['city_name'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['city_name']="";
	$_REQUEST['country_name']="";
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Deal Message Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm" id="frm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<input type="hidden" name="mode" id="mode" value="view_user" />
		<input type="hidden" name="cat_select_id" id="cat_select_id" value="<?=$_REQUEST['cat_select_id']?>" />
		<input type="hidden" name="city_select_id" id="city_select_id" value="<?=$_REQUEST['city_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td colspan="3" align="right" class="cat_name">Category Name
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat_deal();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0 AND status=1");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['cat_id']?>"><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
			<td colspan="3" align="right" class="cat_name">City Name
				<select name="city_select_id" id="city_select_id" class="select" onchange="javascript:return view_city_deal();">
				<option value="">Select City</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE is_active=1");
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['city_id']?>"><?=ucwords(str_replace("_"," ",$row_city['city_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_user'){?>
		<?php 
			$where = "WHERE 1=1 ";
			if($_REQUEST['cat_select_id']!='')
				$where .="AND deal_cate='".$_REQUEST['cat_select_id']."' ";
			if($_REQUEST['city_select_id']!='')
				$where .="AND city='".$_REQUEST['city_select_id']."'";
			$i = 1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_USER." ".$where);
			$num = mysql_num_rows($sql);
		?>
		<form name="frm" id="frm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<input type="hidden" name="mode" id="mode" value="<?=$_REQUEST['mode']?>" />
		<input type="hidden" name="cat_select_id" id="cat_select_id" value="<?=$_REQUEST['cat_select_id']?>" />
		<input type="hidden" name="city_select_id" id="city_select_id" value="<?=$_REQUEST['city_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td colspan="3" align="right" class="cat_name">Category Name
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat_deal();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0 AND status=1");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['cat_id']?>" <?php if($row_cat['cat_id']==$_REQUEST['cat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
			<td width="44%" colspan="3" align="right" class="cat_name">City Name
				<select name="city_select_id" id="city_select_id" class="select" onchange="javascript:return view_city_deal();">
				<option value="">Select City</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE is_active=1");
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['city_id']?>" <?php if($row_city['city_id']==$_REQUEST['city_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_city['city_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="21%" align="left" id="cat_trh"><input type="checkbox" id="all_check" name="al_check" value="<?=$num?>">&nbsp;&nbsp;Check All</td>
			<td colspan="2" align="left" id="cat_trh">User Name</td>
			<td colspan="3" align="left" id="cat_trh">User Email</td>
		</tr>
		<?php 

			if(mysql_num_rows($sql)>0)
			{
				$str = "";
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
					$str .=$row['user_id'].",";
		?>
		<tr class="<?=$id?>">
			<td width="21%" align="left"><input type="checkbox" id="check_<?=$row['user_id']?>" name="check_<?=$row['user_id']?>" value="<?=$row['user_id']?>"></td>
			<td colspan="2" align="left"><?=$row['user_name']?></td>
			<td colspan="3" align="left"><?=$row['user_email']?></td>
		</tr>
		<?php	$i++; }
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><input type="submit" class="button" name="send_deal_message" value="Send Deal Message" onclick="javascript:return send_deal();"/></td></tr>
		<?php
			}else{
		?>
		<tr><td colspan="6" align="center"><b>No Record Found!</b></td></tr>
		<?php } ?>
		</table>
		<input type="hidden" name="no_user" id="no_user" value="<?=substr($str,0,-1)?>" />
		<input type="hidden" name="deal_user" id="deal_user" value="" />
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