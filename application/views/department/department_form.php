<?php echo form_open_multipart('department/'.$param1.'/'.$param2.'/'.$param3, array('id'=>'bb_ajax_form', 'class'=>'form-horizontal')); ?>
<div class="row">
    <div id="bb_ajax_msg"></div>
    
    <?php if($param2 == 'delete') { // delete view ?>
        <div class="col-xs-12 text-center">
            <h3><b><?php echo _ph('are_you_sure'); ?>?</b></h3><br/>
            <input type="hidden" name="d_department_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <input type="hidden" name="department_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                            <input class="form-control" type="text" id="name" name="name" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required>
                            <label for="name"><?php echo _ph('department'); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12"><b><?php echo _ph('designations'); ?></b></div>

            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <table id="alldes" class="tbDesig table table-striped small">
                            <?php if(empty($e_designations)){ ?>
                                <tr class="tbChild">
                                    <td>
                                        <span class="sno" style="display:none;"></span>
                                        <div class="form-material input-group">
                                            <input class="form-control" name="designations[]" placeholder="<?php echo _ph('designation'); ?>" type="text" required>
                                            <a href="javascript:;" class="input-group-addon text-danger removeClone disabled" style=""><i class="si si-close"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <?php $desigs = json_decode($e_designations); ?>
                                <?php for($i=0; $i<count($desigs); $i++): ?>
                                    <?php $desig_name = $this->Crud->read_field('id', $desigs[$i], 'access_role', 'name'); ?>
                                    <tr class="tbChild">
                                        <td>
                                            <span class="sno" style="display:none;"></span>
                                            <div class="form-material input-group">
                                                <input type="hidden" name="edit_designations[]" value="<?php echo $desigs[$i]; ?>" />
                                                <input class="form-control" name="designations[]" placeholder="<?php echo _ph('designation'); ?>" type="text" value="<?php echo $desig_name; ?>" required>
                                                <a href="javascript:;" data-id="<?php echo $desigs[$i]; ?>" data-dept="<?php echo $e_id; ?>" class="input-group-addon text-danger removeClone <?php if($i==0){echo 'disabled';} ?>" style=""><i class="si si-close"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            <?php } ?>
                        </table>
                    </div>

                    <div class="col-xs-12">
                        <a id="tbClone" href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> <?php echo _ph('add_more'); ?></a>
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