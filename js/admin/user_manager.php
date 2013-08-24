<?php 
	require_once("include/top_menu.php");
	require_once("include/function_search.php");
	include("include/pagination.php");
?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST["status"] !="")
{
	$user_id = $_REQUEST['user_id'];
	//$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_MAIN_CATEGORY." where id='".$category_id."'"));
	
	//if($row_status['is_active']==1)
	//{
	mysql_query("update ".MANAGE_USER." set is_active='".$_REQUEST["status"]."' where user_id='".$user_id."'");
	//}
	//else
	//{
	//	mysql_query("update ".MANAGE_E_MAIN_CATEGORY." set is_active=1 where id='".$category_id."'");
	//}
	$msg = "Successfully Change Status of ".$row_status['user_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$user_id = $_REQUEST['user_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_USER." where user_id='".$user_id."'"));
	mysql_query("delete from ".MANAGE_USER." where user_id='".$user_id."'");
	$msg = "Successfully Delete ".$row_status['user_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	if($_REQUEST['user_id']!='')
	{
		/*echo "update ".MANAGE_USER." set user_pass='".$_REQUEST['user_pass']."', user_email='".$_REQUEST['user_email']."', city='".$_REQUEST['city']."' where user_id='".$_REQUEST['user_id']."'";
		exit;*/
		mysql_query("update ".MANAGE_USER." set user_pass='".$_REQUEST['user_pass']."', user_email='".$_REQUEST['user_email']."', city='".$_REQUEST['city']."' where user_id='".$_REQUEST['user_id']."'");
		$msg = "Successfully Edit ".$_REQUEST['user_name'];
	}
	else
	{
		$name = explode(' ', $_REQUEST['user_name']);
		$firstname = $name[0];
		$lastname = '';
		for($i=1 ; $i<count($name); $i++){
			$lastname .=  $name[$i].' ';
		}
		mysql_query("insert into ".MANAGE_USER." (user_firstname ,user_lastname, user_pass, user_email, city) values('".$firstname."', '".$lastname."', '".$_REQUEST['user_pass']."', '".$_REQUEST['user_email']."', '".$_REQUEST['city']."')");
		$msg = "Successfully Add ".$_REQUEST['user_name'];
	}
	$_REQUEST['mode']="";
}
?>		
  <!-- Main Content -->
  <div id="content">
    <div id="main">
      <h1>Welcome To User Manager</h1>
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
    <form name="frm_user" id="frm_user" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
        <table width="99%" align="center" border="0" class="border" cellpadding="5" cellspacing="1">
          <tr class="TDHEAD">
         	<td width="10%" align="center" id="cat_trh">SL. No.</td>
			<td width="26%" align="center" id="cat_trh">Name</td>
			<td width="30%" align="center" id="cat_trh">User Email</td>
			<td width="14%" align="center" id="cat_trh">Status</td>
			<td width="10%" align="center" id="cat_trh" >Edit</td>
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
			 $condition = " AND user_firstname LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['action'] == "alpha") 
			 $condition = " AND user_firstname like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="SELECT * FROM ".MANAGE_USER." WHERE 1   ".$condition."  ORDER BY user_firstname  asc";
			 $row_count = getRowCount($sql);
			$sql="SELECT * FROM ".MANAGE_USER." WHERE 1  ".$condition." ORDER BY user_firstname asc ".$GLOBALS[sql_page];
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
			<td width="10%" align="center"><?=$i++?></td>
			<td width="26%" align="center"><?=$row['user_firstname']?> <?=$row['user_lastname']?></td>
			<td width="30%" align="center"><?=$row['user_email']?></td>
			<td width="14%" align="center"><a href="user_manager.php?user_id=<?=$row['user_id']?>&mode=status&status=<?php echo $status;?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="10%" align="center"><a href="user_manager.php?user_id=<?=$row['user_id']?>&mode=edit">Edit</a></td>
			<td width="10%" align="center"><a href="user_manager.php?user_id=<?=$row['user_id']?>&mode=delete" onClick='return confirm("Are you sure to delete this User?")'>Delete</a></td>
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
			$search_fields = "Name";
			$field_name = "user_lastname";
			Search($search_fields,$field_name);
		?>
      <?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit User"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add User"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_USER." WHERE user_id='".$_REQUEST['user_id']."'");
				$row = mysql_fetch_array($sql);
		?>
		<form name="frm_adduser" id="frm_adduser" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_user();">
		<input type="hidden" name="user_id" id="user_id" value="<?=$_REQUEST['user_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="32%" align="left" class="cat_name">Full Name</td>
			<td width="68%" align="left" style="line-height: 30px;">
				<?php if($_REQUEST['mode']=='add'){?>
					<input type="text" class="text" name="user_name" id="user_name" value="<?=$row['user_firstname']?>  <?=$row['user_lastname']?>" size="40"/>
				<?php }elseif($_REQUEST['mode']=='edit'){?>
					<?=$row['user_firstname']?> <?=$row['user_lastname']?>			
				<?php }?>
			</td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Password</td>
			<td width="68%" align="left"><input type="password" class="text" name="user_pass" id="user_pass" value="<?=$row['user_pass']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Confirm Password</td>
			<td width="68%" align="left"><input type="password" class="text" name="user_pass_conf" id="user_pass_conf" value="<?=$row['user_pass']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Email</td>
			<td width="68%" align="left"><input type="text" class="text" name="user_email" id="user_email" value="<?=$row['user_email']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">City</td>
			<td width="68%" align="left">
				<select name="city" id="city" class="select">
				<option value="">Select City</option>
				<?php
					$sql_city = mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE is_active=1");
					while($row_city = mysql_fetch_array($sql_city))
					{
				?>
				<option value="<?=$row_city['id']?>" <?php if($row_city['id']==$row['city']){?> selected="selected" <?php } ?>><?=ucwords($row_city['city_name'])?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<?php /*?>
				<tr>
			<td width="32%" align="left" class="cat_name">Deal Category</td>
			<td width="68%" align="left">
				<select name="deal_cate" id="deal_cate" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY."");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['categories']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
				<tr>
					<td width="32%" align="left" class="cat_name">Site Name</td>
					<td width="68%" align="left"><input type="text" class="text" name="site_name" id="site_name" value="<?=$row['site_name']?>" size="40"/></td>
				</tr>
		<?php */?>
		
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php } ?>
    </div>
  </div>
  <!-- End of Main Content --> 
  <!-- Sidebar -->
  <?php require_once("include/left_menu.php"); ?>
</div>
<?php require_once("include/footer.php"); ?>
<!-- End of Footer --> 
