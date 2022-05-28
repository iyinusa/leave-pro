<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$lvs_id = $this->session->userdata('lvs_id');
		
		$status_update = array('status'=>0);
		if($this->Crud->update('id', $lvs_id, 'user', $status_update) > 0){
			$newdata = array(
				'lvs_id' => '',
				'lvs_user_email' => '',
				'lvs_user_lastlog' => '',
				'lvs_user_status' => '',
				'lvs_user_othername' => '',
				'lvs_user_lastname' => '',
				'lvs_user_dob' => '',
				'lvs_user_sex' => '',
				'lvs_user_phone' => '',
				'lvs_user_address' => '',
				'lvs_user_state' => '',
				'lvs_user_country' => '',
				'lvs_user_pics' => '',
				'lvs_user_role_id' => '',
				'lvs_user_activate' => '',
				'lvs_user_company' => '',
				'lvs_user_reg_date' => '',
				'logged_in' => FALSE
			);
			$this->session->unset_userdata($newdata);
			//unset($this->session->userdata); 
			$this->session->sess_destroy();
			delete_cookie(config_item('sess_cookie_name'));
			
			$data['err_msg'] = $this->Crud->msg('success', _ph('successfully_logged_out'));
		}
		
		$system_name  = _sys('name');
		$data['system_name'] = $system_name;
		$system_logo  = _sys('logo');
		if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
		$data['system_logo'] = $system_logo;
		
		$data['title'] = _ph('log_out').' | '.$system_name;
		$data['page_active'] = 'login';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('login', $data);
		$this->load->view('designs/auth_footer', $data);
	}
}
