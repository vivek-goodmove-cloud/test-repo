<?php
class LoginApi extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->ERR_CODE = '';
		$this->ERR_DESCRIPTION = '';
		$this->SUC_CODE = '';
		$this->SUC_DESCRIPTION = '';
		$this->RES_LOGS = '';
		$this->RES_DATA = '';

		$this->load->model('RestApi_model');
		$this->load->model('Login_model');
	}

	public function verifyUserLogin(){

		$returnFlag = $this->validate_User_Info();
		if ($returnFlag) {

			$jsonString = file_get_contents("php://input");

			//echo "<pre>Json Data --><br>"; print_r($jsonArry);echo"</pre>";exit();

			if(isset($jsonString) && !empty($jsonString)){
				$jsonArry = json_decode($jsonString, true);
				if(isset($jsonArry['username']) && !empty($jsonArry['username'])){
					$username = $jsonArry['username'];
					if(isset($jsonArry['password']) && !empty($jsonArry['password'])){
						$password = $jsonArry['password'];
						
						$userLoginDetails = $this->Login_model->verifyUserLogin($username,$password);
						if(!empty($userLoginDetails)){

							foreach ($userLoginDetails as $key => $userData) {
								$userID   = $userData['user_id'];
								$userType = $userData['user_type'];

								if($userType == 'employee'){
									$userRoles = $this->Login_model->getRolesByUser($userID,$userType);
									$userLoginDetails[$key]['user_role'] = $userRoles;
								}else{
									$userLoginDetails[$key]['user_role'] = "";
								}
							}

							$this->SUC_CODE = "SUCCESS";
							$this->SUC_DESCRIPTION = "User sucessfully logged In.";
							$this->RES_DATA = $userLoginDetails;

						}else{
							$this->ERR_CODE = "AUTH-ERROR";
							$this->ERR_DESCRIPTION = "Unauthorized access.";
						}

					}else{
						$this->ERR_CODE = "MISSING-PARAM";
						$this->ERR_DESCRIPTION = "Password is required.";
					}
				}else{
					$this->ERR_CODE = "MISSING-PARAM";
					$this->ERR_DESCRIPTION = "User name is required.";
				}
			} else {
				$this->ERR_CODE = "MISSING-PARAM";
				$this->ERR_DESCRIPTION = "Provided Json string is a empty.";
			}

			$jsonArr = array(
				'ERR_CODE' => $this->ERR_CODE,
				'ERR_DESCRIPTION' => $this->ERR_DESCRIPTION,
				'SUC_CODE' => $this->SUC_CODE,
				'SUC_DESCRIPTION' => $this->SUC_DESCRIPTION,
				'RES_LOGS' => $this->RES_LOGS,
				'RES_DATA' => $this->RES_DATA,
			);

			//echo "<br>JsonArr--><pre>"; print_r($jsonArr); echo "</pre>";exit();
			echo json_encode($jsonArr);
		}

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

		if ($returnFlag) {
			return $returnFlag;
		} else {
			header('WWW-Authenticate: Basic realm="My Realm"');
			header('HTTP/1.0 401 Unauthorized');
			exit();
		}
	}

}
