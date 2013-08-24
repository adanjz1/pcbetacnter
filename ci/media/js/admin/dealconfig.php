<?php
require_once("include/top_menu.php"); 
include("functions_image.php");
require_once("include/function_search.php");
include("include/pagination.php");
?>
<?php
if($_REQUEST['mode']=='status' && $_REQUEST["status"] !="")
{
	$deal_id = $_REQUEST['deal_id'];
	
	mysql_query("update ".MANAGE_DEAL_SOURCE." set is_active='".$_REQUEST["status"]."' where deal_source_id='".$deal_id."'");
	
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['deal_source_name']));
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$deal_id = $_REQUEST['deal_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_DEAL_SOURCE." where deal_source_id='".$deal_id."'"));
	mysql_query("delete from ".MANAGE_DEAL_SOURCE." where deal_source_id='".$deal_id."'");
	$msg = "Successfully Delete ".ucwords(str_replace("_"," ",$row_status['deal_source_name']));
	//echo $row_status['deal_source_logo_url'];
	$result = mysql_query("select * from ".MANAGE_DEAL_SOURCE. " where deal_source_id='".deal_id."'");
	while($row = mysql_fetch_array($result))
	{
		$img = $row["deal_source_logo_url"];
	}
	if($img != "")
	unlink("../upload/".$row_status['deal_source_logo_url']);
	
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update_deal')
{
	$image="";
	if($_FILES["deal_source_logo_url"]["name"])
	{
		if ((($_FILES["deal_source_logo_url"]["type"] == "image/gif")|| ($_FILES["deal_source_logo_url"]["type"] == "image/jpeg")|| ($_FILES["deal_source_logo_url"]["type"] == "image/pjpeg")|| ($_FILES["deal_source_logo_url"]["type"] == "image/jpg")|| ($_FILES["deal_source_logo_url"]["type"] == "image/png"))
	)
	  {

		  $time = time();
		  $image=$time.'_'.$_FILES["deal_source_logo_url"]["name"];
		  //move_uploaded_file($_FILES["deal_source_logo_url"]["tmp_name"],"../upload/" .$image );
		  
		  $upload_dir='../upload/brand/';
		  $upload_dir_next='../upload/brand_next/';
		  if($_FILES['deal_source_logo_url']['name']!="")
		   {
					$file_name=$time."_".$_FILES['deal_source_logo_url']['name'];
					$tmp_name=$_FILES['deal_source_logo_url']['tmp_name'];
					$file_size=str_replace(" ","",$_FILES['deal_source_logo_url']['size']);
					$file_type='image';
					
			move_uploaded_file($tmp_name,$upload_dir.$file_name);
			MakeThumbnailNew($upload_dir,$file_name,'86', '60', $orginal="");
			copy($upload_dir.$file_name,$upload_dir_next.$file_name);
			MakeThumbnailNew($upload_dir_next,$file_name,'102', '42', $orginal="");
			}
		
	  }
	else
	  {
	  echo "Invalid file";
	  }
	}
	if($_REQUEST['deal_id']!='')
	{
		if($image!='')
		{
			mysql_query("update ".MANAGE_DEAL_SOURCE." set deal_source_name='".$_REQUEST['deal_source_name']."',deal_source_url='".$_REQUEST['deal_source_url']."', deal_source_logo_url='".$image."' where deal_source_id='".$_REQUEST['deal_id']."'");
		}
		else
			mysql_query("update ".MANAGE_DEAL_SOURCE." set deal_source_name='".$_REQUEST['deal_source_name']."', deal_source_url='".$_REQUEST['deal_source_url']."' where deal_source_id='".$_REQUEST['deal_id']."'");
		$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['deal_source_name']));
	}
	else
	{
		mysql_query("insert into ".MANAGE_DEAL_SOURCE." (deal_source_name,deal_source_url, deal_source_logo_url, deal_source_date) values('".$_REQUEST['deal_source_name']."','".$_REQUEST['deal_source_url']."', '".$image."', '".date("Y-m-d H:i:s")."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['deal_source_name']));
	}
	$_REQUEST['mode']="";
	$_REQUEST['deal_source_name']="";
	$_REQUEST['deal_source_logo_url']="";
}

