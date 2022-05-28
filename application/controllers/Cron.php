<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		
	}
	
	////////////////// START BaseSPOT Subscription Cron //////////////////////////
	public function basespot_sub() {
		$notify_list = '';
		$allcontract = $this->Crud->read('bs_contract');
		if(!empty($allcontract)){
			foreach($allcontract as $cont){
				$contract_id = $cont->id;
				$contract_no = $cont->contract_no;
				$client_id = $cont->client_id;
				$end_date = $cont->end_date;
				$amount = $cont->fix_price;
				$price = $cont->price;	
				$pay_url = $cont->pay_url;	
				
				// get product
				$product = $this->Crud->read_field('id', $cont->service_id, 'bs_service', 'name');
				
				// get client details
				$client_no = $this->Crud->read_field('id', $client_id, 'bs_client', 'client_no');
				$client_name = $this->Crud->read_field('id', $client_id, 'bs_client', 'name');
				$client_phones = $this->Crud->read_field('id', $client_id, 'bs_client', 'phone');
				$client_emails = $this->Crud->read_field('id', $client_id, 'bs_client', 'email');
				
				// get difference in days
				$diff = (strtotime($end_date) - strtotime(date('Y-m-d')));
				$days = floor($diff / (60*60*24));
				
				// add payment url
				if(!empty($pay_url)) {
					$sms_pay_url = $pay_url;
					$pay_url = '<div class="mbtn"><a class="btn btn1" href="'.$pay_url.'">Renew Account</a></div><br />
						<i><small>If payment button not working, kindly copy and paste this to your browser.</small><br />'.$pay_url.'</i>';
				} else {$pay_url = '';} 
				
				// send notification if 7days, 3days, 1day left or its expired
				if($days == 7) {
					$expires = date('d M, Y', strtotime($end_date)).' ('.$days.'days time)';
					$details = '
						Your BaseSPOT is about to expire. Please see details below.<br /><br />
						'.$this->renew_temp($product, $amount, $expires, 'Client ID', $client_no).'
						'.$pay_url.'<br /><br />
						Thanks for choosing BaseSPOT
					';
					
					// send Email
					if($client_emails != '') {
						$email_result = '';
						$from = app_email;
						$subject = 'BaseSPOT Notification';
						$name = 'BaseSPOT';
						$sub_head = 'Upcoming Renewal';
						
						$body = '
							Dear '.$client_name.'<br /><br />'.$details.'
						';
						
						$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
						
						if($email_result == TRUE){
							// now admins
							$notify_list .= '
								<tr>
									<td>'.$client_name.'</td>
									<td>'.$product.'</td>
									<td align="right">&#8358;'.number_format((float)$amount).'</td>
									<td>'.$expires.'</td>
								</tr>
							';
						}
					}
					
					// send SMS
					$sms_details = 'Your BaseSPOT account will expire on '.date('d M, Y', strtotime($end_date)).' ('.$days.'days time). Renew via - '.$sms_pay_url.'. Thanks for choosing BaseSPOT';
					$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $sms_details);
					if($push_sms == true){
						//try update cron
						$this->update_cron('contract', $contract_id, 1, 'Passed');	
					} else {
						//try update cron
						$this->update_cron('contract', $contract_id, 0, 'Failed');
					}
						
				} else if($days == 3) {
					$expires = date('d M, Y', strtotime($end_date)).' ('.$days.'days time)';
					$details = '
						Your BaseSPOT is about to expire. Please see details below.<br /><br />
						'.$this->renew_temp($product, $amount, $expires, 'Client ID', $client_no).'
						'.$pay_url.'<br /><br />
						Thanks for choosing BaseSPOT
					';
					
					// send Email
					if($client_emails != '') {
						$email_result = '';
						$from = app_email;
						$subject = 'BaseSPOT Notification';
						$name = 'BaseSPOT';
						$sub_head = 'Upcoming Renewal';
						
						$body = '
							Dear '.$client_name.'<br /><br />'.$details.'
						';
						
						$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
						
						if($email_result == TRUE){
							// now admins
							$notify_list .= '
								<tr>
									<td>'.$client_name.'</td>
									<td>'.$product.'</td>
									<td align="right">&#8358;'.number_format((float)$amount).'</td>
									<td>'.$expires.'</td>
								</tr>
							';
						}
					}
					
					// send SMS
					$sms_details = 'Your BaseSPOT account will expire on '.date('d M, Y', strtotime($end_date)).' ('.$days.'days time). Renew via - '.$sms_pay_url.'. Thanks for choosing BaseSPOT';
					$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $sms_details);
					if($push_sms == true){
						//try update cron
						$this->update_cron('contract', $contract_id, 1, 'Passed');	
					} else {
						//try update cron
						$this->update_cron('contract', $contract_id, 0, 'Failed');
					}
					
				} else if($days == 1) {
					$expires = date('d M, Y', strtotime($end_date)).' (24hours time)';
					$details = '
						Your BaseSPOT is about to expire. Please see details below.<br /><br />
						'.$this->renew_temp($product, $amount, $expires, 'Client ID', $client_no).'
						'.$pay_url.'<br /><br />
						Thanks for choosing BaseSPOT
					';
					
					// send Email
					if($client_emails != '') {
						$email_result = '';
						$from = app_email;
						$subject = 'BaseSPOT Notification';
						$name = 'BaseSPOT';
						$sub_head = 'Upcoming Renewal';
						
						$body = '
							Dear '.$client_name.'<br /><br />'.$details.'
						';
						
						$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
						
						if($email_result == TRUE){
							// now admins
							$notify_list .= '
								<tr>
									<td>'.$client_name.'</td>
									<td>'.$product.'</td>
									<td align="right">&#8358;'.number_format((float)$amount).'</td>
									<td>'.$expires.'</td>
								</tr>
							';
						}
					}
					
					// send SMS
					$sms_details = 'Your BaseSPOT account will expire on '.date('d M, Y', strtotime($end_date)).' (24hours time). Renew via - '.$sms_pay_url.'. Thanks for choosing BaseSPOT';
					$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $sms_details);
					if($push_sms == true){
						//try update cron
						$this->update_cron('contract', $contract_id, 1, 'Passed');
						
						// notify customer services and technicals
						$admin_phones = '08094223203, 08175135147, 08175135103';
						$admin_details = $client_name.' account will expires on '.date('d M, Y', strtotime($end_date)).' (24hours time).';
						$this->Crud->sms_send('BaseSPOT', $admin_phones, $admin_details);	
					} else {
						//try update cron
						$this->update_cron('contract', $contract_id, 0, 'Failed');	
					}
					
				} else if($days == 0) {
					// try to update Billing API as well
					$upd_billing_api = array(
						'contract' => array(
							'state' => 'disabled',
						),
					);
					$result = $this->Crud->billing_update_records('api/contracts/'.$contract_no, $upd_billing_api);
					if(!empty($result)){
						// try to update Native as well
						$upd_data = array(
							'expired' => 1
						);
						$this->Crud->update('id', $contract_id, 'bs_contract', $upd_data);

						// now try send sms
						$details = '
							Your BaseSPOT is about to expire. Please see details below.<br /><br />
							'.$this->renew_temp($product, $amount, 'Expired', 'Client ID', $client_no).'
							'.$pay_url.'<br /><br />
							You can also contact customer support on +234 (809) 571 2870<br /><br />
							Thanks for choosing BaseSPOT
						';
						
						// send Email
						if($client_emails != '') {
							$email_result = '';
							$from = app_email;
							$subject = 'BaseSPOT Notification';
							$name = 'BaseSPOT';
							$sub_head = 'Upcoming Renewal';
							
							$body = '
								Dear '.$client_name.'<br /><br />'.$details.'
							';
							
							$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
							
							if($email_result == TRUE){
								// now admins
    							$notify_list .= '
    								<tr>
    									<td>'.$client_name.'</td>
    									<td>'.$product.'</td>
    									<td align="right">&#8358;'.number_format((float)$amount).'</td>
    									<td>Expired</td>
    								</tr>
    							';
							}
						}
						
						// send SMS
						$sms_details = 'Your account has expired. Pay via - '.$sms_pay_url.', kindly contact customer care +234 (809) 571 2870. Thanks for choosing BaseSPOT';
						$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $sms_details);
						if($push_sms == true){
							//try update cron
							$this->update_cron('contract', $contract_id, 1, 'Passed');
							
							// notify customer services and technicals
							$admin_phones = '08094223203, 08175135147, 08175135103';
							$admin_details = $client_name.' account has expired';
							$this->Crud->sms_send('BaseSPOT', $admin_phones, $admin_details);	
						} else {
							//try update cron
							$this->update_cron('contract', $contract_id, 0, 'Failed');
						}
					}

				}
			}
			
			// send overral notification to admin
			if($notify_list) {
				$from = app_email;
				$subject = 'Notification';
				$name = 'BaseSPOT';
				$sub_head = 'Subscriptions Notification';
				$admin_email = 'coo@tehilahbase.com, cto@tehilahbase.com, cssdigital@tehilahbase.com';
			
				$body = '
					Hello,<br /><br />Subscription accounts summary. Please see details below.<br /><br />
					<table>
						<tr>
							<td><b>CLIENT</b></td>
							<td><b>TARIFF</b></td>
							<td class="right"><b>AMOUNT</b></td>
							<td><b>EXPIRY</b></td>
						</tr>
						'.$notify_list.'
					</table>
					<br /><br />
					Thanks you.
				';
				$this->Crud->send_email($admin_email, $from, $subject, $body, $name, $sub_head);
			}
		}
	}
	////////////////// STOP BaseSPOT Subscription Cron //////////////////////////
	
	////////////////// START BaseSPOT MOBILE Subscription Cron //////////////////////////
	public function basemobile_sub() {
		$notify_list = '';
		$allmobile = $this->Crud->read('bs_mobile_client');
		if(!empty($allmobile)){
			foreach($allmobile as $mobile){
				$mobile_id = $mobile->id;
				$mid = 'BSM-'.$mobile->id;
				$mdn = $mobile->mdn;
				$product_id = $mobile->product_id;
				$client_id = $mobile->client_id;
				$end_date = $mobile->end_date;		
				
				// get client details
				$client_name = $this->Crud->read_field('id', $client_id, 'bs_client', 'name');
				$client_phones = $this->Crud->read_field('id', $client_id, 'bs_client', 'phone');
				$client_emails = $this->Crud->read_field('id', $client_id, 'bs_client', 'email');
				
				// get product details
				$product = $this->Crud->read_field('id', $product_id, 'bs_mobile_tariff', 'name');
				$amount = $this->Crud->read_field('id', $product_id, 'bs_mobile_tariff', 'price');
				
				// get difference in days
				$diff = (strtotime($end_date) - strtotime(date('Y-m-d')));
				$days = floor($diff / (60*60*24));
				
				$pay_url = 'https://goo.gl/CWWXeF';
				
				// send notification if 7days, 3days, 1day left or its expired
				if($days == 7) {
					$expires = date('d M, Y', strtotime($end_date)).' ('.$days.'days time)';
					$details = '
						Your BaseSPOT MOBILE is about to expire. Please see details below.<br /><br />
						'.$this->renew_temp($product, $amount, $expires, 'MID', $mid).'
						<div class="mbtn"><a class="btn btn1" href="'.$pay_url.'">Renew Account</a></div><br />
						<i><small>If payment button not working, kindly copy and paste this to your browser.</small><br />'.$pay_url.'</i><br /><br />
						Thanks for choosing BaseSPOT MOBILE
					';
					
					// send Email
					if($client_emails != '') {
						$email_result = '';
						$from = app_email;
						$subject = 'BaseSPOT MOBILE Notification';
						$name = 'BaseSPOT';
						$sub_head = 'Upcoming Renewal';
						
						$body = '
							Dear '.$client_name.'<br /><br />'.$details.'
						';
						
						$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
						
						if($email_result == TRUE){
							// now admins
							$notify_list .= '
								<tr>
									<td>'.$client_name.' ('.$mid.')</td>
									<td>'.$product.'</td>
									<td align="right">&#8358;'.number_format((float)$amount).'</td>
									<td>'.$expires.'</td>
								</tr>
							';
						}
					}
					
					// send SMS
					$sms_details = 'Your BaseSPOT MOBILE account will expire on '.date('d M, Y', strtotime($end_date)).' ('.$days.'days time). Renew with MID ('.$mid.') via - '.$pay_url.'. Thanks for choosing BaseSPOT';
					$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $sms_details);
						
				} else if($days == 3) {
					$expires = date('d M, Y', strtotime($end_date)).' ('.$days.'days time)';
					$details = '
						Your BaseSPOT MOBILE is about to expire. Please see details below.<br /><br />
						'.$this->renew_temp($product, $amount, $expires, 'MID', $mid).'
						<div class="mbtn"><a class="btn btn1" href="'.$pay_url.'">Renew Account</a></div><br />
						<i><small>If payment button not working, kindly copy and paste this to your browser.</small><br />'.$pay_url.'</i><br /><br />
						Thanks for choosing BaseSPOT MOBILE
					';
					
					// send Email
					if($client_emails != '') {
						$email_result = '';
						$from = app_email;
						$subject = 'BaseSPOT MOBILE Notification';
						$name = 'BaseSPOT MOBILE';
						$sub_head = 'Upcoming Renewal';
						
						$body = '
							Dear '.$client_name.'<br /><br />'.$details.'
						';
						
						$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
						
						if($email_result == TRUE){
							// now admins
							$notify_list .= '
								<tr>
									<td>'.$client_name.' ('.$mid.')</td>
									<td>'.$product.'</td>
									<td align="right">&#8358;'.number_format((float)$amount).'</td>
									<td>'.$expires.'</td>
								</tr>
							';
						}
					}
					
					// send SMS
					$sms_details = 'Your BaseSPOT MOBILE account will expire on '.date('d M, Y', strtotime($end_date)).' ('.$days.'days time). Renew with MID ('.$mid.') via - '.$pay_url.'. Thanks for choosing BaseSPOT';
					$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $sms_details);
					
				} else if($days == 1) {
					$expires = date('d M, Y', strtotime($end_date)).' (24 hours time)';
					$details = '
						Your BaseSPOT MOBILE is about to expire. Please see details below.<br /><br />
						'.$this->renew_temp($product, $amount, $expires, 'MID', $mid).'
						<div class="mbtn"><a class="btn btn1" href="'.$pay_url.'">Renew Account</a></div><br />
						<i><small>If payment button not working, kindly copy and paste this to your browser.</small><br />'.$pay_url.'</i><br /><br />
						Thanks for choosing BaseSPOT MOBILE
					';
					
					// send Email
					if($client_emails != '') {
						$email_result = '';
						$from = app_email;
						$subject = 'BaseSPOT MOBILE Notification';
						$name = 'BaseSPOT MOBILE';
						$sub_head = 'Upcoming Renewal';
						
						$body = '
							Dear '.$client_name.'<br /><br />'.$details.'
						';
						
						$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
						
						if($email_result == TRUE){
							// now admins
							$notify_list .= '
								<tr>
									<td>'.$client_name.' ('.$mid.')</td>
									<td>'.$product.'</td>
									<td align="right">&#8358;'.number_format((float)$amount).'</td>
									<td>'.$expires.'</td>
								</tr>
							';
						}
					}
					
					// send SMS
					$sms_details = 'Your BaseSPOT MOBILE account will expire on '.date('d M, Y', strtotime($end_date)).' (24hours time). Renew with MID ('.$mid.') via - '.$pay_url.'. Thanks for choosing BaseSPOT';
					$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $sms_details);
					if($push_sms == true){
						// notify customer services and technicals
						$admin_phones = '08094223203, 08175135147, 08175135103';
						$admin_details = $client_name.' account will expires on '.date('d M, Y', strtotime($end_date)).' (24hours time).';
						$this->Crud->sms_send('BaseMOBILE', $admin_phones, $admin_details);	
					}
					
				} else if($days == 0) {
					// try to update Mobile account as well
					$result = $this->Crud->update('id', $mobile_id, 'bs_mobile_client', array('block'=>1));
					
					// block lte device
					$this->block_account($mdn, 'block');
					
					// send notification
					if(!empty($result)){
						// now try send sms
						$details = '
							Your BaseSPOT MOBILE has expired. Please see details below.<br /><br />
							'.$this->renew_temp($product, $amount, 'Expired', 'MID', $mid).'
							<div class="mbtn"><a class="btn btn1" href="'.$pay_url.'">Renew Account</a></div><br />
							<i><small>If payment button not working, kindly copy and paste this to your browser.</small><br />'.$pay_url.'</i><br /><br />You can also contact customer support +234 (809) 571 2870<br /><br />
							Thanks for choosing BaseSPOT MOBILE
						';
						
						// send Email
						if($client_emails != '') {
							$email_result = '';
							$from = app_email;
							$subject = 'BaseSPOT MOBILE Notification';
							$name = 'BaseSPOT MOBILE';
							$sub_head = 'Upcoming Renewal';
							
							$body = '
								Dear '.$client_name.'<br /><br />'.$details.'
							';
							
							$email_result = $this->Crud->send_email($client_emails, $from, $subject, $body, $name, $sub_head);
							
							if($email_result == TRUE){
								// now admins
								$notify_list .= '
								<tr>
									<td>'.$client_name.' ('.$mid.')</td>
									<td>'.$product.'</td>
									<td align="right">&#8358;'.number_format((float)$amount).'</td>
									<td>Expired</td>
								</tr>
							';
							}
						}
						
						// send SMS
						$sms_details = 'Your BaseSPOT MOBILE account has expired. Pay with MID ('.$mid.') via - '.$pay_url.'. Kindly contact customer care +234 (809) 571 2870. Thanks for choosing BaseSPOT';
						$push_sms = $this->push_sms($client_id, $client_name, $client_phones, $details);
						if($push_sms == true){
							// notify customer services and technicals
							$admin_phones = '08094223203, 08175135147, 08175135103';
							$admin_details = $client_name.' account has expired';
							$this->Crud->sms_send('BaseMOBILE', $admin_phones, $admin_details);	
						} else {
						}
					}
					
				}
				
			}
			
			// send overral notification to admin
			if($notify_list) {
			  	$from = app_email;
			 	$subject = 'Notification';
				$name = 'BaseSPOT MOBILE';
				$sub_head = 'Subscriptions Notification';
			 	$admin_email = 'coo@tehilahbase.com, cto@tehilahbase.com, cssdigital@tehilahbase.com';
			
				$body = '
					Hello,<br /><br />Subscription accounts summary. Please see details below.<br /><br />
					<table>
						<tr>
							<td><b>CLIENT</b></td>
							<td><b>TARIFF</b></td>
							<td class="right"><b>AMOUNT</b></td>
							<td><b>EXPIRY</b></td>
						</tr>
						'.$notify_list.'
					</table>
					<br /><br />
					Thanks you.
				';
				$this->Crud->send_email($admin_email, $from, $subject, $body, $name, $sub_head);
			}
		}
	}
	
	// change status
	public function block_account($mdn, $type) {
		if($mdn && $type) {
			$endpoint = $type; // block or unblock
			$key = $this->Crud->lte_key();
			$id = 25;
			
			$hash_data = strtoupper($key.$mdn.$id.$endpoint);
			$token = hash('sha512', $hash_data);
			
			$data = array(
				'mdn' => $mdn
			);
			$this->Crud->lte_post($endpoint, strtoupper($token), $data);
		}
	}
	////////////////// STOP BaseSPOT MOBILE Subscription Cron //////////////////////////
	
	////////////////// START Channel Partner Commission Cron //////////////////////////
	public function cp_commission() {
		// only compute settlement at the last date of the month
		$last_day = date('Y-m-t');
		if($last_day == date('Y-m-d')) {
			$com = (float)$this->Crud->read_field('type', 'client', 'bs_settlement_setting', 'value');
			$full_com = (float)$this->Crud->read_field('type', 'full_com', 'bs_settlement_setting', 'value');
			$half_com = (float)$this->Crud->read_field('type', 'half_com', 'bs_settlement_setting', 'value'); 
			$partner_list = '';
			
			$partner = $this->Crud->read_single('type', 'Channel Partner', 'bs_client');
			if(!empty($partner)) {
				foreach($partner as $part) {
					$partner_id = $part->id;
					$partner_name = $part->name;
					$partner_email = $part->email;
					
					// get earnings
					$total_earning = 0; $customer_count = 0; $dedicated_count = 0;
					$clients = $this->Crud->read_single('type_id', $partner_id, 'bs_mobile_client');
					if(!empty($clients)) {
						foreach($clients as $cli) {
							$client_id = $cli->client_id;
							$cli_reg_date = $cli->reg_date;
							
							// count number of customers this month
							if(date('M Y') == date('M Y', strtotime($cli_reg_date))){
								$customer_count += 1;
								
								// count number of dedicated this month
        						$pdt_name = $this->Crud->read_field('id', $cli->product_id, 'bs_mobile_tariff', 'name');
        						if(strpos($pdt_name, 'Dedicated') === 0) {$dedicated_count += 1;}
							}	
							
							// calculate subs
							$count = 0;
							$client_subs = $this->Crud->read_single_order('client_id', $client_id, 'bs_mobile_subs', 'id', 'asc');
							if(!empty($client_subs)) {
								foreach($client_subs as $subs) {
									$sub_start_date = $subs->start_date;
									$sub_amount = (float)$subs->amount;
									$sub_duration = $subs->duration;
									
									// calculate current earnings
									if(date('M Y') == date('M Y', strtotime($sub_start_date))){
										// check if it's first sales, to remove first month sub
										if($count == 0) {
											if($sub_duration > 1) {
												$silver_amt = $this->Crud->read_field('name', 'Silver', 'bs_mobile_tariff', 'price');
												$total_earning = $total_earning + ($sub_amount - (float)$silver_amt); // remove first month sub
											}
										} else {
											$total_earning += $sub_amount; // total sum of subs this month
										}
									}
									$count += 1;
								}
							}
						}
					}
					
					// get carry over
					$carry_over = 0;
					$allearn = $this->Crud->read_single('partner_id', $partner_id, 'bs_settlement');
					if(!empty($allearn)) {
						foreach($allearn as $learn) {
							if($learn->status == 0) {
								$carry_over += (float)$learn->payable;	
							}
						}
					}
					
					$payable = 0; $total_payable = 0;
					if($customer_count < $com) {
						$payable = $total_earning * $half_com;
					} else {
						$payable = $total_earning * $full_com;	
					}
					
					// if dedicated client this month is more than 1, give full commission
        			if($dedicated_count > 0) {
        				$payable = $total_earning * $full_com;
        			}
					
					if($carry_over > 0){$total_payable = $payable + $carry_over;} else {$total_payable = $payable;}
					
					// now register settlments
					$set_reg['company_id'] = 2;
					$set_reg['partner_id'] = $partner_id;
					$set_reg['month'] = date('M Y');
					$set_reg['customers'] = $customer_count;
					$set_reg['earning'] = $payable;
					$set_reg['payable'] = $total_payable;
					$set_reg['reg_date'] = date(fdate);
					
					if($this->Crud->check2('partner_id', $partner_id, 'month', date('M Y'), 'bs_settlement') <= 0) { 
						if($this->Crud->create('bs_settlement', $set_reg) > 0) {
							// send email to partner
							if($partner_email) {
								$from = app_email;
								$subject = 'BaseSPOT CP COMMISSIONS';
								$name = 'BaseSPOT PARTNER';
								$sub_head = 'Channel Partners Commissions';
							
								$partner_body = '
									Dear '.$partner_name.',<br /><br />Your Commission has been computed for '.date('M, Y').'. Please see details below.<br /><br />
									<table>
										<tr>
											<td><b>CLIENTS</b></td>
											<td class="right">'.$customer_count.'</td>
										</tr>
										<tr>
											<td><b>EARNINGS</b></td>
											<td class="right">&#8358;'.number_format($payable,2).'</td>
										</tr>
										<tr>
											<td><b>CARRIED OVER</b></td>
											<td class="right">&#8358;'.number_format($carry_over,2).'</td>
										</tr>
										<tr>
											<td><b>PAYABLE</b></td>
											<td class="right">&#8358;'.number_format($total_payable,2).'</td>
										</tr>
									</table>
									<br /><br />
									Thanks for partnering with BaseSPOT.
								';
								$this->Crud->send_email($partner_email, $from, $subject, $partner_body, $name, $sub_head);	
							}
							
							// compile for admin
							$partner_list .= '
								<tr>
									<td>'.$partner_name.'</td>
									<td>'.$customer_count.'</td>
									<td class="right">&#8358;'.number_format($total_payable,2).'</td>
								</tr>
							';	
						}
					}
				}
			}
			
			if($partner_list) {
				$from = app_email;
				$subject = 'BaseSPOT CP COMMISSIONS';
				$name = 'BaseSPOT PARTNER';
				$sub_head = 'Channel Partners Commissions';
				$email = 'coo@tehilahbase.com, cto@tehilahbase.com';
			
				$body = '
					Hello,<br /><br />BaseSPOT PARTNERS Commission has been computed for '.date('M, Y').'. Please see details below.<br /><br />
					<table>
						<tr>
							<td><b>PARTNER</b></td>
							<td><b>CLIENTS</b></td>
							<td class="right"><b>PAYABLE</b></td>
						</tr>
						'.$partner_list.'
					</table>
					<br /><br />
					Thanks you.
				';
				$this->Crud->send_email($email, $from, $subject, $body, $name, $sub_head);
			}
		} 
	}
	////////////////// START Channel Partner Commission Cron //////////////////////////
	
	////////////////// START Signup Form Cron //////////////////////////
	public function signup_form() {
		$deactivate_acc = array();
		$allform = $this->Crud->read('bs_signup_form');
		if(!empty($allform)){
			foreach($allform as $rec) {
				$id = $rec->id;
				$client_id = $rec->client_id;
				$account = $rec->account;
				$phone = $rec->phone;
				$email = $rec->email;
				$complete = $rec->complete;
				$grace_end = date('Y-m-d', strtotime('+'.$rec->grace_period.' day', strtotime($rec->grace_date)));
				
				// get uploaded documents
				$save_doc_array = array(); // keep all registered in array
				$get_doc = $this->Crud->read_single('client_id', $client_id, 'bs_doc');
				if(!empty($get_doc)){
					foreach($get_doc as $gdoc) {
						$save_doc_array[] = $gdoc->type_id;
					}
				}
				
				$to_upload = '';
				$get_type = $this->Crud->read('bs_doc_type');
				if(!empty($get_type)) {
					foreach($get_type as $gtype) {
						if(!in_array($gtype->id, $save_doc_array)){
							if($gtype->name != 'SignUp Form'){
								if($gtype->name == 'Certificate of Incorporation'){
									// don't list COI is account not Business
									if($rec->is_business == 1){
										$to_upload .= $gtype->name.', ';
									}
								} else {
									$to_upload .= $gtype->name.', ';	
								}
							}
						}
					}
				}
				
				// get contract no
				$contract_no = 0;
				$getcn = $this->Crud->read_single('client_id', $client_id, 'bs_contract');
				if(!empty($getcn)) {
					foreach($getcn as $cn) {
						$contract_no = $cn->contract_no;	
					}
				}
				
				// check if client completed upload
				if($complete == 0) {
					if($to_upload == '') {
						// force to complete
						$comp = array('complete' => 1);
						$this->Crud->update('id', $id, 'bs_signup_form', $comp);
						$complete = 1;
						
						// enable account
						$upd_billing_api = array(
							'contract' => array(
								'state' => 'enabled',
							),
						);
						$result = $this->Crud->billing_update_records('api/contracts/'.$contract_no, $upd_billing_api);
						$this->Crud->billing_apply_changes();
						
						// update the contract
						$con_upd = array('state'=>'enabled', 'expired'=>0);
						$this->Crud->update('client_id', $client_id, 'bs_contract', $con_upd);
					}
				}
				
				if($complete == 0) {
					$now = new DateTime(date('Y-m-d'));
					$expire = new DateTime($grace_end);
					$interval = $now->diff($expire);
					$days_left = $interval->format('%R%a'); // with absolute sign + or -
					if($days_left == 0) {
						// deactivate the account
						$upd_billing_api = array(
							'contract' => array(
								'state' => 'disabled',
							),
						);
						$result = $this->Crud->billing_update_records('api/contracts/'.$contract_no, $upd_billing_api);
						$this->Crud->billing_apply_changes();
						
						// update the contract
						$con_upd2 = array('state'=>'disabled', 'expired'=>1);
						$this->Crud->update('client_id', $client_id, 'bs_contract', $con_upd2);
						
						$details = 'Dear '.$account.', your account has been deactivated beacuse you failed to upload '.$to_upload.' please contact supports.';
						$resp = $this->Crud->sms_send('BaseSPOT', $phone, $details);
						$deactivate_acc[] = $account;
					} else if($days_left > 0) {
						if($days_left == 1) {
							$day = $interval->format('%a').' day';
						} else {
							$day = $interval->format('%a').' days';	
						}
						$details = 'Dear '.$account.', your account will deactivate in '.$day.' beacuse you are yet to upload '.$to_upload.' please do so.';
						$resp = $this->Crud->sms_send('BaseSPOT', $phone, $details);
					}
				}
			}
			
			// notify admins about deactivated accounts
			if(!empty($deactivate_acc)){
				$list_acc = '';
				for($i=0; $i < count($deactivate_acc); $i++){
				    $list_acc .= $deactivate_acc[$i].'<br/>';
				}
				
				$from = app_email;
				$subject = '[BaseSPOT] Deactivated Accounts';
				$name = 'BaseSPOT';
				$sub_head = 'Incomplete Signup Form Accounts';
							
				$body = '
					Dear Tehilah Base Digital<br /><br />The following accounts were deactivated due to incomplete Signup Form:<br /><br />'.$list_acc.'
				';
							
				$admin_list = 'coo@tehilahbase.com, cssdigital@tehilahbase.com, cto@tehilahbase.com, ed@tehilahbase.com';
				$this->Crud->send_email($admin_list, $from, $subject, $body, $name, $sub_head);
			}
		}
	}
	////////////////// START Signup Form Cron //////////////////////////
	
	////////////////// START Apply Changes //////////////////////////
	public function apply_changes() {
		$this->Crud->billing_apply_changes();
	}
	////////////////// END Apply Changes //////////////////////////
	
	////////////////// START Send To-Do Reminder //////////////////////////
	public function todo_reminder() {
		$reminder = $this->Crud->read('bs_kpi_reminder');
		if(!empty($reminder)) {
			foreach($reminder as $rm) {
				$staff_id = $rm->staff_id;
				$to_remind = $rm->reminder;	
				$remind_date = $rm->remind_date;
				$alert = json_decode($rm->type);
				
				// get task name
				$task_name = $this->Crud->read_field('id', $rm->task_id, 'bs_kpi_task', 'name');
				
				// get staff name, email and phone
				$staff_name = $this->Crud->read_field('id', $staff_id, 'bs_staff', 'firstname').' '.$this->Crud->read_field('id', $staff_id, 'bs_staff', 'lastname');
				$staff_email = $this->Crud->read_field('id', $staff_id, 'bs_staff', 'email');	
				$staff_phone = $this->Crud->read_field('id', $staff_id, 'bs_staff', 'phone');
				
				// send reminder at last 5 mins to set time.
				$time_left = $this->Crud->date_diff(date('Y-m-d H:i:s'), $remind_date, 'minutes');
				if($time_left > 0 && $time_left < 6) {
					// check for email alert
					if(in_array('email', $alert)) {
						if($staff_email) {
							$from = app_email;
							$subject = '[BaseSOFT] Reminder';
							$name = 'BaseSOFT';
							$sub_head = $task_name.' Reminder';
										
							$body = '
								Dear '.$staff_name.',<br /><br />You have a reminder set for <b>'.$task_name.'</b>:<br /><br />'.$to_remind.'
							';
							
							$this->Crud->send_email($staff_email, $from, $subject, $body, $name, $sub_head);
						}
					}
					
					// check for sms alert
					if(in_array('sms', $alert)) {
						if($staff_phone) {
							$sms_details = 'REMINDER: '.$to_remind;
							$this->Crud->sms_send('BaseSOFT', $staff_phone, $sms_details);
						}
					}
				}
			}
		}
	}
	////////////////// END Send To-Do Reminder //////////////////////////
	
	////////////////// START Payment Dues Reminder //////////////////////////
	public function dues_reminder() {
		$reminder = $this->Crud->read('bs_fee_reminder');
		if(!empty($reminder)) {
			foreach($reminder as $rm) {
				$id = $rm->id;
				$staff_id = $rm->staff_id;
				$to_remind = $rm->name;	
				$details = $rm->details;	
				$remind_date = $rm->rem_date;
				$recurrent = $rm->recurrent;
				$recurrent_value = $rm->recurrent_value;
				$active = $rm->active;
				
				// get staff name, email and phone
				$staff_name = $this->Crud->read_field('id', $staff_id, 'bs_staff', 'firstname').' '.$this->Crud->read_field('id', $staff_id, 'bs_staff', 'lastname');
				$staff_email = $this->Crud->read_field('id', $staff_id, 'bs_staff', 'email');	
				$staff_phone = $this->Crud->read_field('id', $staff_id, 'bs_staff', 'phone');
				
				// send reminder 3days before and also same day.
				$time_left = $this->Crud->date_diff(date('Y-m-d H:i:s'), $remind_date, 'days');
				if($active == 1 && $time_left <= 3 && $time_left > 2) {
					// check for email alert
					if($staff_email) {
						if($staff_email) {
							$from = app_email;
							$subject = '[BaseSOFT] Fees Payment Reminder';
							$name = 'BaseSOFT';
							$sub_head = $to_remind.' Payment Reminder';
										
							$body = '
								Dear '.$staff_name.',<br /><br />You have a Fees Payment Reminder set for <b>'.$to_remind.'</b>:<br /><br />'.$details.' on '.date('M d, Y', strtotime($remind_date)).'
							';
							
							$this->Crud->send_email($staff_email, $from, $subject, $body, $name, $sub_head);
						}
					}
					
					// check for sms alert
					if($staff_phone) {
						if($staff_phone) {
							$sms_details = 'PAYMENT REMINDER: '.$to_remind.' on '.date('M d, Y', strtotime($remind_date));
							$this->Crud->sms_send('BaseSOFT', $staff_phone, $sms_details);
						}
					}
				} else {
					if($active == 1 && $time_left <= 1 && $time_left > 0) {
						// check recurrent and auto fix next date
						if($recurrent == 1) {
							if($recurrent_value == 'Daily') {
								$day = 1;
							} else if($recurrent_value == 'Monthly') {
								$day = 30;
							} else if($recurrent_value == 'Yearly') {
								$day = 365;
							}
							
							if($day) {
								$next_date = date(fdate, strtotime('+'.$day.' days'.$remind_date));	
								$this->Crud->update('id', $id, 'bs_fee_reminder', array('rem_date'=>$next_date));
							}
						}
						
						// check for email alert
						if($staff_email) {
							if($staff_email) {
								$from = app_email;
								$subject = '[BaseSOFT] Fees Payment Reminder';
								$name = 'BaseSOFT';
								$sub_head = $to_remind.' Payment Reminder';
											
								$body = '
									Dear '.$staff_name.',<br /><br />You have a Fees Payment Reminder set for <b>'.$to_remind.'</b>:<br /><br />'.$details.' tommorrow
								';
								
								$this->Crud->send_email($staff_email, $from, $subject, $body, $name, $sub_head);
							}
						}
						
						// check for sms alert
						if($staff_phone) {
							if($staff_phone) {
								$sms_details = 'PAYMENT REMINDER: '.$to_remind.' tomorrow';
								$this->Crud->sms_send('BaseSOFT', $staff_phone, $sms_details);
							}
						}
					}
				}
			}
		}
	}
	////////////////// END Payment Dues Reminder //////////////////////////
	
	
	////////////////// START Cron Update //////////////////////////
	public function update_cron($type='', $of='', $state='', $response='') {
		$ins_cron = array(
			'cron_type' => $type,
			'cron_of' => $of,
			'cron_date' => date('Y-m-d'),
			'cron_time' => date('H:i:s'),
			'cron_state' => $state,
			'cron_response' => $response,
		);
		$ins_id = $this->Crud->create('bs_cron', $ins_cron);
	}
	////////////////// STOP Cron Update //////////////////////////
	
	////////////////// RENEWAL TEMPLETE //////////////////////////
	private function renew_temp($account='', $amount='', $expire='', $type='', $id='') {
		$content = '
			<table>
				<tr>
					<td><b>ACCOUNT</b></td>
					<td class="right">'.$account.'</td>
				</tr>
				<tr>
					<td><b>'.strtoupper($type).'</b></td>
					<td class="right">'.$id.'</td>
				</tr>
				<tr>
					<td><b>EXPIRES</b></td>
					<td class="right">'.$expire.'</td>
				</tr>
				<tr>
					<td><b>AMOUNT</b></td>
					<td class="right">&#8358;'.number_format($amount,2).'</td>
				</tr>
			</table>
		';
		
		return $content;	
	}
	////////////////// RENEWAL TEMPLETE //////////////////////////
	
	////////////////// START SMS //////////////////////////
	public function push_sms($client_id='', $client='', $phones='', $details='') {
		$sent = 0; $status = 'Failed'; $unit = 0;
		if($phones != '' && $details != ''){
			$resp = $this->Crud->sms_send('BaseSPOT', $phones, $details);
			$resp = json_decode($resp);
			if($resp->data->status == 'success') {
				$sent = 1;
				$status = 'Successful';
			}
		}
		
		$now = date("Y-m-d H:i:s");
		
		// try and resgister SMS
		$insert_data = array(
			'company_id' => 2,
			'client_id' => $client_id,
			'template_id' => 2,
			'sent_date' => date('Y-m-d'),
			'details' => $details,
			'sent' => $sent,
			'status' => $status,
			'unit' => $unit,
			'reg_date' => $now
		);
		
		$ins_id = $this->Crud->create('bs_sms', $insert_data);
		if($ins_id > 0){
			return true;
		} else {
			return false;
		}
	}
	////////////////// START SMS //////////////////////////
}
