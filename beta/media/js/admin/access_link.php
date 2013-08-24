<?php require_once("include/top_menu.php"); ?>
<script>
function p()
{
	var radios = document.getElementsByName('check_link');
	var value="";
	for(var i = 0; i < radios.length; i++) 
	{
		 if (radios[i].checked) 
		 {
			// get value, set checked flag or do whatever you need to
			//value = radios[i].value; 
			value= value + ","+radios[i].value ;      
		 }
	}
	document.getElementById('link_value').value=value;
}
</script>
<?php
if(isset($_POST['add']))
{
	$inser_link=mysql_query("update  ".TABLE_ADMIN." set access_link_id = '".$_REQUEST['link_value']."' where admin_id = '".$_REQUEST['admin_id']."'");
	if($inser_link)
	{
		echo "<script>window.location.href='access_link.php?admin_id=".$_REQUEST['admin_id']."&msg=record updated'</script>";
	}
}

$select_link_id = "select * from ".TABLE_ADMIN." where `admin_id` = '".$_REQUEST['admin_id']."'";
$query_link_id = mysql_query($select_link_id);
$view = mysql_fetch_assoc($query_link_id);
$link_id1 = explode(",",$view['access_link_id']);
$len1=count($link_id1);

$select_link = mysql_query("select * from pc_counter_leftmenu");
?>
<!-- Background wrapper -->
<div id="bgwrap">

<!-- Main Content -->
<div id="content">
	<div id="main">
		<h1>Access Link Management</h1>
		
				<style>
					tr.cat_tr1 td, tr.cat_tr2 td{
						padding: 0 10px;
					}
				</style>
				<form action="" method="post" enctype="multipart/form-data"  name="form1" id="form1">
					<table style="width: 100%;" class="tableBorder" border="0" cellpadding="10" cellspacing="0">
						<tbody>
							<?php if(isset($get['msg'])){?>
								<div class='successBox'> 
									<div class='success' ><?php echo urldecode($get['msg']);?></div> 
								</div> 
							<?php }?>
							
							<?php if(isset($error)){?>
								<div class='successBox'> 
									<div class='success' ><?php echo $error;?></div> 
								</div> 
							<?php }?>
							
							<?php 
								$k =1;		
								while($link_name=mysql_fetch_array($select_link))
								{ 
									if($k%2 == 0)
										$class_id = "cat_tr1";
									else
										$class_id = "cat_tr2";
							?> 
									<tr class="<?=$class_id?>">
										<td class="tableCellOne"><b><?php echo $link_name['link'];?></b> </td>
										<td class="tableCellOne" style="text-align:right;">
											<input name="check_link" type="checkbox" value="<?php echo $link_name['link_id'];?>" onClick="p()" id="check_link" <?php for($i=1;$i<=$len1;$i++){if($link_name['link_id'] == $link_id1[$i]) {?> checked="checked"<?php } }?>>
										</td>
									</tr>
						 	<?php 
									$k++;
								}
							?>
									<tr>
										<td><input name="link_value" type="hidden" id="link_value" value="<?php echo $view['access_link_id'];?>"></td>
									</tr>
									<tr>
										<td class="tableCellTwo" colspan="2" style="text-align:center; padding-top: 10px;">
											<div class="buttonWrapper">
											<input type="submit" name="add" value="Add"  class="button"/>
											</div>
										</td>
									</tr>
						</tbody>
					</table>
				</form>
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