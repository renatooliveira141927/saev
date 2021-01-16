<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Teste_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function emailAvailability() {
        $this->db->where('email','teste');
        $query = $this->db->get('tablename');
        return $query->row();
    }


}