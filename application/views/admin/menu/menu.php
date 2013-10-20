<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container"><a class="btn btn-navbar"
                                  data-toggle="collapse" data-target=".nav-collapse"> <span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span
                    class="icon-bar"></span> </a> <a class="brand" href="<?php echo base_url(); ?>index.php/admin/dashboard"><?php echo $this->lang->line('codeigniter_admin_pro'); ?></a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li <?php if ($type == 'dashboard') { ?>class="active"<?php } ?>><a href="<?php echo base_url(); ?>index.php/admin/dashboard"><?php echo $this->lang->line('main'); ?></a></li>
                    <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
		                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 1 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
                        <li class="dropdown <?php if ($type == 'user') { ?>active<?php } ?>">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $this->lang->line('users'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>index.php/admin/user/user"><?php echo $this->lang->line('user_manager');?></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/user/group"><?php echo $this->lang->line('groups');?></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/admin/user/permission"><?php echo $this->lang->line('permissions');?></a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    
					<li class="dropdown <?php if ($type == 'component') { ?>active<?php } ?>" id="mnu_component"><a data-toggle="dropdown"
						class="dropdown-toggle" href="#"><?php echo $this->lang->line('components'); ?> <b
							class="caret"></b> </a>
						<ul class="dropdown-menu">
							<?php foreach ($mnuGroup as $v){
								if (empty($v['coms'])) continue;
								?>
							<li class="dropdown-submenu">
								<a href="#" tabindex="-1" onclick="clickGroup(this); return false;"><?php echo $v['name'];?></a>
								<ul class="dropdown-menu">
									<?php foreach ($v['coms'] as $com){
										$permissions = $auth->getPermissionType($com['id']);
										if (!in_array(4, $permissions)) continue;
										?>
									<li><a href="<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=<?php echo $com['id']; ?>"><?php echo $com['component_name']?></a></li>
									<?php } ?>
								</ul>
							</li>
							<?php } ?>
							<?php foreach ($coms as $com){
								if (in_array($com['id'], $exComs)) continue;
								$permissions = $auth->getPermissionType($com['id']);
								if (!in_array(4, $permissions)) continue;
							?>
							<li><a href="<?php echo base_url(); ?>index.php/admin/scrud/browse?com_id=<?php echo $com['id']; ?>"><?php echo $com['component_name']?></a></li>
							<?php }?>
						</ul>
					</li>
					<?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 2 || 
		                    (int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 2 ||
		                    (int) $CRUD_AUTH['user_manage_flag'] == 3) { ?>
					<li class="dropdown  <?php if ($type == 'tool') { ?>active<?php } ?>" ><a data-toggle="dropdown"
						class="dropdown-toggle" href="#"><?php echo $this->lang->line('tools'); ?><b
							class="caret"></b> </a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>index.php/admin/component/builder"><?php echo $this->lang->line('component_builder'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/component/groups"><?php echo $this->lang->line('groups'); ?></a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/table/index"><?php echo $this->lang->line('table_builder'); ?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/language/index"><?php echo $this->lang->line('language_manager'); ?></a></li>
						</ul>
					</li>
					<?php } ?>
					<?php if ($auth->isSettingManagement()){?>
					<li class="dropdown <?php if ($type == 'setting') { ?>active<?php } ?>"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"><?php echo $this->lang->line('settings');?> <b class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/index"><?php echo $this->lang->line('general')?></a></li>
							<li class="nav-header"><?php echo $this->lang->line('email_templates'); ?></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/new_user"><?php echo $this->lang->line('new_user');?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/email/reset_password"><?php echo $this->lang->line('reset_password'); ?></a></li>
						</ul></li>
					<?php } ?>
				</ul>
                <ul class="nav pull-right">
                    <!-- <li class="divider-vertical"></li> -->
                    <li class="dropdown   <?php if ($type == 'account') { ?>active<?php } ?>">
                        <a class=" dropdown-toggle" data-toggle="dropdown" href="#" > &nbsp;  <i class="icon icon-user"></i>&nbsp; <?php echo $CRUD_AUTH['user_name']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        	<?php if ($auth->isSettingManagement()){?>
							<li><a href="<?php echo base_url(); ?>index.php/admin/setting/index"> <i class="icon-cog"></i> <?php echo $this->lang->line('settings');?></a></li>
							<?php } ?>
                            <?php if ($CRUD_AUTH['group']['group_name'] != 'SystemAdmin') { ?>
                                <li><a href="<?php echo base_url(); ?>index.php/user/editprofile"> <i class="icon-user"></i> <?php echo $this->lang->line('edit_profile');?></a></li>
                                <li><a href="<?php echo base_url(); ?>index.php/user/changepassword"> <i class="icon-pencil"></i> <?php echo $this->lang->line('change_password');?></a></li>
                                <li class="divider"></li>
                            <?php } ?>
                            <li><a href="<?php echo base_url(); ?>index.php/admin/logout"> <i class="icon-minus-sign"></i> <?php echo $this->lang->line('log_out');?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
	function clickGroup(obj){
		window.location = $(obj).parent().find('ul').find('a:first').attr('href');
	}
    $(document).ready(function(){
    	$('#mnu_component > ul > li').each(function(){
			if ($(this).hasClass('dropdown-submenu')){
				if ($(this).find('li').length <= 0){
					$(this).remove();
				}
			}
       });
        
       if ($('#mnu_component').children('ul').find('li').length <= 0){
           $('#mnu_component').hide();
       }else{
           $('#mnu_component').show();
       } 
    });
</script>