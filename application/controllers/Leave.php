<?php defined('BASEPATH') or exit('No direct script access allowed');

class Leave extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$s_data = array('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		if ($this->session->userdata('logged_in') == false) {
			redirect(base_url('login'), 'refresh');
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Leave', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Leave', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Leave', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Leave', 'delete');
			if ($role_r == 0) {
				redirect(base_url('dashboard'), 'refresh');
			}
			$data['role_c'] = $role_c;
		}
		
		// for datatable
		$data['table_rec'] = 'leave/lists'; // ajax table
		$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
		$data['no_sort'] = '4'; // sort disable columns (1,3,5)

		$data['title'] = _ph('leave');
		$data['page_active'] = 'leave';

		$this->load->view('designs/header', $data);
		$this->load->view('leave/leave', $data);
		$this->load->view('designs/footer', $data);
	}

	// manage
	public function manage($param2 = '', $param3 = '')
	{
		$s_data = array('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		$table = 'user';
		
		// pass parameters to view
		$data['param1'] = 'manage';
		$data['param2'] = $param2;
		$data['param3'] = $param3;

		// prepare for delete
		if ($param2 == 'delete') {
			if ($param3) {
				$edit = $this->Crud->read_single('id', $param3, $table);
				if (!empty($edit)) {
					foreach ($edit as $e) {
						$data['d_id'] = $e->id;
					}
				}

				if ($_POST) {
					$del_id = $this->input->post('d_user_id');
					if ($this->Crud->delete('id', $del_id, $table) > 0) {
						// delete staff record
						$this->Crud->delete('user_id', $del_id, 'staff');

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
			if ($param2 == 'edit') {
				if ($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if (!empty($edit)) {
						foreach ($edit as $e) {
							$data['e_id'] = $e->id;
							$data['e_staff_no'] = $e->staff_no;
							$data['e_email'] = $e->email;
							$data['e_phone'] = $e->phone;
							$data['e_lastname'] = $e->lastname;
							$data['e_othername'] = $e->othername;
							$data['e_sex'] = $e->sex;
							if (!empty($e->dob)) {
								$data['e_dob'] = date('d-m-Y', strtotime($e->dob));
							}
							$data['e_address'] = $e->address;
							$data['e_state'] = $e->state;
							$data['e_country_id'] = $e->country_id;
							$data['e_pics'] = $e->pics;
							$data['e_activate'] = $e->activate;
							$data['e_dept_id'] = $e->dept_id;
							$data['e_desig_id'] = $e->desig_id;
							$data['e_role_id'] = $e->role_id;
							$data['e_picture'] = $e->pics;

							// load designations
							$desigs_list = '';
							$desigs = $this->Crud->read_field('id', $e->dept_id, 'department', 'designation');
							if (count($desigs) > 0) {
								$desigs = json_decode($desigs);
								for ($i = 0; $i < count($desigs); $i++) {
									$desig_name = $this->Crud->read_field('id', $desigs[$i], 'access_role', 'name');
									if ($desigs[$i] == $e->desig_id) {
										$desig_act = 'selected';
									} else {
										$desig_act = '';
									}
									$desigs_list .= '<option value="' . $desigs[$i] . '" ' . $desig_act . '>' . $desig_name . '</option>';
								}
								$data['desigs_list'] = $desigs_list;
							}

							// load roles
							$roles_list = '';
							$roles = $this->Crud->read_order('access_role', 'name', 'asc');
							if (!empty($roles)) {
								foreach ($roles as $role) {
									if ($role->id == $e->role_id) {
										$role_active = 'selected';
									} else {
										$role_active = '';
									}
									$roles_list .= '<option value="' . $role->id . '" ' . $role_active . '>' . $role->name . '</option>';
								}
								$data['roles_list'] = $roles_list;
							}

							// get staff details
							$staff = $this->Crud->read_single('user_id', $e->id, 'staff');
							if (!empty($staff)) {
								foreach ($staff as $s) {
									$data['e_line_manager_id'] = $s->line_manager_id;
									if (!empty($s->employ_date)) {
										$data['e_employ_date'] = date('d-m-Y', strtotime($s->employ_date));
									}
									$data['e_current'] = $s->current;
									if (!empty($s->exit_date)) {
										$data['e_exit_date'] = date('d-m-Y', strtotime($s->exit_date));
									}
									$data['e_kin_relation'] = $s->kin_relation;
									$data['e_kin_name'] = $s->kin_name;
									$data['e_kin_email'] = $s->kin_email;
									$data['e_kin_phone'] = $s->kin_phone;
									$data['e_kin_address'] = $s->kin_address;
									$data['e_kin_state'] = $s->kin_state;
									$data['e_kin_country_id'] = $s->kin_country_id;
								}
							}
						}
					}
				}
			}

			if ($_POST) {
				$user_id = $this->input->post('user_id');
				$line_manager_id = $this->input->post('line_manager_id');
				$employ_date = date('Y-m-d', strtotime($this->input->post('employ_date')));
				if ($this->input->post('current')) {
					$current = 1;
				} else {
					$current = 0;
				}
				$exit_date = date('Y-m-d', strtotime($this->input->post('exit_date')));
				$staff_no = $this->input->post('staff_no');
				$password = $this->input->post('password');
				$email = $this->input->post('email');
				$phone = $this->input->post('phone');
				$lastname = $this->input->post('lastname');
				$othername = $this->input->post('othername');
				$sex = $this->input->post('sex');
				$dob = $this->input->post('dob');
				$address = $this->input->post('address');
				$state = $this->input->post('state');
				$country_id = $this->input->post('country_id');
				$activate = $this->input->post('activate');
				$dept_id = $this->input->post('dept_id');
				$desig_id = $this->input->post('desig_id');
				$role_id = $this->input->post('role_id');
				if ($this->input->post('activate')) {
					$activate = 1;
				} else {
					$activate = 0;
				}

				$kin_relation = $this->input->post('kin_relation');
				$kin_name = $this->input->post('kin_name');
				$kin_email = $this->input->post('kin_email');
				$kin_phone = $this->input->post('kin_phone');
				$kin_address = $this->input->post('kin_address');
				$kin_state = $this->input->post('kin_state');
				$kin_country_id = $this->input->post('kin_country_id');

				if ($this->input->post('send_email')) {
					$send_email = 1;
				} else {
					$send_email = 0;
				}
				if ($this->input->post('send_sms')) {
					$send_sms = 1;
				} else {
					$send_sms = 0;
				}
				
				// do create or update
				if ($user_id) {
					if (!empty($password)) {
						$upd_data['password'] = md5($password);
					}
					$upd_data['staff_no'] = $staff_no;
					$upd_data['email'] = $email;
					$upd_data['phone'] = $phone;
					$upd_data['lastname'] = $lastname;
					$upd_data['othername'] = $othername;
					$upd_data['sex'] = $sex;
					$upd_data['dob'] = date('Y-m-d', strtotime($dob));
					$upd_data['address'] = $address;
					$upd_data['state'] = $state;
					$upd_data['country_id'] = $country_id;
					$upd_data['activate'] = $activate;
					$upd_data['dept_id'] = $dept_id;
					$upd_data['role_id'] = $role_id;
					$upd_data['desig_id'] = $desig_id;
					$upd_rec = $this->Crud->update('id', $user_id, $table, $upd_data);
					
					// update staff details
					$upd_staff['line_manager_id'] = $line_manager_id;
					if ($current == 1) {
						$upd_staff['employ_date'] = $employ_date;
					}
					$upd_staff['current'] = $current;
					$upd_staff['kin_relation'] = $kin_relation;
					$upd_staff['kin_name'] = $kin_name;
					$upd_staff['kin_email'] = $kin_email;
					$upd_staff['kin_phone'] = $kin_phone;
					$upd_staff['kin_address'] = $kin_address;
					$upd_staff['kin_state'] = $kin_state;
					$upd_staff['kin_country_id'] = $kin_country_id;
					$upd_staff = $this->Crud->update('user_id', $user_id, 'staff', $upd_staff);

					//check picture upload
					if (isset($_FILES['userfile']['name'])) {
						$resp = $this->upload_pics($user_id, 'userfile');
						if (!empty($resp->status)) {
							if ($resp->status == 1) {
								$upd_pics = $this->Crud->update('id', $user_id, $table, array('pics' => $resp->id));
							}
						}
					}

					if ($upd_rec > 0 || !empty($upd_staff) || !empty($upd_pics)) {
						echo $this->Crud->msg('success', _ph('record_updated'));
						echo '<script>location.reload(false);</script>';
					} else {
						echo $this->Crud->msg('info', _ph('no_changes'));
					}
				} else {
					if ($this->Crud->check('staff_no', $staff_no, $table) > 0 || $this->Crud->check('email', $email, $table) > 0) {
						echo $this->Crud->msg('warning', _ph('record_already_exist'));
					} else {
						$ins_data['username'] = time();
						if (!empty($password)) {
							$ins_data['password'] = md5($password);
						}
						$ins_data['staff_no'] = $staff_no;
						$ins_data['email'] = $email;
						$ins_data['phone'] = $phone;
						$ins_data['lastname'] = $lastname;
						$ins_data['othername'] = $othername;
						$ins_data['sex'] = $sex;
						$ins_data['dob'] = date('Y-m-d', strtotime($dob));
						$ins_data['address'] = $address;
						$ins_data['state'] = $state;
						$ins_data['country_id'] = $country_id;
						$ins_data['activate'] = $activate;
						$ins_data['dept_id'] = $dept_id;
						$ins_data['role_id'] = $role_id;
						$ins_data['desig_id'] = $desig_id;
						$ins_data['activate'] = 1;
						$ins_data['reg_date'] = date(fdate);
						$ins_rec = $this->Crud->create($table, $ins_data);
						if ($ins_rec > 0) {
							// save staff details
							$ins_staff['line_manager_id'] = $line_manager_id;
							$ins_staff['user_id'] = $ins_rec;
							if ($current == 1) {
								$ins_staff['employ_date'] = $employ_date;
							}
							$ins_staff['current'] = $current;
							$ins_staff['kin_relation'] = $kin_relation;
							$ins_staff['kin_name'] = $kin_name;
							$ins_staff['kin_email'] = $kin_email;
							$ins_staff['kin_phone'] = $kin_phone;
							$ins_staff['kin_address'] = $kin_address;
							$ins_staff['kin_state'] = $kin_state;
							$ins_staff['kin_country_id'] = $kin_country_id;
							$ins_staff['reg_date'] = date(fdate);
							$this->Crud->create('staff', $ins_staff);

							//check picture upload
							if (isset($_FILES['userfile']['name'])) {
								$resp = $this->upload_pics($ins_rec, 'userfile');
								if (!empty($resp->status)) {
									if ($resp->status == 1) {
										$this->Crud->update('id', $ins_rec, $table, array('pics' => $resp->id));
									}
								}
							}

							// check for email notification
							$system_name = _sys('name');
							if ($send_email) {
								$email_result = '';
								$from = _sys('email');
								$subject = 'Account Setup';
								$name = $system_name;
								$sub_head = 'Account Setup Instruction';

								$body = '
									<div class="mname">Dear ' . ucwords($othername) . ',</div><br/>
									You account is completely setup on ' . $system_name . ', see your authentication details below:<br /><br />
									<b>UserID:</b> ' . $email . '<br/>
									<b>Password:</b> ' . $password . '.<br /><br/>
									Kindly click below link to login.
									<div class="mbtn"><a href="' . base_url('login') . '" class="btn btn-primary">Login Now</a></div>In case button do not work, kindly copy and paste below link to browser.<br />' . base_url('login') . '<br /><br />
									Warm Regards.
								';

								$this->Crud->send_email($email, $from, $subject, $body, $name, $sub_head);
							}

							// check for sms notification
							if ($send_sms) {
								$sms_body = 'Dear ' . $othername . ', your account is setup on ' . $system_name . '. Use UserID (' . $email . ') and Password (' . $password . ') to login via ' . base_url('login');
								$this->Sms->send_sms($sms_body, $phone);
							}

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

		$this->load->view('leave/leave_form', $data);
	}

	// list
	public function lists()
	{
		$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
		$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
		$role_u = $this->Crud->module($lvs_user_role_id, 'Staff', 'update');
		$role_d = $this->Crud->module($lvs_user_role_id, 'Staff', 'delete');
		
		// DataTable parameters
		$table = 'leave';
		$column_order = array('id', 'start_date', 'end_date', 'reason', 'status');
		$column_search = array('id', 'start_date', 'end_date', 'reason', 'status');
		$order = array('id' => 'desc');
		$where = '';
		
		// load data into table
		$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
		$data = array();
		// $no = $_POST['start'];
		$count = 1;
		foreach ($list as $item) {
			$id = $item->id;
			$staff_id = $item->staff_id;
			$type_id = $item->type_id;
			$start_date = $item->start_date;
			$end_date = $item->end_date;
			$days = $item->days;
			$reason = $item->reason;
			$status = $item->status;

			// get staff name and picture
			$staff_name = $this->Crud->read_field('id', $staff_id, 'user', 'othername').' '.$this->Crud->read_field('id', $staff_id, 'user', 'lastname');
			$pics = $this->Crud->read_field('id', $staff_id, 'user', 'pics');
			$pics_path = $this->Crud->read_field('id', $pics, 'img', 'pics_square');
			if (empty($pics_path)) {
				$pics_path = 'assets/img/avatars/avatar.png';
			}

			// get type
			$leave_type = $this->Crud->read_field('id', $type_id, 'leave_type', 'name');
			$leave_quota = $this->Crud->read_field('id', $type_id, 'leave_type', 'quota');

			if($status == 'Approved') {
				$status_mark = 'success';
			} else if($status == 'Pending') {
				$status_mark = 'warning';
			} else if($status == 'Rejected') {
				$status_mark = 'danger';
			}

			if(strlen($reason) > 15){$reason = substr($reason,0,15).'...';}
			
			// add scripts to last record
			if ($count == count($list)) {
				$script = '<script src="' . base_url('assets/js/jsform.js') . '"></script>';
			} else {
				$script = '';
			}
			
			// edit 
			if ($role_u == 1) {
				$edit_btn = '
					<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage ' . $leave_type . ' (' . $staff_name . ')" pageName="' . base_url('leave/manage/edit/' . $id) . '" pageSize="">
						<i class="fa fa-edit"></i>
					</a>
				';
			} else {
				$edit_btn = '';
			}
			
			// delete 
			if ($role_d == 1) {
				$del_btn = '
					<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete ' . $leave_type . ' (' . $staff_name . ')" pageName="' . base_url('leave/manage/delete/' . $id) . '">
						<i class="fa fa-trash-o"></i>
					</a>
				';
			} else {
				$del_btn = '';
			}
			
			// add manage buttons
			$all_btn = '
				<div class="text-center">
					' . $del_btn . '
					' . $edit_btn . '
				</div>
				' . $script . '
			';

			$row = array();
			$row[] = '<img class="img-avatar img-avatar32 img-avatar-thumb" src="' . base_url($pics_path) . '" alt=""> <b>' . $staff_name . '</b>';
			$row[] = $leave_type . '<br /><small class="text-muted">- ' . $reason . '</small>';
			$row[] = date('M d, Y', strtotime($start_date)) . '<br/>' . date('M d, Y', strtotime($end_date)).' <span class="text-muted">('.$days.')</span>';
			$row[] = '<span class="lable label-'.$status_mark.'">'.$status.'</span>';
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

	/////// TYPE
	public function type($param1 = '', $param2 = '', $param3 = '')
	{
		$s_data = array('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		if ($this->session->userdata('logged_in') == false) {
			redirect(base_url('login'), 'refresh');
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Leave Type', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Leave Type', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Leave Type', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Leave Type', 'delete');
			if ($role_r == 0) {
				redirect(base_url('dashboard'), 'refresh');
			}
			$data['role_c'] = $role_c;
		}
		$table = 'leave_type';
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		
		// manage record
		if ($param1 == 'manage') {
			// prepare for delete
			if ($param2 == 'delete') {
				if ($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if (!empty($edit)) {
						foreach ($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}

					if ($_POST) {
						$del_id = $this->input->post('d_type_id');
						if ($this->Crud->delete('id', $del_id, $table) > 0) {
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
				if ($param2 == 'edit') {
					if ($param3) {
						$edit = $this->Crud->read_single('id', $param3, $table);
						if (!empty($edit)) {
							foreach ($edit as $e) {
								$data['e_id'] = $e->id;
								$data['e_name'] = $e->name;
								$data['e_quota'] = $e->quota;
							}
						}
					}
				}

				if ($_POST) {
					$type_id = $this->input->post('type_id');
					$name = $this->input->post('name');
					$quota = $this->input->post('quota');
					
					// do create or update
					if ($type_id) {
						$upd_data = array(
							'name' => $name,
							'quota' => $quota
						);
						$upd_rec = $this->Crud->update('id', $type_id, $table, $upd_data);
						if ($upd_rec > 0) {
							echo $this->Crud->msg('success', _ph('record_updated'));
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', _ph('no_changes'));
						}
					} else {
						if ($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', _ph('record_already_exist'));
						} else {
							$ins_data = array(
								'name' => $name,
								'quota' => $quota
							);
							$ins_rec = $this->Crud->create($table, $ins_data);
							if ($ins_rec > 0) {
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
		if ($param1 == 'list') {
			// DataTable parameters
			$table = 'leave_type';
			$column_order = array('name', 'quota');
			$column_search = array('name', 'quota');
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
				$quota = $item->quota;
				
				// add scripts to last record
				if ($count == count($list)) {
					$script = '<script src="' . base_url('assets/js/jsform.js') . '"></script>';
				} else {
					$script = '';
				}

				// edit 
				if ($role_u == 1) {
					$edit_btn = '
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage ' . $name . '" pageName="' . base_url('leave/type/manage/edit/' . $id) . '" pageSize="">
							<i class="fa fa-edit"></i>
						</a>
					';
				} else {
					$edit_btn = '';
				}
				
				// delete 
				if ($role_d == 1) {
					$del_btn = '
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete ' . $name . '" pageName="' . base_url('leave/type/manage/delete/' . $id) . '" pageSize="">
							<i class="fa fa-trash-o"></i>
						</a>
					';
				} else {
					$del_btn = '';
				}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						' . $del_btn . '
						' . $edit_btn . '
					</div>
					' . $script . '
				';

				$row = array();
				$row[] = $name;
				$row[] = $quota;
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

		if ($param1 == 'manage') { // view for form data posting
			$this->load->view('leave/type_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'leave/type/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1'; // sort disable columns (1,3,5)

			$data['title'] = _ph('leave_type');
			$data['page_active'] = 'leave_type';

			$this->load->view('designs/header', $data);
			$this->load->view('leave/type', $data);
			$this->load->view('designs/footer', $data);
		}

	}

	/////// GET QUOTA
	public function get_quota() {
		$type_id = $this->input->post('type_id');
		$response['id'] = $type_id;
		
		echo json_encode($response);
	}
}
