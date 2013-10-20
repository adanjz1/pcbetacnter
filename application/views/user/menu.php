<div class="container">
<h2><?php echo $this->lang->line('account_settings'); ?></h2>
<ul class="nav nav-tabs" id="my_settings" style="margin-bottom: 0px;">
    <li <?php if ($type == 'profile'){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url(); ?>index.php/user/editprofile"><?php echo $this->lang->line('edit_profile'); ?></a>
    </li>
    <li  <?php if ($type == 'password'){ ?> class="active" <?php } ?>>
        <a href="<?php echo base_url(); ?>index.php/user/changepassword"><?php echo $this->lang->line('change_password'); ?></a>
    </li>
</ul>
</div>