?>	
  <!-- Main Content -->
  <div id="content">
    <div id="main">
      <h1>Deal Source</h1>
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
      <form name="frm_viewcat" id="frm_viewcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="orderupdating"  value="<? echo $_REQUEST['orderupdating']; ?>" />
        <table width="99%" align="center" border="0" class="border" cellpadding="5" cellspacing="1">
          <tr class="TDHEAD">
            <td width="13%" align="left" id="cat_trh">SL. No.</td>
			<td width="10%" align="left" id="cat_trh">Deal Source Name</td>
			<td width="21%" align="left" id="cat_trh">Deal Image</td>
			<td width="14%" align="left" id="cat_trh">Deal Source </td>
			<td width="21%" align="center" id="cat_trh">Status</td>
			<td width="12%" align="center" id="cat_trh" >Edit</td>
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
			 $condition = " AND deal_source_name LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['action'] == "alpha") 
			 $condition = " AND deal_source_name like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="SELECT * FROM ".MANAGE_DEAL_SOURCE."  WHERE 1 ".$condition."  ORDER BY deal_source_id  asc";
			 $row_count = getRowCount($sql);
			$sql="SELECT * FROM ".MANAGE_DEAL_SOURCE." WHERE 1  ".$condition." ORDER BY deal_source_id asc ".$GLOBALS[sql_page];
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
			<td width="13%" align="center"><?=$i++?></td>
			<td width="10%" align="center"><?=ucwords(str_replace("_"," ",$row['deal_source_name']))?></td>
			<td width="19%" align="center"><img src="<?=($row['deal_source_logo_url'])? SITE_URL.'upload/brand/thumbnail/thumb_'.$row['deal_source_logo_url'] : "../images/noImage.jpg"?>" height="40" width="40" alt="" /></td>
			<td width="14%" align="center"><?=$row['deal_source_url']?></td>
			<td width="21%" align="center"><a href="dealconfig.php?deal_id=<?=$row['deal_source_id']?>&mode=status&status=<?php echo $status; ?>"><?php if($row['is_active']==1){?>Active<?php } else { ?><font color="#FF0000">Inactive</font><?php }?></a></td>
			<td width="12%" align="center"><a href="dealconfig.php?deal_id=<?=$row['deal_source_id']?>&mode=edit">Edit</a></td>
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
            <td colspan="7" align="center" style="padding-top:10px;"><b>No Deal Data Found</b></td>
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
			$search_fields = "Deal source name";
			$field_name = "deal_source_name";
			Search($search_fields,$field_name);
		?>
      <?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add_deal'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Deal"; } elseif($_REQUEST['mode']=='add_deal'){ $mode = "Add Deal"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_DEAL_SOURCE." WHERE deal_source_id='".$_REQUEST['deal_id']."'");
				$row = mysql_fetch_array($sql);			
		?>
		<form name="frm_addbanner" id="frm_addbanner" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" onSubmit="javascript:return add_edit_deal();">
		<input type="hidden" name="deal_id" id="deal_id" value="<?=$_REQUEST['deal_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_deal" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Deal SourceName</td>
			<td width="71%" align="left"><input type="text" class="text" name="deal_source_name" id="deal_source_name" value="<?=$row['deal_source_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Deal Source URL </td>
			<td width="71%" align="left"><input type="text" class="text" name="deal_source_url" id="deal_source_url" value="<?=$row['deal_source_url']?>" size="40"/></td>
		</tr>
		
		<tr>
			<td width="29%" align="left" class="cat_name">Deal Source Logo Image</td>
			<td width="71%" align="left"><input type="file" class="text" name="deal_source_logo_url" size="20"/></td>
		</tr>
		<?php /*?><tr>
			<td width="29%" align="left" class="cat_name">Deal Source Logo URL </td>
			<td width="71%" align="left"><input type="text" class="text" name="deal_source_logo_url" id="deal_source_logo_url" value="<?=$row['deal_source_logo_url']?>" size="40"/></td>
		</tr><?php */?>
		<tr>
		<td>&nbsp;</td>
		<td ><img src="<?=($row['deal_source_logo_url'])? SITE_URL.'upload/brand/thumbnail/thumb_'.$row['deal_source_logo_url'] : "../images/noImage.jpg"?>" width="50" height="50" alt="No Image" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='add_subcat' || $_REQUEST['mode']=='edit_subcat'){?>
		<?php if($_REQUEST['mode']=='add_subcat'){ $mode = "Add SubCategory"; } elseif($_REQUEST['mode']=='edit_subcat'){ $mode = "Edit SubCategory"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$_REQUEST['subcategory_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addsubcat" id="frm_addsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="javascript:return add_edit_subcat();" enctype="multipart/form-data">
		<input type="hidden" name="subcategory_id" id="subcategory_id" value="<?=$_REQUEST['subcategory_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update_subcat" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="29%" align="left" class="cat_name">Banner Name</td>
			<td width="71%" align="left">
				<select name="cat_name" id="cat_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_DEAL_SOURCE." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['cat_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Sub Category Name</td>
			<td width="71%" align="left"><input type="text" class="text" name="subcat_name" id="subcat_name" value="<?=$row['category_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat' && $_REQUEST['cat_select_id']==''){?>
		<form name="frm_viewsubcat" id="frm_viewsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="mode" id="mode" value="view_subcat" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td colspan="6" align="right" class="cat_name">Category Name&nbsp;&nbsp;
				<select name="cat_select_id" id="cat_select_id" class="select" onChange="javascript:return view_cat();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_DEAL_SOURCE." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['cat_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="28%" align="left" id="cat_trh">SubCategory Name</td>
			<td width="28%" align="left" id="cat_trh">Category Name</td>
			<td width="10%" align="center" id="cat_trh">Status</td>
			<td width="9%" align="center" id="cat_trh" >Edit</td>
			<td width="9%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." ORDER BY category_name");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
					if($row["is_active"] == 1)
					$status = 0;
					else
					$status = 1;
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i++?></td>
			<td width="28%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
			<td width="28%" align="left">
			<?php 
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_DEAL_SOURCE." WHERE id='".$row['cat_id']."'");
				$row_cat = mysql_fetch_array($sql_cat);
				echo ucwords(str_replace("_"," ",$row_cat['category_name']));
			?>
			</td>
			<td width="10%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['id']?>&mode=status_sub&status_sub=<?php echo $status;?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['id']?>&mode=edit_subcat">Edit</a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['id']?>&mode=delete_sub" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['category_name']))?>?")'>Delete</a></td>
		</tr>
		<?php
				}
			}
			else
			{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Sub Category found!</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat' && $_REQUEST['cat_select_id']==''){?>
      <form name="frm_viewsubcat" id="frm_viewsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
        <input type="hidden" name="mode" id="mode" value="view_subcat" />
        <table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
          <tr>
            <td width="29%" align="left" class="cat_name">Category Name</td>
            <td width="71%" align="left"><!--<input type="text" class="text" name="cat_name" id="cat_name" value="<?=$row['category_name']?>" size="40"/>-->
              
              <select name="cat_id" id="cat_id" >
                <option>----Select Category----</option>
                <?php
				  	  $sql_category = "select * from ".MANAGE_E_MAIN_CATEGORY." where is_active = 1 order by cate_update desc";
					  $res_category = mysql_query($sql_category);
					  while($row_category  = mysql_fetch_array($res_category))
					  {
				  ?>
                <option value="<?php echo $row_category['id'];?>"<?php if($row_category['id'] == $row['cat_id']) echo "Selected";?>><?php echo $row_category['category_name'];?></option>
                <?php
				  	  }
				  ?>
              </select>
              <span id="err_sub_catname"></span></td>
          </tr>
          <tr>
            <td width="29%" align="left" class="cat_name">Sub-Category Name</td>
            <td width="71%" align="left"><input type="text" class="text" name="cat_name" id="cat_name" value="<?=$row['category_name']?>" size="40"/>
              <span id="err_catname"></span></td>
          </tr>
          <tr>
            <td width="10%" align="left" id="cat_trh">SL. No.</td>
            <td width="28%" align="left" id="cat_trh">Category Name</td>
            <td width="28%" align="left" id="cat_trh">SubCategory Name</td>
            <td width="10%" align="center" id="cat_trh">Status</td>
            <td width="9%" align="center" id="cat_trh" >Edit</td>
            <td width="9%" align="center" id="cat_trh">Delete</td>
          </tr>
          <?php
			$i=1;
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." ORDER BY category_name");
			if(mysql_num_rows($sql)>0)
			{
				while($row = mysql_fetch_array($sql))
				{
					if($i%2)
						$id = "cat_tr1";
					else
						$id = "cat_tr2";
					if($row["is_active"] == 1)
					$status = 0;
					else
					$status = 1;
		?>
          <tr class="<?=$id?>">
            <td width="10%" align="left"><?=$i++?></td>
            <td width="28%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
            <td width="28%" align="left"><?php 
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$row['cat_id']."'");
				$row_cat = mysql_fetch_array($sql_cat);
				echo ucwords(str_replace("_"," ",$row_cat['category_name']));
			?></td>
            <td width="10%" align="center"><a href="deal_sub_category_manager.php?subcategory_id=<?=$row['id']?>&mode=status_sub&status_sub=<?php echo $status;?>">
              <?php if($row['is_active']==1){?>
              ON
              <?php } else { ?>
              <font color="#FF0000">OFF</font>
              <?php }?>
              </a></td>
            <td width="9%" align="center"><a href="deal_sub_category_manager.php?subcategory_id=<?=$row['id']?>&mode=edit_subcat">Edit</a></td>
            <td width="9%" align="center"><a href="deal_sub_category_manager.php?subcategory_id=<?=$row['id']?>&mode=delete_sub" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['category_name']))?>?")'>Delete</a></td>
          </tr>
          <?php
				}
			}
			else
			{
		?>
          <tr>
            <td colspan="6" align="center" style="padding-top:10px;"><b>No Sub Category found!</b></td>
          </tr>
          <?php
			}
		?>
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
