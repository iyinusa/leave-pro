<?php
	$system_logo  = $this->db->get_where('settings', array('type' => 'system_logo'))->row()->description;
	if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
	
	$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
	$role_r = $this->Crud->module($lvs_user_role_id, 'Setup:System', 'read');
?>

<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading"> <?php echo _ph('system_setup');?> </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><?php echo _ph('dashboard');?></li>
                    <li><?php echo _ph('setup');?></li>
                    <li><a class="link-effect" href="<?php echo base_url('setup/systems'); ?>"><?php echo _ph('system_setup');?></a></li>
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
                                <li class="active"><a href="#tab_system"><i class="si si-settings"></i> <?php echo _ph('system');?></a></li>
                                <li class=""><a href="#tab_logo"><i class="si si-camera"></i> <?php echo _ph('logo');?></a></li>
                                <li class=""><a href="#tab_theme"><i class="si si-picture"></i> <?php echo _ph('theme');?></a></li>
                                <!--<li class=""><a href="#tab_update"><i class="si si-equalizer"></i> <?php echo _ph('update');?></a></li>-->
                            </ul>
                            
                            <div class="block-content tab-content">
                                <div class="tab-pane fade fade-up active in" id="tab_system">
                                    <div class="col-md-8"><br />
                                        <?php echo form_open(base_url('setup/systems/do_update'), array('class' => 'form-horizontal form-groups-bordered','target'=>'_top'));?>
                                        
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <input type="text" class="form-control" name="system_name" value="<?php echo $this->db->get_where('settings' , array('type' =>'system_name'))->row()->description; ?>" readonly required>
                                                        <label for="field-2"><?php echo _ph('system_name');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <input type="text" class="form-control" name="system_title" value="<?php echo $this->db->get_where('settings' , array('type' =>'system_title'))->row()->description;?>" required>
                                                        <label for="field-2"><?php echo _ph('system_title');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <textarea name="address" class="form-control" rows="3"><?php echo $this->db->get_where('settings' , array('type' =>'address'))->row()->description;?></textarea>
                                                        <label for="field-2"><?php echo _ph('address');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <input type="email" class="form-control" name="system_email" value="<?php echo $this->db->get_where('settings' , array('type' =>'system_email'))->row()->description;?>" required>
                                                        <label for="field-2"><?php echo _ph('system_email');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <input type="text" class="form-control" name="phone" value="<?php echo $this->db->get_where('settings' , array('type' =>'phone'))->row()->description;?>" required>
                                                        <label for="field-2"><?php echo _ph('phone');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <select name="language" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                                                            <?php
                                                                $fields = $this->db->list_fields('language');
                                                                foreach ($fields as $field) {
                                                                    if ($field == 'id' || $field == 'phrase') continue;
                                                                    $current_default_language	=	$this->db->get_where('settings' , array('type'=>'language'))->row()->description;
                                                                ?>
                                                                    <option value="<?php echo $field;?>" <?php if ($current_default_language == $field)echo 'selected';?>> <?php echo ucwords($field); ?> </option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                        <label for="field-2"><?php echo _ph('language');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <input type="text" class="form-control" name="purchase_code" value="<?php echo $this->db->get_where('settings' , array('type' =>'purchase_code'))->row()->description; ?>" readonly required>
                                                        <label for="field-2"><?php echo _ph('purchase_code');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('update');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_logo">
                                    <div class="col-ms-8"><br />
                                        <?php echo form_open(base_url('setup/systems/upload_logo'), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                              <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                                                  <img src="<?php echo base_url($system_logo);?>" alt="">
                                                              </div>
                                                              <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                                              <div>
                                                                  <span class="btn btn-white btn-file">
                                                                      <span class="fileinput-new btn btn-primary btn-sm"><i class="si si-check"></i> <?php echo _ph('select_image');?></span>
                                                                      <span class="fileinput-exists btn btn-warning btn-sm"><i class="si si-refresh"></i> <?php echo _ph('change');?></span>
                                                                      <input type="file" name="userfile" accept="image/*" required="required">
                                                                  </span>
                                                                  <a href="#" class="btn btn-danger btn-sm fileinput-exists" data-dismiss="fileinput"><i class="si si-trash"></i> <?php echo _ph('remove');?></a>
                                                              </div>
                                                        </div>
                                                        <label for="field-2"><?php echo _ph('photo');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-upload"></i> <?php echo _ph('upload');?></button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_theme">
                                    <div><br />
                                        <?php
                                            $skin = $this->db->get_where('settings' , array(
                                              'type' => 'skin_colour'
                                            ))->row()->description;
                                        ?>
                                        <div class="theme-div">
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="default">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/default.png"
                                                            <?php if ($skin == 'default') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="default">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('default');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                        
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="black">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/black.png"
                                                              <?php if ($skin == 'black') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="black">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="blue">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/blue.png"
                                                            <?php if ($skin == 'blue') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="blue">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="cafe">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/cafe.png"
                                                            <?php if ($skin == 'cafe') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="cafe">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="green">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/green.png"
                                                            <?php if ($skin == 'green') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="green">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="purple">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/purple.png"
                                                            <?php if ($skin == 'purple') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="purple">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="red">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/red.png"
                                                            <?php if ($skin == 'red') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="red">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="white">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/white.png"
                                                            <?php if ($skin == 'white') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="white">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                                            <div class="col-sm-4">
                                                <article class="album">
                                                    <header>
                                                        <a href="javascript:;" id="yellow">
                                                            <img src="<?php echo base_url(); ?>assets/img/skins/yellow.png"
                                                            <?php if ($skin == 'yellow') echo 'style="background-color: black; opacity: 0.3;"';?> />
                                                        </a>
                                                        <a href="javascript:;" class="album-options" id="yellow">
                                                            <i class="si si-check"></i>
                                                            <?php echo _ph('select_theme');?>
                                                        </a>
                                                    </header>
                                                </article>
                                            </div>
                        
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_update">
                                    <div class="col-md-8"><br />
                                        <?php echo form_open(base_url().'updater/update', array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data'));?>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <input type="file" name="file_name" class="form-control" data-label="<i class='fa fa-file'></i> Browse" />
                                                        <label for="field-2"><?php echo _ph('update_file');?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <div class="form-material">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-upload"></i> <?php echo _ph('install_update');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <?php echo form_close(); ?>
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

<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
    $(".theme-div").on('click', 'a', function () {
        skin = this.id;
        $.ajax({
            url: '<?php echo base_url('setup/systems/change_skin/');?>' + skin,
            success: window.location = '<?php echo base_url('setup/systems');?>'
        });
	});
</script>
