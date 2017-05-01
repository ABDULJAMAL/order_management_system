<?php

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function create_orders($data)
	{  
		
		$data_orders['email_id']=$data['email_id'];
		$data_orders['status']=$data['status'];
		$data_orders['created_at']=$data_order_items['created_at']=date('Y-m-d H:i:s');
		$data_orders['updated_at']=$data_order_items['updated_at']=date('Y-m-d H:i:s');
		$success=$this->db->insert('orders',$data_orders);
		if($success)
		{
		$data_order_items['order_id']=$this->db->insert_id();
		$data_order_items['name']=$data['name'];
		$data_order_items['price']=$data['price'];
		$data_order_items['quantity']=$data['quantity'];
		$success=$this->db->insert('order_items',$data_order_items);
		if($success)
			return $success;
		else
			return 0;
		}
		else
		{
			return 0;
		}
		
	}
	public function update_orders($data)
	{  
		if($data['id']>0)
		{		
			$data['updated_at']=date('Y-m-d H:i:s');
			$this->db->set('orders.updated_at', $data['updated_at']);
			if(!empty($data['status']))
			$this->db->set('orders.status', $data['status']);
			if(!empty($data['email_id']))
			$this->db->set('orders.email_id', $data['email_id']);
			$this->db->where('orders.id', $data['id']);
			$this->db->update('orders');			
			$this->db->set('order_items.updated_at', $data['updated_at']);
			if(!empty($data['name']))
			$this->db->set('order_items.name', $data['name']);
			if(!empty($data['price']))
			$this->db->set('order_items.price', $data['price']);
			if(!empty($data['quantity']))
			$this->db->set('order_items.quantity', $data['quantity']);
			$this->db->where('order_items.order_id', $data['id']);
			//$this->db->where('orders.id = order_items.order_id');
			//$this->db->where('orders.id', $data['id']);
			//$this->db->update('orders,order_items');
			return $this->db->update('order_items');
			
		}
		else
			return 0;
		
	}
	public function cancel_orders($id)
	{  
		if($id>0)
		{
			$this->db->set('status','cancelled');
			$this->db->where('id', $id);
			return $this->db->update('orders');
		}
		else
			return 0;
	}
	public function add_payment_to_orders($id)
	{  
		if($id>0)
		{
			$this->db->set('status','processed');
			$this->db->where('id', $id);
			return $this->db->update('orders');
		}
		else
			return 0;
	}
	public function get_orders_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('order_items');
		$this->db->where('id',$id);
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
	}
	public function get_todays_orders()
	{
		$this->db->select('*');
		$this->db->from('order_items');
		$this->db->where('date(`created_at`) = curdate()');
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
	}
	public function get_orders_by_user_id($user_email_id)
	{
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('email_id',$user_email_id);
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        }
	}
	public function get_user_email_id($id)
	{
		$this->db->select('email_id');
		$this->db->from('user');
		$this->db->where('id',$id);
		$query=$this->db->get();
		if ($query->num_rows() > 0) {
            $row = $query->result_array();
			return $row[0]['email_id'];
        }
	}
}

?>