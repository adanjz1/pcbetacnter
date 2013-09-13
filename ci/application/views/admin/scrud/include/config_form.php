<div class="row-fluid">
    <div class="span12">
        <div style="position: relative; margin-bottom:20px;" id="form-preview">
                <form id="frm_preview">
                    <ul id="elements_preview" class="nav"></ul>
                </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('input[name="preview_type_form"]').click(function(){
            switch ($(this).val()){
                case '1':
                    $('#frm_preview').removeClass('form-horizontal');
                    break;
                case '2':
                    $('#frm_preview').addClass('form-horizontal');
                    break;
            }
            ScrudCForm.config.frm_type=$(this).val();
            $('#form-preview').css({height:'auto'});
            $('#form-preview').height($('#form-preview').height());
        });
        
        if (ScrudCForm.config.frm_type == undefined){
            ScrudCForm.config.frm_type = '2';
        }
        
        $('input[name="preview_type_form"]').each(function(){
            if ($(this).val() == ScrudCForm.config.frm_type){
                $(this).attr({checked:"checked"});
            }
        });
        
        
        var preview_type_form = $('input[name="preview_type_form"]:checked').val();
        switch(preview_type_form){
            case '1':
                $('#frm_preview').removeClass('form-horizontal');
                break;
            case '2':
                $('#frm_preview').addClass('form-horizontal');
                break;
        }
    });
</script>
