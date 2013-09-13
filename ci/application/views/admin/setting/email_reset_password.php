<div id="container" class="container">
	<div class="container">
		<h2><?php echo $this->lang->line('setting_email_reset_password');?></h2>
		<div id="tab_user_manager" class="row-fluid show-grid">
			<div class="span12">
				<ul class="nav nav-tabs" style="margin-bottom: 0px;">
					<li><a href="<?php echo base_url(); ?>index.php/admin/setting/index"><?php echo $this->lang->line('general'); ?></a>
					</li>
					<li class="dropdown active"><a class="dropdown-toggle"
						data-toggle="dropdown" href="#"><?php echo $this->lang->line('email_templates'); ?> <b class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/new_user"><?php echo $this->lang->line('new_user'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/reset_password"><?php echo $this->lang->line('reset_password'); ?></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>

</div>
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
       		
            <div style="text-align:right;width:100%;">
                <button onclick="save_setting();" class="btn btn-primary"
						type="button"><?php echo $this->lang->line('save_change');?></button>
            </div>
        </div>
    </div>
 </div>
<div  class="container">
<div class="container">	
		
		<div class="row-fluid show-grid">
			<form accept-charset="utf-8" method="post" id="SettingSaveForm"
				class="form-horizontal">
				<input type="hidden" id="SettingSettingKey"
					value="<?php echo $setting_key; ?>"
					name="data[setting_key]">
				<div class="control-group">
					<label class="control-label" for="email-activate-resend-subj"><?php echo $this->lang->line('request'); ?>
					</label>
					<div class="controls">
						<label> <input type="text" id="SettingRequestSubject"
							<?php if (isset($data['request_subject'])){?>
								value = "<?php echo htmlspecialchars($data['request_subject']); ?>"
								<?php }?>
								placeholder="Subject"
							class="input-xlarge" name="data[request_subject]">
							<p class="help-inline"><?php echo $this->lang->line('subject'); ?></p>
						</label>
						<textarea id="SettingRequestBody" placeholder="Message body"
							rows="10" class="input-xlarge" name="data[request_body]"><?php if (isset($data['request_body'])){
									echo htmlspecialchars($data['request_body']);  }?></textarea>
						<div class="help-inline">
							<p><?php echo $this->lang->line('message_body');?></p>
							<br>
							<p>
								<strong><?php echo $this->lang->line('short_code'); ?> </strong>
							</p>
							<p>
								<?php echo $this->lang->line('site_address'); ?>
								<code>{site_address}</code>
							</p>
							<p>
								<?php echo $this->lang->line('full_name');?>
								<code>{user_name}</code>
							</p>
							<p>
								<?php echo $this->lang->line('user_email'); ?>
								<code>{user_email}</code>
							</p>
							<p>
								<?php echo $this->lang->line('reset_link'); ?>
								<code>{reset_link}</code>
							</p>
						</div>
					</div>
				</div>


				<div class="control-group">
					<label class="control-label" for="email-activate-subj">Success </label>
					<div class="controls">
						<label> <input type="text" id="SettingSuccessSubject"
							<?php if (isset($data['success_subject'])){?>
								value = "<?php echo htmlspecialchars($data['success_subject']); ?>"
								<?php }?>
							placeholder="Subject" class="input-xlarge"
							name="data[success_subject]">
							<p class="help-inline"><?php echo $this->lang->line('subject'); ?></p>
						</label>
						<textarea id="SettingSuccessBody" placeholder="Message body"
							rows="10" class="input-xlarge" name="data[success_body]"><?php if (isset($data['success_body'])){
									echo htmlspecialchars($data['success_body']);  }?></textarea>
						<div class="help-inline">
							<p><?php echo $this->lang->line('message_body');?></p>
							<br>
							<p>
								<strong><?php echo $this->lang->line('short_code'); ?> </strong>
							</p>
							<p>
								<?php echo $this->lang->line('site_address'); ?>
								<code>{site_address}</code>
							</p>
							<p>
								<?php echo $this->lang->line('full_name');?>
								<code>{user_name}</code>
							</p>
							<p>
								<?php echo $this->lang->line('user_email'); ?>
								<code>{user_email}</code>
							</p>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
function save_setting(){
	$.post('<?php echo base_url(); ?>index.php/admin/setting/save',$('#SettingSaveForm').serialize(),function(o){
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:3px; bottom:20px; -webkit-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; -moz-box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.8) inset; display: none;">'
			+ '<button data-dismiss="alert" class="close" type="button">×</button>'
			+ '<?php echo $this->lang->line('successfully_changed_setting');?>'
			+ '</div>';
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	},'json');
}
$(document).ready(function(){
	$('title').html($('h2').html());
});
</script>
</div>
