<?php $crudUser = $this->input->post('crudUser'); ?>
<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<legend><?php echo $this->lang->line('create_a_codeigniter_admin_pro_account');?></legend>
			<?php if (count($errors) > 0) { ?>
            <div class="alert alert-error">
                <?php foreach($errors as $error) {?>
                <div><?php echo $error;?></div>
                <?php } ?>
            </div>   
            <?php } ?>
			<form  method="post" action="<?php echo base_url(); ?>index.php/admin/signup">
			<div class="control-group">
              <label  class="control-label"><?php echo $this->lang->line('user_name'); ?></label>
              <div class="controls">
                <input type="text" placeholder="<?php echo $this->lang->line('user_name'); ?>" name="crudUser[name]" class="span4"  value="<?php
		            if (isset($crudUser['name'])) {
		                echo htmlspecialchars($crudUser['name']);
		            }
		            ?>" />
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label"><?php echo $this->lang->line('password'); ?></label>
              <div class="controls">
                <input type="password" placeholder="<?php echo $this->lang->line('password'); ?>"  name="crudUser[password]" class="span4"  value="<?php
                           if (isset($crudUser['password'])) {
                               echo htmlspecialchars($crudUser['password']);
                           }
            ?>" />
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label"><?php echo $this->lang->line('confirm_password');?></label>
              <div class="controls">
                <input type="password" placeholder="<?php echo $this->lang->line('confirm_password');?>"  name="crudUser[confirm_password]" class="span4"  value="<?php
                           if (isset($crudUser['confirm_password'])) {
                               echo htmlspecialchars($crudUser['confirm_password']);
                           }
            ?>" />
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label"><?php echo $this->lang->line('email');?></label>
              <div class="controls">
                <input type="text" placeholder="user@example.com"  name="crudUser[email]" class="span4"  value="<?php
                           if (isset($crudUser['email'])) {
                               echo htmlspecialchars($crudUser['email']);
                           }
            ?>" />
              </div>
            </div>
            <?php if ((int)$setting['enable_recaptcha'] == 1){?>
            <div class="control-group">
              <label  class="control-label"><?php echo $this->lang->line('recaptcha');?></label>
              <div class="controls">
                <script type="text/javascript">
					var RecaptchaOptions = {
						theme : 'white'
					};
				</script> <?php 
				$publickey = $setting['recaptcha_public_key'];
					echo recaptcha_get_html($publickey, null); ?>
              </div>
            </div>
			<?php }?>
			<button class="btn btn-info" type="submit"><?php echo $this->lang->line('create_my_account'); ?></button>
			<div style="padding-top:5px;">
				<label>
					<a href="<?php echo base_url(); ?>index.php/admin/login"><?php echo $this->lang->line('have_an_account'); ?></a>
				</label>
			</div>
			</form> 
		</div>
	</div>
</div>