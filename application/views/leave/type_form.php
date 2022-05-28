<?php echo form_open_multipart('leave/type/'.$param1.'/'.$param2.'/'.$param3, array('id'=>'bb_ajax_form', 'class'=>'form-horizontal')); ?>
<div class="row">
    <div id="bb_ajax_msg"></div>
    
    <?php if($param2 == 'delete') { // delete view ?>
        <div class="col-xs-12 text-center">
            <h3><b><?php echo _ph('are_you_sure'); ?>?</b></h3><br/>
            <input type="hidden" name="d_type_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
        </div>
        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <span class="btn-label"><i class="fa fa-trash-o"></i></span> <?php echo _ph('yes'); ?>
                </button>
            </div>
        </div>
    <?php } else { // insert/edit view ?>
        <div class="col-sm-8 col-sm-offset-2">
            <div class="col-xs-8">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <input type="hidden" name="type_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                            <input class="form-control" type="text" id="name" name="name" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required>
                            <label for="name"><?php echo _ph('leave_type'); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <input class="form-control" type="text" id="quota" name="quota" value="<?php if(!empty($e_quota)){echo $e_quota;} ?>" placeholder="<?php echo _ph('days'); ?>/<?php echo _ph('year'); ?>" required>
                            <label for="quota"><?php echo _ph('quota'); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group text-center m-t-40">
                <div class="col-xs-12">
                    <button class="btn btn-primary btn-block text-uppercase bb_form_btn" type="submit">
                        <span class="btn-label"><i class="fa fa-save"></i></span> <?php echo _ph('save'); ?>
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php echo form_close(); ?>

<script src="<?php echo base_url(); ?>assets/js/jsform.js"></script>
<script>jQuery(function(){App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);});</script>
<script>
    $('#tbClone').on('click', function(){
        $('.tbDesig').append( '<tr>' + $( 'tr.tbChild' ).html()  + '</tr>' );
        $('.sno').each(function(index) {
            $(this).text(index+1);
            
            if (index > 0) {
                $(this).parent().find('.removeClone').removeClass('disabled');
            }
        });
        $('tr:last-child').find('input').val('');
    });

    $(document).on('click', '.removeClone', function() {
        $(this).parents().eq(1).remove();
        
        $('.sno').each(function(index) {
            $(this).text(index+1);
        });	
        
        var data_id = $(this).attr('data-id');
        var data_dept = $(this).attr('data-dept');
        if (data_id.length) {
            $.ajax({
                url: "<?php echo base_url('department/delete_designation'); ?>",
                type: 'post',
                dataType: 'json',
                data: { id: data_id, dept: data_dept },
                success:function(data) {}
            });
        }
    });
</script>