<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$this->modules();
	}
	
	/////// MODULES
	public function modules($param1='', $param2='', $param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$permit = array('Super');
			if(!in_array($lvs_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'access_module';
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		
		// manage record
		if($param1 == 'manage') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}
					
					if($_POST){
						$del_id = $this->input->post('d_module_id');
						if($this->Crud->delete('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', _ph('record_deleted'));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', _ph('please_try_later'));
						}
						exit;	
					}
				}
			} else {
				// prepare for edit
				if($param2 == 'edit') {
					if($param3) {
						$edit = $this->Crud->read_single('id', $param3, $table);
						if(!empty($edit)) {
							foreach($edit as $e) {
								$data['e_id'] = $e->id;
								$data['e_name'] = $e->name;
							}
						}
					}
				}
				
				if($_POST){
					$module_id = $this->input->post('module_id');
					$name = $this->input->post('name');
					
					// do create or update
					if($module_id) {
						$upd_data = array(
							'name' => $name
						);
						$upd_rec = $this->Crud->update('id', $module_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', _ph('record_updated'));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', _ph('no_changes'));	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', _ph('record_already_exist'));
						} else {
							$ins_data = array(
								'name' => $name
							);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', _ph('record_created'));
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', _ph('please_try_later'));	
							}	
						}
					}
					exit;	
				}
			}
		}
		
		// record listing
		if($param1 == 'list') {
			// DataTable parameters
			$table = 'access_module';
			$column_order = array('name');
			$column_search = array('name');
			$order = array('id' => 'desc');
			$where = '';
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$name = $item->name;
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('settings/modules/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('settings/modules/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $name;
				$row[] = $all_btn;
	
				$data[] = $row;
				$count += 1;
			}
	
			$output = array(
				"draw" => intval($_POST['draw']),
				"recordsTotal" => $this->Crud->datatable_count($table, $where),
				"recordsFiltered" => $this->Crud->datatable_filtered($table, $column_order, $column_search, $order, $where),
				"data" => $data,
			);
			
			//output to json format
			echo json_encode($output);
			exit;
		}
		
		if($param1 == 'manage') { // view for form data posting
			$this->load->view('setting/module_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'settings/modules/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
			$data['title'] = _ph('modules');
			$data['page_active'] = 'module';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setting/module', $data);
			$this->load->view('designs/footer', $data);
		}
	
	}
	
	/////// ROLES
	public function roles($param1='', $param2='', $param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$permit = array('Super');
			if(!in_array($lvs_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$company_id = $this->session->userdata('lvs_user_company');
		$table = 'access_role';
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		
		// manage record
		if($param1 == 'manage') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}
					
					if($_POST){
						$del_id = $this->input->post('d_role_id');
						if($this->Crud->delete('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', _ph('record_deleted'));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', _ph('please_try_later'));
						}
						exit;	
					}
				}
			} else {
				// prepare for edit
				if($param2 == 'edit') {
					if($param3) {
						$edit = $this->Crud->read_single('id', $param3, $table);
						if(!empty($edit)) {
							foreach($edit as $e) {
								$data['e_id'] = $e->id;
								$data['e_name'] = $e->name;
							}
						}
					}
				}
				
				if($_POST){
					$role_id = $this->input->post('role_id');
					$name = $this->input->post('name');
					
					// do create or update
					if($role_id) {
						$upd_data = array(
							'name' => $name
						);
						$upd_rec = $this->Crud->update('id', $role_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', _ph('record_updated'));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', _ph('no_changes'));	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', _ph('record_already_exist'));
						} else {
							$ins_data = array(
								'name' => $name
							);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', _ph('record_created'));
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', _ph('please_try_later'));	
							}	
						}
					}
					exit;	
				}
			}
		}
		
		// record listing
		if($param1 == 'list') {
			// DataTable parameters
			$table = 'access_role';
			$column_order = array('name');
			$column_search = array('name');
			$order = array('id' => 'desc');
			$where = '';
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$name = $item->name;
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('settings/roles/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('settings/roles/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $name;
				$row[] = $all_btn;
	
				$data[] = $row;
				$count += 1;
			}
	
			$output = array(
				"draw" => intval($_POST['draw']),
				"recordsTotal" => $this->Crud->datatable_count($table, $where),
				"recordsFiltered" => $this->Crud->datatable_filtered($table, $column_order, $column_search, $order, $where),
				"data" => $data,
			);
			
			//output to json format
			echo json_encode($output);
			exit;
		}
		
		if($param1 == 'manage') { // view for form data posting
			$this->load->view('setting/role_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'settings/roles/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
			$data['title'] = _ph('roles');
			$data['page_active'] = 'role';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setting/role', $data);
			$this->load->view('designs/footer', $data);
		}
	
	}
	
	/////// ACCESS CRUD
	public function access() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$permit = array('Super');
			if(!in_array($lvs_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$company_id = $this->session->userdata('lvs_user_company');
		$data['allrole'] = $this->Crud->read_order('access_role', 'name', 'asc');
			
		$data['title'] = _ph('access').' CRUD';
		$data['page_active'] = 'access';
		
		$this->load->view('designs/header', $data);
		$this->load->view('setting/access', $data);
		$this->load->view('designs/footer', $data);
	
	}
	
	public function load_module() {
		$mod_list = '';
		
		if($_POST) {
			$role_id = $_POST['role_id'];
			
			// load modules
			$ct = 0;
			$modules = $this->Crud->read_order('access_module', 'name', 'asc');
			if(!empty($modules)) {
				foreach($modules as $mod) {
					$mod_id = $mod->id;	
					$mod_name = $mod->name;	
					
					// crud check status
					$c_chk = '';
					$r_chk = '';
					$u_chk = '';
					$d_chk = '';
					
					// load crud
					$gmod = $this->Crud->read_field('role_id', $role_id, 'access', 'crud');
					if(!empty($gmod)) {
						$gmod = json_decode($gmod);
						foreach($gmod as $gm) {
							$gm = explode('.', $gm);
							if($mod_id == $gm[0]) {
								if($gm[1] == 1){$c_chk = 'checked';} // create status
								if($gm[2] == 1){$r_chk = 'checked';} // read status
								if($gm[3] == 1){$u_chk = 'checked';} // update status
								if($gm[4] == 1){$d_chk = 'checked';} // delete status
								break;
							}
						}
					}
					
					// create
					$c = '
						<label class="css-input switch switch-sm switch-success">
							<input id="c'.$ct.'" type="checkbox" oninput="saveModule('.$ct.')" '.$c_chk.'><span></span>
                    	</label>
					';
					
					// read
					$r = '
						<label class="css-input switch switch-sm switch-success">
							<input id="r'.$ct.'" type="checkbox" oninput="saveModule('.$ct.')" '.$r_chk.'><span></span>
                    	</label>
					';
					
					// update
					$u = '
						<label class="css-input switch switch-sm switch-success">
							<input id="u'.$ct.'" type="checkbox" oninput="saveModule('.$ct.')" '.$u_chk.'><span></span>
                    	</label>
					';
					
					// delete
					$d = '
						<label class="css-input switch switch-sm switch-success">
							<input id="d'.$ct.'" type="checkbox" oninput="saveModule('.$ct.')" '.$d_chk.'><span></span>
                    	</label>
					';
					
					$mod_list .= '
						<tr>
							<td>'.$mod_name.' <input type="hidden" id="mod'.$ct.'" value="'.$mod_id.'" /></td>
							<td>'.$c.'</td>
							<td>'.$r.'</td>
							<td>'.$u.'</td>
							<td>'.$d.'</td>
						</tr>
					';
					
					$ct += 1;
				}
			}
		}
		
		echo '<input type="hidden" id="rol" value="'.$role_id.'" />'.$mod_list;
	}
	
	public function save_module() {
		if($_POST) {
			$rol = $_POST['rol'];
			$mod = $_POST['mod'];
			$c = $_POST['c'];
			$r = $_POST['r'];
			$u = $_POST['u'];
			$d = $_POST['d'];
			
			$crud = array();
			if($this->Crud->check('role_id', $rol, 'access') > 0) {
				// get module crud in access
				$ct = 0;
				$gmod = $this->Crud->read_field('role_id', $rol, 'access', 'crud');
				$gmod = json_decode($gmod);
				foreach($gmod as $gm) {
					$gm = explode('.', $gm); // break crud
					if($mod == $gm[0]) {
						unset($gmod[$ct]); // first remove module
						break;
					}
					$ct += 1;
				}
				$crud[] = $mod.'.'.$c.'.'.$r.'.'.$u.'.'.$d; // recreate module crud
				$new_crud = array_merge($gmod, $crud); // add new to existing crud
				$upd['crud'] = json_encode($new_crud);
				$this->Crud->update('role_id', $rol, 'access', $upd);
			} else {
				$crud[] = $mod.'.'.$c.'.'.$r.'.'.$u.'.'.$d;
				
				$reg['role_id'] = $rol;
				$reg['crud'] = json_encode($crud);
				$this->Crud->create('access', $reg);
			}
		}
	}
}
