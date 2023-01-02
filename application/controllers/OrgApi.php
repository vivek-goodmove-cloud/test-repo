<?php

class OrgApi extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->ERR_CODE = '';
		$this->ERR_DESCRIPTION = '';
		$this->SUC_CODE = '';
		$this->SUC_DESCRIPTION = '';
		$this->RES_LOGS = '';
		$this->RES_DATA = '';

		$this->load->helper('App_helper');

		$this->load->model('RestApi_model');
		$this->load->model('Organization');
	}

	public function validate_User_Info() {
		$returnFlag = false;
		if (isset($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && !empty($_SERVER['PHP_AUTH_PW'])) {

			$username = $_SERVER['PHP_AUTH_USER'];
			$password = $_SERVER['PHP_AUTH_PW'];
			if (!empty($username) && !empty($password)) {
				$password = md5($password);
				$returnFlag = $this->RestApi_model->validate_User($username, $password);
			}
		}
		return $returnFlag;
	}

	public function saveApplyOrg() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");
			$jsonArry = json_decode($jsonString, true);

			if (!empty($jsonArry)) {
				//echo "<br>Post Arr--><pre>"; print_r($jsonArry);	echo "</pre>";
				//create org object from json String
				$this->Organization->jsonToObject($jsonString);

				//check duplicate entry of orgnization
				$isDuplicate = $this->Organization->checkduplicateToDatabase();
				if ($isDuplicate) {
					$this->ERR_CODE = "DUPLICATE-ENTRY";
					$this->ERR_DESCRIPTION = "The requested org data is exists.";
				} else {
					//echo "<br>No duplicate found..";
					//adding the org data into duplicate
					$isInserted = $this->Organization->addInitApplnToDatabase();
					//$isInserted = true;
					if ($isInserted) {
						$orgJson = $this->Organization->objectToJson();
						$this->SUC_CODE = "SUCCESS";
						$this->SUC_DESCRIPTION = "Org data added sucessfully.";
					} else {
						$this->ERR_CODE = "MYSQL-ERROR";
						$this->ERR_DESCRIPTION = "Org data not inserted in database.";
					}
				}

				//echo "<br>Organization Arr--><pre>";print_r($this->Organization);echo "</pre>";
				//echo "<br>Organization Json--><pre>";print_r($orgJson);echo "</pre>";

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
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

	public function getOrgApplicationList() {
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			//Load the allo appln org list form database
			$orgApplicationList = $this->Organization->getAllAppln();
			if (!empty($orgApplicationList)) {
				$this->SUC_CODE = 'SUCCESS';
				$this->SUC_DESCRIPTION = 'Org application list ';
				$this->RES_DATA = $orgApplicationList;
			} else {
				$this->ERR_CODE = "NO_RECORD";
				$this->ERR_DESCRIPTION = "NO more records found.";
			}
		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
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

	public function assignOrgAppln() {

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");
			$jsonArry = json_decode($jsonString, true);

			if (!empty($jsonArry)) {

				$emp_iD = $jsonArry['emp_id'];
				$appln_id = $jsonArry['appln_id'];

				//create org object from json String
				$orgApply = $this->Organization->getOrgApplnByApplnId($appln_id);
				//verify the appln is aggigned or not
				if (isset($orgApply->Emp_ID_Level1) && !empty($orgApply->Emp_ID_Level1)) {
					$this->SUC_CODE = "SUCCESS";
					$this->SUC_DESCRIPTION = "The Org Appln is alredy assigned. Please choose another.";
				} else {

					//echo "<br>orgApply--><pre>";print_r($orgApply);echo "</pre>";exit();

					$statusList = appStatusList();

					$orgApply->Status_website = $statusList[0]['KEY'];
					$orgApply->Status_website = $statusList[0]['KEY'];
					$orgApply->Status_Email = $statusList[0]['KEY'];
					$orgApply->Status_mobile = $statusList[0]['KEY'];
					$orgApply->Status_Level1 = $statusList[0]['KEY'];
					$orgApply->Emp_ID_Level1 = $emp_iD;
					$orgApply->DTTM_Level1 = date('Y-m-d H:i:s');
					$orgApply->Status_Level2 = NULL;
					$orgApply->Emp_ID_Level2 = NULL;
					$orgApply->DTTM_Level2 = NULL;

					//add Appln Screen level2 data into table with all status step_0
					$isInserted = $this->Organization->addApplnLevel1ToDatabase($orgApply);
					if ($isInserted) {
						//update status of int appln as step_1
						$chageStatus = $this->Organization->updateInitOrgApplnStatus($statusList[1]['KEY'], $orgApply->Appln_ID);
						if ($chageStatus) {
							//load the new object of org from databse
							$orgApply = $this->Organization->getOrgApplnByApplnId($appln_id);

							//pass the new object to end user with sucess
							$orgJson = $this->Organization->objectToJson();
							$this->SUC_CODE = "SUCCESS";
							$this->SUC_DESCRIPTION = "The Org Appln is assigned sucessfully.";
							$this->RES_DATA = $orgJson;

						} else {
							$this->ERR_CODE = "MYSQL-ERROR";
							$this->ERR_DESCRIPTION = "Org init appln status is not changed.";
						}

					} else {
						$this->ERR_CODE = "MYSQL-ERROR";
						$this->ERR_DESCRIPTION = "Org Leve1 data not inserted in database.";
					}

				}

				//echo "<br>orgApply--><pre>";	print_r($orgApply);	echo "</pre>";exit();

			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Invalid Json data request.";
			}

		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
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

	public function getOrgApplLevel_2_List(){
		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			//Load the allo appln org list form database
			$orgApplicationList = $this->Organization->get_level_2_orgList();
			// echo "<br>resp--><pre>"; print_r($orgApplicationList); echo "</pre>";
			if (!empty($orgApplicationList)) {
				$this->SUC_CODE = 'SUCCESS';
				$this->SUC_DESCRIPTION = 'Org application list ';
				$this->RES_DATA = $orgApplicationList;
			} else {
				$this->ERR_CODE = "NO_RECORD";
				$this->ERR_DESCRIPTION = "NO more records found.";
			}
		} else {
			$this->ERR_CODE = "INVALID AUTH ACCESS";
			$this->ERR_DESCRIPTION = "The user request has invalid access.";
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

}
