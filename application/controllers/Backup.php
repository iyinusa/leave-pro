<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->dbutil();

        $params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		
		$this->load->library('dropbox', $params);
    }
	
	public function index() {
		$backup = '';
		$backup = $this->backup_tables('localhost','root','root','nakdb');

        if(!empty($backup)) {
        	$status = 'BackUp Successful!';
        } else {
        	$status = 'BackUp Failed!';
        }
		
		if(!empty($backup)) {
			// try and push email notification
			$this->email->clear(); //clear initial email variables
			$this->email->to('coo@tehilahbase.com');
			$this->email->from(app_email,app_name);
			$this->email->subject(app_name.' - Database BackUp');
			$this->email->attach($save); // attach zip file to email
							
			//compose html body of mail
			$mail_subhead = 'Backup Notification';
			$body_msg = '
				'.app_name.' Database Backup ('.$backup.') Status:<br /><br />
				<b>Local Storage: </b>'.$status.'<br /><br />Thanks
			';
							
			$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
			$this->email->set_mailtype("html"); //use HTML format
			$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
					
			$this->email->message($mail_design);
			if($this->email->send()) {}
		}

        // force download backup
        //$this->load->helper('download');
        //force_download($db_name, $backup);
	}
	
	/* backup the db OR just a table */
	public function backup_tables($host,$user,$pass,$name,$tables = '*'){
		$link = mysqli_connect($host,$user,$pass,$name);
		
		//get all of the tables
		if($tables == '*') {
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result)) {
				$tables[] = $row[0];
			}
		} else {
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		//cycle through
		$return = '';
		foreach($tables as $table) {
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			$return.= 'DROP TABLE '.$table.';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			
			for ($i = 0; $i < $num_fields; $i++) {
				while($row = mysql_fetch_row($result)) {
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j < $num_fields; $j++)  {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = str_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j < ($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		
		//save file
		$backup_name = 'assets/backups/'.$name.'-backup-'.date('d-M-Y H.i').'.sql.zip';
		$handle = fopen($backup_name,'w+');
		fwrite($handle,$return);
		fclose($handle);
		
		return $backup_name;
	}

	/////////////////// DROPBOX API ////////////////////////////////////////////////
	// Call this method first by visiting http://SITE_URL/example/request_dropbox
    public function request_dropbox()
	{
		$params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		
		$this->load->library('dropbox', $params);
		$data = $this->dropbox->get_request_token(base_url("backup/access_dropbox"));
		$this->session->set_userdata('token_secret', $data['token_secret']);
		redirect($data['redirect']);
	}
	//This method should not be called directly, it will be called after 
    //the user approves your application and dropbox redirects to it
	public function access_dropbox()
	{
		$params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		
		$this->load->library('dropbox', $params);
		
		$oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));
		
		$this->session->set_userdata('oauth_token', $oauth['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
        redirect('backup/test_dropbox');
	}
	//Once your application is approved you can proceed to load the library
    //with the access token data stored in the session. If you see your account
    //information printed out then you have successfully authenticated with
    //dropbox and can use the library to interact with your account.
	public function test_dropbox()
	{
		$params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		$params['access'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
								  'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
		
		$this->load->library('dropbox', $params);
		
        $dbobj = $this->dropbox->account();
		
        print_r($dbobj);
	}

	/////////////////// END DROPBOX API ///////////////////////////////////////////
}
