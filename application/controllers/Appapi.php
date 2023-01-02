<?php
class Appapi extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('Appapi_model');
		$this->load->helper('Auth_helper');
		$this->load->helper('Cache_helper');
	}

	public function ref_countryCodes() {

		$searchText = $this->input->get('searchText');
		//clearCache();
		$cacheCountryList = verifyCountryRefDataInCache("refCountryList");
		//echo "Cache Country List--><br>"; print_r($cacheCountryList);die;
		echo $cacheCountryList;

	}

	public function get_countryList() {

		$searchText = $this->input->get('searchText');
		$cacheCountryList = checkCacheCountryDataExist("countryList", $searchText);
		//echo "Cache Country List--><br>"; print_r($cacheCountryList);die;
		if (!empty($cacheCountryList)) {
			echo $cacheCountryList;
		} else {
			//echo "Country List Not found!";
			$cacheCountryList = loadDataInCache("countryList", $searchText);
			echo $cacheCountryList;
		}
	}

	public function get_stateList() {

		$searchText = $this->input->get('searchText');
		$countryId = $this->input->get('ctid');

		$cacheStateList = checkCacheStateDataExist("stateListByCountry", $countryId, $searchText);
		//echo "Cache State List--><br>"; print_r($countryId,);die;
		if (!empty($cacheStateList)) {
			echo $cacheStateList;
		} else {
			//echo "State List Not found!";
			$cacheStateList = loadStateDataInCache("stateListByCountry", $countryId, $searchText);
			echo $cacheStateList;
		}

		// $stateResult = $this->Appapi_model->getStateByCountrId($countryId, $searchText);
		// $data = array();
		// foreach ($stateResult as $key => $value) {
		//     $countryarr = array();
		//     $countryarr['id'] = $value['id'];
		//     $countryarr['text'] = $value['name'];
		//     $data[] = $countryarr;
		// }

		// echo json_encode($data);
	}

	public function get_cityList() {

		$searchText = $this->input->get('searchText');
		$stateId = $this->input->get('stid');

		$cityResult = $this->Appapi_model->getCityByStateId($stateId, $searchText);
		$data = array();
		foreach ($cityResult as $key => $value) {
			$countryarr = array();
			$countryarr['id'] = $value['id'];
			$countryarr['text'] = $value['name'];
			$data[] = $countryarr;
		}

		echo json_encode($data);
	}

	public function get_DepartmentList() {

		$searchText = $this->input->get('searchText');

		$data = array(
			array("id" => 1, "text" => 'Human Resource'),
			array("id" => 2, "text" => 'Production'),
			array("id" => 3, "text" => 'Support'),
			array("id" => 4, "text" => 'Account'),
		);

		$dataResult = array();
		foreach ($data as $key => $value) {
			$tempText = $value['text'];
			if ($this->startsWith($tempText, $searchText)) {
				//unset($data[$key]);
				$dataResult[] = $value;
			}
		}
		if (empty($dataResult) && empty($searchText)) {
			$dataResult = $data;
		}
		echo json_encode($dataResult);
	}

	public function get_Location() {
		$searchText = $this->input->get('searchText');

		$data = array(
			array("id" => 1, "text" => 'Chennai,Tamil Nadu'),
			array("id" => 2, "text" => 'Mumbai,Maharashtra'),
			array("id" => 3, "text" => 'Banglore,Karnataka'),
			array("id" => 4, "text" => 'Pune,Maharashtra'),
		);

		$dataResult = array();
		foreach ($data as $key => $value) {
			$tempText = $value['text'];
			if ($this->startsWith($tempText, $searchText)) {
				//unset($data[$key]);
				$dataResult[] = $value;
			}
		}
		if (empty($dataResult) && empty($searchText)) {
			$dataResult = $data;
		}
		echo json_encode($dataResult);
	}

	function startsWith($string, $startString) {
		$len = strlen($startString);
		return (substr($string, 0, $len) === $startString);
	}

}
