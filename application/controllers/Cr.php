<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cr extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('cr_model','cr',true);
	}

	public function index()
	{

		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			
			$cr_data=$this->show_cr();
			
			
		}
		else
		{}
				//$this->load->view('cr_view');

		}



	function pr($data){

		print_r($data);

	}

	function ShowMsg($para)
	{
		if($para=='exist')
		{
			echo "<script language=javascript>alert('CR ID already exist!!');";
		}
		else if($para=='short')
		{
			echo "<script language=javascript>alert('CR ID cannot shorter than 6 digits');";
		}
		else if($para=='norec')
		{
			echo "<script language=javascript>alert('There is no CR ID to update. Please check again.');";
		}


		echo "window.location.href = '" . base_url()."';</script>" ;
	}

	function insert_inidata()
	{
		$buttonvalue;
		if($this->input->post('Reserve')){
			$buttonvalue = $this->input->post('Reserve');
		}
		//else if($this->input->post(''))
		
		//Reserve Start
		if($buttonvalue=='Reserve')
		{
			$cr_data=$this->cr->selectcr($_POST['cr_id']);
			$cr_array=(array)$cr_data;

			if(!empty($cr_array))
			{
				$this->ShowMsg('exist');
			}

			else if(strlen($_POST['cr_id'])!=6)
			{
				$this->ShowMsg('short');
			}

			else{
				$data['cr_id']=$_POST['cr_id'];

				$data['cr_title']=$_POST['cr_title'];
				$data['cr_description']=$_POST['cr_description'];
				$pattern = "^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$^";

				//$data['cr_submitted']=$_POST['cr_submitted'];
				$subdate=$_POST['cr_submitted'];

				if(!preg_match($pattern, $subdate))
				{

				}
				else {$data['cr_submitted']=$subdate;}
				$data['cr_requestor']=$_POST['cr_requestor'];
				$data['cr_requestor_unit']=$_POST['cr_requestor_unit'];
				$data['cr_approval_ran']=$_POST['cr_approval_ran'];
				$data['cr_approval_transmission']=$_POST['cr_approval_transmission'];
				$data['cr_approval_build']=$_POST['cr_approval_build'];
				$data['cr_approval_operations']=$_POST['cr_approval_operations'];
				$date=$_POST['cr_status_processed'];
				if(!preg_match($pattern, $date))
				{}
				else {$data['cr_status_processed']=$date;}
				if($_POST=='Please OX Admin')
				{
					$data['cr_processed_by']='';
				}
				else
				{
					$data['cr_processed_by']=$_POST['cr_processed_by'];
					$cookie_name = "cr_processed_by";
					$cookie_value = $data['cr_processed_by'];
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
				}
				

				$tmp=$this->cr->save_data('ox_cr_list',$data);
				redirect(base_url());
			}
		}
		//Reserve End
		//Update Start
		if($buttonvalue=='Update')
		{
			$cr_data2=$_POST['cr_id'];
			$cr_data=$this->cr->selectcr($_POST['cr_id']);
			$cr_array=(array)$cr_data;

			if(empty($cr_array))
			{
				$this->ShowMsg('norec');
			}

			else{
				$con['cr_id'] = $_POST['cr_id'];



				$data['cr_title']=$_POST['cr_title'];
				$data['cr_description']=$_POST['cr_description'];
				$pattern = "^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$^";

				//$data['cr_submitted']=$_POST['cr_submitted'];
			$subdate=$_POST['cr_submitted'];

				if(!preg_match($pattern, $subdate))
				{

				}
				else {$data['cr_submitted']=$subdate;}
				$data['cr_requestor']=$_POST['cr_requestor'];
				$data['cr_requestor_unit']=$_POST['cr_requestor_unit'];
				$data['cr_approval_ran']=$_POST['cr_approval_ran'];
				$data['cr_approval_transmission']=$_POST['cr_approval_transmission'];
				$data['cr_approval_build']=$_POST['cr_approval_build'];
				$data['cr_approval_operations']=$_POST['cr_approval_operations'];
				$date=$_POST['cr_status_processed'];
				if(!preg_match($pattern, $date))
				{}
				else {$data['cr_status_processed']=$date;}
				$data['cr_processed_by']=$_POST['cr_processed_by'];
				$this->cr->update_cr('ox_cr_list',$con,$data);
				redirect(base_url());
			}
		}
		//Update end
		//header('Refresh: 10.2');
	}
	
	function get_lastnumber_Cookie($data)
	{
		/////////////////////////////////////////////////////////    Last CR and Cookies
		$cr_datalast=$this->cr->lastcr();
		//$this->pr($cr_data);
		//$data['cr_data'] = $cr_data2;
		$last_cr=(string)$cr_datalast[0]->cr_id;
		preg_match_all('/^([^\d]+)(\d+)/', $last_cr, $match);
			
		$text = $match[1][0];
		$num = $match[2][0];
		//$last_cr=$last_cr+1;
		$num=$num+1;
		if(strlen($num)==3)
		{$num='0'.$num;}
		$last_cr=$text.$num;
		$data['last_cr']=$last_cr;
			
			
		if(!isset($_COOKIE['cr_processed_by'])) {
			$data['cookies']='';
		} else {
			//echo "Cookie '" . $cookie_name . "' is set!<br>";
			$data['cookies']= $_COOKIE['cr_processed_by'];
		}
		return $data;
		/////////////////////////////////////////////////////////    Last CR and Cookies
	}

	function show_cr()
	{
		session_start();
		$radiovalue='';
		$data;
		//$this->pr($_SESSION['radio']);
		//if (!empty($_POST['radio']) || !empty($_SESSION['radio']))
		if(isset($_POST['Show']))
		{
			
		}
		if (!empty($_POST['radio']))
		{
			if(!empty($_SESSION['radio']))
			{
				$_SESSION['radio'] = $_POST['radio'];
				$radiovalue=$_SESSION['radio'];
			}


			//$this->pr($radiovalue);

			if($radiovalue=='CR_ID')
			{
				if(isset($_POST['cr_id_search']))
				{

					$data['radiovalue']=$radiovalue;

					$data['cr_id_search']=$_POST['cr_id_search'];

					$cr_data=$this->cr->selectcr($data);
					$data['cr_data']=$cr_data;
					
					$data=$this->get_lastnumber_Cookie($data);
					
					
					if(isset($_POST['Show']))
					{
						$this->load->view('cr_view',$data);
					}
					if(isset($_POST['Export']))
					{
						$cr_array=(array)$data;
						json_encode($cr_array);
						//$this->pr($cr_array);
						header('Content-Type: application/excel');
						header('Content-Disposition: attachment; filename="sample.csv"');
						
						$list = array
						(
								"Peter,Griffin,Oslo,Norway",
								"Glenn,Quagmire,Oslo,Norway",
						);
						$file=fopen('php://output', 'w');
						foreach ($data as $line)
						{
							$val = explode(",", $line);
    						fputcsv($file, $val);
						}
						fclose($file);
					}

				}

			}
			else if($radiovalue=='CR_ID_Range')
			{

				if(isset($_POST['cr_id_from']) || isset($_POST['cr_id_to']))
				{


					$data['radiovalue']=$radiovalue;
					$data['cr_id_from']=$_POST['cr_id_from'];
					$data['cr_id_to']=$_POST['cr_id_to'];

					$cr_data=$this->cr->selectcr($data);


					$data['cr_data']=$cr_data;
					$data=$this->get_lastnumber_Cookie($data);//get last number & cookie
					if(isset($_POST['Show']))
					{
						$this->load->view('cr_view',$data);
					}
					if(isset($_POST['Export']))
					{
						$cr_array=(array)$data['cr_data'];
						
						//$this->pr($cr_array);
						header('Content-Type: application/excel');
						header('Content-Disposition: attachment; filename="sample.csv"');
						
						$headers = ['CR ID', 'CR Title', 'Description', 'Submitted Da', 'CR Requestor', 'Requestor Unit','CR Approval RAN','CR Approval TX','CR Approval Build','CR Approval Operations','Processed Date','Processed By'];
						$fp=fopen('php://output', 'w');
						
						fputcsv($fp, $headers);
						foreach ($cr_array as $fields)
						{
							if( is_object($fields) )
        						$fields = (array) $fields;
    						fputcsv($fp, $fields);
						}
						
						
						fclose($fp);
						
					}
					
				}

				//$this->pr($cr_data);
			}
			else if($radiovalue=='Submitted_Date')
			{
				if(isset($_POST['submit_date']))
				{
					$data['radiovalue']=$radiovalue;
					$data['submit_date']=$_POST['submit_date'];
					$cr_data=$this->cr->selectcr($data);
					$data['cr_data']=$cr_data;
					$data=$this->get_lastnumber_Cookie($data);//get last number & cookie
					if(isset($_POST['Show']))
					{
						$this->load->view('cr_view',$data);
					}
					if(isset($_POST['Export']))
					{
						$cr_array=(array)$data['cr_data'];
					
						//$this->pr($cr_array);
						header('Content-Type: application/excel');
						header('Content-Disposition: attachment; filename="sample.csv"');
					
						$headers = ['CR ID', 'CR Title', 'Description', 'Submitted Da', 'CR Requestor', 'Requestor Unit','CR Approval RAN','CR Approval TX','CR Approval Build','CR Approval Operations','Processed Date','Processed By'];
						$fp=fopen('php://output', 'w');
					
						fputcsv($fp, $headers);
						foreach ($cr_array as $fields)
						{
							if( is_object($fields) )
								$fields = (array) $fields;
								fputcsv($fp, $fields);
						}
					
					
						fclose($fp);
					
					}
					
				}
			}
			else if($radiovalue=='Requestor')
			{
				if(isset($_POST['request']))
				{
					$data['radiovalue']=$radiovalue;
					$data['request']=$_POST['request'];
					$cr_data=$this->cr->selectcr($data);
					$data['cr_data']=$cr_data;
					$data=$this->get_lastnumber_Cookie($data);//get last number & cookie
					if(isset($_POST['Show']))
					{
						$this->load->view('cr_view',$data);
					}
					if(isset($_POST['Export']))
					{
						$cr_array=(array)$data['cr_data'];
					
						//$this->pr($cr_array);
						header('Content-Type: application/excel');
						header('Content-Disposition: attachment; filename="sample.csv"');
					
						$headers = ['CR ID', 'CR Title', 'Description', 'Submitted Da', 'CR Requestor', 'Requestor Unit','CR Approval RAN','CR Approval TX','CR Approval Build','CR Approval Operations','Processed Date','Processed By'];
						$fp=fopen('php://output', 'w');
					
						fputcsv($fp, $headers);
						foreach ($cr_array as $fields)
						{
							if( is_object($fields) )
								$fields = (array) $fields;
								fputcsv($fp, $fields);
						}
					
					
						fclose($fp);
					
					}
					
				}
			}
			else if($radiovalue=='Processed_Date')
			{
				if(isset($_POST['process_date']))
				{
					$data['radiovalue']=$radiovalue;
					$data['process_date']=$_POST['process_date'];
					$cr_data=$this->cr->selectcr($data);
					$data['cr_data']=$cr_data;
					$data=$this->get_lastnumber_Cookie($data);//get last number & cookie
					if(isset($_POST['Show']))
					{
						$this->load->view('cr_view',$data);
					}
					if(isset($_POST['Export']))
					{
						$cr_array=(array)$data['cr_data'];
					
						//$this->pr($cr_array);
						header('Content-Type: application/excel');
						header('Content-Disposition: attachment; filename="sample.csv"');
					
						$headers = ['CR ID', 'CR Title', 'Description', 'Submitted Da', 'CR Requestor', 'Requestor Unit','CR Approval RAN','CR Approval TX','CR Approval Build','CR Approval Operations','Processed Date','Processed By'];
						$fp=fopen('php://output', 'w');
					
						fputcsv($fp, $headers);
						foreach ($cr_array as $fields)
						{
							if( is_object($fields) )
								$fields = (array) $fields;
								fputcsv($fp, $fields);
						}
					
					
						fclose($fp);
					
					}
					
				}
			}
			else if($radiovalue=='Processed_By')
			{
				if(isset($_POST['cr_processed_by']))
				{
					$data['radiovalue']=$radiovalue;
					$data['process_by']=$_POST['cr_processed_by'];

					$cr_data=$this->cr->selectcr($data);
					$data['cr_data']=$cr_data;
					$data=$this->get_lastnumber_Cookie($data);//get last number & cookie
					if(isset($_POST['Show']))
					{
						$this->load->view('cr_view',$data);
					}
					if(isset($_POST['Export']))
					{
						$cr_array=(array)$data['cr_data'];
					
						//$this->pr($cr_array);
						header('Content-Type: application/excel');
						header('Content-Disposition: attachment; filename="sample.csv"');
					
						$headers = ['CR ID', 'CR Title', 'Description', 'Submitted Da', 'CR Requestor', 'Requestor Unit','CR Approval RAN','CR Approval TX','CR Approval Build','CR Approval Operations','Processed Date','Processed By'];
						$fp=fopen('php://output', 'w');
					
						fputcsv($fp, $headers);
						foreach ($cr_array as $fields)
						{
							if( is_object($fields) )
								$fields = (array) $fields;
								fputcsv($fp, $fields);
						}
					
					
						fclose($fp);
					
					}
					
				}
			}
			//$this->pr($data);
		}
		else
		{

				$cr_data=$this->cr->getcr();
				//$this->pr($cr_data);
				$data['cr_data'] = $cr_data;
				$data=$this->get_lastnumber_Cookie($data);//get last number & cookie
				
				//$this->pr($data);
				$this->load->view('cr_view',$data);
		}

		//$crto=$_POST['cr_id_to'];
		//if(!isset($_POST['cr_id_from']) && !isset($_POST['cr_id_to']))
		//{
			//$cr_data=$this->cr->getcr();

			//$data['cr_data'] = $cr_data;
			//$this->load->view('cr_view',$data);
		//}
		//else
		//{
			//$data['cr_id_from']=$_POST['cr_id_from'];
			//$data['cr_id_to']=$_POST['cr_id_to'];
			//$cr_data=$this->cr->selectcr($data);
			//$data['cr_data']=$cr_data;
			//$this->load->view('cr_view',$data);
			//$this->pr($cr_data);
		//	}

	}

	public function edit_cr()
	{
		$data['cr_id']=$_POST['cr_id'];
		$cr_e_data['cr_title']=$_POST['cr_title'];
		$cr_data=$this->cr->getcr();
		$this->pr($cr_e_data);
		$data['cr_data'] = $cr_data;
		$this->load->view('cr_edit',$data);
	}

	public function select_cr()
	{
		if($this->input->post('cr_id')!=null)
		{
			$cr_id=$this->input->post('cr_id');
			//$this->pr($cr_id);
			$cr_data=$this->cr->selectcr($cr_id);
			$cr_array=(array)$cr_data;
			echo json_encode($cr_array);
			exit();
		}

	}
}
