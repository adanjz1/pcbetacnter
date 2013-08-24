<?php
	require_once("include/top_menu.php");
	require_once("include/function_search.php");
	include("include/pagination.php");
	require_once 'functions_image.php';


if($_REQUEST['orderupdating']=='OrderUpdate'){

	foreach($_POST['Updateorder'] as $id=>$value){
		if(!is_numeric($value)){
			$value=0;
		}
		$UpdateOrderQuery=mysql_query("UPDATE ".MANAGE_E_CATEGORY." SET in_order='".$value."' WHERE id='".$id."'");
	}
	echo "<script>location.href='deal_category_manager.php';</script>";
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
	){

		  $time = time();
		  $image=$time.'_'.$_FILES["cat_image"]["name"];
		  $upload_dir='../upload/category/';
		  if($_FILES['cat_image']['name']!=""){
					$file_name=$time."_".$_FILES['cat_image']['name'];
					$tmp_name=$_FILES['cat_image']['tmp_name'];
					$file_size=str_replace(" ","",$_FILES['cat_image']['size']);
					$file_type='image';
					
			move_uploaded_file($tmp_name,$upload_dir.$file_name);
			MakeThumbnailNew($upload_dir,$file_name,'300', '300', $orginal="");
			}
		
	  }
	else{
	  echo "Invalid file";
	  }
	}

	if($_REQUEST['category_id']!=''){
		if($image){
			mysql_query("update ".MANAGE_E_CATEGORY." set category_name='".$_REQUEST['cat_name']."',cat_image='".$image."', keyword='".$_REQUEST['keyword']."', in_order='".$_REQUEST['in_order']."', type='".$_REQUEST['type']."', title='".$_REQUEST['title']."', title_name='".$_REQUEST['title_name']."', title_desc='".$_REQUEST['title_desc']."', meta_tag='".$_REQUEST['meta_tag']."', meta_content='".$_REQUEST['meta_content']."' where id='".$_REQUEST['category_id']."'");
		}else
			mysql_query("update ".MANAGE_E_CATEGORY." set category_name='".$_REQUEST['cat_name']."', keyword='".$_REQUEST['keyword']."', in_order='".$_REQUEST['in_order']."', type='".$_REQUEST['type']."' , title='".$_REQUEST['title']."', title_name='".$_REQUEST['title_name']."', title_desc='".$_REQUEST['title_desc']."', meta_tag='".$_REQUEST['meta_tag']."', meta_content='".$_REQUEST['meta_content']."' where id='".$_REQUEST['category_id']."'");
		$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['cat_name']));
	}
	else{
		mysql_query("insert into ".MANAGE_E_CATEGORY." (category_name,cat_image,keyword,in_order,cate_update,type, title, title_name, title_desc, meta_tag, meta_content) values('".$_REQUEST['cat_name']."','".$image."','".$_REQUEST['keyword']."', '".$_REQUEST['in_order']."', '".date("Y-m-d H:i:s")."', '".$_REQUEST['type']."', '".$_REQUEST['title']."', '".$_REQUEST['title_name']."', '".$_REQUEST['title_desc']."', '".$_REQUEST['meta_tag']."', '".$_REQUEST['meta_content']."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['cat_name']));
	}
	$_REQUEST['mode']="";
	$_REQUEST['cat_name']="";
	$_REQUEST['in_order']="";
	
}
elseif($_REQUEST['mode']=='update_subcat'){
	if($_REQUEST['subcategory_id']!=''){
		
		mysql_query('update '.MANAGE_E_CATEGORY.' set category_name="'.$_REQUEST['subcat_name'].'", cat_id="'.$_REQUEST['cat_name'].'", keyword="'.$_REQUEST['keyword'].'"  where id="'.$_REQUEST['subcategory_id'].'"');
		$msg = "Successfully Edit ".ucwords(str_replace("_"," ",$_REQUEST['subcat_name']));
	}
	else{
		mysql_query("insert into ".MANAGE_E_CATEGORY." (category_name, cat_id, keyword) values('".$_REQUEST['subcat_name']."', '".$_REQUEST['cat_name']."', '".$_REQUEST['keyword']."')");
		$msg = "Successfully Add ".ucwords(str_replace("_"," ",$_REQUEST['subcat_name']));
	}
	$_REQUEST['mode']="view_subcat";
	$_REQUEST['subcat_name']="";
	$_REQUEST['cat_name']="";
	
}
elseif($_REQUEST['mode']=='status_sub' && $_REQUEST["status_sub"] !=""){
	$subcategory_id = $_REQUEST['subcategory_id'];
	$sql = "update ".MANAGE_E_CATEGORY." set is_active='".$_REQUEST["status_sub"]."' where id='".$subcategory_id."'";
	mysql_query($sql);
	$msg = "Successfully Change Status of ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="view_subcat";
	
	
}
elseif($_REQUEST['mode']=='delete_sub'){
	$subcategory_id = $_REQUEST['subcategory_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_E_CATEGORY." where id='".$subcategory_id."'"));
	mysql_query("delete from ".MANAGE_E_CATEGORY." where id='".$subcategory_id."'");
	$msg = "Successfully Delete ".ucwords(str_replace("_"," ",$row_status['category_name']));
	$_REQUEST['mode']="view_subcat";
	
}
?>			
<!-- Background wrapper -->
<div id="bgwrap">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm_addcat.cat_name.value=="")
	{
		document.getElementById("err_catname").innerHTML="Please Enter Deal Source Category Name";
		document.frm_addcat.cat_name.focus();
		return false;
	}
	else
	{
		document.getElementById("err_catname").innerHTML="";
	}
