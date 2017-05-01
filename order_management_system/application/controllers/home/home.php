<?php

class Home extends CI_Controller {

    public $home_model;
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('home/home_model', 'home');
        $this->load->model('admin/admin_model', 'admin');
    }

    public function index() {
		$data['data'] = array();
		$this->load->view('home/home', $data);
    }
	function header_verification($headers)
	{
		try
		{
			if(isset($headers['access_token'])&&isset($headers['password'])&&base64_decode($headers['access_token'])=='admin'&&base64_decode($headers['password'])=='1234')
				return 1;
			else 
				return 0;
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        } 
		
	}
	public function create_orders() {
		try
        {	
			$header=$this->header_verification($this->input->request_headers());
			if($header)
			{
				$data=(array) json_decode($this->input->raw_input_stream);
				if(!empty($data))
				{	
					$data=array_filter($data);					
					$required_values = array('email_id','status', 'name','quantity','price');
					$missing_values=array_diff($required_values,array_flip($data));					
					if(count($missing_values)==0)
					{					
					$status = $this->home->create_orders($data);
					if($status)
						echo json_encode(array("error"=>"0","message"=>"your order placed successfully"),true);
					else
						echo json_encode(array("error"=>"1","message"=>"order not placed"),true);            
					}
					else
					{
					echo json_encode(array("error"=>"1","message"=>"required parameter or value of parameter is missing!!","parameters"=>array_values($missing_values)),true);
					}
				}
				else
				{
					$data['data']=array("error"=>"1","message"=>"passed value/parameter is wrong");
					echo json_encode($data['data'],true); 
				}
			}
			else
			{
				$data['data']=array("error"=>"1","message"=>"user authentication  failed");
				echo json_encode($data['data'],true); 
			}
				
			
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        }
    }
	public function update_orders() {
		try
        {	
			$header=$this->header_verification($this->input->request_headers());
			if($header)
			{
				$data=(array) json_decode($this->input->raw_input_stream);	
				$data=array_filter($data);
				if(!empty($data))
				{				
					$status = $this->home->update_orders($data);
					if($status)
						echo json_encode(array("error"=>"0","message"=>"your order updated successfully"),true);
					else
						echo json_encode(array("error"=>"1","message"=>"order not updated"),true);
				}
				else
				{
					$data['data']=array("error"=>"1","message"=>"passed value/parameter is wrong");
					echo json_encode($data['data'],true); 
				}
			}
			else
			{
				$data['data']=array("error"=>"1","message"=>"user authentication  failed");
				echo json_encode($data['data'],true); 
			}
				
			
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        }
    }
	public function cancel_orders() {
		try
        {	
			$header=$this->header_verification($this->input->request_headers());
			if($header)
			{
				
				$data=(array) json_decode($this->input->raw_input_stream);
				if(isset($data['id'])&&$data['id']>0)
				{
					$status = $this->home->cancel_orders($data['id']);
					if($status)
						echo json_encode(array("error"=>"0","message"=>"your order cancelled successfully"),true);
					else
						echo json_encode(array("error"=>"1","message"=>"order not cancelled"),true);;
				}
				else
				{
					$data['data']=array("error"=>"1","message"=>"passed value/parameter is wrong");
					echo json_encode($data['data'],true); 
				}
			}
			else
			{
				$data['data']=array("error"=>"1","message"=>"user authentication  failed");
				echo json_encode($data['data'],true); 
			}
				
			
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        }
    }
	public function add_payment_to_orders() {
		try
        {	
			
			$header=$this->header_verification($this->input->request_headers());
			if($header)
			{
				
				$data=(array) json_decode($this->input->raw_input_stream);
				if(isset($data['id'])&&$data['id']>0)
				{
					$status = $this->home->add_payment_to_orders($data['id']);
					if($status)
						echo json_encode(array("error"=>"0","message"=>"your order has paid"),true);
					else
						echo json_encode(array("error"=>"1","message"=>"order not processed"),true);;
				}
				else
				{
					$data['data']=array("error"=>"1","message"=>"passed value/parameter is wrong");
					echo json_encode($data['data'],true); 
				}
			}
			else
			{
				$data['data']=array("error"=>"1","message"=>"user authentication  failed");
				echo json_encode($data['data'],true); 
			}
				
			
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        }
    }
	public function get_orders_by_id() {
		try
        {	
			$header=$this->header_verification($this->input->request_headers());
			if($header)
			{
				$data=(array) json_decode($this->input->raw_input_stream);
				if(isset($data['id'])&&$data['id']>0)
				{			
					$data['data'] = $this->home->get_orders_by_id($data['id']);
					echo json_encode(array("orders"=>$data['data'],"error"=>"0","message"=>"success"),true);
				}
				else
				{
					$data['data']=array("error"=>"1","message"=>"passed value/parameter is wrong");
					echo json_encode($data['data'],true); 
				}
			}
			else
			{
				$data['data']=array("error"=>"1","message"=>"user authentication  failed");
				echo json_encode($data['data'],true); 
			}
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        }
    }
	public function get_todays_orders() {
		try
        {	
			$header=$this->header_verification($this->input->request_headers());
			if($header)
			{		
				$data['data'] = $this->home->get_todays_orders();
				echo json_encode(array("today_orders"=>$data['data'],"error"=>"0","message"=>"success"),true);	
			}
			else
			{
				$data['data']=array("error"=>"1","message"=>"user authentication  failed");
				echo json_encode($data['data'],true); 
			}			
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        }
    }
	public function get_orders_by_user_id() {
		try
        {	
			$header=$this->header_verification($this->input->request_headers());
			if($header)
			{
				$data=(array) json_decode($this->input->raw_input_stream);
				if(isset($data['user_id'])&&$data['user_id']>0)
				{			
				$user_email_id=$this->home->get_user_email_id($data['user_id']);
				$data['data'] = $this->home->get_orders_by_user_id($user_email_id);
				if(!empty($data['data']))
					echo json_encode(array("orders"=>$data['data'],"error"=>"0","message"=>"success"),true);
				else
					echo json_encode(array("error"=>"0","message"=>"no user found in this id"),true);
				}
				else
				{
					$data['data']=array("error"=>"1","message"=>"passed value/parameter is wrong");
					echo json_encode($data['data'],true); 
				}
			}
			else
			{
				$data['data']=array("error"=>"1","message"=>"user authentication  failed");
				echo json_encode($data['data'],true); 
			}
		}
		catch(Exception $err)
        {
            $exception=$err->getMessage();
			$data['data']=array("error"=>"1","message"=>$exception);
			echo json_encode($data['data'],true); 
        }
    }
}

?>