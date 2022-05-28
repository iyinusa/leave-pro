<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == TRUE){
			redirect(base_url('dashboard'), 'refresh');	
		} 
		
		$data['change'] = FALSE;
		
		if($_POST){
			$email = $_POST['email'];
				
			if($this->Crud->check('email', $email, 'user') <= 0) {
				echo $this->Crud->msg('danger', _ph('email_not_found'));
				die;
			} else {
				$time = time().rand();
				
				// get user details
				$othername = $email;
				$username = '';
				$getuser = $this->Crud->read_single('email', $email, 'user');
				if(!empty($getuser)){
					foreach($getuser as $user){
						$username = $user->username;
						$othername = $user->othername;	
					}
				}
				
				$reg_data = array(
					'reset' => 1,
					'reset_stamp' => $time
				);
				if($this->Crud->update('email', $email, 'user', $reg_data) > 0){
					echo $this->Crud->msg('success', _ph('instruction_sent').' to '.$email);
					// send email
					$system_name = _sys('name');
					$email_result = '';
					$from = _sys('email');
					$subject = 'Reset Password';
					$name = $system_name;
					$sub_head = 'Reset Password Instruction';
					
					$body = '
						<div class="mname">Dear '.ucwords($othername).',</div><br/>
						You requested to reset password on '.$system_name.', kindly click below link to set new password.
						<div class="mbtn"><a href="'.base_url('forgot/change/'.$time.'/'.$username).'" class="btn btn-primary">Reset Now</a></div>In case button do not work, kindly copy and paste below link to browser.<br />'.base_url('forgot/change/'.$time.'/'.$username).'<br /><br />
						Warm Regards.
					';
					
					$email_result = $this->Crud->send_email($email, $from, $subject, $body, $name, $sub_head);
					die;
				}
			}
		}
		
		$system_name  = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
		$data['system_name'] = $system_name;
		$system_logo  = $this->db->get_where('settings', array('type' => 'system_logo'))->row()->description;
		if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
		$data['system_logo'] = $system_logo;
		
		$data['title'] = _ph('forgot_password').' | '.$system_name;
		$data['page_active'] = 'forgot';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('forgot', $data);
		$this->load->view('designs/auth_footer', $data);
	}
	
	public function change($param1='', $param2='') {
		$data['change'] = FALSE;
		$data['param1'] = '';
		$data['param2'] = '';
		
		// check record
		if($this->Crud->check2('reset_stamp', $param1, 'username', $param2, 'user') <= 0){
			redirect(base_url('forgot'), 'refresh');
		} else {
			$getrec = $this->Crud->read2('reset_stamp', $param1, 'username', $param2, 'user');
			if(!empty($getrec)){
				foreach($getrec as $rec){
					$id = $rec->id;
					$reset = $rec->reset;	
				}
			}
			
			if($reset == 0){
				redirect(bas_url('forgot'), 'refresh');
			} else {
				$data['change'] = TRUE;
				$data['param1'] = $param1;
				$data['param2'] = $param2;
				
				if($_POST){
					$new = $_POST['password'];
					$confirm = $_POST['confirm'];
					
					if($new != $confirm){
						echo $this->Crud->msg('warning', _ph('password_not_matched'));
						die;
					} else {
						$update_data = array(
							'password' => md5($new),
							'reset' => 0,
							'reset_stamp' => ''
						);
						
						if($this->Crud->update('username', $param2, 'user', $update_data) > 0){
							echo $this->Crud->msg('success', _ph('password_reset_successfully'));
							die;
						} else {
							echo $this->Crud->msg('danger', _ph('please_try_later'));
							die;
						}
					}
				}
				
				//$this->load->view('forgot', $data);
			}
		}
		
		$system_name  = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
		$data['system_name'] = $system_name;
		$system_logo  = $this->db->get_where('settings', array('type' => 'system_logo'))->row()->description;
		if(empty($system_logo)){$system_logo = 'assets/img/logo.png';}
		$data['system_logo'] = $system_logo;
		
		$data['title'] = _ph('forgot_password').' | '.$system_name;
		$data['page_active'] = 'forgot';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('forgot', $data);
		$this->load->view('designs/auth_footer', $data);
	}
}
