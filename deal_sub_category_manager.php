<?php
	require_once("include/top_menu.php");
	require_once("include/function_search.php");
	include("include/pagination.php");

if($_REQUEST['orderupdating']=='OrderUpdate'){

	foreach($_POST['Updateorder'] as $id=>$value){
		if(!is_numeric($value)){
			$value=0;
		}
		$UpdateOrderQuery=mysql_query("UPDATE ".MANAGE_E_CATEGORY." SET in_order='".$value."' WHERE id='".$id."'");
	}
	echo "<script>location.href='deal_sub_category_manager.php';</script>";
}
if($_REQUEST['mode']=='status' && $_REQUEST["status"] !=""){
	$category_id = $_REQUEST['category_id'];
	
	mysql_query("update ".MANAGE_E_CATEGORY." set is_active='".$_REQUEST["status"]."' where id='".$category_id."'");
	
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete'){
	$category_id = $_REQUEST['category_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_CATEGORY." where id='".$category_id."'"));
	mysql_query("delete from ".MANAGE_E_CATEGORY." where id='".$category_id."'");
	$msg = "Successfully Delete ".ucwords(str_replace("_"," ",$row_status['category_name']));
	
	$result = mysql_query("select * from ".MANAGE_E_CATEGORY. " where id='".category_id."'");
	while($row = mysql_fetch_array($result)){
		$img = $row["cat_image"];
	}
	if($img != "")
	unlink("../upload/".$row_status['cat_image']);
	
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update_cat'){
	$image="";
		
	if($_FILES["cat_image"]["name"]){
		if ((($_FILES["cat_image"]["type"] == "image/gif")|| ($_FILES["cat_image"]["type"] == "image/jpeg")|| ($_FILES["cat_image"]["type"] == "image/pjpeg")|| ($_FILES["cat_image"]["type"] == "image/jpg")|| ($_FILES["cat_image"]["type"] == "image/png"))
	)
	  {

		  $time = time();
		  $image=$time.'_'.$_FILES["cat_image"]["name"];
		  move_uploaded_file($_FILES["cat_image"]["tmp_name"],"../upload/" .$image );
		
	  }
	else{
	  echo "Invalid file";
	  }
	}
		
	if($_REQUEST['cat_id']!=''){
		$sql_check = "select * from ".MANAGE_E_CATEGORY." where id = '".$_REQUEST['category_id']."'";
		$res_check = mysql_query($sql_check);
		$num_check = mysql_num_rows($res_check);
		$row_check = mysql_fetch_array($res_check);

		if($num_check == 0){			
			if($image != "")
				mysql_query("insert into ".MANAGE_E_CATEGORY." (cat_id,category_name,cat_image,keyword,in_order,cate_update) values('".$_REQUEST['cat_id']. "','" .$_REQUEST['cat_name']."','".$image."','".$_REQUEST['keyword']."', '".$_REQUEST['in_order']."', '".date("Y-m-d H:i:s")."')");
			else
				mysql_query("insert into ".MANAGE_E_CATEGORY." (cat_id,category_name,keyword,in_order,cate_update) values('".$_REQUEST['cat_id']. "','" .$_REQUEST['cat_name']."','".$_REQUEST['keyword']."', '".$_REQUEST['in_order']."', '".date("Y-m-d H:i:s")."')");
			
			$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['cat_name']));
		}
		else{
			if($image != "")
				mysql_query("update ".MANAGE_E_CATEGORY." set cat_id = '".$_REQUEST['cat_id']."',category_name='".$_REQUEST['cat_name']."',cat_image='".$image."',keyword='".$_REQUEST['keyword']."', in_order='".$_REQUEST['in_order']."' where id='".$_REQUEST['category_id']."'");
			else
				mysql_query("update ".MANAGE_E_CATEGORY." set cat_id = '".$_REQUEST['cat_id']."',category_name='".$_REQUEST['cat_name']."',keyword='".$_REQUEST['keyword']."', in_order='".$_REQUEST['in_order']."' where id='".$_REQUEST['category_id']."'");
			
			$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['cat_name']));
		}
	}
	else{
		mysql_query("insert into ".MANAGE_E_CATEGORY." (category_name,cat_image,keyword,in_order,cate_update) values('".$_REQUEST['cat_name']."','".$image."','".$_REQUEST['keyword']."', '".$_REQUEST['in_order']."', '".date("Y-m-d H:i:s")."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['cat_name']));
	}
	$_REQUEST['mode']="";
	$_REQUEST['cat_name']="";
	$_REQUEST['in_order']="";
}

?>
<!-- Background wrapper -->

<div id="bgwrap"> 
  <script language="javascript" type="text/javascript">
