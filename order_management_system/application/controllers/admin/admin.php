<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/admin_model', 'admin');
    }

    public function index() {

        $data=array();
        $this->load->view('admin/admin_home', $data);
		
    }
    public function add_cms()
    {
        try
        {            
            
        }
        catch(Exception $err)
        {
            log_message("error",$err->getMessage());
            return show_error($err->getMessage());
        }
    }
    public function update_cms()
    {
        try
        {           
           
        }
        catch(Exception $err)
        {
            log_message("error",$err->getMessage());
            return show_error($err->getMessage());
        }
    }
    public function delete_cms()
    {
        try
        {
           
        }
        catch(Exception $err)
        {
            log_message("error",$err->getMessage());
            return show_error($err->getMessage());
        }
    }
}

?>