<?php require_once("include/top_menu.php"); ?>
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
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To Content Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_deal" id="frm_deal" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">SL. No.</td>
			<td width="24%" align="left" id="cat_trh">Content Name</td>
			<td width="30%" align="left" id="cat_trh">Content Description</td>
			<td width="15%" align="center" id="cat_trh">Status</td>
			<td width="11%" align="center" id="cat_trh" >Edit</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$items = 10;
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
				
			$sql="select * from ".MANAGE_CONTENT." ORDER BY content_name";
			$sqlStrAux = "SELECT count(*) as total FROM ".MANAGE_CONTENT." ORDER BY content_name";

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
		?>
		<tr class="<?=$id?>">
			<td width="10%" align="left"><?=$i?></td>
			<td width="24%" align="left"><?=$row['content_name']?></td>
			<td width="30%" align="left"><?=substr($row['content_desc'],0,100)?></td>
			<td width="15%" align="center"><a href="content_manager.php?content_id=<?=$row['content_id']?>&mode=status&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="11%" align="center"><a href="content_manager.php?content_id=<?=$row['content_id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="content_manager.php?content_id=<?=$row['content_id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Content?")'>Delete</a></td>
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
		<tr><td colspan="6" align="center" style="padding-top:10px;"><b>No Content Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
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
			<td width="23%" align="left" class="cat_name">Meta Tag</td>
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
			<td width="23%" align="left" class="cat_name">Content Name</td>
			<td width="77%" align="left"><input type="text" class="text" name="content_name" id="content_name" value="<?=$row['content_name']?>" size="60"/></td>
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

<!-- End of Sidebar -->

</div>
<!-- End of bgwrap -->

<!-- Footer -->
<?php require_once("include/footer.php"); ?>				
<!-- End of Footer -->