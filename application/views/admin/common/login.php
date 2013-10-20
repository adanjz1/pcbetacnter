<?php $CI = & get_instance(); 
$crudUser = $CI->input->post('crudUser');
?>
<?php 
$_lang = $this->session->userdata('lang');
$_c_lang = $this->input->cookie('lang', true);

if(isset($_GET['lang'])){
	$defaultLang = $_GET['lang'];
}else if(!empty($_lang)){
	$defaultLang = $_lang;
}else if(!empty($_c_lang)){
	$defaultLang = $_c_lang;
}else{
	$this->db->select('*');
	$this->db->from('crud_settings');
	$this->db->where('setting_key',sha1('general'));
	$query = $this->db->get();
	$setting = $query->row_array();
	$setting = unserialize($setting['setting_value']);
	 
	if (!empty($setting['default_language']) && trim($setting['default_language']) != ''){
		$defaultLang = $setting['default_language'];
	}else{
		$defaultLang = '';
	}
}
?>
<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<legend><?php echo $this->lang->line('sign_in_to_codeigniter_admin_pro'); ?></legend>
			<form  method="post" class="">
          	<?php if (!empty($crudUser)) { ?>
            <div class="alert alert-error">
                <?php echo $this->lang->line('incorrect_username_or_password'); ?>
            </div>   
            <?php } ?>
			
			<div class="control-group">
              <label class="control-label"><?php echo $this->lang->line('user_name'); ?></label>
              <div class="controls">
                <input type="text" placeholder="<?php echo $this->lang->line('user_name'); ?>" name="crudUser[name]" class="span4"  value="<?php
		            if (isset($crudUser['name'])) {
		                echo htmlspecialchars($crudUser['name']);
		            }
		            ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label"><?php echo $this->lang->line('password'); ?></label>
              <div class="controls">
                <input type="password" placeholder="<?php echo $this->lang->line('password'); ?>"  name="crudUser[password]" class="span4"  value="<?php
                           if (isset($crudUser['name'])) {
                               echo htmlspecialchars($crudUser['password']);
                           }
            ?>" />
              </div>
            </div>
            <div class="control-group">
				<label for="SettingDefaultLanguage" class="control-label"><?php echo $this->lang->line('language'); ?> </label>
				<div class="controls">
					<select name="lang">
					<?php if (!empty($languages)){?>
					<?php foreach ($languages as $language){?>
					<option value="<?php echo $language['language_code']; ?>"
					<?php if ($language['language_code'] == $defaultLang){?>
						selected="selected" <?php }?>>
						<?php echo htmlspecialchars($language['language_name']); ?>
					</option>
					<?php }?>
					<?php }?>
				</select>
				</div>
			</div>
			<button class="btn btn-info" name="submit" type="submit"><?php echo $this->lang->line('sign_in');?></button>
			<label class="checkbox inline" for="remember_me"> 
				<input type="hidden" name="remember_me" value="0" />
				<input type="checkbox" name="remember_me" value="1" id="remember_me"
				<?php if (isset($_POST['remember_me']) && (int)$_POST['remember_me'] == 1){ ?>
					checked="checked"
				<?php } ?>
				 /> <?php echo $this->lang->line('remember_me'); ?>
			</label>
			<div style="padding-top:5px;">
				<?php if ((int)$setting['disable_reset_password'] != 1){?>
				<label>
					<a href="#" onclick="resetPassword(); return false;"><?php echo $this->lang->line('can_not_access_your_account')?></a>
				</label>
				<?php }?>
			</div>
			</form> 
		</div>
	</div>
</div>
<script>
<?php if ((int)$setting['disable_reset_password'] != 1){?>
function resetPassword() {
	var step = 1;
    var mId = $.sModal({
    	header:'<?php echo $this->lang->line('reset_password'); ?>',
    	width:450,
        form:[
			{label:'<?php echo $this->lang->line('email_address'); ?>',type:'text',name:'user_email',attr:{'placeholder':'Email address',style:'width:300px;'}}
              ],
        animate: 'fadeDown',
        buttons: [{
            text: ' Submit ',
            addClass: 'btn-primary',
            click: function(id, data) {
            	if (step == 1){
	            	var btnSubmit = $('#'+id).children('.modal-footer').children('a');
	            	btnSubmit.attr({disabled:'disabled'});
	            	btnSubmit.text('Loading...');
	            	$.post('<?php echo base_url(); ?>index.php/admin/send_reset_password_link',{user_email:$('#'+id).find('#user_email').val()},function(o){
	            		if (o.send_link == 1){
		            		btnSubmit.attr({disabled:false});
		                	btnSubmit.text('Done');
		                	$('#'+id).children('.modal-body').children('div').html('<div class="alert alert-success" style="padding:8px;"><?php echo $this->lang->line('sent_password_reset_email'); ?></div>');
		                	step =2;
	            		}else{
	            			btnSubmit.attr({disabled:false});
		                	btnSubmit.text(' Submit ');
	            			step =1;
	            			$('#'+id).find('.alert-error').remove();
	            			$('#'+id).children('.modal-body').children('div').prepend('<div class="alert alert-error" style="padding:8px;"><?php echo $this->lang->line('please_provide_a_correct_email');?></div>');
	            		}
	            	},'json');
            	}else if (step == 2){
            		$.sModal('close', id);
            	}
            }
        }]
        });
    $('#'+mId).find('input[type="text"]').each(function(){
		$(this).keypress(function(event){
			 if ( event.which == 13 ) {
			 	event.preventDefault();
			 }
		});
	});
}
<?php } ?>

</script>