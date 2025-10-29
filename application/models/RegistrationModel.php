<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegistrationModel extends CI_Model
{
    public function insert_registration($data)
    {
        return $this->db->insert('registration', $data);
    }
}
