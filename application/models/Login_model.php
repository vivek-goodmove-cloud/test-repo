<?php

class Login_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function verifyUserLogin($username,$password) {
    	$this->db->select('*');
        $this->db->from('user ur');
        //$this->db->join('emp_role_table er', 'er.emp_id = emp.emp_id', 'left');
        //$this->db->join('emp_permission_table ep', 'ep.emp_id = emp.emp_id', 'left');
        $this->db->where('ur.username',$username);
        $this->db->where('ur.password',$password);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
	}

    public function getRolesByUser($userid,$usertype) {
        $this->db->select('*');
        $this->db->from('employee_role er');
        $this->db->join('roles r', 'r.role_id = er.role_id', 'left');
        $this->db->where('er.emp_id',$userid);
        $this->db->where('er.emp_type',$usertype);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function getPermissionByRoleId($roleid) {
        $this->db->select('*');
        $this->db->from('role_permission rp');
        $this->db->join('permission per', 'per.per_id = rp.rp_per_id', 'left');
        $this->db->where('rp.rp_role_id',$roleid);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result_array();
    }
    // public function verifyEmployeeLogin($username,$password) {
    //     $this->db->select('emp.emp_id,emp.emp_name, er.emp_role_id,er.role_name,ep.emp_per_id,ep.per_id');
    //     $this->db->from('employee_lookup emp');
    //     $this->db->join('emp_role_table er', 'er.emp_id = emp.emp_id', 'left');
    //     $this->db->join('emp_permission_table ep', 'ep.emp_id = emp.emp_id', 'left');
    //     $this->db->where('emp.username',$username);
    //     $this->db->where('emp.password',$password);
    //     $query = $this->db->get();
    //     //echo $this->db->last_query();die;
    //     return $query->row_array();
    // }

}