function validate(){
	if(document.frm_addcat.cat_id.value==""){
		document.getElementById("err_sub_catname").innerHTML="Please Enter Category Name";
		document.frm_addcat.cat_id.focus();
		return false;
	}
	else{
		document.getElementById("err_sub_catname").innerHTML="";
	}
	if(document.frm_addcat.cat_name.value==""){
		document.getElementById("err_catname").innerHTML="Please Enter Sub-Category Name";
		document.frm_addcat.cat_name.focus();
		return false;
	}
	else{
		document.getElementById("err_catname").innerHTML="";
	}
return true;
}
</script> 
  <!-- Main Content -->
  <div id="content">
    <div id="main">
      <h1>Welcome To Sub-Category Manager</h1>
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
            <td width="11%" align="center" id="cat_trh">SL. No.</td>
            <td width="37%" align="center" id="cat_trh">Sub-Category Name</td>
            <td width="18%" align="center" id="cat_trh">Category Name</td>
            <td width="5%" align="center" id="cat_trh">Order</td>
            <td width="13%" align="center" id="cat_trh">Status</td>
            <td width="10%" align="center" id="cat_trh" >Edit</td>
            <td width="11%" align="center" id="cat_trh">Delete</td>
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
			 $condition = " AND category_name LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['action'] == "alpha") 
			 $condition = " AND category_name like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id != 0   ".$condition."  ORDER BY in_order  asc";
			 $row_count = getRowCount($sql);
			$sql="SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id != 0  ".$condition." ORDER BY in_order asc ".$GLOBALS[sql_page];
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
            <td width="11%" align="center"><?=$i++?></td>
            <td width="37%" align="center"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
            <td width="18%" align="center"><?php 
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$row['cat_id']."'");
					$row_cat = mysql_fetch_array($sql_cat);
					echo ucwords(str_replace("_"," ",$row_cat['category_name']));
				?></td>
            <td width="5%" align="center"><input type="text" name="Updateorder[<?=$row['id']?>]" id="UpdateOrder[<?=$row['id']?>]" value="<?=$row['in_order']?>" size="2" /></td>
            <td width="13%" align="center"><a href="deal_sub_category_manager.php?category_id=<?=$row['id']?>&mode=status&status=<?php echo $status; ?>">
              <?php if($row['is_active']==1){?>
              ON
              <?php } else { ?>
              <font color="#FF0000">OFF</font>
              <?php }?>
              </a></td>
            <td width="10%" align="center"><a href="deal_sub_category_manager.php?category_id=<?=$row['id']?>&mode=edit">Edit</a></td>
            <td width="11%" align="center"><a href="deal_sub_category_manager.php?category_id=<?=$row['id']?>&mode=delete" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['category_name']))?>?")'>Delete</a></td>
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
        <table  style="border:1px solid #000;padding:10px 0 10px 0;" width="99%">
          <tr>
            <td c align="center"><input type="button" name="UpdateOrderButton" id="UpdateOrderButton" value="Update Order" onclick="UpdateOrder();" /></td>
          </tr>
        </table>
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
			$search_fields = "Sub-Category";
			$field_name = "category_name";
			Search($search_fields,$field_name);
		?>
      <?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add_cat'){?>
      <?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Category"; } elseif($_REQUEST['mode']=='add_cat'){ $mode = "Add Category"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$_REQUEST['category_id']."'");
				$row = mysql_fetch_array($sql);			
		?>
      <form name="frm_addcat" id="frm_addcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" onsubmit="return validate();">
        <input type="hidden" name="category_id" id="category_id" value="<?=$_REQUEST['category_id']?>" />
        <input type="hidden" name="mode" id="mode" value="update_cat" />
        <table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
          <tr>
            <td width="29%" align="left" class="cat_name">Category Name</td>
            <td width="71%" align="left"><!--<input type="text" class="text" name="cat_name" id="cat_name" value="<?=$row['category_name']?>" size="40"/>-->
              
              <select name="cat_id" id="cat_id" >
                <option>----Select Category----</option>
                <?php
				  	  $sql_category = "select * from ".MANAGE_E_CATEGORY." where is_active = 1 order by cate_update desc";
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
            <td width="29%" align="left" class="cat_name">Sub-Category Keyword</td>
            <td width="71%" align="left"><input type="text" class="text" name="keyword" id="keyword" value="<?=$row['keyword']?>" size="40"/>
              <span id="err_catname"></span></td>
          </tr>
          
          <tr>
            <td width="29%" align="left" class="cat_name">Order Number</td>
            <td width="71%" align="left"><input type="text" class="text" name="in_order" id="in_order" value="<?=$row['in_order']?>" size="10"/>
              <span id="err_inorder"></span></td>
          </tr>
          <tr>
            <td width="29%" align="left" class="cat_name">Category Image</td>
            <td width="71%" align="left"><input type="file" class="text" name="cat_image" size="20"/></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td ><img src="<?=($row['cat_image'])? '../upload/'.$row['cat_image'] : '../images/noImage.jpg' ?>" width="80" height="80" alt="No Image" /></td>
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
      <form name="frm_addsubcat" id="frm_addsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_subcat();" enctype="multipart/form-data">
        <input type="hidden" name="subcategory_id" id="subcategory_id" value="<?=$_REQUEST['subcategory_id']?>" />
        <input type="hidden" name="mode" id="mode" value="update_subcat" />
        <table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
          <tr>
            <td width="29%" align="left" class="cat_name">Category Name</td>
            <td width="71%" align="left"><select name="cat_name" id="cat_name" class="select">
                <option value="">Select Category</option>
                <?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
                <option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$row['cat_id']){?> selected="selected" <?php } ?>>
                <?=ucwords(str_replace("_"," ",$row_cat['category_name']))?>
                </option>
                <?php
					}
				?>
              </select></td>
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
      <?php }elseif($_REQUEST['mode']=='add_subcat' || $_REQUEST['mode']=='edit_subcat'){?>
      <?php if($_REQUEST['mode']=='add_subcat'){ $mode = "Add SubCategory"; } elseif($_REQUEST['mode']=='edit_subcat'){ $mode = "Edit SubCategory"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$_REQUEST['subcategory_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
      <form name="frm_addsubcat" id="frm_addsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_subcat();">
        <input type="hidden" name="subcategory_id" id="subcategory_id" value="<?=$_REQUEST['subcategory_id']?>" />
        <input type="hidden" name="mode" id="mode" value="update_subcat" />
        <table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
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
            <td>&nbsp;</td>
            <td align="left"><input type="submit" class="button" name="<?=$mode?>" value="<?=$mode?>"/></td>
          </tr>
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
<script>
function UpdateOrder(){
	document.frm_viewcat.orderupdating.value='OrderUpdate';
	document.frm_viewcat.submit();
	
}
</script>