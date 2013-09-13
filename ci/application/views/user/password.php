<?php $CI = & get_instance(); 
$lang = $CI->lang;
?>
<div class="container">
         <?php echo $user_menu; ?>
         <br />
        <form class="bs-docs-example form-horizontal" method="post" action="<?php echo base_url(); ?>index.php/user/changepassword">
            <?php if (count($errors) > 0) { ?>
                <div class="alert alert-error">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <?php foreach ($errors as $v) { ?>
                        <strong><?php echo $lang->line('error'); ?>!</strong> <?php echo $v; ?> <br />
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($update_flag == 1 && count($errors) <= 0) { ?>
                <div class="alert alert-success">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $lang->line('you_have_successfully_changed_your_password');?>
                </div>
            <?php } ?>
            <div class="control-group  <?php if (array_key_exists('current_password', $errors)) { ?> error <?php } ?>">
                <label for="inputPassword" class="control-label" style=" text-align: right !important;"><?php echo $lang->line('current_password'); ?></label>
                <div class="controls">
                    <input type="password" placeholder="<?php echo $lang->line('current_password'); ?>" id="current_password"  name="current_password"  value="<?php
            $current_password = $CI->input->post('current_password');
            if (!empty($current_password)) {
                echo htmlspecialchars($current_password);
            }
            ?>" >
                </div>
            </div>
            <div class="control-group  <?php if (array_key_exists('new_password', $errors)) { ?> error <?php } ?>">
                <label for="inputPassword" class="control-label" style=" text-align: right !important;"><?php echo $lang->line('new_password'); ?></label>
                <div class="controls">
                    <input type="password" placeholder="<?php echo $lang->line('new_password'); ?>" id="new_password"   name="new_password"  value="<?php
                           $new_password = $CI->input->post('new_password');
                           if (!empty($new_password)) {
                               echo htmlspecialchars($new_password);
                           }
            ?>" >
                </div>
            </div>
            <div class="control-group <?php if (array_key_exists('confirm_new_password', $errors)) { ?> error <?php } ?>">
                <label for="inputPassword" class="control-label" style=" text-align: right !important;"><?php echo $lang->line('re_type_new_password'); ?></label>
                <div class="controls">
                    <input type="password" placeholder="<?php echo $lang->line('re_type_new_password'); ?>" id="confirm_new_password"   name="confirm_new_password"  value="<?php
                    $confirm_password = $CI->input->post('confirm_new_password');
                    if (!empty($confirm_password)) {
                        echo htmlspecialchars($confirm_password);
                    }
            ?>" >
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit"><?php echo $lang->line('change_password'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
    	$('title').html($('h2').html());
    });
</script>