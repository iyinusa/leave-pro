<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    ////////////////// CLEAR CACHE ///////////////////
	public function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
	
	//////////////////// C - CREATE ///////////////////////
	public function create($table, $data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();	
	}
	
	//////////////////// R - READ /////////////////////////
	public function read($table) {
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_order($table, $field, $type) {
		$query = $this->db->order_by($field, $type);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_group($table, $field) {
		$query = $this->db->group_by($field);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_single($field, $value, $table) {
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where($field, $value);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_single_reverse($field, $value, $table) {
		$query = $this->db->order_by('id', 'ASC');
		$query = $this->db->where($field, $value);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_single_order($field, $value, $table, $fd, $type) {
		$query = $this->db->order_by($fd, $type);
		$query = $this->db->where($field, $value);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read_field($field, $value, $table, $call) {
		$return_call = '';
		$getresult = $this->read_single($field, $value, $table);
		if(!empty($getresult)) {
			foreach($getresult as $result)  {
				$return_call = $result->$call;
			}
		}
		return $return_call;
	}
	
	public function read_field2($field, $value, $field2, $value2, $table, $call) {
		$return_call = '';
		$getresult = $this->read2($field, $value, $field2, $value2, $table);
		if(!empty($getresult)) {
			foreach($getresult as $result)  {
				$return_call = $result->$call;
			}
		}
		return $return_call;
	}
	
	public function read2($field, $value, $field2, $value2, $table) {
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read2_order($field, $value, $field2, $value2, $table, $fd, $type) {
		$query = $this->db->order_by($fd, $type);
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read3($field, $value, $field2, $value2, $field3, $value3, $table) {
		$query = $this->db->order_by('id', 'DESC');
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->where($field3, $value3);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function read3_order($field, $value, $field2, $value2, $field3, $value3, $table, $fd, $type) {
		$query = $this->db->order_by($fd, $type);
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->where($field3, $value3);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	public function check($field, $value, $table){
		$query = $this->db->where($field, $value);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	public function check2($field, $value, $field2, $value2, $table){
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	public function check3($field, $value, $field2, $value2, $field3, $value3, $table){
		$query = $this->db->where($field, $value);
		$query = $this->db->where($field2, $value2);
		$query = $this->db->where($field3, $value3);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	public function read_date($start, $end, $table) {
		$query = $this->db->where('report_date >=', $start);
		$query = $this->db->where('report_date <=', $end);
		$query = $this->db->get($table);
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	//////////////////// U - UPDATE ///////////////////////
	public function update($field, $value, $table, $data) {
		$this->db->where($field, $value);
		$this->db->update($table, $data);
		return $this->db->affected_rows();	
	}
	
	//////////////////// D - DELETE ///////////////////////
	public function delete($field, $value, $table) {
		$this->db->where($field, $value);
		$this->db->delete($table);
		return $this->db->affected_rows();	
	}
	//////////////////// END DATABASE CRUD ///////////////////////
	
	//////////////////// DATATABLE AJAX CRUD ///////////////////////
	public function datatable_query($table, $column_order, $column_search, $order, $where='') {
		// where clause
		if(!empty($where)) {
			$this->db->where(key($where), $where[key($where)]);
		}
		
		$this->db->from($table);
 
		// here combine like queries for search processing
		$i = 0;
		if($_POST['search']['value']) {
			foreach($column_search as $item) {
				if($i == 0) {
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				
				$i++;
			}
		}
		 
		// here order processing
		if(isset($_POST['order'])) { // order by click column
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)) { // order by default defined
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
 
	public function datatable_load($table, $column_order, $column_search, $order, $where='') {
		$this->datatable_query($table, $column_order, $column_search, $order, $where);
		
		if($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
 
	public function datatable_filtered($table, $column_order, $column_search, $order, $where='') {
		$this->datatable_query($table, $column_order, $column_search, $order, $where);
		$query = $this->db->get();
		return $query->num_rows();
	}
 
	public function datatable_count($table, $where='') {
		$this->db->select("*");
		
		// where clause
		if(!empty($where)) {
			$this->db->where(key($where), $where[key($where)]);
		}
		
		$this->db->from($table);
		return $this->db->count_all_results();
	} 
	//////////////////// END DATATABLE AJAX CRUD ///////////////////
	
	//////////////////// NOTIFICATION CRUD ///////////////////////
	public function msg($type = '', $text = ''){
		if($type == 'success') {
			$icon = 'si si-check';
		} else if($type == 'info') {
			$icon = 'si si-info';
		} else if($type == 'warning') {
			$icon = 'si si-question';
		} else {
			$icon = 'si si-close';	
		}
		return '<div class="col-xs-12 text-white bg-'.$type.'" style="padding:15px; margin:15px 0px;">
			<i class="'.$icon.'"></i> '.$text.'</div>
		';	
	}
	//////////////////// END NOTIFICATION CRUD ///////////////////////
	
	//////////////////// EMAIL CRUD ///////////////////////
	public function send_email($to, $from, $subject, $body_msg, $name, $subhead) {
		//clear initial email variables
		$this->email->clear(); 
		$email_status = '';
		
		$this->email->to($to);
		$this->email->from($from, $name);
		$this->email->subject($subject);
						
		$mail_data = array('message'=>$body_msg, 'subhead'=>$subhead);
		$this->email->set_mailtype("html"); //use HTML format
		$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
				
		$this->email->message($mail_design);
		if(!$this->email->send()) {
			$email_status = FALSE;
		} else {
			$email_status = TRUE;
		}
		
		$this->email->clear();
		return $email_status;
	}
	//////////////////// END EMAIL CRUD ///////////////////////
	
	//////////////////// SMS CRUD ///////////////////////
	public function get_credit() {
		$token = 'DfUKVKt0ZAq8XuPVzmdcI4kQlNgRcnBaP4azI9kefuXntUuhz00MbD7eGGn8';
		$api_link = 'https://www.bulksmsnigeria.com/api/v2/balance/get?api_token='.$token;
		$result = file_get_contents($api_link);
		return $result;
	}

	public function sms_send($sender = '', $recipient = '', $message = '') {
		// create a new cURL resource
		$curl = curl_init();
		
		$token = 'DfUKVKt0ZAq8XuPVzmdcI4kQlNgRcnBaP4azI9kefuXntUuhz00MbD7eGGn8';
		$api_link = 'https://www.bulksmsnigeria.com/api/v1/sms/create?';
		
		//$curl_data = $api_link.'api_token='.$token.'&from='.$sender.'&to='.$recipient.'&body='.$message;
		$curl_data = array('api_token'=>$token, 'from'=>$sender, 'to'=>$recipient, 'body'=>$message);
		
		$chead = array();
		//$chead[] = 'Content-Type: application/json';

		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $api_link);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $chead);
		curl_setopt($curl, CURLOPT_POST, 1);
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		// grab URL and pass it to the browser
		$result = curl_exec($curl);

		// close cURL resource, and free up system resources
		curl_close($curl);

		return $result;
	}
	//////////////////// END SMS CRUD ///////////////////////
	
	//////////////////// GoogleURL SHORTNER API ///////////////////////
	public function google_url($url, $type) {
		$apiKey = "AIzaSyBCPAUolft5U3FI00jhgdG115Kg2wM4H5Q";
		//load the library
		$this->load->library('GoogleURL');
		//initialize with the google API Key
		$this->googleurl->_initialize($apiKey);
		//for shortening 
		if($type == 'short') {
			return $this->googleurl->shorten($url);
		} else {
			//for expanding
			return $this->googleurl->expand($url);
		}
	}
	//////////////////// END GoogleURL SHORTNER API ///////////////////////
	
	//////////////////// MUNITES TO HOURS ///////////////////////
	public function to_hours($time, $format = '%02d:%02d') {
		if ($time < 1) {
			return;
		}
		$hours = floor(($time) / 60);
		$minutes = ($time % 60);
		return sprintf($format, $hours, $minutes);
	}
	//////////////////// END MUNITES TO HOURS ///////////////////////
	
	//////////////////// DATETIME ///////////////////////
	public function date_diff($now, $end, $type) {
		$now = new DateTime($now);
		$end = new DateTime($end);
		$date_left = $end->getTimestamp() - $now->getTimestamp();
		
		if($type == 'seconds') {
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'minutes') {
			$date_left = $date_left / 60;
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'hours') {
			$date_left = $date_left / (60*60);
			if($date_left <= 0){$date_left = 0;}
		} else if($type == 'days') {
			$date_left = $date_left / (60*60*24);
			if($date_left <= 0){$date_left = 0;}
		} else {
			$date_left = $date_left / (60*60*24*365);
			if($date_left <= 0){$date_left = 0;}
		}	
		
		return $date_left;
	}
	//////////////////// END DATETIME ///////////////////////
	
	//////////////////// MODULE ///////////////////////
	public function module($role, $module, $type) {
		$result = 0;
		
		$mod_id = $this->read_field('name', $module, 'access_module', 'id');
		$crud = $this->read_field('role_id', $role, 'access', 'crud');
		if($mod_id) {
			if(!empty($crud)) {
				$crud = json_decode($crud);
				foreach($crud as $cr) {
					$cr = explode('.', $cr);
					if($mod_id == $cr[0]) {
						if($type == 'create'){$result = $cr[1];}
						if($type == 'read'){$result = $cr[2];}
						if($type == 'update'){$result = $cr[3];}
						if($type == 'delete'){$result = $cr[4];}
						break;
					}
				}
			}
		}
		
		return $result;
	}
	public function mod_read($role, $module) {
		$rs = $this->module($role, $module, 'read');
		return $rs;
	}
	//////////////////// END MODULE ///////////////////////
	
	//////////////////// IMAGE UPLOAD ///////////////////////
	public function do_upload($htmlFieldName, $path) {
        $config['file_name'] = time();
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|tif|bmp';
        $config['max_size'] = '10000';
        $config['max_width'] = '6000';
        $config['max_height'] = '6000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        unset($config);
        if (!$this->upload->do_upload($htmlFieldName)) {
            return array('error' => $this->upload->display_errors(), 'status' => 0);
        } else {
            $up_data = $this->upload->data();
			return array('status' => 1, 'upload_data' => $this->upload->data(), 'image_width' => $up_data['image_width'], 'image_height' => $up_data['image_height']);
        }
    }
	
	public function resize_image($sourcePath, $desPath, $width = '500', $height = '500', $real_width, $real_height) {
        $this->image_lib->clear();
		$config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['thumb_marker'] = '';
		$config['width'] = $width;
        $config['height'] = $height;
		
		$dim = (intval($real_width) / intval($real_height)) - ($config['width'] / $config['height']);
		$config['master_dim'] = ($dim > 0)? "height" : "width";
		
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->resize())
            return true;
        return false;
    }
	
	public function crop_image($sourcePath, $desPath, $width = '320', $height = '320') {
        $this->image_lib->clear();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
		$config['x_axis'] = '20';
		$config['y_axis'] = '20';
        
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->crop())
            return true;
        return false;
    }
}
