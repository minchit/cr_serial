<?php
class Cr_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function pr($data =null){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
	
	function save_data($table,$data)
	{
	
		if($this->db->insert($table,$data)){
			return 1;
		}else{
			return 0;
		}
	}
	
	function update_cr($table,$con,$data){
		$this->db->where($con);
		if($this->db->update($table,$data)){
			return 1;
		}else{
			return 0;
		}
	}
	
	function selectcr($cr_id)
	{
		if(is_array($cr_id) && $_SERVER['REQUEST_METHOD'] == 'POST')
		{
			
			
			//$this->pr($_SERVER['REQUEST_METHOD']);
			//$this->pr($_SESSION['radio']);
			
			if($_SESSION['radio']=='CR_ID')
			{
				
				if(!empty($cr_id['cr_id_search']))
				{
					$this->db->select('cr.*');
					$this->db->from('ox_cr_list as cr');
					$this->db->like('cr.cr_id', $cr_id['cr_id_search']);
					$query=$this->db->get();
					return $query->result();
				}
			}
			else if($cr_id['radiovalue']=='CR_ID_Range')
			{
				
				if(empty($cr_id['cr_id_from']) || empty($cr_id['cr_id_to']))
				{
					
					$this->db->select('cr.*');
					$this->db->from('ox_cr_list as cr');
					if(!empty($cr_id['cr_id_from']))
					{
						$this->db->where('cr.cr_id >',$cr_id['cr_id_from']);
							
					}
					else if(!empty($cr_id['cr_id_to']))
					{
							
						$cr_id_to=implode('', $cr_id);
						//$this->pr($cr_id_to);
						$this->db->where('cr.cr_id >',$cr_id_to);
							
					}
					$query=$this->db->get();
					return $query->result();
				}
				else
				{
					
					$this->db->select('cr.*');
					$this->db->from('ox_cr_list as cr');
					$this->db->where('cr.cr_id >=',$cr_id['cr_id_from']);
					$this->db->where('cr.cr_id <=',$cr_id['cr_id_to']);
					$query=$this->db->get();
					return $query->result();
				
				}
			}
			else if($_SESSION['radio']=='Submitted_Date')
			{
				//$this->pr($_SESSION['radio']);
				//exit();
				if(!empty($cr_id['submit_date']))
				{
					//$this->pr($_SESSION['radio']);
					
					$this->db->select('cr.*');
					$this->db->from('ox_cr_list as cr');
					$this->db->where('cr.cr_submitted',$cr_id['submit_date']);
					$query=$this->db->get();
					return $query->result();
				}
			}
			else if($_SESSION['radio']=='Requestor')
			{
				//$this->pr($_SESSION['radio']);
				//exit();
				if(!empty($cr_id['request']))
				{
					$this->db->select('cr.*');
					$this->db->from('ox_cr_list as cr');
					$this->db->like('cr.cr_requestor', $cr_id['request']);
					$query=$this->db->get();
					return $query->result();
				}
			}
			else if($_SESSION['radio']=='Processed_Date')
			{
				//$this->pr($_SESSION['radio']);
				//exit();
				if(!empty($cr_id['process_date']))
				{
					$this->db->select('cr.*');
					$this->db->from('ox_cr_list as cr');
					$this->db->where('cr.cr_status_processed',$cr_id['process_date']);
					$query=$this->db->get();
					return $query->result();
				}
			}
			else if($_SESSION['radio']=='Processed_By')
			{
				//$this->pr($_SESSION['radio']);
				//exit();
				if(!empty($cr_id['process_by']))
				{
					$this->db->select('cr.*');
					$this->db->from('ox_cr_list as cr');
					$this->db->where('cr.cr_processed_by',$cr_id['process_by']);
					$query=$this->db->get();
					return $query->result();
				}
			}
					
		}
		else
		{
			$this->db->select('cr.*');
			$this->db->from('ox_cr_list as cr');
			$this->db->where('cr.cr_id',$cr_id);
			
			$query=$this->db->get();
			return $query->result();
		}
	}
	
	function getcr()
	{
	
		$this->db->select('cr.*');
		$this->db->from('ox_cr_list as cr');
		$this->db->order_by('cr_id','desc');
		$this->db->limit(20);
		//$this->db->where('u.user_id',$u);
		//$this->db->where('u.password',$p);
		$query = $this->db->get();
		return $query->result();
	}
	
	function lastcr()
	{
	
		$this->db->select('cr.*');
		$this->db->from('ox_cr_list as cr');
		$this->db->order_by('cr_id','desc');
		$this->db->limit(1);
		//$this->db->where('u.user_id',$u);
		//$this->db->where('u.password',$p);
		$query = $this->db->get();
		return $query->result();
	}
}