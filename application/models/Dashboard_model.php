<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // ensure db is loaded (autoload is also fine)
        $this->load->database();
    }

    // Example: total registrants
    public function get_total_registrants()
    {
        return (int) $this->db->count_all('registrants');
    }

    // Example: total QR issued (assumes 'qr_issued' boolean/int column)
    public function get_total_qr_issued()
    {
        $this->db->from('registrants')->where('qr_issued', 1);
        return (int) $this->db->count_all_results();
    }

    // Example: total checked-in (assumes 'checked_in' boolean/int column)
    public function get_total_checked_in()
    {
        $this->db->from('registrants')->where('checked_in', 1);
        return (int) $this->db->count_all_results();
    }

    // Example: open alerts (customize per your alerts table)
    public function get_open_alerts()
    {
        // If you have an alerts table:
        // return (int) $this->db->where('status','open')->from('alerts')->count_all_results();

        // fallback: count registrants needing manual verification (example column 'needs_manual_verify')
        $this->db->from('registrants')->where('needs_manual_verify', 1);
        return (int) $this->db->count_all_results();
    }

    // Recent registrants: returns array of objects
    public function get_recent_registrants($limit = 10)
    {
        $query = $this->db
                      ->select('id, name, aadhaar, phone, qr_status, checked_in, photo_url, created_at')
                      ->order_by('created_at', 'DESC')
                      ->limit((int)$limit)
                      ->get('registrants');

        return $query->result();
    }
}