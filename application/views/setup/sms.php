<?php
	$active_sms_service = $this->db->get_where('settings' , array(
		'type' => 'active_sms_service'
	))->row()->description;
	
	$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
	$role_r = $this->Crud->module($lvs_user_role_id, 'Setup:SMS', 'read');
?>

<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading"> SMS <?php echo _ph('setup');?> </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><?php echo _ph('dashboard');?></li>
                    <li><?php echo _ph('setup');?></li>
                    <li><a class="link-effect" href="<?php echo base_url('setup/sms'); ?>">SMS <?php echo _ph('setup');?></a></li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="content content-narrow">
       	<div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="block">
                            <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                                <li class="active"><a href="#tab_active"><i class="si si-check"></i> <?php echo _ph('active');?></a></li>
                                <li class=""><a href="#tab_bulksmsng"><i class="si si-check text-<?php if ($active_sms_service == 'bulksmsng'){echo 'success';} else {echo 'danger';} ?>"></i> BulkSMS NG</a></li>
                                <li class=""><a href="#tab_clickatell"><i class="si si-check text-<?php if ($active_sms_service == 'clickatell'){echo 'success';} else {echo 'danger';} ?>"></i> Clickatell</a></li>
                                <li class=""><a href="#tab_twilio"><i class="si si-check text-<?php if ($active_sms_service == 'twilio'){echo 'success';} else {echo 'danger';} ?>"></i> Twilio</a></li>
                                <li class=""><a href="#tab_msg91"><i class="si si-check text-<?php if ($active_sms_service == 'msg91'){echo 'success';} else {echo 'danger';} ?>"></i> MSG91</a></li>
                            </ul>
                            
                            <div class="block-content tab-content">
                                <div class="tab-pane fade fade-up active in" id="tab_active">
                                    <div class="col-sm-4"><br />
                                        <?php echo form_open(base_url('setup/sms/active_service'), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                                        
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <select name="active_sms_service" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                                                                <option value=""<?php if ($active_sms_service == '') echo 'selected';?>>
                                                                    <?php echo _ph('not_selected');?>
                                                                </option>
                                                                <option value="bulksmsng"
                                                                    <?php if ($active_sms_service == 'bulksmsng') echo 'selected';?>>
                                                                        BulkSMS NG
                                                                </option>
                                                                <option value="clickatell"
                                                                    <?php if ($active_sms_service == 'clickatell') echo 'selected';?>>
                                                                        Clickatell
                                                                </option>
                                                                <option value="twilio"
                                                                    <?php if ($active_sms_service == 'twilio') echo 'selected';?>>
                                                                        Twilio
                                                                </option>
                                                                                        <option value="msg91"
                                                                    <?php if ($active_sms_service == 'msg91') echo 'selected';?>>
                                                                        MSG91
                                                                </option>
                                                                <option value="disabled"<?php if ($active_sms_service == 'disabled') echo 'selected';?>>
                                                                    <?php echo _ph('disabled');?>
                                                                </option>
                                                            </select>
                                                            <label for="field-2"><?php echo _ph('activate_a_service');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('save');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_bulksmsng">
                                    <div class="col-sm-6"><br />
                                        <?php echo form_open(base_url('setup/sms/bulksmsng'), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="bulksmsng_key" value="<?php echo $this->db->get_where('settings' , array('type' =>'bulksmsng_key'))->row()->description;?>" required>
                                                            <label for="field-2">BulkSMS Nigeria API Key</label>
                                                        </div>
                                                        <small><a href="https://goo.gl/AnWPB5" target="_blank">Setup BulkSMS Nigeria Account</a> to obtain API KEY</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material"> 
                                                            <input type="text" class="form-control" name="bulksmsng_sender" maxlength="11" value="<?php echo $this->db->get_where('settings' , array('type' =>'bulksmsng_sender'))->row()->description;?>" required>
                                                            <label for="field-2">BulkSMS SenderID</label>
                                                        </div>
                                                        <small><?php echo 'SMS '._ph('sender_name'); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('save');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_clickatell">
                                    <div class="col-sm-4"><br />
                                        <?php echo form_open(base_url('setup/sms/clickatell'), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="clickatell_user" value="<?php echo $this->db->get_where('settings' , array('type' =>'clickatell_user'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('clickatell_username');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="clickatell_password" value="<?php echo $this->db->get_where('settings' , array('type' =>'clickatell_password'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('clickatell_password');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="clickatell_api_id" value="<?php echo $this->db->get_where('settings' , array('type' =>'clickatell_api_id'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('clickatell'); ?> API ID</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('save');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_twilio">
                                    <div class="col-sm-4"><br />
                                        <?php echo form_open(base_url('setup/sms/twilio'), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="twilio_account_sid" value="<?php echo $this->db->get_where('settings' , array('type' =>'twilio_account_sid'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('twilio_account');?> SID</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="twilio_auth_token" value="<?php echo $this->db->get_where('settings' , array('type' =>'twilio_auth_token'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('twilio_auth_token');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="twilio_sender_phone_number" value="<?php echo $this->db->get_where('settings' , array('type' =>'twilio_sender_phone_number'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('registered_phone_number');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('save');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_msg91">
                                    <div class="col-sm-6"><br />
                                        <?php echo form_open(base_url('setup/sms/msg91'), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="authentication_key" value="<?php echo $this->db->get_where('settings' , array('type' =>'msg91_authentication_key'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('authentication_key');?> SID</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="sender_ID" value="<?php echo $this->db->get_where('settings' , array('type' =>'msg91_sender_ID'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('sender_ID');?></label>
                                                            <small><i class="si si-question"></i> <a href="http://help.msg91.com/article/40-what-is-a-sender-id-how-to-select-a-sender-id" target="_blank"><?php echo _ph('what_is_sender_ID?'); ?></a></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="msg91_route" value="<?php echo $this->db->get_where('settings' , array('type' =>'msg91_route'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('route');?></label>
                                                            <small><i class="si si-question"></i> If your operator supports multiple routes then give one route name. Eg: route=1 for promotional, route=4 for transactional SMS.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="msg91_country_code" value="<?php echo $this->db->get_where('settings' , array('type' =>'msg91_country_code'))->row()->description;?>" required>
                                                            <label for="field-2"><?php echo _ph('country_code');?></label>
                                                            <small><i class="si si-question"></i> 0 for international, 234 for Nigeria, 1 for USA.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('save');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
