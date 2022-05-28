<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
	$system_name  = _sys('name');
	$system_logo  = _sys('logo');
	if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus" lang="en">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<meta charset="utf-8">
<title><?php echo _ph('login'); ?> | <?php echo $system_name; ?></title>
<meta name="description" content="">
<meta name="author" content="">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/googlefonts.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min-1.4.css">
<link rel="stylesheet" id="css-main" href="<?php echo base_url(); ?>assets/css/main.min-2.2.css">
<?php
    $skin_colour = $this->db->get_where('settings' , array(
        'type' => 'skin_colour'
    ))->row()->description; 
    if ($skin_colour != ''):?>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skins/<?php echo $skin_colour;?>.css">

<?php endif;?>
</head>
<body style="background-image: url('<?php echo base_url('assets/img/bg.jpg'); ?>'); background-size:cover; background-attachment:fixed">