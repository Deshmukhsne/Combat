<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Total registrants (counts rows in registration table)
     */
    public function get_total_registrants()
    {
        return (int) $this->db->count_all('registration');
    }

    /**
     * QR Issued - your table doesn't have qr_issued; decide a heuristic.
     * Example heuristic: if 'aadhaar_file' (uploaded id) exists, consider QR issued.
     * Adjust as needed.
     */
    public function get_total_qr_issued()
    {
        $this->db->from('registration')->where('aadhaar_file IS NOT NULL', null, false);
        return (int) $this->db->count_all_results();
    }

    /**
     * Checked-in - your table doesn't include this; return 0 by default.
     * If you add a column (e.g. checked_in TINYINT), change this accordingly.
     */
    public function get_total_checked_in()
    {
        // if you later add 'checked_in' column, uncomment below:
        // $this->db->from('registration')->where('checked_in', 1);
        // return (int) $this->db->count_all_results();

        return 0;
    }

    /**
     * Alerts count — customize as you require. For now return 0.
     * If you have a column (needs_manual_verify), change logic.
     */
    public function get_open_alerts()
    {
        // Example fallback: count rows with missing aadhaar_file (needs verification)
        $this->db->from('registration')->where('aadhaar_file IS NULL', null, false);
        return (int) $this->db->count_all_results();
    }

    /**
     * Get recent registrants (maps DB columns to view-friendly object)
     */
    public function get_recent_registrants($limit = 10)
    {
        $q = $this->db
            ->select("id, full_name, aadhaar_number, aadhaar_file, mobile_number, email, created_at")
            ->order_by('created_at', 'DESC')
            ->limit((int)$limit)
            ->get('registration');

        $rows = $q->result();

        // Normalize to fields expected by the view (name, aadhaar, phone, photo_url, qr_status, checked_in)
        foreach ($rows as &$r) {
            // map existing columns
            $r->name = $r->full_name ?? '';
            $r->aadhaar = $r->aadhaar_number ?? '';
            $r->phone = $r->mobile_number ?? '';
            // photo_url — derive from aadhaar_file if you store files under uploads/
            $r->photo_url = !empty($r->aadhaar_file) ? base_url('uploads/aadhaar/' . $r->aadhaar_file) : null;

            // stub qr_status and checked_in (adjust if you implement them)
            $r->qr_status = !empty($r->aadhaar_file) ? 'issued' : 'pending';
            $r->checked_in = 0;
        }
        unset($r);

        return $rows;
    }
}