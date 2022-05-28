<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$this->systems();
	}
	
	/////// ACCOUNT
	public function account($param1='', $param2='', $param3='') {
		$s_data = array ('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$user_id = $this->session->userdata('lvs_id');
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Setup:Account', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Setup:Account', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Setup:Account', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Setup:Account', 'delete');
			if($role_r == 0){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$data['err_msg'] = '';
		
		//check for posting
		if($_POST){
			$user_id = $this->session->userdata('lvs_id');	
			$country = $_POST['country'];
			$othername = $_POST['othername'];
			$lastname = $_POST['lastname'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$sex = $_POST['sex'];
			$dob = $_POST['dob'];		
			$address = $_POST['address'];
			$state = $_POST['state'];
			
			$upd_data = array(
				'country_id' => $country,
				'othername' => $othername,
				'lastname' => $lastname,
				'address' => $address,
				'state' => $state,
				'phone' => $phone,
				'email' => $email,
				'sex' => $sex,
				'dob' => $dob
			);
			
			if(($this->Crud->check('id', $user_id, 'user') > 0) && ($email != $this->Crud->read_field('id', $user_id, 'user', 'email'))) {
				$data['err_msg'] = $this->Crud->msg('danger', _ph('email_not_available'));
			} else {
				if($this->Crud->update('id', $user_id, 'user', $upd_data) > 0){
					//add data to session
					$s_data = array (
						'lvs_user_email' => $email,
						'lvs_user_othername' => $othername,
						'lvs_user_lastname' => $lastname,
						'lvs_user_dob' => $dob,
						'lvs_user_sex' => $sex,
						'lvs_user_phone' => $phone,
						'lvs_user_address' => $address,
						'lvs_user_state' => $state,
						'lvs_user_country' => $country
					);	
					$this->session->set_userdata($s_data);
					$data['err_msg'] = $this->Crud->msg('success', _ph('record_updated'));
				}
			}
			
			//now check change password posting
			$old = $_POST['old'];
			$new = $_POST['new'];
			$confirm = $_POST['confirm'];
			if($old != '' || $new != '' || $confirm != ''){
				if($old != '' && $new != '' && $confirm != ''){
					//check if new and confirm password are same
					if($new != $confirm){
						$data['err_msg'] = $this->Crud->msg('warning', _ph('password_not_matched'));
					} else {
						$old = md5($old);
						$new = md5($new);
						//now check if current password correspond with account
						if($this->Crud->check2('id', $user_id, 'password', $old, 'user') <= 0){
							$data['err_msg'] = $this->Crud->msg('danger', _ph('wrong_password'));
						} else {
							$p_data = array('password' => $new);
							if($this->Crud->update('id', $user_id, 'user', $p_data) > 0){
								$data['err_msg'] = $this->Crud->msg('success', _ph('password_changed'));
							} 
						}
					}
				} else {
					$data['err_msg'] = $this->msg('warning', _ph('password_fields_are_required'));
				}
			}
			
			//check image upload
			if(isset($_FILES['pics']['name'])){
				$stamp = time();
				$path = 'assets/img/avatars/'.$user_id;
				 
				if (!is_dir($path))
					mkdir($path, 0755);
	
				$pathMain = './'.$path;
				if (!is_dir($pathMain))
					mkdir($pathMain, 0755);
	
				$result = $this->Crud->do_upload("pics", $pathMain);
	
				if (!$result['status']){
					// not upload picture
				} else {
					$save_path = $path . '/' . $result['upload_data']['file_name'];
					
					//if size not up to 400px above
					if($result['image_width'] >= 400){
						if($result['image_width'] >= 400 || $result['image_height'] >= 400) {
							if($this->Crud->resize_image($pathMain . '/' . $result['upload_data']['file_name'], $stamp .'-400.gif','400','400', $result['image_width'], $result['image_height'])){
								$resize400 = $pathMain . '/' . $stamp.'-400.gif';
								$resize400_dest = $resize400;
								
								if($this->Crud->crop_image($resize400, $resize400_dest,'400','220')){
									$save_path400 = $path . '/' . $stamp .'-400.gif';
								}
							}
						}
							
						if($result['image_width'] >= 300 || $result['image_height'] >= 300){
							if($this->Crud->resize_image($pathMain . '/' . $result['upload_data']['file_name'], $stamp .'-300.gif','350','350', $result['image_width'], $result['image_height'])){
								$resize100 = $pathMain . '/' . $stamp.'-300.gif';
								$resize100_dest = $resize100;	
								
								if($this->Crud->crop_image($resize100, $resize100_dest,'300','300')){
									$save_path100 = $path . '/' . $stamp .'-300.gif';
								}
							}
						}
						
						//save picture in system
						$pics_data = array(
							'user_id' => $user_id,
							'pics' => $save_path,
							'pics_small' => $save_path400,
							'pics_square' => $save_path100
						);
						$pics_ins = $this->Crud->create('img', $pics_data);
						// update in user table
						if($pics_ins) {
							$u_pics_data = array('pics'=>$pics_ins);
							$u_pics_ins = $this->Crud->update('id', $user_id, 'user', $u_pics_data);	
							if($u_pics_ins > 0){
								$data['err_msg'] = $this->Crud->msg('success', _ph('picture_uploaded'));
								// update session
								$u_p_data = array('lvs_user_pics' => $save_path100);
								$this->session->set_userdata($u_p_data);
							}
						}
					} else {
						$data['err_msg'] = $this->Crud->msg('warning', _ph('picture_minium_width_required').': 400px');
					}
				}
			}
			/// end profile picture upload
		}
		
		$data['user_id'] = $this->session->userdata('lvs_id');
		$data['username'] = $this->session->userdata('lvs_username');
		$data['othername'] = $this->session->userdata('lvs_user_othername');
		$data['lastname'] = $this->session->userdata('lvs_user_lastname');
		$data['phone'] = $this->session->userdata('lvs_user_phone');
		$data['email'] = $this->session->userdata('lvs_user_email');
		$data['dob'] = $this->session->userdata('lvs_user_dob');
		$data['sex'] = $this->session->userdata('lvs_user_sex');
		$data['address'] = $this->session->userdata('lvs_user_address');
		$data['state'] = $this->session->userdata('lvs_user_state');
		$data['country_id'] = $this->session->userdata('lvs_user_country');
		$data['reg_date'] = $this->session->userdata('lvs_user_reg_date');
		$data['pics'] = $this->session->userdata('lvs_user_pics');
		$data['role'] = $lvs_user_role;
		
		$data['allcountry'] = $this->Crud->read_order('country', 'name', 'ASC');
		
		$data['title'] = _ph('account_setup');
		$data['page_active'] = 'account';
		
		$this->load->view('designs/header', $data);
		$this->load->view('setup/account', $data);
		$this->load->view('designs/footer', $data);
	}
	
	/////// SYSTEMS
	public function systems($param1='', $param2='', $param3='') {
		$s_data = array ('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Setup:System', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Setup:System', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Setup:System', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Setup:System', 'delete');
			if($role_r == 0){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		// system update
		if ($param1 == 'do_update') {
            $rec_data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
			$this->db->update('settings' , $rec_data);
			$this->session->set_userdata('lvs_system_name', $this->input->post('system_name'));

            $rec_data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $rec_data);

            $rec_data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $rec_data);

            $rec_data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $rec_data);

            $rec_data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
			$this->db->update('settings' , $rec_data);
			$this->session->set_userdata('lvs_system_email', $this->input->post('system_email'));

            $rec_data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            if($this->db->update('settings' , $rec_data) > 0) {
				$this->session->set_userdata(array('lvs_current_language'=>$this->input->post('language')));	
			}

            $rec_data['description'] = $this->input->post('purchase_code');
            $this->db->where('type' , 'purchase_code');
            $this->db->update('settings' , $rec_data);

            redirect(base_url('setup/systems'), 'refresh');
        }
		
		// logo upload
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'assets/img/logo2.png');
            $ins_data['description'] = 'assets/img/logo2.png';
            $this->db->where('type' , 'system_logo');
			$this->db->update('settings' , $ins_data);
			redirect(base_url('setup/systems'), 'refresh');
        }
		
		// skin
        if ($param1 == 'change_skin') {
            $ins_data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $ins_data);
            redirect(base_url('setup/systems'), 'refresh');
        }
		
        $data['settings']   = $this->db->get('settings')->result_array();
		
		$data['title'] = _ph('system_setup');
		$data['page_active'] = 'system';
		
		$this->load->view('designs/header', $data);
		$this->load->view('setup/system', $data);
		$this->load->view('designs/footer', $data);
	}
	
	/////// LANGUAGE
	public function language($param1='', $param2='', $param3='') {
		$s_data = array ('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Setup:Language', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Setup:Language', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Setup:Language', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Setup:Language', 'delete');
			if($role_r == 0){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		// edit phrase
		if ($param1 == 'edit_phrase') {
			$data['edit_profile'] 	= $param2;
			
			// auto translate language
			$query = $this->Crud->read_order('language', 'id', 'asc'); 
			if(!empty($query)) {
				foreach($query as $q) {
					$phrase_name = $q->phrase;
					if(!$q->$param2) {
						$langCode = _langCode($param2); // get short code for language
						if($langCode) {
							$toConvert = ucwords(str_replace("_", " ", $phrase_name));
							if(strtolower($param2) == 'english') {
								$this->Crud->update('id', $q->id, 'language', array($param2 => $toConvert));
							} else {
								$convertPhrase = _translate($toConvert, 'en', $langCode);
								if($convertPhrase) {
									$this->Crud->update('id', $q->id, 'language', array($param2 => $convertPhrase));	
								}
							}
						}
					}
				}
			}
		}
		
		// open phrases
		if ($param1 == 'update_phrase') {
			$language	=	$param2;
			$total_phrase	=	$this->input->post('total_phrase');
			for($i = 1 ; $i < $total_phrase ; $i++){
				$this->db->where('id' , $i);
				$this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
			}
			redirect(base_url('setup/language/edit_phrase/'.$language), 'refresh');
		}
		
		// update phrases
		if ($param1 == 'do_update') {
			$language        = $this->input->post('language');
			$ins_data[$language] = $this->input->post('phrase');
			$this->db->where('id', $param2);
			$this->db->update('language', $data);
			redirect(base_url('setup/language/'), 'refresh');
		}
		
		// add phrase
		if ($param1 == 'add_phrase') {
			$ins_data['phrase'] = $this->input->post('phrase');
			$this->db->insert('language', $ins_data);
			redirect(base_url('setup/language/'), 'refresh');
		}
		
		// add language
		if ($param1 == 'add_language') {
			$language = $this->input->post('language');
			$this->load->dbforge();
			$fields = array(
				$language => array(
					'type' => 'LONGTEXT'
				)
			);
			$this->dbforge->add_column('language', $fields);

			redirect(base_url('setup/language/'), 'refresh');
		}
		
		// delete language
		if ($param1 == 'delete_language') {
			$language = $param2;
			$this->load->dbforge();
			$this->dbforge->drop_column('language', $language);

			redirect(base_url('setup/language/'), 'refresh');
		}
		
		$data['title'] = _ph('language_setup');
		$data['page_active'] = 'language';
		
		$this->load->view('designs/header', $data);
		$this->load->view('setup/language', $data);
		$this->load->view('designs/footer', $data);
	}
	
	/////// SMS
	public function sms($param1='', $param2='', $param3='') {
		$s_data = array ('lvs_redirect' => uri_string());
		$this->session->set_userdata($s_data);
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
			$lvs_user_role = $this->Crud->read_field('id', $lvs_user_role_id, 'access_role', 'name');
			$role_c = $this->Crud->module($lvs_user_role_id, 'Setup:SMS', 'create');
			$role_r = $this->Crud->module($lvs_user_role_id, 'Setup:SMS', 'read');
			$role_u = $this->Crud->module($lvs_user_role_id, 'Setup:SMS', 'update');
			$role_d = $this->Crud->module($lvs_user_role_id, 'Setup:SMS', 'delete');
			if($role_r == 0){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		// BulkSMS NG setup
		if ($param1 == 'bulksmsng') {
            $ins_data['description'] = $this->input->post('bulksmsng_key');
            $this->db->where('type' , 'bulksmsng_key');
			$this->db->update('settings' , $ins_data);
			
			$ins_data['description'] = $this->input->post('bulksmsng_sender');
            $this->db->where('type' , 'bulksmsng_sender');
            $this->db->update('settings' , $ins_data);

            redirect(base_url('setup/sms/'), 'refresh');
        }
		
		// Clickatell setup
		if ($param1 == 'clickatell') {
            $ins_data['description'] = $this->input->post('clickatell_user');
            $this->db->where('type' , 'clickatell_user');
            $this->db->update('settings' , $ins_data);

            $ins_data['description'] = $this->input->post('clickatell_password');
            $this->db->where('type' , 'clickatell_password');
            $this->db->update('settings' , $ins_data);

            $ins_data['description'] = $this->input->post('clickatell_api_id');
            $this->db->where('type' , 'clickatell_api_id');
            $this->db->update('settings' , $ins_data);

            redirect(base_url('setup/sms/'), 'refresh');
        }
		
		// Twilio setup
        if ($param1 == 'twilio') {
            $ins_data['description'] = $this->input->post('twilio_account_sid');
            $this->db->where('type' , 'twilio_account_sid');
            $this->db->update('settings' , $ins_data);

            $ins_data['description'] = $this->input->post('twilio_auth_token');
            $this->db->where('type' , 'twilio_auth_token');
            $this->db->update('settings' , $ins_data);

            $ins_data['description'] = $this->input->post('twilio_sender_phone_number');
            $this->db->where('type' , 'twilio_sender_phone_number');
            $this->db->update('settings' , $ins_data);

            redirect(base_url('setup/sms/'), 'refresh');
        }
		
		// MSG91 setup
        if ($param1 == 'msg91') {
            $ins_data['description'] = $this->input->post('authentication_key');
            $this->db->where('type' , 'msg91_authentication_key');
            $this->db->update('settings' , $ins_data);

            $ins_data['description'] = $this->input->post('sender_ID');
            $this->db->where('type' , 'msg91_sender_ID');
            $this->db->update('settings' , $ins_data);

            $ins_data['description'] = $this->input->post('msg91_route');
            $this->db->where('type' , 'msg91_route');
            $this->db->update('settings' , $ins_data);

            $ins_data['description'] = $this->input->post('msg91_country_code');
            $this->db->where('type' , 'msg91_country_code');
            $this->db->update('settings' , $ins_data);

            redirect(base_url('setup/sms/'), 'refresh');
        }
		
		// activaate SMS
        if ($param1 == 'active_service') {
			$service = $this->input->post('active_sms_service');
			$ins_data['description'] = $this->input->post('active_sms_service');
            $this->db->where('type' , 'active_sms_service');
            $this->db->update('settings' , $ins_data);
			
			$this->session->set_userdata('lvs_system_sms', $service);
            redirect(base_url('setup/sms/'), 'refresh');
        }
		
		$data['settings']   = $this->db->get('settings')->result_array();
		
		$data['title'] = 'SMS '._ph('setup');
		$data['page_active'] = 'sms';
		
		$this->load->view('designs/header', $data);
		$this->load->view('setup/sms', $data);
		$this->load->view('designs/footer', $data);
	}
}
