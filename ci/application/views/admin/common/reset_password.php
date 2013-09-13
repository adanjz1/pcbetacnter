<?php 
$data = $this->input->post('data');
?>
<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<legend><?php echo $this->lang->line('reset_password');?></legend>
			<?php if (count($errors) > 0) { ?>
			<div class="alert alert-error">
				<?php foreach($errors as $error) {?>
				<div>
					<?php echo $error;?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
			<form method="post" action="<?php echo base_url(); ?>index.php/admin/reset_password?code=<?php echo $code; ?>">
				<div style="display: none;">
					<input name="_method" value="post" type="hidden">
				</div>
				<input name="data[code]"
					value="<?php echo $code;?>"
					type="hidden">
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo $this->lang->line('new_password'); ?> </label>
					<div class="controls">
						<input name="data[user_password]" class="span4"  placeholder="<?php echo $this->lang->line('new_password'); ?>" id="Password" type="password" value="<?php
		            if (!empty($data) && isset($data['user_password'])) {
		                echo htmlspecialchars($data['user_password']);
		            }
		            ?>"/>
					</div>
				</div>
				<div class="control-group">
					<label for="inputPassword" class="control-label"><?php echo $this->lang->line('confirm_password'); ?> </label>
					<div class="controls">
						<input name="data[user_confirm_password]" placeholder="<?php echo $this->lang->line('confirm_password'); ?>" class="span4"  id="ConfirmPassword" type="password" value="<?php
		            if (!empty($data) && isset($data['user_confirm_password'])) {
		                echo htmlspecialchars($data['user_confirm_password']);
		            }
		            ?>" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit"><?php echo $this->lang->line('reset_password_submit'); ?></button>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>
