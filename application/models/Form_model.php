<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form_model extends CI_Model
{
    public function get_all_registrations()
    {
        $query = $this->db->get('registration');
        return $query->result_array();
    }

    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('registration', ['status' => $status]);
    }
}
?>