return true;
}
</script>
<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Deal Category Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
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
			<td width="37%" align="center" id="cat_trh">Category Name</td>
         <td width="8%" align="center" id="cat_trh">Type</td>
			<td width="18%" align="center" id="cat_trh">Order Number</td>
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
			 
			$sql="SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id = 0   ".$condition."  ORDER BY in_order  asc";
			 $row_count = getRowCount($sql);
			$sql="SELECT * FROM ".MANAGE_E_CATEGORY." where cat_id = 0  ".$condition." ORDER BY in_order asc ".$GLOBALS[sql_page];
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
            <td width="8%" align="center"><?php
											if($row['type']=='d')
												echo 'Deal';
											else
												echo 'Coupan';
											?>
            </td>
			<td width="18%" align="center"><input type="text" name="Updateorder[<?=$row['id']?>]" id="UpdateOrder[<?=$row['id']?>]" value="<?=$row['in_order']?>" size="2" /></td>
			<td width="13%" align="center"><a href="deal_category_manager.php?category_id=<?=$row['id']?>&mode=status&status=<?php echo $status; ?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="10%" align="center"><a href="deal_category_manager.php?category_id=<?=$row['id']?>&mode=edit">Edit</a></td>
			<td width="11%" align="center"><a href="deal_category_manager.php?category_id=<?=$row['id']?>&mode=delete" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['category_name']))?>?")'>Delete</a></td>
		</tr>
		<?php
					$srl_no=$srl_no+1;
				}
		?>
        
		<tr>
		  <td colspan="7" align="center"><? if($row_count>0) pagination($row_count,"frmPaging"); ?>
		  </td>
		</tr>
		<?php
			}
			else{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><b>No Deal Data Found</b></td></tr>
		<?php
			}
		?>
        
		</table>
        <br />
        <br />
        <table  style="border:1px solid #000;padding:10px 0 10px 0;" width="99%">
        <tr>
		  <td c align="center"><input type="button" name="UpdateOrderButton" id="UpdateOrderButton" value="Update Order" onclick="UpdateOrder();" />
		  </td>
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
			$search_fields = "Category";
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
			<td width="71%" align="left"><input type="text" class="text" name="cat_name" id="cat_name[<?=$_REQUEST['category_id']?>]" value="<?=$row['category_name']?>" size="40"/>
			<span id="err_catname"></span>
			</td>
		</tr>
		
		<tr>
			<td width="29%" align="left" class="cat_name">Category Keywords(',' Seprated)</td>
			<td width="71%" align="left"><input type="text" class="text" name="keyword" id="keyword[<?=$_REQUEST['keyword']?>]" value="<?=$row['keyword']?>" size="40"/>
			</td>
		</tr>
		
		<tr>
			<td width="29%" align="left" class="cat_name">Order Number</td>
			<td width="71%" align="left"><input type="text" class="text" name="in_order" id="in_order" value="<?=$row['in_order']?>" size="10"/>
			<span id="err_inorder"></span>
			</td>
		</tr>
      <tr>
         <td width="29%" align="left" class="cat_name">Category Type</td>
         <td width="71%" align="left"  style="padding-bottom:7px;">
           <select name="type" id="type" >
             <option value="d" <?php if($row['type']=='d') { ?> selected="selected" <?php } ?>>Deals</option>
             <option value="c" <?php if($row['type']=='c') { ?> selected="selected" <?php } ?>>Coupan</option>
           </select>
         </td>
      </tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Title</td>
			<td width="71%" align="left"><input type="text" class="text" name="title" id="title[<?=$_REQUEST['title']?>]" value="<?=$row['title']?>" size="40"/>
			</td>
		</tr>      
      <tr>
			<td width="29%" align="left" class="cat_name">Content Name</td>
			<td width="71%" align="left"><input type="text" class="text" name="title_name" id="title_name[<?=$_REQUEST['title_name']?>]" value="<?=$row['title_name']?>" size="40"/>
			</td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Content Description</td>
			<td width="71%" align="left"><input type="text" class="text" name="title_desc" id="title_desc[<?=$_REQUEST['title_desc']?>]" value="<?=$row['title_desc']?>" size="40"/>
			</td>
		</tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Meta Tag</td>
			<td width="71%" align="left"><input type="text" class="text" name="meta_tag" id="meta_tag[<?=$_REQUEST['meta_tag']?>]" value="<?=$row['meta_tag']?>" size="40"/>
			</td>
		 </tr>
		 <tr>
			<td width="29%" align="left" class="cat_name">Meta Content</td>
			<td width="71%" align="left"><input type="text" class="text" name="meta_content" id="meta_content[<?=$_REQUEST['meta_content']?>]" value="<?=$row['meta_content']?>" size="40"/>
			</td>
		 </tr>
		<tr>
			<td width="29%" align="left" class="cat_name">Category Image</td>
			<td width="71%" align="left"><input type="file" class="text" name="cat_image" size="20"/></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td ><img src="<?=($row['cat_image'])? '../upload/category/thumbnail/thumb_'.$row['cat_image'] : '../images/noImage.jpg'?>" width="80" height="80" alt="No Image" /></td>
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
			<td width="71%" align="left">
				<select name="cat_name" id="cat_name" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." ORDER BY category_name");
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
		<form name="frm_viewsubcat" id="frm_viewsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" value="view_subcat" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td colspan="6" align="right" class="cat_name">Category Name&nbsp;&nbsp;
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat)){
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
			if(mysql_num_rows($sql)>0){
				while($row = mysql_fetch_array($sql)){
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
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$row['cat_id']."'");
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
			else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Sub Category found!</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='view_subcat' && $_REQUEST['cat_select_id']!=''){?>
		<form name="frm_viewsubcat" id="frm_viewsubcat" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" value="view_subcat" />
		<input type="hidden" name="cat_select_id" id="cat_select_id" value="<?=$_REQUEST['cat_select_id']?>" />
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" class="table_cate">
		<tr>
			<td colspan="6" align="right" class="cat_name">Category Name&nbsp;&nbsp;
				<select name="cat_select_id" id="cat_select_id" class="select" onchange="javascript:return view_cat();">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." ORDER BY category_name");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['id']?>" <?php if($row_cat['id']==$_REQUEST['cat_select_id']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
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
			$sql = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE cat_id='".$_REQUEST['cat_select_id']."'");
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
			<td width="28%" align="left"><?=ucwords(str_replace("_"," ",$row['category_name']))?></td>
			<td width="28%" align="left">
			<?php 
				$sql_cat = mysql_query("SELECT * FROM ".MANAGE_E_CATEGORY." WHERE id='".$row['cat_id']."'");
				$row_cat = mysql_fetch_array($sql_cat);
				echo ucwords(str_replace("_"," ",$row_cat['category_name']));
			?>
			</td>
			<td width="10%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['sub_category_id']?>&mode=status_sub"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['sub_category_id']?>&mode=edit_subcat">Edit</a></td>
			<td width="9%" align="center"><a href="deal_category_manager.php?subcategory_id=<?=$row['sub_category_id']?>&mode=delete_sub" onClick='return confirm("Are you sure to delete <?=ucwords(str_replace("_"," ",$row['sub_category_name']))?>?")'>Delete</a></td>
		</tr>
		<?php
				}
			}else{
		?>
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Sub Category found!</b></td></tr>
		<?php } ?>				
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