<?php echo form_open_multipart('staff/'.$param1.'/'.$param2.'/'.$param3, array('id'=>'bb_ajax_form', 'class'=>'form-horizontal')); ?>
<div class="row">
    <div id="bb_ajax_msg"></div>

    <?php if($param2 == 'delete') { // delete view ?>
        <div class="col-xs-12 text-center">
            <h3><b><?php echo _ph('are_you_sure'); ?>?</b></h3><br/>
            <input type="hidden" name="d_user_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
        </div>
        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <span class="btn-label"><i class="fa fa-trash-o"></i></span> <?php echo _ph('yes'); ?>
                </button>
            </div>
        </div>
    <?php } else { // insert/edit view ?>
        <div class="col-sm-6">
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li><button type="button" data-toggle="block-option" data-action="content_toggle"></button></li>
                    </ul>
                    <h3 class="block-title text-primary"><?php echo _ph('personal_details'); ?></h3>
                </div>
                
                <div class="block-content">
                    <div class="row">  
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input type="hidden" name="user_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                        <input class="form-control" type="text" id="othername" name="othername" value="<?php if(!empty($e_othername)){echo $e_othername;} ?>" required>
                                        <label for="othername"><?php echo _ph('othername'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="lastname" name="lastname" value="<?php if(!empty($e_lastname)){echo $e_lastname;} ?>" required>
                                        <label for="lastname"><?php echo _ph('lastname'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="email" name="email" value="<?php if(!empty($e_email)){echo $e_email;} ?>" required>
                                        <label for="email"><?php echo _ph('email'); ?> <span class="text-danger small" style="font-size:xx-small;"><i>(Login ID, <?php echo _ph('use_official_email'); ?>)</i></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="phone" name="phone" value="<?php if(!empty($e_phone)){echo $e_phone;} ?>" required>
                                        <label for="phone"><?php echo _ph('phone'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="sex" name="sex" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <?php $sex = array('Male', 'Female'); for($i=0; $i<count($sex); $i++): ?>
                                            <option value="<?php echo $sex[$i]; ?>" <?php if(!empty($e_sex)){if($e_sex == $sex[$i]){echo 'selected';}} ?>><?php echo $sex[$i]; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <label for="sex"><?php echo _ph('gender');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input type="text" class="form-control js-datepicker" id="dob" name="dob" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php if(!empty($e_dob)){echo $e_dob;} ?>">
                                        <label for="dob"><?php echo _ph('date_of_birth');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <textarea name="address" id="address" class="form-control" rows="4" placeholder=""><?php if(!empty($e_address)){echo $e_address;} ?></textarea>
                                        <label for="address"><?php echo _ph('address');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="state" name="state" value="<?php if(!empty($e_state)){echo $e_state;} ?>">
                                        <label for="state"><?php echo _ph('state'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="country_id" name="country_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <?php $country = $this->Crud->read_order('country', 'name', 'asc'); foreach($country as $ct): ?>
                                            <option value="<?php echo $ct->id; ?>" <?php if(!empty($e_country_id)){if($e_country_id == $ct->id){echo 'selected';}} else {if($ct->name == 'Nigeria'){echo 'selected';}} ?>><?php echo $ct->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="country_id"><?php echo _ph('country');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12"><h3 class="block-title text-primary"><?php echo _ph('next_of_kin'); ?></h3><br/></div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="kin_relation" name="kin_relation" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <?php $relation = array('Brother', 'Sister', 'Father', 'Mother', 'In-Law', 'Cousin', 'Niece', 'Nephew', 'Mentor', 'Guardian', 'Friend'); for($i=0; $i<count($relation); $i++): ?>
                                            <option value="<?php echo $relation[$i]; ?>" <?php if(!empty($e_kin_relation)){if($e_kin_relation == $relation[$i]){echo 'selected';}} ?>><?php echo $relation[$i]; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <label for="kin_relation"><?php echo _ph('relationship');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="kin_name" name="kin_name" value="<?php if(!empty($e_kin_name)){echo $e_kin_name;} ?>">
                                        <label for="kin_name"><?php echo _ph('fullname'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="kin_email" name="kin_email" value="<?php if(!empty($e_kin_email)){echo $e_kin_email;} ?>">
                                        <label for="kin_email"><?php echo _ph('email'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="kin_phone" name="kin_phone" value="<?php if(!empty($e_kin_phone)){echo $e_kin_phone;} ?>">
                                        <label for="kin_phone"><?php echo _ph('phone'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <textarea name="kin_address" id="kin_address" class="form-control" rows="4" placeholder=""><?php if(!empty($e_kin_address)){echo $e_kin_address;} ?></textarea>
                                        <label for="kin_address"><?php echo _ph('address');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="kin_state" name="kin_state" value="<?php if(!empty($e_kin_state)){echo $e_kin_state;} ?>">
                                        <label for="kin_state"><?php echo _ph('state'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="kin_country_id" name="kin_country_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <?php $country = $this->Crud->read_order('country', 'name', 'asc'); foreach($country as $ct): ?>
                                            <option value="<?php echo $ct->id; ?>" <?php if(!empty($e_kin_country_id)){if($e_kin_country_id == $ct->id){echo 'selected';}} else {if($ct->name == 'Nigeria'){echo 'selected';}} ?>><?php echo $ct->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="kin_country_id"><?php echo _ph('country');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li><button type="button" data-toggle="block-option" data-action="content_toggle"></button></li>
                    </ul>
                    <h3 class="block-title text-primary"><?php echo _ph('official_details'); ?></h3>
                </div>
                
                <div class="block-content">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;" data-trigger="fileinput">
                                                <?php if(!empty($e_picture)) {
                                                    $pics_path = $this->Crud->read_field('id', $e_picture, 'img', 'pics_square');
                                                    if(empty($pics_path)){$pics_path = 'assets/img/avatars/avatar.png';}
                                                } else {$pics_path = 'assets/img/avatars/avatar.png';} ?>
                                                <img src="<?php echo base_url($pics_path);?>" alt="" style="width:100%;">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new btn btn-primary btn-sm"><i class="si si-check"></i> <?php echo _ph('select_image');?></span>
                                                    <span class="fileinput-exists btn btn-warning btn-sm"><i class="si si-refresh"></i> <?php echo _ph('change');?></span>
                                                    <input type="file" name="userfile" accept="image/*">
                                                </span>
                                                <a href="#" class="btn btn-danger btn-sm fileinput-exists" data-dismiss="fileinput"><i class="si si-trash"></i> <?php echo _ph('remove');?></a>
                                            </div>
                                        </div>
                                        <label for="field-2"><?php echo _ph('passport');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="line_manager_id" name="line_manager_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <option value="0"><?php echo _ph('none');?></option>
                                            <?php $line = $this->Crud->read_order('user', 'othername', 'asc'); foreach($line as $lm): ?>
                                            <option value="<?php echo $lm->id; ?>" <?php if(!empty($e_line_manager_id)){if($e_line_manager_id == $lm->id){echo 'selected';}} ?>><?php echo $lm->othername.' '.$lm->lastname; ?> (<?php echo $lm->staff_no; ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="line_manager_id"><?php echo _ph('line_manager');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="staff_no" name="staff_no" value="<?php if(!empty($e_staff_no)){echo $e_staff_no;} ?>" required>
                                        <label for="staff_no"><?php echo _ph('staff'); ?> ID</label>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input type="text" class="form-control js-datepicker" id="employ_date" name="employ_date" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php if(!empty($e_employ_date)){echo $e_employ_date;} ?>">
                                        <label for="employ_date"><?php echo _ph('employment_date');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="dept_id" name="dept_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" onchange="load_desig();">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <?php $dept = $this->Crud->read_order('department', 'name', 'asc'); foreach($dept as $dp): ?>
                                            <option value="<?php echo $dp->id; ?>" <?php if(!empty($e_dept_id)){if($e_dept_id == $dp->id){echo 'selected';}} ?>><?php echo $dp->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="dept_id"><?php echo _ph('department');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="desig_id" name="desig_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" onchange="load_roles();">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <?php if(!empty($desigs_list)){echo $desigs_list;} ?>
                                        </select>
                                        <label for="desig_id"><?php echo _ph('designation');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <div>    
                                            <label class="css-input switch switch-sm switch-primary">
                                                <input id="current" name="current" type="checkbox" onchange="toogle_current();" <?php if(!empty($e_current)){echo 'checked';} ?>><span></span>
                                            </label>
                                        </div>
                                        <label for="current"><?php echo _ph('current'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input type="text" class="form-control js-datepicker" id="exit_date" name="exit_date" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php if(!empty($e_exit_date)){echo $e_exit_date;} ?>" <?php if(!empty($e_current)){echo 'disabled';} ?>>
                                        <label for="exit_date"><?php echo _ph('exit_date');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="role_id" name="role_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true">
                                            <option value=""><?php echo _ph('select');?></option>
                                            <?php if(!empty($roles_list)){echo $roles_list;} ?>
                                        </select>
                                        <label for="role_id"><?php echo _ph('access_role');?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="password" name="password" value="<?php if(empty($e_id)){echo substr(md5(rand()),0,6);} ?>">
                                        <label for="password"><?php if(empty($e_id)){echo _ph('password');} else {echo _ph('new_password');} ?></label>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <div>    
                                            <label class="css-input switch switch-sm switch-primary">
                                                <input id="activate" name="activate" type="checkbox" <?php if(!empty($e_activate) || empty($e_id)){echo 'checked';} ?>><span></span>
                                            </label>
                                        </div>
                                        <label for="activate"><small><?php echo _ph('allow_login'); ?></small></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(empty($e_id)): ?>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <div>    
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input id="send_email" name="send_email" type="checkbox" checked><span></span>
                                                </label>
                                            </div>
                                            <label for="send_email"><small><?php echo _ph('email_notification'); ?></small></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <?php 
                                                $active_sms = _sys('sms');
                                                if($active_sms == 'disabled' || empty($active_sms)) {
                                                    echo '<b class="text-danger">'._ph('no_active').' SMS '._ph('service').'</b>';
                                                } else {
                                            ?>
                                            <div>    
                                                <label class="css-input switch switch-sm switch-primary">
                                                    <input id="send_sms" name="send_sms" type="checkbox" checked><span></span>
                                                </label>
                                            </div>
                                            <?php } ?>
                                            <label for="send_sms"><small><?php echo 'SMS '._ph('notification'); ?></small></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    
                        <div class="col-xs-12"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12"><hr /></div>

        <div class="col-sm-6 col-sm-offset-3">
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
<script>jQuery(function(){App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs', 'content_toggle']);});</script>
<script>
    function toogle_current() {
        if($('#current').prop('checked')) {
            $('#exit_date').val('');
            $('#exit_date').attr('disabled', 'disabled');
        } else {
            $('#exit_date').removeAttr('disabled');
        }
    }
    
    function load_desig() {
        var dept_id = $('#dept_id').val();
        $.ajax({
            url: "<?php echo base_url('staff/load_designation'); ?>",
            type: 'post',
            dataType: 'json',
            data: {id: dept_id},
            success: function(response) {
                $('#desig_id').html(response.desigs);
                $('#role_id').html(response.roles);
            }
        });
    }

    function load_roles() {
        var desig_id = $('#desig_id').val();
        $.ajax({
            url: "<?php echo base_url('staff/load_roles'); ?>",
            type: 'post',
            dataType: 'json',
            data: {id: desig_id},
            success: function(response) {
                $('#role_id').html(response.roles);
            }
        });
    }
</script>