<?php 

require_once("include/top_menu.php"); 


$sql = mysql_query("SELECT * FROM ".MANAGE_NEWSLETTER." ORDER BY `id` DESC");
$total_count=mysql_num_rows($sql);


if($_REQUEST['mode']=='delete')
{
	$deal_email_id = $_REQUEST['deal_email_id'];
	$row_status=mysql_fetch_array(mysql_query("select * from ".MANAGE_NEWSLETTER." where id='".$id."'"));
	mysql_query("delete from ".MANAGE_NEWSLETTER." where id='".$id."'");
	$msg = "Successfully Delete ".$row_status['user_name'];
	$_REQUEST['mode']="";
}
?>	

<script language="javascript">
	function check(ch,cou)
	{
		
		var i;
		for(i=0;i<cou;i++)
		{
		var u="id"+i;
		document.getElementById('id'+i).checked=ch
		}
	
	}
function SendEmail(con)
	{
	
	var flag=false;
	var i;
	
	
	for(i=0;i<con;i++)
		{
			//alert(document.getElementById('id'+i).checked);
			var x=document.getElementById('id'+i).checked;
			
			if(x==true)
			{
			   	
				flag=true;
				break;
			}
		}
	
	
		if(flag==true)
			{
			var regid="";
			
	        for(i=0;i<con;i++)
		    {
			
			var x=document.getElementById('id'+i).checked;
			
			if(x==true)
			{
			
			   var d=document.getElementById('id'+i).value;
			   
				regid=regid +"-"+ d;
				
			
			
			
		    }	
				
				//alert(document.getElementById('id'+i).value);
				window.open("dailynewsletter-send.php?reg_id="+regid, "mywindow","height=750, width=750,top=60px, left=200px");
			}}
		else
			{
			alert("Please Choose The Member(s) To Send Mail");
			}	
		
	}	
   </script>
		
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Welcome To User Manager</h1>
		
		<?php if($msg!=''){?>
				<p><?=$msg?></p>
		<?php }else { ?>
				<p>&nbsp;</p>
		<?php } ?>
		
		<?php if($_REQUEST['mode']==''){?>
		<form name="frm_user" id="frm_user" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
		<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
		<tr>
			<td width="10%" align="left" id="cat_trh">Select</td>
			<td width="26%" align="left" id="cat_trh">Deal Email</td>
			<td width="30%" align="left" id="cat_trh">Deal City</td>
			<td width="14%" align="center" id="cat_trh">Status</td>
			<td width="10%" align="center" id="cat_trh">Delete</td>
		</tr>
		<?php
			$i=1;
			$flag=0;
			$j=0;
			$sql = mysql_query("SELECT * FROM ".MANAGE_NEWSLETTER."");
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
			<td width="10%" align="left"><input type="checkbox" value="<?=$row['id']?>"  name="id[]" id="id<?=$j;?>" size="4" /></td>
			<td width="26%" align="left"><?=$row['email']?></td>
			
			<?php $sqlcity = mysql_fetch_array(mysql_query("SELECT * FROM ".MANAGE_CITY." WHERE id = '".$row['city']."'")); ?>
			
			<td width="30%" align="left"><?=$row['city']?></td>
			<td width="14%" align="center"><?php echo $row['status']; ?></td>
			<td width="10%" align="center"><a href="dailynewsletter.php?id=<?=$row['id']?>&mode=delete" onClick='return confirm("Are you sure to delete this User?")'>Delete</a></td>
		</tr>
		<?php
		$j++;
			}
		?>
		<tr>
			<!--<td><a href="JavaScript:checkAll(document.frm_user)" class="normalLink">Check All</a></td>
			<td><a href="JavaScript:uncheckAll(document.frm_user)" class="normalLink">Unckeck All</a></td>-->
			<td><input name="Send" type="button"  onclick="return SendEmail(<?php echo $total_count; ?>);" class="hbutton" value="Send Newsletter" /></td>
		</tr>
		</table>
		</form>
		<?php }elseif($_REQUEST['mode']=='edit' || $_REQUEST['mode']=='add'){?>
		<?php if($_REQUEST['mode']=='edit'){ $mode = "Edit User"; } elseif($_REQUEST['mode']=='add'){ $mode = "Add User"; }
				$sql = mysql_query("SELECT * FROM ".MANAGE_NEWSLETTER." WHERE id='".$_REQUEST['id']."'");
				$row = mysql_fetch_array($sql);
		?>
		<form name="frm_adduser" id="frm_adduser" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="javascript:return add_edit_user();">
		<input type="hidden" name="id" id="id" value="<?=$_REQUEST['id']?>" />
		<input type="hidden" name="mode" id="mode" value="update" />
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="80%">
		<tr>
			<td width="32%" align="left" class="cat_name">Full Name</td>
			<td width="68%" align="left"><input type="text" class="text" name="user_name" id="user_name" value="<?=$row['user_name']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Password</td>
			<td width="68%" align="left"><input type="password" class="text" name="user_pass" id="user_pass" value="<?=$row['user_pass']?>" size="40"/></td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Confirm Password</td>
			<td width="68%" align="left"><input type="password" class="text" name="user_pass_conf" id="user_pass_conf" value="" size="40"/></td>
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
				<option value="<?=$row_city['city_id']?>" <?php if($row_city['city_id']==$row['city']){?> selected="selected" <?php } ?>><?=ucwords($row_city['city_name'])?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Deal Category</td>
			<td width="68%" align="left">
				<select name="deal_cate" id="deal_cate" class="select">
				<option value="">Select Category</option>
				<?php
					$sql_cat = mysql_query("SELECT * FROM ".TABLE_CATEGORY." WHERE parentid=0");
					while($row_cat = mysql_fetch_array($sql_cat))
					{
				?>
				<option value="<?=$row_cat['cat_id']?>" <?php if($row_cat['cat_id']==$row['deal_cate']){?> selected="selected" <?php } ?>><?=ucwords(str_replace("_"," ",$row_cat['category_name']))?></option>
				<?php
					}
				?>
				</select></td>
		</tr>
		<tr>
			<td width="32%" align="left" class="cat_name">Site Name</td>
			<td width="68%" align="left"><input type="text" class="text" name="site_name" id="site_name" value="<?=$row['site_name']?>" size="40"/></td>
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