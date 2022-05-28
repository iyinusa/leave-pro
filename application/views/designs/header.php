<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
	$system_name  = _sys('name');
	$system_logo  = _sys('logo');
	if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
	
	$role = $this->session->userdata('lvs_user_role_id');
	$lvs_user_role = $this->Crud->read_field('id', $role, 'access_role', 'name');
	
	if($page_active) {
		if($page_active == 'dashboard'){$dash_act='active';}else{$dash_act='';}
		if($page_active == 'department'){$dept_act='active';}else{$dept_act='';}
		if($page_active == 'staff'){$staff_act='active';}else{$staff_act='';}
		if($page_active == 'leave'){$leave_act='active';}else{$leave_act='';}
		if($page_active == 'leave_type'){$leave_type_act='active';}else{$leave_type_act='';}
		if($page_active == 'calendar'){$calendar_act='active';}else{$calendar_act='';}
		if($page_active == 'account'){$account_act='active';}else{$account_act='';}
		if($page_active == 'holiday'){$holiday_act='active';}else{$holiday_act='';}
		if($page_active == 'system'){$system_act='active';}else{$system_act='';}
		if($page_active == 'language'){$language_act='active';}else{$language_act='';}
		if($page_active == 'sms'){$sms_act='active';}else{$sms_act='';}
		if($page_active == 'module'){$module_act='active';}else{$module_act='';}
		if($page_active == 'role'){$role_act='active';}else{$role_act='';}
		if($page_active == 'access'){$access_act='active';}else{$access_act='';}
	}
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus" lang="en">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<meta charset="utf-8">
<title><?php echo $title.' | '.$system_name; ?></title>
<meta name="description" content="<?php echo app_meta_desc; ?>">
<meta name="author" content="">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/googlefonts.css">
<?php if($page_active != 'dashboard'){ ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/dropzonejs/dropzone.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.min.css">
<?php } ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/summernote/summernote.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min-1.4.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/slick/slick.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/slick/slick-theme.min.css">
<link rel="stylesheet" id="css-main" href="<?php echo base_url(); ?>assets/css/main.min-2.2.css">
<?php
    $skin_colour = $this->db->get_where('settings' , array(
        'type' => 'skin_colour'
    ))->row()->description; 
    if ($skin_colour != ''):?>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/<?php echo $skin_colour;?>.css">

