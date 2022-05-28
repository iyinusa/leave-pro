<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
	$system_name  = _sys('name');
	$system_logo  = _sys('logo');
	if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<style>
	body{width:100%; margin:auto;}
	#m_wrap{width:100%; margin:auto; background-color:#eee; color:#666; padding:15px; font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif}
	#m_box{width:85%; margin:auto; background-color:#fff; border-radius:15px; padding:20px;}
	.mlogo{padding:10px 0px; text-align:center; margin-bottom:10px;}
	.mlogo a{text-decoration:none; outline:none; border:none;}
	.mhead{font-size:18px; padding-bottom:20px; background-color:#EEE; padding:15px; margin-bottom:15px; color:#999; text-align:center; font-weight:bold;}
	.mcontent{font-size:14px;}
	.mcontent .mname{font-size:14px; font-weight:bold;}
	table{width:100%; border:none;}
	table td{border-bottom:1px solid #eee; padding:5px;}
	table td.left{text-align:left;}
	table td.right{text-align:right;}
	table td.center{text-align:center;}
	.mfooter{text-align:center; font-size:12px; margin-top:15px;}
	.mbtn{justify-content: center; align-items: center; align-content: center; flex-wrap: wrap; width: 100%; margin: 15px auto;}
	.mbtn .btn{background-color: #eee; padding: 10px 30px; text-align: center; transition: 0.5s; color: white; box-shadow: 0 0 20px #eee; border-radius: 5px; cursor:pointer; outline:none; text-decoration:none;}
	.mbtn .btn:hover{background-color: #eee; color:#999;}
	.mbtn .btn1{background-color: #ccc; border:1px solid #ddd;}
	.mbtn .btn1 a{color:#999;}
</style>
</head>

<body>
	<div id="m_wrap"> 
        <div id="m_box">
            <div class="mhead">
                <div class="mlogo">
                    <img alt="<?php echo $system_name; ?>" src="<?php echo base_url($system_logo); ?>" style="max-width:100%;" />
                </div>
				<?php echo $subhead; ?>
            </div>
            
            <div class="mcontent">
                <?php echo $message; ?>
            </div>
        </div>
        
        <div class="mfooter">
            <b><?php echo $system_name; ?></b><br />
            &copy;<?php echo date('Y'); ?> - All right reserved.
        </div>
    </div>
</body>
</html>