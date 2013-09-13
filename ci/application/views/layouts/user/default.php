<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="<?php echo __HTML_CHARSET__; ?>">
        <title><?php echo $this->lang->line('codeigniter_admin_pro'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="<?php echo base_url(); ?>media/css/template.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>media/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>media/select2/select2.css" rel="stylesheet">

        <script src="<?php echo base_url(); ?>media/bootstrap/js/jquery-1.7.1.min.js"></script>
        <script src="<?php echo base_url(); ?>media/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>media/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url(); ?>media/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>media/select2/select2.js"></script>

    </head>

    <body>
        <?php echo $main_menu; ?>
        <?php echo $main_content; ?>
        <?php echo $main_footer; ?>
    </body>
</html>
