<?php 
class Login_model extends CI_Model {

	var $title   = '';
	var $content = '';
	var $date    = '';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function pr($data =null){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	// Aunthentication Process

	function authenticate($username, $password)
	{
	   $this->db->select('sys_users.PTID, user_id,firstname,lastname,id_employer,job_title,email,company_name');
	   $this->db->from('sys_users');
	   $this->db->join('sys_persons', 'sys_users.PTID = sys_persons.PTID');
	   $this->db->join('sys_customer_admin_users', 'sys_persons.PTID = sys_customer_admin_users.PTID');
	   $this->db->join('sys_customers', 'sys_customers.id_customer = sys_customer_admin_users.id_customer');
	   $this->db->join('sys_companies', 'sys_customers.id_company = sys_companies.id_company');
	   $this->db->where('user_id', $username);
	   $this->db->where('password',$password);
	   $this->db->limit(1);
	   $query = $this->db->get();
	   $tmp = $query->num_rows();
	   //log_message('info',"user: $username,  pass: $password, num rows: $tmp");
	   if($query->num_rows() == 1)
	   {
	   log_message('info',"pass: $password");
	     return $query->result();
	   }
	   else
	   {
	     return false;
	   }
	}
	
	//Get the customer through tool
	
	function nexsysone_login($ptid)
	{
		$sql = "SELECT p.PTID,p.firstname,p.lastname,p.id_employer,u.user_id,g.id_group,g.group_name,p.job_title,p.email 
					FROM sys_persons p 
					JOIN sys_users u 
					ON p.PTID = u.PTID 
					JOIN mod_projectone_group_members gm 
					ON gm.PTID = u.PTID 
					JOIN mod_projectone_groups g 
					ON g.id_group = gm.id_group 
					WHERE p.PTID = '$ptid'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	//Check regional
	function check_group($ptid)
	{
		$sql = "SELECT count(*) as access 
					FROM mod_projectone_groups g 
					JOIN mod_projectone_group_members m ON g.id_group = m.id_group 
					WHERE (g.group_name = 'ROM_NATIONAL' OR g.group_name = 'ROM_REGIONAL') 
					AND PTID = '$ptid'";
		$query = $this->db->query($sql);
		$result =  $query->row();
		return $result->access;
	}
	
	//Check regional
	function check_group_process($username, $password)
	{
		$sql = "SELECT count(*) as access
					FROM mod_projectone_groups g 
					JOIN mod_projectone_group_members m ON g.id_group = m.id_group
					JOIN sys_users u ON u.PTID = m.PTID 
					WHERE (g.group_name = 'ROM_NATIONAL' OR g.group_name = 'ROM_REGIONAL') 
					AND user_id = '$username' AND password = '$password'";
		$query = $this->db->query($sql);
		$result =  $query->row();
		return $result->access;
	}
	
	//Get all customer assigned to the engineer
	
	function get_customers()
	{
		$sess = $this->session->userdata('logged_in');
		$ptid = $sess['PTID'];
		
		$this->db->select('u.PTID, gu.id_customer, co.*');
		$this->db->from('sys_users as u');
		$this->db->join('sys_customer_group_users as gu', ' gu.PTID = u.PTID','LEFT');
		$this->db->join('sys_customers as cu', ' cu.id_customer = gu.id_customer','LEFT');
		$this->db->join('sys_companies as co', ' co.id_company = cu.id_company','LEFT');
		$this->db->where('u.PTID',$ptid);
		$query = $this->db->get();
		return $query->result();
		
	}
	
	
	//Get Project
	
	function get_project()
	{
		$customer =  18;
		$this->db->select('u.project_name, u.id_project');
		$this->db->from('mod_projectone_projects as u');
		$this->db->where('u.customer_id_customer',$customer);
		$query = $this->db->get();
		return $query->result();
	}
	
	function checkLogin($u,$p)
	{
	
		$this->db->select('u.*');
		$this->db->from('sys_users as u');
		$this->db->where('u.user_id',$u);
		$this->db->where('u.password',$p);
		$query = $this->db->get();
		return $query->result();
	}
	
	function save_data($table,$data)
	{
	
		
		if($this->db->insert($table,$data)){
			return 1;			
		}else{
			return 0;
		}
	}
	
	function update_data($table,$con,$data){
		$this->db->where($con);
		if($this->db->update($table,$data)){
			return 1;
		}else{
			return 0;
		}
	}
	
	function delete_record($table,$con){
		$this->db->where($con);
		if($this->db->delete($table)){
			return 1;
		}else{
			return 0;
		}
	}
	
	// Update the history table
	
	function update_history($data)
	{
		if(!empty($data))
		{
			$this->db->insert('mod_taskone_history', $data);
		}
	}
}