<?php endif;?>
</head>
<body>
<div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
    <nav id="sidebar">
        <div id="sidebar-scroll">
            <div class="sidebar-content">
                <div class="side-header side-content bg-white">
                    <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close"> <i class="si si-arrow-left"></i> </button>
                    <a class="h5 text-white" href="<?php echo base_url('dashboard'); ?>"> 
                    	<img alt="" src="<?php echo base_url($system_logo); ?>" style="max-height:40px;" />
                        <span class="h4 font-w600 sidebar-mini-hide text-black"><?php if(strlen($system_name) > 15){echo substr($system_name,0,15).'...';} else {echo $system_name;} ?></span> 
                    </a> 
              	</div>
                
                <div class="side-content">
                    <ul class="nav-main">
                        
                        <?php if($this->Crud->mod_read($role, 'Dashboard') == 1){ ?>
                        <li> 
                        	<a href="<?php echo base_url('dashboard'); ?>" class="<?php echo $dash_act; ?>"><i class="si si-speedometer"></i><span class="sidebar-mini-hide"><?php echo _ph('dashboard'); ?></span></a> 
                     	</li>
                        <?php } ?>
                        
                        <?php if($this->Crud->mod_read($role, 'Department') == 1){ ?>
                        <li> 
                        	<a href="<?php echo base_url('department'); ?>" class="<?php echo $dept_act; ?>"><i class="si si-home"></i><span class="sidebar-mini-hide"><?php echo _ph('department'); ?></span></a> 
                     	</li>
                        <?php } ?>
                        
                        <?php if($this->Crud->mod_read($role, 'Staff') == 1){ ?>
                        <li> 
                        	<a href="<?php echo base_url('staff'); ?>" class="<?php echo $staff_act; ?>"><i class="si si-user"></i><span class="sidebar-mini-hide"><?php echo _ph('staff'); ?></span></a> 
                     	</li>
                        <?php } ?>
                        
                        <?php if($this->Crud->mod_read($role, 'Leave Type') == 1 || $this->Crud->mod_read($role, 'Leave') == 1){ ?>
                        <li class="<?php if($page_active=='leave_type' || $page_active=='leave'){echo 'open';} ?>"> 
                        	<a class="nav-submenu" data-toggle="nav-submenu" href="javascript:;"><i class="si si-note"></i><span class="sidebar-mini-hide">Leave</span></a>
                            <ul>
                                <?php if($this->Crud->mod_read($role, 'Leave Type') == 1){ ?>
                                <li> <a href="<?php echo base_url('leave/type'); ?>" class="<?php echo $leave_type_act; ?>"><?php echo _ph('leave_type'); ?></a> </li>
                                <?php } ?>
                                <?php if($this->Crud->mod_read($role, 'Leave') == 1){ ?>
                                <li> <a href="<?php echo base_url('leave'); ?>" class="<?php echo $leave_act; ?>"><?php echo _ph('leave'); ?></a> </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <?php if($this->Crud->mod_read($role, 'Calendar') == 1){ ?>
                        <li> 
                        	<a href="<?php echo base_url('calendar'); ?>" class="<?php echo $calendar_act; ?>"><i class="si si-calendar"></i><span class="sidebar-mini-hide"><?php echo _ph('calendar'); ?></span></a> 
                     	</li>
                        <?php } ?>
                        
                        <?php if($this->Crud->mod_read($role, 'Setup:Account') == 1 || $this->Crud->mod_read($role, 'Setup:Holiday') == 1 || $this->Crud->mod_read($role, 'Setup:System') == 1 || $this->Crud->mod_read($role, 'Setup:Language') == 1 || $this->Crud->mod_read($role, 'Setup:SMS') == 1){ ?>
                        <li class="nav-main-heading"><span class="sidebar-mini-hide">Setup</span></li>
                        <li class="<?php if($page_active=='account' || $page_active=='holiday' || $page_active=='system' || $page_active=='language' || $page_active=='sms'){echo 'open';} ?>"> 
                        	<a class="nav-submenu" data-toggle="nav-submenu" href="javascript:;"><i class="si si-globe"></i><span class="sidebar-mini-hide">Setup</span></a>
                            <ul>
                                <?php if($this->Crud->mod_read($role, 'Setup:Account') == 1){ ?>
                                <li> <a href="<?php echo base_url('setup/account'); ?>" class="<?php echo $account_act; ?>"><?php echo _ph('account'); ?></a> </li>
                                <?php } ?>
                                <?php if($this->Crud->mod_read($role, 'Setup:Holiday') == 1){ ?>
                                <li> <a href="<?php echo base_url('setup/holiday'); ?>" class="<?php echo $holiday_act; ?>"><?php echo _ph('holidays'); ?></a> </li>
                                <?php } ?>
                                <?php if($this->Crud->mod_read($role, 'Setup:System') == 1){ ?>
                                <li> <a href="<?php echo base_url('setup/systems'); ?>" class="<?php echo $system_act; ?>"><?php echo _ph('system'); ?></a> </li>
                                <?php } ?>
                                <?php if($this->Crud->mod_read($role, 'Setup:Language') == 1){ ?>
                                <li> <a href="<?php echo base_url('setup/language'); ?>" class="<?php echo $language_act; ?>"><?php echo _ph('language'); ?></a> </li>
                                <?php } ?>
                                <?php if($this->Crud->mod_read($role, 'Setup:SMS') == 1){ ?>
                                <li> <a href="<?php echo base_url('setup/sms'); ?>" class="<?php echo $sms_act; ?>">SMS</a> </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        
                        
                        <?php if($lvs_user_role == 'Super') { ?>
                        <li class="nav-main-heading"><span class="sidebar-mini-hide">Settings</span></li>
                        <li class="<?php if($page_active=='module' || $page_active=='role' || $page_active=='access'){echo 'open';} ?>"> 
                        	<a class="nav-submenu" data-toggle="nav-submenu" href="javascript:;"><i class="si si-settings"></i><span class="sidebar-mini-hide">Access Roles</span></a>
                            <ul>
                                <li> <a href="<?php echo base_url('settings/modules'); ?>" class="<?php echo $module_act; ?>">Modules</a> </li>
                                <li> <a href="<?php echo base_url('settings/roles'); ?>" class="<?php echo $role_act; ?>">Roles</a> </li>
                                <li> <a href="<?php echo base_url('settings/access'); ?>" class="<?php echo $access_act; ?>">Access CRUD</a> </li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <header id="header-navbar" class="content-mini content-mini-full">
        <ul class="nav-header pull-right">
            <li>
                <div class="btn-group">
                    <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button"> <img src="<?php echo base_url($this->session->userdata('lvs_user_pics')); ?>" alt=""> <span class="caret"></span> </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header"><?php echo _ph('account'); ?></li>
                        <li> <a tabindex="-1" href="<?php echo base_url('setup/account'); ?>"> <i class="si si-user pull-right"></i> <?php echo _ph('profile'); ?> </a> </li>
                        <li class="divider"></li>
                        <li class="dropdown-header"><?php echo _ph('action'); ?></li>
                        <li> <a tabindex="-1" href="<?php echo base_url('logout'); ?>"> <i class="si si-logout pull-right"></i><?php echo _ph('log_out'); ?></a> </li>
                    </ul>
                </div>
            </li>
        </ul>
        <ul class="nav-header pull-left">
            <li class="hidden-md hidden-lg">
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button"> <i class="fa fa-navicon"></i> </button>
            </li>
            <li class="hidden-xs hidden-sm">
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button"> <i class="fa fa-ellipsis-v"></i> </button>
            </li>
            <li class="text-muted small">
            	<b class="text-danger"><?php echo $system_name; ?></b><br />
                <span class="hidden-xs">
					<?php echo $this->session->userdata('lvs_user_othername').' <b>- '.$lvs_user_role.'</b>'; ?>
                </span>
                <span class="xs-only hidden-lg hidden-md hidden-sm">
					<?php echo substr($this->session->userdata('lvs_user_othername'),0,10).'... <b>- '.$lvs_user_role.'</b>'; ?>
                </span>
            </li>
        </ul>
    </header>