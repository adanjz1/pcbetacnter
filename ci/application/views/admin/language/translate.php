<div class="container">
		<h2><?php echo $this->lang->line('tool_language_manager');?></h2>
        <ul class="nav nav-tabs" id="auth_tab" style="margin-bottom: 0px;">
            <li><a href="<?php echo base_url(); ?>index.php/admin/component/builder"> <?php echo $this->lang->line('components'); ?> </a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/component/groups"> <?php echo $this->lang->line('group_component'); ?> </a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/table/index"><?php echo $this->lang->line('table_builder'); ?></a></li>
            <li class="active"><a href="<?php echo base_url(); ?>index.php/admin/language/index"> <?php echo $this->lang->line('language_manager'); ?> </a></li>
        </ul>
</div>
<div style="height: 52px;">
    <div data-spy="affix" data-offset-top="90" style="
         top: 24px;
         width: 100%;
         padding-top:5px;
         padding-bottom:5px;
         z-index: 100;">
        <div class="container" style="border-bottom: 1px solid #CCC; padding-bottom:5px;padding-top:5px;
        	background: #FBFBFB;
       		background-image: linear-gradient(to bottom, #FFFFFF, #FBFBFB);">
            <div style="text-align:right; width:100%;">
                <a class="btn"  onclick="back();">   <i class="icon-arrow-left"></i>  <?php echo $this->lang->line('back'); ?>  &nbsp; </a>
                <a class="btn btn-info" onclick="translateLanguage();" > &nbsp;  <i class="icon-ok icon-white"></i>  <?php echo $this->lang->line('save'); ?> &nbsp; </a>
            </div>
        </div>
    </div>
    </div>
<div class="container">    
        <form id="frm_translate">
        	<input type="hidden" name="language_code" value="<?php echo $rs['language_code']; ?>" />
	        <table class="table-striped" style="width:100%;">
	        <col style="width:30%;" />
	        <thead>
	        <tr>
	        	<th style="text-align: left;">Default</th>
	        	<th style="text-align: left;"><?php echo htmlspecialchars($rs['language_name']); ?></th>
	        </tr>
	        </thead>
	        <?php foreach($lang_default as $key => $language){
	        	if ($key == 'date_text') continue;
	        	?>
	        	<tr>
	        		<td><?php echo htmlspecialchars($language);?></td>
	        		<td><input type="text" name="<?php echo htmlspecialchars($key); ?>" style="width: 98%;" value="<?php 
	        		if (isset($lang[$key])){
	        			echo str_replace('"', '&quot;', $lang[$key]);
	        		}else{
						echo '';
					} ?>"></td>
	        	</tr>
			<?php }?>
			</table>
        </form>
</div>
    
<script>
function back() {
    window.location = "<?php echo base_url(); ?>index.php/admin/language/index?xtype=index";
}

function translateLanguage(){
	$('.alert').remove();
	$.post(window.location.href,$('#frm_translate').serialize(),function(o){
		if (o.error == 0){
			var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
	        '<button data-dismiss="alert" class="close" type="button">×</button>' +
	        '<?php echo $this->lang->line('you_successfully_saved');?>' +
	        '</div>';
	        var alertSuccess = $(strAlertSuccess).appendTo('body');
	        alertSuccess.show();
	        
	        setTimeout(function(){ 
	            alertSuccess.remove();
	        },2000);
		}else{
			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">' +
	        '<button data-dismiss="alert" class="close" type="button">×</button>' +
	        o.error_message +
	        '</div>';
	        var alertSuccess = $(strAlertSuccess).appendTo('body');
	        alertSuccess.show();
		}
        
	},'json');	
}

</script>