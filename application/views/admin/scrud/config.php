<style>
.affix .clickover{
	top: 38px !important;
}
.affix-top .clickover{
	top: 152px !important;
}

#form_toolbar .popover-content{
	max-height: 500px !important;
	overflow: auto;
}
</style>
<script type="text/javascript">
    ScrudCForm.wpage = '<?php echo base_url(); ?>index.php';
    ScrudCForm.urlGetOptions = '<?php echo base_url(); ?>index.php/admin/scrud/getOptions';
    ScrudCForm.urlGetFields = '<?php echo base_url(); ?>index.php/admin/scrud/getFields?table=';
    ScrudCForm.urlSaveConfig = '<?php echo base_url(); ?>index.php/admin/scrud/saveConfig';
    ScrudCForm.table = '<?php echo $_GET['table']; ?>';
    ScrudCForm.successfully_message = '<?php echo $this->lang->line('you_successfully_saved'); ?>';
<?php
if (!empty($crudConfigTable)) {
    ?>
            ScrudCForm.config = <?php echo $crudConfigTable; ?>;
    <?php
}
?>
<?php if (!empty($tables)) { ?>
    <?php
    foreach ($tables as $t) {
        if (strpos($t, 'crud_') !== false)
            continue;
        ?>
                    ScrudCForm.tables[ScrudCForm.tables.length] = '<?php echo $t; ?>';
    <?php } ?>
<?php } ?>

<?php foreach ($fields as $f) { 
		if (in_array($f['Field'], array('created','created_by','modified','modified_by'))) continue;
	?>
        ScrudCForm.fields[ScrudCForm.fields.length] = '<?php echo $f['Field']; ?>'
<?php } ?>
<?php foreach ($fieldConfig as $f => $c) { ?>
        ScrudCForm.elements['<?php echo $f; ?>'] = <?php echo $c; ?>;
<?php } ?>
</script>
<div class="container">
    <div class="row-fluid" >
        <div class="tabbable">
        	<h2><?php echo $this->lang->line('tool_configure'); ?> <?php echo $com['component_name']; ?></h2>
            <ul  class="nav nav-tabs" id="myTab" style="margin-bottom: 0px;">
                <li class="active"><a data-toggle="tab" href="#form" onclick="$('#frm_preview_opt').show();"> &nbsp; <?php echo $this->lang->line('form'); ?> &nbsp;</a></li>
                <li><a data-toggle="tab" href="#searchList" onclick="__clickList();$('#frm_preview_opt').hide();"> &nbsp;&nbsp; <?php echo $this->lang->line('list'); ?> &nbsp;&nbsp; </a></li>
            </ul>
            
           </div>
	</div>
</div>
	<div style="height: 52px;">
    <div data-spy="affix" data-offset-top="86" style="
         top: 24px;
         width: 100%;
         padding-top:5px;
         padding-bottom:5px;
         z-index: 100;">
        <div class="container" style="border-bottom: 1px solid #CCC; padding-bottom:5px;padding-top:5px;
        	background: #FBFBFB;
       		background-image: linear-gradient(to bottom, #FFFFFF, #FBFBFB);">
            <div style="text-align:right;width:100%;" id="form_toolbar" >
            	<span id="frm_preview_opt">
            	<a class="btn" id="btn_field_to_form"><i class="icon-plus"></i></a> &nbsp;
                    <label style="display:inline-block; margin-right: 15px;" class="radio inline">
                        <input type="radio" name="preview_type_form" value="1"><?php echo $this->lang->line('normal');?>
                    </label>
                    <label style="display:inline-block; margin-right: 15px;" class="radio inline">
                        <input type="radio" name="preview_type_form" value="2"><?php echo $this->lang->line('horizontal');?>
                    </label>
                </span>    
                <a class="btn" href="<?php echo base_url(); ?>index.php/admin/component/builder?xtype=index"> <i class="icon-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
                <a class="btn btn-primary" onclick="ScrudCForm.saveElements('<?php echo $_GET['table']; ?>','<?php echo $_GET['com_id']; ?>');" > <i class="icon-ok icon-white"></i> <?php echo $this->lang->line('save'); ?> </a>
            </div>
        </div>
    </div>
    </div>
<div class="container">
    <div class="row-fluid" >
        <div class="tabbable">
            <div class="tab-content" id="myTabContent">
                <div id="form" class="tab-pane fade  in active">
                    <?php require_once 'include/config_form.php'; ?>
                </div>
                <div id="searchList" class="tab-pane fade">
                    <div class="span12">
                        <div style="padding: 5px;">
                            <?php require_once 'include/config_data_list.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    function __clickList(){
        $('#filter_elements > li:first > a > a').trigger('click');
        $('#column_elements > li:first > a > a').trigger('click');
    };
</script>
