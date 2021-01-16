<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Niveis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('teste_model', 'modelteste');
    }

    public function index()
    {

    }

    public function email_available($str) {
        // You can access
        // $_POST variable
         if ($result) {
             $this->form_validation->set_message('email_available', 'The %s already exists');
             return FALSE;
         }else{
             return TRUE;
         }
    }


}


