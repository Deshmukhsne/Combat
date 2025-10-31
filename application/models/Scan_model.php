<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan_model extends CI_Model
{
    /**
     * Get recent scans joined with registration data.
     *
     * @param int $limit
     * @return array
     */
    public function get_recent_scans($limit = 100)
    {
        $this->db
            ->select('qs.id as scan_id, qs.registration_id, qs.scanned_at, qs.scanner, qs.result, r.full_name, r.mobile_number, r.aadhaar_number, r.qr_code_file')
            ->from('qr_scans qs')
            ->join('registration r', 'r.id = qs.registration_id', 'left')
            ->order_by('qs.scanned_at', 'DESC')
            ->limit((int)$limit);

        $q = $this->db->get();
        return $q->result_array();
    }
}