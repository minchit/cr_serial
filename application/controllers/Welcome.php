<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model','login',true);
		
	}
	function pr($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function login() 
	{
		$user_name = $_POST['username'];
		$password = $_POST['password'];
		
		$tmp = $this->login->checkLogin($user_name,$password);
		
		$this->pr($tmp);exit;
		
		
		
		
	}
	
	function insert_data(){
		$data['company_name'] = "Test Company";

		
		$tmp = $this->login->save_data('sys_companies',$data);
				
		$this->pr($tmp);exit;
	}
	
	function update_data(){
		$con['id_company'] = 61;	
		$data["company_name"] = "Companytest1";
		$tmp = $this->login->update_data('sys_companies',$con,$data);
	
		$this->pr($tmp);exit;
	}
	
	function delete_data(){
		$con['id_company'] = 61;

		$tmp = $this->login->delete_record('sys_companies',$con);
	
		$this->pr($tmp);exit;
	}
	
}
