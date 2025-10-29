<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegistrationModel extends CI_Model
{
    protected $table = 'registration'; // make sure this matches actual table name

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_registration($data)
    {
        $this->db->insert($this->table, $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }
}
