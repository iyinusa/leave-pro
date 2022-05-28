<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading"> Access CRUD </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li>Dashboard</li>
                    <li>Settings</li>
                    <li><a class="link-effect" href="<?php echo base_url('settings/access'); ?>">Access CRUD</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content content-narrow">
        <div class="block row">
            <div class="block-content">
                <div class="col-xs-12">
                	<br />
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select id="role_id" name="role_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" onchange="getModule();">
                                        <option value="">Select</option>
                                        <?php if(!empty($allrole)): ?>
                                        <?php foreach($allrole as $rol): ?>
                                            <option value="<?php echo $rol->id; ?>" <?php if(!empty($e_role_id)){if($e_role_id == $rol->id){echo 'selected';}} ?>><?php echo $rol->name; ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <label for="role_id">Role</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <table class="table table-striped small">
                        	<thead>
                                <tr>
                                    <th>Module</th>
                                    <th><u>C</u><span class="hidden-xs">reate</span></th>
                                    <th><u>R</u><span class="hidden-xs">ead</span></th>
                                    <th><u>U</u><span class="hidden-xs">pdate</span></th>
                                    <th><u>D</u><span class="hidden-xs">elete</span></th>
                                </tr>
                            </thead>
                            <tbody id="module_list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
	function getModule() {
		var hr = new XMLHttpRequest();
		var role_id = document.getElementById('role_id').value;
		var c_vars = "role_id="+role_id;
		hr.open("POST", "<?php echo base_url('settings/load_module'); ?>", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4 && hr.status == 200) {
				var data = hr.response;
				document.getElementById("module_list").innerHTML = data;
		   }
		}
		hr.send(c_vars);
		document.getElementById("module_list").innerHTML = '<div class="col-xs-12 text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></div>';
	}
	
	function saveModule(x) {
		var hr = new XMLHttpRequest();
		var rol = document.getElementById('rol').value;
		var mod = document.getElementById('mod' + x).value;
		var c = document.getElementById('c' + x);
		var r = document.getElementById('r' + x);
		var u = document.getElementById('u' + x);
		var d = document.getElementById('d' + x);
		
		if(c.checked){c = 1;} else {c = 0;}
		if(r.checked){r = 1;} else {r = 0;}
		if(u.checked){u = 1;} else {u = 0;}
		if(d.checked){d = 1;} else {d = 0;}
		var c_vars = "rol="+rol+"&mod="+mod+"&c="+c+"&r="+r+"&u="+u+"&d="+d;
		hr.open("POST", "<?php echo base_url('settings/save_module'); ?>", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4 && hr.status == 200) {
				var data = hr.response;
				document.getElementById("module_save").innerHTML = data;
		   }
		}
		hr.send(c_vars);
	}
</script>