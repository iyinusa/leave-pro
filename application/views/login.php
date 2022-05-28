<div class="bg-cover">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 animated fadeIn">
                    <div class="text-center"> <img alt="<?php echo $system_name; ?>" src="<?php echo base_url($system_logo); ?>" height="150px" /> 
                        <h1 class="push-15-t"><?php echo $system_name; ?></h1>
                    </div>
                    <?php echo form_open_multipart('login', array('class'=>'js-validation-login form-horizontal push-30-t', 'id'=>'bb_ajax_form')); ?>
                        <div id="bb_ajax_msg"></div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" required>
                                    <label for="email"><?php echo _ph('email_address'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="password" id="password" name="password" required>
                                    <label for="password"><?php echo _ph('password'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label class="css-input switch switch-sm switch-primary">
                                    <input type="checkbox" id="remember-me" name="remember-me">
                                    <span></span> <?php echo _ph('remember_me'); ?>? </label>
                            </div>
                            <div class="col-xs-6">
                                <div class="font-s13 text-right push-5-t"> <a href="<?php echo base_url('forgot'); ?>"><?php echo _ph('forgot_password'); ?>?</a> </div>
                            </div>
                        </div>
                        <div class="form-group push-30-t">
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <button class="btn btn-sm btn-block btn-primary bb_form_btn" type="submit"><i class="fa fa-key"></i> <?php echo _ph('login'); ?></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>