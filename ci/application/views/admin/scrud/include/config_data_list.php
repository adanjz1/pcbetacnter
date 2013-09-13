<form class="form-horizontal">
	<div id="dataListConfigCommon" style="margin-top: 10px;">
	    <div class="control-group">
	        <label class="control-label" for="crudTitle"><b><?php echo $this->lang->line('title');?></b> </label>
	        <div class="controls">
	            <input type="text" id="crudTitle" name="crud[title]">
	        </div>
	    </div>
	    <div class="control-group">
	        <label class="control-label" for="crudRowsPerPage"><b><?php echo $this->lang->line('rows_per_page');?></b>
	        </label>
	        <div class="controls">
	            <input type="text" style="width: 40px;" name="crud[rows_per_page]" id="crudRowsPerPage">
	        </div>
	    </div>
	    <div class="control-group">
	        <label class="control-label" for="crudOrderField"><b><?php echo $this->lang->line('order_by');?></b> </label>
	        <div class="controls">
	            <select name="crud[order_field]" id="crudOrderField">
	                <option value=""></option>
	                <?php foreach($fields as $f){ ?>
			         <option value="<?php echo $f['Field']; ?>"><?php echo $f['Field']; ?></option>
			        <?php } ?>
	            </select> 
	            <select style="width: auto;" name="crud[order_type]" id="crudOrderType">
	                <option value=""></option>
	                <option value="asc"><?php echo $this->lang->line('asc');?></option>
	                <option value="desc"><?php echo $this->lang->line('desc');?></option>
	            </select>
	        </div>
	    </div>
            <div class="control-group">
                    <label class="control-label" for="crudNoColumn"><b><?php echo $this->lang->line('no_column');?></b></label>
                    <div class="controls">
                        <input type="checkbox" value="1" id="crudNoColumn">
                    </div>
                </div>
	    <div class="control-group">
	        <label class="control-label"><b><?php echo $this->lang->line('join');?></b> </label>
	        <div class="controls">
	        	<div id="dataListJoin" style="margin-bottom: 5px;"></div>
	            <input type="button" class="btn" value="<?php echo $this->lang->line('add_join'); ?>" id="addJoinButton"/>
	        </div>
	    </div>
	</div>


    <div>
        <ul id="dataListConfigElement" class="nav nav-tabs">
            <li class="active"><a href="#filter" data-toggle="tab">
            	<?php echo $this->lang->line('filter_elements');?>
            </a></li>
            <li><a href="#column" data-toggle="tab"><?php echo $this->lang->line('column_elements');?></a></li>
        </ul>
        <div id="dataListConfigElementContent" class="tab-content">
            <div class="tab-pane fade in active" id="filter">
            	<div class="row-fluid">
	            	<div id="filter_container">
	                	<ul class="nav nav-tabs nav-stacked" id="filter_elements"></ul>
	                </div>
	           	</div>
            </div>
            <div class="tab-pane fade" id="column">
            	<div class="row-fluid">
				    <div id="column_container">
					    <ul class="nav nav-tabs nav-stacked" id="column_elements"></ul>
				    </div>
				</div>
            </div>
        </div>
    </div>
</form>
<script>
$(function() {
    $( "#filter_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
    $( "#column_elements" ).sortable({forcePlaceholderSize: true,placeholder: "ui-state-highlight"});
});
</script>
