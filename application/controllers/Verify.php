<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verify extends CI_Controller
{
    public function __construct()
   {
    parent::__construct();
    $this->load->database();
    date_default_timezone_set('Asia/Kolkata'); // ✅ Set to India time
}

   public function index($id = null)
{
    if (empty($id)) {
        show_error('No ID provided in QR code URL', 400);
        return;
    }

    $token = $this->input->get('token', true);
    if (empty($token)) {
        $data['error'] = 'QR missing token';
        $this->load->view('verify/verify_view', $data);
        return;
    }

    // fetch matching record
    $query = $this->db->get_where('registration', [
        'id' => $id,
        'qr_token' => $token,
        'qr_issued' => 1
    ]);

    $is_valid = ($query->num_rows() > 0);
    $status = $is_valid ? 'valid' : 'invalid';

    // ✅ Log the scan into `qr_scans` table
    $log_data = [
        'registration_id' => $id,
        'scanned_at'      => date('Y-m-d H:i:s'),
        'scanner'         => $this->input->get('scanner') ?? null, // optional param for staff name/device
        'result'          => $status,
        'ip_address'      => $this->input->ip_address(),
        'user_agent'      => $this->input->user_agent(),
    ];
    $this->db->insert('qr_scans', $log_data);

    // Load verification result
    if ($is_valid) {
        $data['record'] = $query->row();
        $data['status'] = 'valid';
    } else {
        $data['status'] = 'invalid';
    }

    $this->load->view('verify/verify_view', $data);
}
}