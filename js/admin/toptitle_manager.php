<?php 
	require_once("include/top_menu.php");
	require_once("include/function_search.php");
	include("include/pagination.php");
?> 
<?php
if($_REQUEST['mode']=='status')
{
	$id= $_REQUEST['id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TOP_TITLE." where id='".$id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".TOP_TITLE." set is_active=0 where id='".$id."'");
	}
	else
	{
		mysql_query("update ".TOP_TITLE." set is_active=1 where id='".$id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['title_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$id= $_REQUEST['id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".TOP_TITLE." where id='".$id."'"));
	mysql_query("delete from ".TOP_TITLE." where id='".$id."'");
	
	$msg = "Successfully Delete ".$row_status['title_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	
	/*$data['title']=$_REQUEST['title'];*/
	$data['title_name']=$_REQUEST['title_name'];
	$data['title_desc']=$_REQUEST['title_desc'];
		
	if($_REQUEST['id']!='')
	{
		$id= $_REQUEST['id'];
		$db->query_update(TOP_TITLE, $data, "id='$id'");
		$msg = "Successfully Edit ".$_REQUEST['title_name'];
	}
	else
	{
		$id=$db->query_insert(TOP_TITLE, $data);
		$data_1['id']=$id;		
		$msg = "Successfully Add ".$_REQUEST['title_name'];
	}
	$_REQUEST['mode']="";
	/*$_REQUEST['title']="";*/
	$_REQUEST['title_name']="";
	$_REQUEST['title_desc']="";
}
?>			
  <!-- Main Content -->
  <div id="content">
    <div id="main">
      <h1>Welcome To Top Title Manager</h1>
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
     <form name="frm_deal" id="frm_deal" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
        <table width="99%" align="center" border="0" class="border" cellpadding="5" cellspacing="1">
          <tr class="TDHEAD">
         	<td width="10%" align="center" id="cat_trh">SL. No.</td>
			<td width="24%" align="center" id="cat_trh">Title Name</td>
			<td width="20%" align="center" id="cat_trh">Title Description</td>
            <td width="10%" align="center" id="cat_trh">Page Name</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="11%" align="center" id="cat_trh" >Edit</td>
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
			 $condition = " AND page_name LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['action'] == "alpha") 
			 $condition = " AND page_name like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="SELECT * FROM ".TOP_TITLE." where 1   ".$condition."  ORDER BY id  asc";
			 $row_count = getRowCount($sql);
			$sql="SELECT * FROM ".TOP_TITLE." where 1  ".$condition." ORDER BY id asc ".$GLOBALS[sql_page];
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
			<td width="10%" align="center"><?=$i?></td>
			<td width="24%" align="center"><?=$row['title_name']?></td>
			<td width="20%" align="center"><?=substr($row['title_desc'],0,100)?></td>
            <td width="10%" align="center"><?=$row['page_name']?></td>
			<td width="15%" align="center"><a href="toptitle_manager.php?id=<?=$row['id']?>&mode=status&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="11%" align="center"><a href="toptitle_manager.php?id=<?=$row['id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="toptitle_manager.php?id=<?=$row['id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Content?")'>Delete</a></td>
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
            <td colspan="7" align="center" style="padding-top:10px;"><b>No Data Found</b></td>
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
			$search_fields = "Page Name";
			$field_name = "page_name";
			Search($search_fields,$field_name);
		?>
      <?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Content"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Content"; }
				$sql = mysql_query("SELECT * FROM ".TOP_TITLE." WHERE id='".$_REQUEST['id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcontent" id="frm_addcontent" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_content();">
		<input type="hidden" name="id" id="id" value="<?=$_REQUEST['id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="5" align="left" width="100%">
		<tr>
			<td width="23%" align="left" class="cat_name">Page Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="page_name" id="page_name" value="<?=$row['page_name']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Content Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="title_name" id="title_name" value="<?=$row['title_name']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Content Description</td>
			<td width="77%" align="left"><input type="text" class="text" name="title_desc" id="title_desc" value="<?=$row['title_desc']?>" size="60"/></td>
		</tr>
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
		
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->

<!-- End of Main Content -->

<!-- Sidebar -->

<?php require_once("include/left_menu.php"); ?>				

<!-- End of Sidebar -->

</div>
<!-- End of bgwrap -->

<!-- Footer -->
<?php require_once("include/footer.php"); ?>				
<!-- End of Footer -->