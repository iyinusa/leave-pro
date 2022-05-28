<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$s_data = array ('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Department', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Department', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Department', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Department', 'delete');
			if($role_r == 0){
				redirect(base_url('dashboard'), 'refresh');	
			}
			$data['role_c'] = $role_c;
		}
		
		// for datatable
		$data['table_rec'] = 'department/lists'; // ajax table
		$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
		$data['no_sort'] = '1,2'; // sort disable columns (1,3,5)

		$data['title'] = _ph('department');
		$data['page_active'] = 'department';
		
		$this->load->view('designs/header', $data);
		$this->load->view('department/department', $data);
		$this->load->view('designs/footer', $data);
	}

	// manage
	public function manage($param2='', $param3='') {
		$s_data = array ('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		$table = 'department';
		
		// pass parameters to view
		$data['param1'] = 'manage';
		$data['param2'] = $param2;
		$data['param3'] = $param3;

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
					$del_id = $this->input->post('d_department_id');
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
							$data['e_designations'] = $e->designation;
						}
					}
				}
			}
			
			if($_POST){
				$department_id = $this->input->post('department_id');
				$name = $this->input->post('name');
				$designations = $this->input->post('designations');
				
				// do create or update
				if($department_id) {
					$edit_designations = $this->input->post('edit_designations');
					// now check and update designation/role status
					$desig_ids = array();
					for($i=0; $i<count($designations); $i++) {
						$desig_id = $this->Crud->read_field('name', $designations[$i], 'access_role', 'id');
						if(empty($desig_id)) {
							// if designation is editted
							if(!empty($edit_designations[$i])) {
								$upd_data2['name'] = $designations[$i];
								$upd_rec2 = $this->Crud->update('id', $edit_designations[$i], 'access_role', $upd_data2);
								$desig_id = $edit_designations[$i];
							} else {
								$ins_data2['name'] = $designations[$i];
								$desig_id = $this->Crud->create('access_role', $ins_data2);
								if($desig_id > 0){$upd_rec2 = $desig_id;}
							}
						}
						if($desig_id) {$desig_ids[] = $desig_id;}
					}
					
					$upd_data['name'] = $name;
					$upd_data['designation'] = json_encode($desig_ids);
					$upd_rec = $this->Crud->update('id', $department_id, $table, $upd_data);
					if($upd_rec > 0 || !empty($upd_rec2)) {
						echo $this->Crud->msg('success', _ph('record_updated'));
						echo '<script>location.reload(false);</script>';
					} else {
						echo $this->Crud->msg('info', _ph('no_changes'));	
					}
				} else {
					if($this->Crud->check('name', $name, $table) > 0) {
						echo $this->Crud->msg('warning', _ph('record_already_exist'));
					} else {
						$ins_data['name'] = $name;
						$ins_rec = $this->Crud->create($table, $ins_data);
						if($ins_rec > 0) {
							// now register designation in role and link to department
							$desig_ids = array();
							for($i=0; $i<count($designations); $i++) {
								$desig_id = $this->Crud->read_field('name', $designations[$i], 'access_role', 'id');
								if(empty($desig_id)) {
									$ins_data2['name'] = $designations[$i];
									$desig_id = $this->Crud->create('access_role', $ins_data2);
								}
								if($desig_id) {$desig_ids[] = $desig_id;}
							}
							$upd_data['designation'] = json_encode($desig_ids);
							$this->Crud->update('id', $ins_rec, $table, $upd_data);

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

		$this->load->view('department/department_form', $data);
	}

	// list
	public function lists() {
		$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
		$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
		$role_u = $this->Crud->module($lvs_user_role_id, 'Department', 'update');
		$role_d = $this->Crud->module($lvs_user_role_id, 'Department', 'delete');
		
		// DataTable parameters
		$table = 'department';
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
			$designations = $item->designation;

			// load designations
			$desig_list = '';
			$designations = json_decode($designations);
			for($i=1; $i<=count($designations); $i++) {
				$desig_name = $this->Crud->read_field('id', $designations[$i-1], 'access_role', 'name');
				$desig_list .= '
					<div>
						'.$i.'. '.$desig_name.'
					</div>
				';
			}
			
			// add scripts to last record
			if($count == count($list)){
				$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
			} else {$script = '';}
			
			// edit 
			if($role_u == 1) {
				$edit_btn = '
					<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('department/manage/edit/'.$id).'">
						<i class="fa fa-edit"></i>
					</a>
				';	
			} else {$edit_btn = '';}
			
			// delete 
			if($role_d == 1) {
				$del_btn = '
					<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('department/manage/delete/'.$id).'">
						<i class="fa fa-trash-o"></i>
					</a>
				';	
			} else {$del_btn = '';}
			
			// add manage buttons
			$all_btn = '
				<div class="text-center">
					'.$del_btn.'
					'.$edit_btn.'
				</div>
				'.$script.'
			';
			
			$row = array();
			$row[] = $name;
			$row[] = $desig_list;
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

	// delete designation
	public function delete_designation() {
		$id = $this->input->post('id');
		$dept = $this->input->post('dept');

		if($id && $dept) {
			// check if other departments uses this designation
			$count = 0;
			$departments = $this->Crud->read('department');
			if(!empty($departments)){
				foreach($departments as $d) {
					if(in_array($id, json_decode($d->designation))){$count += 1;}
				}
			}

			// if count not more than 1, delete in role 
			if($count <= 1) {
				// delete role
				$this->Crud->delete('id', $id, 'access_role');
			}

			// remove from designation array
			$dept_desigs = $this->Crud->read_field('id', $dept, 'department', 'designation');
			$new_desigs['designation'] = array_diff(json_decode($dept_desigs), array($id));
			$this->Crud->update('id', $dept, 'department', $new_desigs);
		}
	}
}
