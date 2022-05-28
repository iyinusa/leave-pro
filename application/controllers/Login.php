<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$redir = $this->session->userdata('lv_redirect');
		if($this->session->userdata('logged_in') == TRUE){
			if(empty($redir)){$redir = 'dashboard';}
			redirect(base_url($redir), 'refresh');
		} 

		$system_name  = _sys('name');
		$data['system_name'] = $system_name;
		$system_logo  = _sys('logo');
		if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
		$data['system_logo'] = $system_logo;
		
		if($_POST) {
			$email = $_POST['email'];
			$password = $_POST['password'];
			$password = md5($password);
			if(isset($_POST['remember-me'])){$remind='true';}else{$remind='';}
			
			if($this->Crud->check2('email', $email, 'password', $password, 'user') <= 0){
				echo $this->Crud->msg('danger', _ph('invalid_authentication')); die;
			} else {
				$query = $this->Crud->read2('email', $email, 'password', $password, 'user');
				
				if(!empty($query)) {
					foreach($query as $row) { 
						if($row->activate != 1) {
							echo $this->Crud->msg('danger', _ph('unauthorized_zone')); die;
						}
						
						//update status
						$first_log = $row->last_log; //to check first time user
						
						$now = date("Y-m-d H:i:s");
						$status_update = array('status'=>1, 'last_log'=>$now);
						$this->Crud->update('id', $row->id, 'user', $status_update);
						
						//get country name
						$country_name = $this->Crud->read_field('id', $row->country_id, 'country', 'name');
						
						//get logo
						$logo_path = $this->Crud->read_field('id', $row->pics, 'img', 'pics');
						if(empty($logo_path)){$logo_path = 'assets/img/avatars/avatar.png';}
						
						//add data to session
						$s_data = array (
							'lvs_id' => $row->id,
							'lvs_username' => $row->username,
							'lvs_user_email' => $row->email,
							'lvs_user_lastlog' => $row->last_log,
							'lvs_user_status' => $row->status,
							'lvs_user_othername' => $row->othername,
							'lvs_user_lastname' => $row->lastname,
							'lvs_user_dob' => $row->dob,
							'lvs_user_sex' => $row->sex,
							'lvs_user_phone' => $row->phone,
							'lvs_user_address' => $row->address,
							'lvs_user_state' => $row->state,
							'lvs_user_country' => $row->country_id,
							'lvs_user_country_name' => $country_name,
							'lvs_user_pics' => $logo_path,
							'lvs_user_role_id' => $row->role_id,
							'lvs_user_activate' => $row->activate,
							'lvs_user_reg_date' => $row->reg_date,
							'logged_in' => TRUE
						);
					}
					$this->session->set_userdata($s_data);
					$this->Crud->msg('success', _ph('successfully_logged_in'));
					
					// redirect page
					if($redir==''){$redir = 'dashboard';}
					echo '<script>window.location.replace("'.base_url($redir).'");</script>';
					die;
				}
			}
		}
		
		$data['title'] = _ph('log_in').' | '.$system_name;
		$data['page_active'] = 'login';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('login', $data);
		$this->load->view('designs/auth_footer', $data);
	}
	
}