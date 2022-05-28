<?php echo form_open_multipart('leave/type/'.$param1.'/'.$param2.'/'.$param3, array('id'=>'bb_ajax_form', 'class'=>'form-horizontal')); ?>
<div class="row">
    <div id="bb_ajax_msg"></div>
    
    <?php if($param2 == 'delete') { // delete view ?>
        <div class="col-xs-12 text-center">
            <h3><b><?php echo _ph('are_you_sure'); ?>?</b></h3><br/>
            <input type="hidden" name="d_leave_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
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
            <input type="hidden" name="leave_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />

            <div class="col-xs-9">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <select id="type_id" name="type_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" onchange="show_quota();">
                                <option value=""><?php echo _ph('select');?></option>
                                <?php $type = $this->Crud->read_order('leave_type', 'name', 'asc'); foreach($type as $tp): ?>
                                <option value="<?php echo $tp->id; ?>" <?php if(!empty($e_type_id)){if($e_type_id == $tp->id){echo 'selected';}} ?>><?php echo $tp->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="type_id"><?php echo _ph('leave_type');?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-3">
                <div class="form-group">
                    <div id="display_quota" class="col-xs-12">
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-xs-12" for="startdate"><?php echo _ph('duration'); ?></label>
                    <div class="col-xs-12">
                        <div class="input-daterange input-group" data-date-format="dd-mm-yyyy">
                            <input class="form-control input-sm" type="text" id="startdate" name="startdate" placeholder="<?php echo _ph('from'); ?>">
                            <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                            <input class="form-control input-sm" type="text" id="enddate" name="enddate" placeholder="<?php echo _ph('to'); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <textarea name="reason" id="reason" class="form-control" rows="3" placeholder=""></textarea>
                            <label for="reason"><?php echo _ph('reason');?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group text-center m-t-40">
                <div class="col-xs-12">
                    <button class="btn btn-primary btn-block text-uppercase bb_form_btn" type="submit">
                        <span class="btn-label"><i class="fa fa-save"></i></span> <?php echo _ph('submit'); ?>
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
    function show_quota() {
        var type = $('#type_id').val();
        $.ajax({
            url: "<?php echo base_url('leave/get_quota'); ?>",
            type: 'post',
            dataType: 'json',
            data: { type_id: type },
            success:function(data) {
                $('#display_quota').html(data->id);
            }
        });
    }
</script>