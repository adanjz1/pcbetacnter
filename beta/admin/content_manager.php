<?php 
	require_once("include/top_menu.php");
	require_once("include/function_search.php");
	include("include/pagination.php");
?> 
<?php
if($_REQUEST['mode']=='status')
{
	$content_id = $_REQUEST['content_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_CONTENT." where content_id='".$content_id."'"));
	
	if($row_status[is_active]==1)
	{
		mysql_query("update ".MANAGE_CONTENT." set is_active=0 where content_id='".$content_id."'");
	}
	else
	{
		mysql_query("update ".MANAGE_CONTENT." set is_active=1 where content_id='".$content_id."'");
	}
	$msg = "Successfully Change Status of ".$row_status['content_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='delete')
{
	$content_id = $_REQUEST['content_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_CONTENT." where content_id='".$content_id."'"));
	mysql_query("delete from ".MANAGE_CONTENT." where content_id='".$content_id."'");
	
	$msg = "Successfully Delete ".$row_status['content_name'];
	$_REQUEST['mode']="";
}
elseif($_REQUEST['mode']=='update')
{
	
	$data['title']=$_REQUEST['title'];
	$data['meta_tag']=$_REQUEST['meta_tag'];
	$data['meta_content']=str_replace("%5C%22","",$_REQUEST['meta_content']);
	$data['content_name']=$_REQUEST['content_name'];
	$data['content_desc']=str_replace("%5C%22","",$_REQUEST['content_desc']);
	$data['uptodate']=date("Y-m-d");
		
	if($_REQUEST['content_id']!='')
	{
		$content_id = $_REQUEST['content_id'];
		$db->query_update(MANAGE_CONTENT, $data, "content_id='$content_id'");
		$msg = "Successfully Edit ".$_REQUEST['content_name'];
	}
	else
	{
		$content_id=$db->query_insert(MANAGE_CONTENT, $data);
		$data_1['content_id']=$content_id;		
		$msg = "Successfully Add ".$_REQUEST['content_name'];
	}
	$_REQUEST['mode']="";
	$_REQUEST['title']="";
	$_REQUEST['meta_tag']="";
	$_REQUEST['meta_content']="";
	$_REQUEST['content_name']="";
	$_REQUEST['content_desc']="";
}
?>		
  <!-- Main Content -->
  <div id="content">
    <div id="main">
      <h1>Welcome To Content Manager</h1>
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
			<td width="24%" align="center" id="cat_trh">Content Name</td>
			<td width="30%" align="center" id="cat_trh">Content Description</td>
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
			 $condition = " AND content_name LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['action'] == "alpha") 
			 $condition = " AND content_name like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="SELECT * FROM ".MANAGE_CONTENT." where 1   ".$condition."  ORDER BY content_id  asc";
			 $row_count = getRowCount($sql);
			$sql="SELECT * FROM ".MANAGE_CONTENT." where 1  ".$condition." ORDER BY content_id asc ".$GLOBALS[sql_page];
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
			<td width="10%" align="center"><?=$srl_no?></td>
			<td width="24%" align="center"><?=$row['content_name']?></td>
			<td width="30%" align="center"><?=substr($row['content_desc'],0,100)?></td>
			<td width="15%" align="center"><a href="content_manager.php?content_id=<?=$row['content_id']?>&mode=status&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="11%" align="center"><a href="content_manager.php?content_id=<?=$row['content_id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="content_manager.php?content_id=<?=$row['content_id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Content?")'>Delete</a></td>
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
			$search_fields = "Content name";
			$field_name = "content_name";
			Search($search_fields,$field_name);
		?>
      <?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit Content"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add Content"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_CONTENT." WHERE content_id='".$_REQUEST['content_id']."'");
				$row = mysql_fetch_array($sql);
			
		?>
		<form name="frm_addcontent" id="frm_addcontent" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_content();">
		<input type="hidden" name="content_id" id="content_id" value="<?=$_REQUEST['content_id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="5" align="left" width="100%">
		<tr>
			<td width="23%" align="left" class="cat_name">Title</td>
			<td width="77%" align="left"><input type="text" class="text" name="title" id="title" value="<?=$row['title']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Content Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="content_name" id="content_name" value="<?=$row['content_name']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Meta Keyword</td>
			<td width="77%" align="left"><input type="text" class="text" name="meta_tag" id="meta_tag" value="<?=$row['meta_tag']?>" size="60"/></td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Meta Description</td>
			<td width="77%" align="left">
			<?php
				/*$sw = new SPAW_Wysiwyg('content_desc',$row['content_desc']);
				$sw->show();*/
				$mFCKeditor = new FCKeditor('meta_content');
				$mFCKeditor->BasePath = '../fckeditor/';
				$mFCKeditor->Value = stripslashes($row['meta_content']) ;
				$mFCKeditor->Width = '100%' ;
				$mFCKeditor->Height = '500' ;
				$mFCKeditor->ToolbarSet = 'Default';
				$mFCKeditor->Create();
			?>
			</td>
		</tr>
		<tr>
			<td width="23%" align="left" class="cat_name">Content Description</td>
			<td width="77%" align="left">
			<?php
				/*$sw = new SPAW_Wysiwyg('content_desc',$row['content_desc']);
				$sw->show();*/
				$oFCKeditor = new FCKeditor('content_desc');
				$oFCKeditor->BasePath = '../fckeditor/';
				$oFCKeditor->Value = stripslashes($row['content_desc']) ;
				$oFCKeditor->Width = '100%' ;
				$oFCKeditor->Height = '500' ;
				$oFCKeditor->ToolbarSet = 'Default';
				$oFCKeditor->Create();
			?>
			</td>
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
</div>
<?php require_once("include/footer.php"); ?>
<!-- End of Footer --> 
