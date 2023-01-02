<?php
class OrgApply extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('App_helper');
		$this->load->helper('Auth_helper');

		$this->ERR_CODE = '';
		$this->ERR_DESCRIPTION = '';
		$this->SUC_CODE = '';
		$this->SUC_DESCRIPTION = '';
		$this->RES_LOGS = '';
		$this->RES_DATA = '';

	}

	public function show_apply_form() {

		//$this->load->model('AdminActivity_model');

		$ip_address = '';
		$mac_id = '';

		if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		//$macCommandString = "arp " . $ip_address . " | awk 'BEGIN{ i=1; } { i++; if(i==3) print $3 }'";
		//$mac_id = exec($macCommandString);

		//$ip_address = '';

		$data['ip_address'] = $ip_address;
		$data['mac_id'] = $mac_id;

		$data['excludeNavigation'] = 'YES';

		$data['main_content'] = 'org/org_apply_form';
		$this->load->view('theme/template', $data);
	}

	public function save_apply_form() {

		if (isset($_POST['ACTION']) && !empty($_POST['ACTION']) && $_POST['ACTION'] == 'SAVE_APP_REQUEST') {

			if (isset($_POST['POST_ORGDATA']) && !empty($_POST['POST_ORGDATA'])) {
				$jsonPostData = $_POST['POST_ORGDATA'];
				$arrPostData = json_decode($jsonPostData, true);
				if (!empty($arrPostData)) {

					//echo "<br>JsonArr--><pre>";	print_r($arrPostData);	echo "</pre>";
					$fileOutput1 = post_data('/saveApplyOrg', $jsonPostData);
					//echo "<br>FileOutput1-->" . $fileOutput1;
					$fileArry = json_decode($fileOutput1, true);
					if (isset($fileArry['ERR_CODE']) && isset($fileArry['SUC_CODE'])) {
						$this->ERR_CODE = $fileArry['ERR_CODE'];
						$this->ERR_DESCRIPTION = $fileArry['ERR_DESCRIPTION'];
						$this->SUC_CODE = $fileArry['SUC_CODE'];
						$this->SUC_DESCRIPTION = $fileArry['SUC_DESCRIPTION'];
						$this->RES_LOGS = $fileArry['RES_LOGS'];
						$this->RES_DATA = $fileArry['RES_DATA'];
					} else {
						$this->ERR_CODE = "API-REQUEST-FAIL";
						$this->ERR_DESCRIPTION = "Org save request is failed.";
						$this->RES_LOGS = $fileOutput1;
					}

				} else {
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = "Invalid Json data request.";
				}

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Json data request required.";
			}

		} else {
			$this->ERR_CODE = "INVALID-REQUEST";
			$this->ERR_DESCRIPTION = "This is unsported request to handle this controller.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);

	}

	public function get_org_appl_List() {

		//verify the user is logged in.

		$url = "/getOrgApplList";
		$jsonResp = get_data($url);

		if (!empty($jsonResp)) {
			$jsonArr = json_decode($jsonResp);
			if (isset($jsonArr->SUC_CODE) && ($jsonArr->SUC_CODE == 'SUCCESS')) {
				$orgData = $jsonArr->RES_DATA;
				$data['orgData'] = $orgData;
			} else {
				$this->ERR_CODE = 'The received json response is invalid.';
				$this->ERR_DESCRIPTION = $jsonResp;
			}

		} else {
			$this->ERR_CODE = 'The received json response is empty.';
			$this->ERR_DESCRIPTION = $jsonResp;
		}

		$errorMsg = getErrorString($this->ERR_CODE, $this->ERR_DESCRIPTION);
		$data['errorMsg'] = $errorMsg;

		$data['main_content'] = 'org/org_apply_list';
		$this->load->view('theme/template', $data);
	}

	public function assign_Org_Appln() {

		if (isset($_POST['ACTION']) && !empty($_POST['ACTION']) && $_POST['ACTION'] == 'ASSIGN_APPLN') {

			if (isset($_POST['POST_ORGDATA']) && !empty($_POST['POST_ORGDATA'])) {
				$jsonPostData = $_POST['POST_ORGDATA'];
				$arrPostData = json_decode($jsonPostData, true);
				if (!empty($arrPostData)) {

					//verify the user/employee is logged in
					//collect the emp id from session
					$user = $this->session->userdata('user');
					$empID = $user['emp_id'];
					$arrPostData['emp_id'] = $empID;

					//echo "<br>JsonArr--><pre>";	print_r($arrPostData);echo "</pre>";exit();

					$jsonPostData = json_encode($arrPostData);
					$fileOutput1 = post_data('/assignOrgAppln', $jsonPostData);
					//echo "<br>FileOutput1-->" . $fileOutput1;
					$fileArry = json_decode($fileOutput1, true);
					if (isset($fileArry['ERR_CODE']) && isset($fileArry['SUC_CODE'])) {
						$this->ERR_CODE = $fileArry['ERR_CODE'];
						$this->ERR_DESCRIPTION = $fileArry['ERR_DESCRIPTION'];
						$this->SUC_CODE = $fileArry['SUC_CODE'];
						$this->SUC_DESCRIPTION = $fileArry['SUC_DESCRIPTION'];
						$this->RES_LOGS = $fileArry['RES_LOGS'];
						$this->RES_DATA = $fileArry['RES_DATA'];
					} else {
						$this->ERR_CODE = "API-REQUEST-FAIL";
						$this->ERR_DESCRIPTION = "Org assigne request is failed.";
						$this->RES_LOGS = $fileOutput1;
					}

				} else {
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = "Invalid Json data request.";
				}

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Json data request required.";
			}

		} else {
			$this->ERR_CODE = "INVALID-REQUEST";
			$this->ERR_DESCRIPTION = "This is unsported request to handle this controller.";
		}

		$jsonArr = array(
			'ERR_CODE' => $this->ERR_CODE,
			'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
			'SUC_CODE' => $this->SUC_CODE,
			'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
			'RES_LOGS' => $this->RES_LOGS,
			'RES_DATA' => $this->RES_DATA,
		);

		//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";
		echo json_encode($jsonArr);

	}

	//Akash
	public function lavel_2_list(){
		//verify the user is logged in.

		$url = "/getOrgApplLevel_2_List";
		$jsonResp = get_data($url);

		if (!empty($jsonResp)) {
			$jsonArr = json_decode($jsonResp);
			if (isset($jsonArr->SUC_CODE) && ($jsonArr->SUC_CODE == 'SUCCESS')) {
				$orgData = $jsonArr->RES_DATA;
				$data['orgData'] = $orgData;
			} else {
				$this->ERR_CODE = 'The received json response is invalid.';
				$this->ERR_DESCRIPTION = $jsonResp;
			}

		} else {
			$this->ERR_CODE = 'The received json response is empty.';
			$this->ERR_DESCRIPTION = $jsonResp;
		}

		$errorMsg = getErrorString($this->ERR_CODE, $this->ERR_DESCRIPTION);
		$data['errorMsg'] = $errorMsg;

		// echo "<pre>";print_r($data);echo "</pre>";
		$data['main_content'] = 'org/org_lavel_2_list';
		$this->load->view('theme/template', $data);
	}
}
