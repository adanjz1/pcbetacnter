<?php 
	require_once("include/top_menu.php");
	require_once("include/function_search.php");
	
	$mode 		 = $_REQUEST['mode'];
	$action 	= $_REQUEST['action'];
	$mode_toggle = $_REQUEST['mode_toggle'];
?>
<div id="bgwrap">
<div id="content">
	<div id="main">
<?php	
	if($mode == "add" || $mode == "edit")		
	  	show_add_edit($_REQUEST[row_id]);	
	elseif	($mode == "delete")						
	  	delete_record($_REQUEST['row_id'], PRODUCT_MASTER, "product_id");
	elseif	($mode == "ChangeStatus")		
		change_status($_REQUEST['row_id'], PRODUCT_MASTER, "is_active ", "product_id");	 
	elseif 	($mode == "update")						
		update_record($_REQUEST['row_id']);
	else											
		show_list();
?>
	</div>
</div>
<?php require_once("include/left_menu.php"); ?>				
</div>
<?php require_once("include/footer.php"); ?>		
<?php	
function show_list()
{
?>
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frm_adddeal.cat_name.value=="")
	{
		document.getElementById("err_catname").innerHTML="Please Enter Category Name";
		document.frm_adddeal.cat_name.focus();
		return false;
	}
	else
	{
		document.getElementById("err_catname").innerHTML="";
	}
	
	if(document.frm_adddeal.deal_sources_id.value=="")
	{
		document.getElementById("err_dealsourceid").innerHTML="Please Enter Deal Source Name";
		document.frm_adddeal.deal_sources_id.focus();
		return false;
	}
	else
	{
		document.getElementById("err_dealsourceid").innerHTML="";
	}
	
	if(document.frm_adddeal.title.value=="")
	{
		document.getElementById("err_title").innerHTML="Please Enter Deal Name";
		document.frm_adddeal.title.focus();
		return false;
	}
	else
	{
		document.getElementById("err_title").innerHTML="";
	}
	
	if(document.frm_adddeal.deal_url.value=="")
	{
		document.getElementById("err_dealurl").innerHTML="Please Enter Deal URL";
		document.frm_adddeal.deal_url.focus();
		return false;
	}
	else
	{
		document.getElementById("err_dealurl").innerHTML="";
	}
	
	if(document.frm_adddeal.deal_price.value=="")
	{
		document.getElementById("err_dealprice").innerHTML="Please Enter Deal Price";
		document.frm_adddeal.deal_price.focus();
		return false;
	}
	else
	{
		document.getElementById("err_dealprice").innerHTML="";
	}
	
	if(document.frm_adddeal.actual_price.value=="")
	{
		document.getElementById("err_actualprice").innerHTML="Please Enter Actual Price";
		document.frm_adddeal.actual_price.focus();
		return false;
	}
	else
	{
		document.getElementById("err_actualprice").innerHTML="";
	}
	
	if(document.frm_adddeal.currency.value=="")
	{
		document.getElementById("err_currency").innerHTML="Please Enter Currency";
		document.frm_adddeal.currency.focus();
		return false;
	}
	else
	{
		document.getElementById("err_currency").innerHTML="";
	}
	
	if(document.frm_adddeal.image_url.value=="")
	{
		document.getElementById("err_imageurl").innerHTML="Please Enter Image Url";
		document.frm_adddeal.image_url.focus();
		return false;
	}
	else
	{
		document.getElementById("err_imageurl").innerHTML="";
	}
return true;
}
</script>
<script language="javascript" type="text/javascript">
	function dealcheck()
	{
		if(document.dealsearch.Search_for.value.search(/\S/) == -1)
		{
			document.getElementById("err_dealsearch").innerHTML="Please enter something atleast to get a related Search Result.";
			document.dealsearch.Search_for.value="";
			document.dealsearch.Search_for.focus();
			return false;
		}
		else
		{
			document.getElementById("err_dealsearch").innerHTML="";
		}
	}
</script>
<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Manager Deal</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
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
			  <td width="8%">SL</td>
			  <td width="42%">Deal Name</td>
			  <td width="10%">Home Deal</td>
			  <td width="10%">Hot Deal</td>
			  <td width="10%" align="left">Status</td>
			  <td width="10%" align="left">Edit</td>    
			  <td width="10%" align="left">Delete</td>
			</tr>
		<?php
			$items = 15;
			$page = 1;
					
			if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
			{
				$limit = " LIMIT ".(($page-1)*$items).",$items";
				$i = $items*($page-1)+1;
			}
			else
			{
				$limit = " LIMIT $items";
				$i = 1;
			}
			if ($_REQUEST['mode'] == "search")
			 $condition = " AND ".$_REQUEST['search_field']." LIKE '%".$_REQUEST['search_txt']."%' ";
		  elseif ($_REQUEST['mode'] == "alpha") 
			 $condition = " AND title like '".$_REQUEST['search_txt']."%' ";
			else 
			 $condition = "";
			 
			$sql="select * from ".TABLE_PRODUCT." where deal_coupon = 'd'".$condition;
			$sqlStrAux = "SELECT count(*) as total FROM ".TABLE_PRODUCT." where deal_coupon = 'd'".$condition;

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
						$id = "table_record";
					else
						$id = "table_record_alt";
					if($row["is_active"] ==1)
					$status =0;
					else
					$status =1;
					if($row["deal_destination"] == "home")
					{
						$deal_status = "";
					}
					else
					{
						$deal_status = "home";
					}
					if($row["deal_type"] == "hot")
					{
						$dealtype_status = "";
					}
					else
					{
						$dealtype_status = "hot";
					}
		?>
		<tr class="<?=$id?>">
			<td width="8%" align="left"><?=$i?></td>
			<td width="42%" align="left"><?=$row['title']?></td>
			<td width="10%" align="left"><?php /*?><?php if($row['deal_type'] == "" ){ echo "Normal"; } elseif($row['deal_type'] == "home" ){ echo "Home"; } elseif($row['deal_type'] == "hot" ){ echo "Hot"; }?><?php */?><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=dealdest&deal_status=<?php echo $deal_status;?>&page=<?=$_REQUEST['page']?>"><?php if($row['deal_destination'] == "home") { echo "ON"; } else { echo "OFF"; } ?></a></td>
			<td width="10%" align="left"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=dealtype&dealtype_status=<?php echo $dealtype_status;?>&page=<?=$_REQUEST['page']?>"><?php if($row['deal_type'] == "hot") { echo "ON"; } else { echo "OFF"; } ?></a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=status&status=<?php echo $status;?>&page=<?=$_REQUEST['page']?>"><?php if($row['is_active']==1){?>ON<?php } else { ?><font color="#FF0000">OFF</font><?php }?></a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=edit&page=<?=$_REQUEST['page']?>">Edit</a></td>
			<td width="10%" align="center"><a href="deal_manager.php?product_id=<?=$row['product_id']?>&mode=delete&page=<?=$_REQUEST['page']?>" onClick='return confirm("Are you sure to delete this Article?")'>Delete</a></td>
		</tr>
		<?php
					$i++;
				}
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><?php $p->show();?></td></tr>
		<?php
			}
			else
			{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><b>No Deal Data Found</b></td></tr>
		<?php
			}
		?>
		</table>
		</form>
		<div style="height:10px; clear:both">&nbsp;</div>
		<?php
			$search_fields = "Deal";
			$field_name = "title";
			Search($search_fields,$field_name);
		?>
		
}