<?php

class Organization extends CI_Model {

	//Init_Appln
	public $Org_Website_URL;
	public $Appln_Email_ID;
	public $Appln_Phone_Code;
	public $Appln_Mobile_No;
	public $Date;
	public $Appln_ID;
	public $F_Name;
	public $L_Name;
	public $Org_Name;
	public $IP_Address;
	public $Appln_status;
	public $Time;

	//Appln_Screen_Lvl_1
	public $Status_website;
	public $Status_Email;
	public $Status_mobile;
	public $Status_Level1;
	public $Emp_ID_Level1;
	public $DTTM_Level1;
	public $Status_Level2;
	public $Emp_ID_Level2;
	public $DTTM_Level2;

	public function __construct() {
		parent::__construct();

	}

	public function jsonToObject($datString = '') {

		if (!empty($datString)) {
			$objdata = json_decode($datString, true);
			if (isset($objdata['first_name'])) {
				$this->F_Name = $objdata['first_name'];
			}
			if (isset($objdata['last_name'])) {
				$this->L_Name = $objdata['last_name'];
			}
			if (isset($objdata['email_id'])) {
				$this->Appln_Email_ID = $objdata['email_id'];
			}
			if (isset($objdata['country_code'])) {
				$this->Appln_Phone_Code = $objdata['country_code'];
			}
			if (isset($objdata['mob_no'])) {
				$this->Appln_Mobile_No = $objdata['mob_no'];
			}
			if (isset($objdata['org_name'])) {
				$this->Org_Name = $objdata['org_name'];
			}
			if (isset($objdata['org_website'])) {
				$this->Org_Website_URL = $objdata['org_website'];
			}
			if (isset($objdata['ip_address'])) {
				$this->IP_Address = $objdata['ip_address'];
			}

			$this->Date = date('Y-m-d');
			$this->Time = time();
			$this->Appln_ID = $this->generateNewApplnId();
			$this->Appln_status = 0;

		}
	}

	public function objectToJson() {
		return json_encode($this);
	}

	public function getAllAppln() {
		$this->db->select('*');
		$this->db->from('init_appln');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getOrgApplnByApplnId($Appln_ID = '') {
		$this->db->select('*, ia.Appln_ID as Appln_ID');
		$this->db->from('init_appln ia');
		$this->db->join('Appln_Screen_Lvl_1 lv1', 'lv1.Appln_ID = ia.Appln_ID', 'left');
		$this->db->where('ia.Appln_ID', $Appln_ID);
		$query = $this->db->get();
		return $query->row();
	}

	public function checkduplicateToDatabase() {
		$retunFlag = false;

		$query = $this->db->query("SELECT Appln_ID FROM init_appln WHERE Org_Website_URL = '$this->Org_Website_URL' AND  Appln_Email_ID='$this->Appln_Email_ID' AND  Appln_Phone_Code='$this->Appln_Phone_Code' AND  Appln_Mobile_No='$this->Appln_Mobile_No' AND Date = '$this->Date'");

		$row = $query->row_array();
		//echo $this->db->last_query();
		$error = $this->db->error();
		if (empty($error->message)) {
			if (isset($row['Appln_ID']) && !empty($row['Appln_ID'])) {
				$retunFlag = true;
			} else {
				$retunFlag = false;
			}
		} else {
			var_dump($error);
		}

		return $retunFlag;
	}

	public function addInitApplnToDatabase() {
		$retunFlag = false;

		$int_appln_data = array(
			"Org_Website_URL" => $this->Org_Website_URL,
			"Appln_Email_ID" => $this->Appln_Email_ID,
			"Appln_Phone_Code" => $this->Appln_Phone_Code,
			"Appln_Mobile_No" => $this->Appln_Mobile_No,
			"Date" => $this->Date,
			"Appln_ID" => $this->Appln_ID,
			"F_Name" => $this->F_Name,
			"L_Name" => $this->L_Name,
			"Org_Name" => $this->Org_Name,
			"IP_Address" => $this->IP_Address,
			"Appln_status" => $this->Appln_status,
			"Time" => $this->Time,
		);

		$this->db->insert('init_appln', $int_appln_data);
		$error = $this->db->error();
		if (empty($error->message)) {
			if ($this->db->affected_rows() > 0) {
				$retunFlag = true;
			}
		} else {
			var_dump($error);
		}

		return $retunFlag;
	}

	public function addApplnLevel1ToDatabase($orgApply = '') {
		$retunFlag = false;

		$appln_lev1_data = array(
			"Appln_ID" => $orgApply->Appln_ID,
			"Status_website" => $orgApply->Status_website,
			"Status_Email" => $orgApply->Status_Email,
			"Status_mobile" => $orgApply->Status_mobile,
			"Status_Level1" => $orgApply->Status_Level1,
			"Emp_ID_Level1" => $orgApply->Emp_ID_Level1,
			"DTTM_Level1" => $orgApply->DTTM_Level1,
			"Status_Level2" => $orgApply->Status_Level2,
			"Emp_ID_Level2" => $orgApply->Emp_ID_Level2,
			"DTTM_Level2" => $orgApply->DTTM_Level2,
		);

		$this->db->insert('appln_screen_lvl_1', $appln_lev1_data);
		$error = $this->db->error();
		if (empty($error->message)) {
			if ($this->db->affected_rows() > 0) {
				$retunFlag = true;
			}
		} else {
			var_dump($error);
		}

		return $retunFlag;
	}

	public function updateInitOrgApplnStatus($Appln_status, $Appln_ID) {
		$retunFlag = false;
		$int_appln_data = array(
			'Appln_status' => $Appln_status,
		);
		$this->db->where('Appln_ID', $Appln_ID);
		$this->db->update('init_appln', $int_appln_data);
		$error = $this->db->error();
		if (empty($error->message)) {
			if ($this->db->affected_rows() > 0) {
				$retunFlag = true;
			}
		} else {
			var_dump($error);
		}
		return $retunFlag;

	}

	public function generateNewApplnId() {
		$apply_ID = 1001;

		$this->db->select_max('Appln_ID');
		$query = $this->db->get('init_appln');
		$row = $query->row_array();
		if (isset($row['Appln_ID']) && !empty($row['Appln_ID'])) {
			$apply_ID = $row['Appln_ID'];
			$apply_ID++;
		} else {
			$apply_ID = 1001;
		}
		return $apply_ID;
	}

	public function get_level_2_orgList() {
		$this->db->select('*, ia.Appln_ID as Appln_ID');
		$this->db->from('init_appln ia');
		$this->db->join('Appln_Screen_Lvl_2 lv2', 'lv2.Appln_ID = ia.Appln_ID', 'Inner');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
}
