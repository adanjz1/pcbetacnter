<?php $CRUD_AUTH = $this->session->userdata('CRUD_AUTH'); ?>
<div class="container">
		<h2><?php echo $this->lang->line('user_manager_users');?></h2>
        <ul class="nav nav-tabs" id="auth_tab" style="margin-bottom: 0px;">
        <?php if ((int) $CRUD_AUTH['group']['group_manage_flag'] == 1 || 
        		(int) $CRUD_AUTH['group']['group_manage_flag'] == 3 ||
        		(int) $CRUD_AUTH['user_manage_flag'] == 1 || 
        		(int) $CRUD_AUTH['user_manage_flag'] == 3 ) { ?>
            <li class="active"><a href="<?php echo base_url(); ?>index.php/admin/user/user"> &nbsp; <?php echo $this->lang->line('users');?> &nbsp; </a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/user/group"><?php echo $this->lang->line('groups');?></a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/user/permission"><?php echo $this->lang->line('permissions');?></a></li>
          <?php } ?>
        </ul>
        <?php echo $content; ?>
</div>
