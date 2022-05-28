<div class="bg-cover">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-100 animated fadeIn">
                    <div class="text-center"> <img alt="<?php echo $system_name; ?>" src="<?php echo base_url($system_logo); ?>" height="150px" /> 
                        <h1 class="push-15-t"><?php echo $system_name; ?></h1>
                    </div>
                    <?php if(empty($change)){ ?>
						<?php echo form_open_multipart(base_url('forgot'), array('class'=>'js-validation-reminder form-horizontal push-30-t', 'id'=>'bb_ajax_form')); ?>
                            <div id="bb_ajax_msg"></div>
                            
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="email" id="email" name="email" required>
                                        <label for="reminder-email"><?php echo _ph('email_address'); ?></label>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="font-s13 text-right push-8-t"> <a href="<?php echo base_url('login'); ?>"><?php echo _ph('log_in'); ?></a> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                    <button class="btn btn-sm btn-block btn-primary bb_form_btn" type="submit"><i class="fa fa-key"></i> <?php echo _ph('reset_password'); ?></button>
                                </div>
                            </div>
                        <?php echo form_close(); ?> 
                    
					<?php } else { ?>
                    	
						<?php echo form_open_multipart(base_url('forgot/change/'.$param1.'/'.$param2), array('class'=>'js-validation-reminder form-horizontal push-30-t', 'id'=>'bb_ajax_form')); ?>
                            <div id="bb_ajax_msg"></div>
                            
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="password" id="password" name="password" required>
                                        <label for="password"><?php echo _ph('new_password'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="password" id="confirm" name="confirm" required>
                                        <label for="password"><?php echo _ph('confirm_password'); ?></label>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="font-s13 text-right push-8-t"> <a href="<?php echo base_url('login'); ?>"><?php echo _ph('log_in'); ?></a> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                    <button class="btn btn-sm btn-block btn-primary bb_form_btn" type="submit"><i class="fa fa-key"></i> <?php echo _ph('change_password'); ?></button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    <?php } ?>
               	</div>
            </div>
        </div>
    </div>
</div>
