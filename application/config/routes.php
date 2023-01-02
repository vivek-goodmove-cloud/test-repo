<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'Login/app_login';
$route['company_registration'] = 'Login/company_registration';
$route['app_login'] = 'Login/app_login';
$route['appLogout'] = 'Login/app_logout';
$route['verify_login_user'] = 'Login/verify_login_user';
$route['selectUserRole'] = 'Login/select_user_role';
$route['submitUserRole'] = 'Login/submit_user_role';

$route['get_countryList'] = 'Appapi/get_countryList';
$route['get_stateList'] = 'Appapi/get_stateList';
$route['get_cityList'] = 'Appapi/get_cityList';
$route['get_DepartmentList'] = 'Appapi/get_DepartmentList';

$route['submit_companyRegistration'] = 'Login/submit_companyRegistration';

$route['dashBoardIndex'] = 'dashboard/dashboard_page';
$route['candidate_list'] = 'dashboard/candidate_list';
$route['company_approvalList'] = 'dashboard/company_approvalList';
$route['show_companyDetails'] = 'dashboard/show_companyDetails';
$route['add_Alt_Admin'] = 'AdminActivity/add_altAdmin';
$route['add_Department'] = 'AdminActivity/add_department';
$route['add_Location'] = 'AdminActivity/add_location';
$route['add_new_department'] = 'AdminActivity/add_new_department';
$route['add_User'] = 'AdminActivity/add_User';

$route['tranfer_points_dept_to_dept'] = 'AdminActivity/tranfer_pointsBetweenDepartment';
$route['tranfer_points_loc_to_loc'] = 'AdminActivity/tranfer_pointsBetweenLocation';
$route['tranfer_points_pool_to_dept'] = 'AdminActivity/tranfer_poolPointsToDepartment';
$route['tranfer_points_dept_to_pool'] = 'AdminActivity/tranfer_departmentPointsToPool';

$route['get_Location'] = 'Appapi/get_Location';

$route['performCacheKeyValueOperations'] = 'login/performCacheKeyValueOperations';

$route['getOrgList'] = 'OrgApply/get_org_appl_List';
$route['appln_assign'] = 'OrgApply/assign_Org_Appln';
$route['apply_request'] = 'OrgApply/show_apply_form';
$route['save_apply_request'] = 'OrgApply/save_apply_form';
$route['ref_countryCodes'] = 'Appapi/ref_countryCodes';

//REST API urls
//$route['rest'] = 'RestApi/countryList/$1/$2';
$route['rest/api/countryList'] = 'RestApi/countryList';
$route['rest/api/stateList'] = 'RestApi/stateList';
$route['rest/api/cityList'] = 'RestApi/cityList';
$route['rest/api/stateListByCountry'] = 'RestApi/stateListByCountry';
$route['rest/api/cityListByState'] = 'RestApi/cityListByState';
$route['rest/api/locationList'] = 'RestApi/locationList';
$route['rest/api/departmentList'] = 'RestApi/departmentList';

$route['rest/api/refCountryCodes'] = 'RestApi/refcountryCodeList';
$route['rest/api/saveApplyOrg'] = 'OrgApi/saveApplyOrg';

$route['rest/api/getOrgApplList'] = 'OrgApi/getOrgApplicationList';
$route['rest/api/assignOrgAppln'] = 'OrgApi/assignOrgAppln';

$route['rest/api/verifyUserLogin'] = 'LoginApi/verifyUserLogin';



//Akash


//Akash
$route['upload_documents'] = 'AdminActivity/upload_documents';
$route['save_Org_Documents'] = 'OrganizationApi/save_Org_Documents';
$route['save_uploaded_document'] = 'OrganizationApi/save_uploaded_document';

$route['verify_app_emailId'] = 'OrganizationApi/verify_app_emailId';
$route['verify_app_Website'] = 'OrganizationApi/verify_app_Website';

$route['rest/api/save_uploaded_documents'] = 'RestApi/save_uploaded_documents';
$route['rest/api/update_email_verification'] = 'RestApi/update_email_verification';

$route['lavel_2_list'] = 'OrgApply/lavel_2_list';
$route['rest/api/getOrgApplLevel_2_List'] = 'OrgApi/getOrgApplLevel_2_List';