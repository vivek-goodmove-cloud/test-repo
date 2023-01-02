<?php

class RestApi_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->api_users = 'api_users';
		$this->app_locations = 'app_locations';
		$this->app_departments = 'app_departments';
		$this->cntry = 'cntry';
	}
	public function getRefCountryList($searchText = '') {
		$this->db->select('*');
		$this->db->from($this->cntry);
		if ($searchText != "") {
			$this->db->like("Cntry_Name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function validate_User($username, $password) {
		$result = false;
		$this->db->select('password');
		$this->db->from($this->api_users);
		$this->db->where('username', $username);
		$this->db->where('password_hash', $password);
		$query = $this->db->get();
		$row = $query->row_array();
		//echo $this->db->last_query();exit();
		if (isset($row['password']) && !empty($row['password'])) {
			$result = true;
		}
		return $result;
	}

	public function getCountryList($searchText) {
		$this->db->select('*');
		$this->db->from('country');
		if ($searchText != "") {
			$this->db->like("country_name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getStateList($searchText) {
		$this->db->select('*');
		$this->db->from('states');
		if ($searchText != "") {
			$this->db->like("name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCityList($searchText) {
		$this->db->select('*');
		$this->db->from('city');
		if ($searchText != "") {
			$this->db->like("name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getStateByCountrId($countryId, $searchText) {
		$this->db->select('*');
		$this->db->from('states');
		$this->db->where('country_id', $countryId);
		if ($searchText != "") {
			$this->db->like("name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCityByStateId($stateId, $searchText) {
		$this->db->select('*');
		$this->db->from('city');
		$this->db->where('state_id', $stateId);
		if ($searchText != "") {
			$this->db->like("name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getLocationList($searchText) {
		$this->db->select('*');
		$this->db->from($this->app_locations);
		if ($searchText != "") {
			$this->db->like("loc_name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getDepartmentList($searchText) {
		$this->db->select('*');
		$this->db->from($this->app_departments);
		if ($searchText != "") {
			$this->db->like("dept_name", $searchText);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

}
