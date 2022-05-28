<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Dashboard', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Dashboard', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Dashboard', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Dashboard', 'delete');
			//if($role_r == 1){
//				if($lvs_user_role == 'Client') {
//					$dash_type = 'Client';
//					$data['dash_type'] = 'Client';
//				} else if($lvs_user_role == 'Channel Partner') {
//					$dash_type = 'Channel Partner';
//					$data['dash_type'] = 'Channel Partner';
//				} else {
//					$dash_type = 'Company Admin';
//					$data['dash_type'] = 'Company Admin';	
//				}
//			} else {
//				redirect(base_url('profile'), 'refresh');		
//			}
		}
		
		
		
		$data['title'] = _ph('dashboard');
		$data['page_active'] = 'dashboard';
		
		$this->load->view('designs/header', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('designs/footer', $data);
	}
}
