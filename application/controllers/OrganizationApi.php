<?php
class OrganizationApi extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('RestApi_model');
	}

	public function save_Org_Application() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			//validate complete json
			//create orgnization object from json struning
			//all valication here
			//validate duplicate entry
			//save the data to database
			$this->Appln_ID;
			//select new orgnization object database
			//create json string from new orgnization object

			$data = array('errr' => '', 'org_data' => $jsonStringfromOrgobject);

			echo json_encode($data);
		}
	}

	public function save_Org_Documents() {

		// echo "<pre>";
		// print_r($_POST);
		// print_r($_FILES);
		// echo "<pre>";

		$app_id = $_POST['app_id'];
		$is_success_flag = 1;

		$path = './assets/uploaded_dcuments/';

		$comp_reg_doc_1 = '';
		if (isset($_FILES["comp_reg_doc_1"]['name']) && !empty($_FILES["comp_reg_doc_1"]['name'])) {
			$comp_reg_doc_1 = $_FILES["comp_reg_doc_1"]['name'];
		}

		$comp_reg_doc_2 = '';
		if (isset($_FILES["comp_reg_doc_2"]['name']) && !empty($_FILES["comp_reg_doc_2"]['name'])) {
			$comp_reg_doc_2 = $_FILES["comp_reg_doc_2"]['name'];
		}

		if (empty($comp_reg_doc_1) && empty($comp_reg_doc_2)) {
			$data = array('errr' => 1, 'msg' => 'Please Upload company registered document -1 or document -2');
			echo json_encode($data);
			exit();
		}
		$Doc1_Upload_flag = 0;
		$Doc1_Level1 = 0;
		$Doc1_Level2 = 0;

		if (!empty($comp_reg_doc_1)) {

			$comp_reg_doc_1 = time() . "_" . $comp_reg_doc_1;
			$uploaded_1 = $this->upload_files('comp_reg_doc_1', $comp_reg_doc_1, $path);

			if ($uploaded_1) {
				$is_success_flag = 0;
				$Doc1_Upload_flag = 1;
				$Doc1_Level1 = 1;
				$Doc1_Level2 = 1;
			}
		}
		$Doc2_Upload_falg = 0;
		$Doc2_Level1 = 0;
		$Doc2_Level2 = 0;
		if (!empty($comp_reg_doc_2)) {

			$comp_reg_doc_2 = time() . "_" . $comp_reg_doc_2;
			$uploaded_2 = $this->upload_files('comp_reg_doc_2', $comp_reg_doc_2, $path);
			if ($uploaded_2) {
				$is_success_flag = 0;
				$Doc2_Upload_falg = 1;
				$Doc2_Level1 = 1;
				$Doc2_Level2 = 1;
			}

		}

		if ($is_success_flag == 1) {
			$data = array('errr' => 1, 'msg' => 'Something went to wrong please contact to admin');
			echo json_encode($data);
			exit();
		} else {

			$MSA_Uploaded = 0;
			$Status_Level1 = 'In queue';
			$Emp_ID_Level1 = '99';

			$Status_Level2 = 1;
			$MSA_Level2 = 0;
			$Emp_ID_Level2 = '199';
			$Appln_status = 1;

			$document_array = array(
				'Appln_ID' => $app_id,
				'Doc1_Upload' => $Doc1_Upload_flag,
				'Doc2_Upload' => $Doc2_Upload_falg,
				'MSA_Uploaded' => $MSA_Uploaded,
				'Doc1_Level1' => $Doc1_Level1,
				'Doc2_Level1' => $Doc2_Level1,
				'Status_Level1' => $Status_Level1,
				'Emp_ID_Level1' => $Emp_ID_Level1,
				'Status_Level2' => $Status_Level2,
				'Doc1_Level2' => $Doc1_Level2,
				'Doc2_Level2' => $Doc2_Level2,
				'MSA_Level2' => $MSA_Level2,
				'Emp_ID_Level2' => $Emp_ID_Level2,
				'Appln_status' => $Appln_status,
				'Doc1_File_name' => $comp_reg_doc_1,
				'Doc1_File_path' => $path,
				'Doc2_File_name' => $comp_reg_doc_2,
				'Doc2_File_path' => $path,
			);

			$called_api_resp = $this->save_uploaded_document($document_array);
			if ($called_api_resp == 1) {
				$data = array('errr' => 0, 'msg' => 'Document uploaded successfully');
			} else {
				$data = array('errr' => 0, 'msg' => 'Document uploaded successfully but record is not saved.Please contact to admin');
			}
			echo json_encode($data);
			exit();
		}
	}

	public function upload_files($name_id, $file_name, $path) {
		$config = array();
		$config['upload_path'] = $path;
		$config["overwrite"] = FALSE;
		$config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
		$config['max_size'] = 2000;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($name_id)) {
			/*$error = array('error' => $this->upload->display_errors());
			print_r($error);*/
			return false;
		} else {
			return true;
		}
	}

	public function save_uploaded_document($data_array) {

		$itemList = array(
			'document_data' => array($data_array),
		);

		//echo "<pre>"; print_r($itemList); echo "</pre>";

		$post_document_data = json_encode($itemList);

		// echo "<br>ConnectWMS post string --><pre>";
		// print_r($post_document_data);
		// echo "</pre>"; //exit();

		$url = CALL_URL . "save_uploaded_documents";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_document_data);
		$response = curl_exec($ch);
		curl_close($ch);

		// echo "<br>API server response ---> <pre>";
		// print_r($response);
		// echo "</pre>";

		$json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response), true);

		//echo '<br>ConnecWMS response --> <pre>'.PHP_EOL; print_r($json); echo '</pre>'.PHP_EOL; exit();
		// echo '<br>ConnecWMS response --> <pre>' . PHP_EOL;
		// print_r($response);
		// echo '</pre>' . PHP_EOL; //exit();
		// echo $json['resp'];

		if (isset($json['resp']) && ($json['resp'] == 1)) {
			return 1;
		} else {
			return 0;
		}

	}

	public function verify_app_emailId(){

		$Appln_ID =$_POST['app_id'];

		if(!empty($Appln_ID)){

			$to       = 'vivek@goodmove.cloud';
			$subject  = 'App Verification Email';
			$message  = 'Hi, my message!';
			$headers  = 'From: akash.lokhande21@gmail.com' . "\r\n" .
			            'MIME-Version: 1.0' . "\r\n" .
			            'Content-type: text/html; charset=utf-8';
			if(mail($to, $subject, $message, $headers)){

				$itemList = array(
					'app_data' => array(
											'Appln_ID'=>$Appln_ID
										),
					);

				//echo "<pre>"; print_r($itemList); echo "</pre>";

				$post_document_data = json_encode($itemList);

			    $url = CALL_URL . "update_email_verification";

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_document_data);
				$response = curl_exec($ch);
				curl_close($ch);

				// echo "<br>API server response ---> <pre>";
				// print_r($response);
				// echo "</pre>";

				$json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response), true);

				if (isset($json['resp']) && ($json['resp'] == 1)) {
					$data = array('errr' => 0, 'msg' => 'Email id verification successfully');
				} else {
					$data = array('errr' => 0, 'msg' => 'Email id verification failed.Please contact to admin');
				}

				echo json_encode($data);
				exit();
			}else{

				$data = array('errr' => 1, 'msg' => 'Email sending failed');
				echo json_encode($data);
				exit();
			    //echo "Email sending failed";
			}
			
		}else{
			$data = array('errr' => 1, 'msg' => 'Application id required feild.Please send application id');
			echo json_encode($data);
			exit();
		}
	}

	public function verify_app_Website(){
		$website =$_POST['website'];

		$file = $website;
		$Appln_ID =$_POST['app_id'];

		if(!empty($Appln_ID)){

			$file_headers = @get_headers($file);
			if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
			    $data = array('errr' => 1, 'msg' => 'Currently website is not working state');
				echo json_encode($data);
				exit();
			}
			else {

				$itemList = array(
					'app_data' => array(
											'Appln_ID'=>$Appln_ID
										),
					);

				//echo "<pre>"; print_r($itemList); echo "</pre>";

				$post_document_data = json_encode($itemList);

			    $url = CALL_URL . "verify_Website";

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_document_data);
				$response = curl_exec($ch);
				curl_close($ch);

				// echo "<br>API server response ---> <pre>";
				// print_r($response);
				// echo "</pre>";

				$json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response), true);

				if (isset($json['resp']) && ($json['resp'] == 1)) {
					$data = array('errr' => 0, 'msg' => 'Website verification successfully');
				} else {
					$data = array('errr' => 0, 'msg' => 'Website verification failed.Please contact to admin');
				}

				echo json_encode($data);
				exit();
			}
			
		}else{
			$data = array('errr' => 1, 'msg' => 'Application id required feild.Please send application id');
			echo json_encode($data);
			exit();
		}
	}



}
