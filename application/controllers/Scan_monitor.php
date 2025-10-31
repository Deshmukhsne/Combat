<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan_monitor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Scan_model');
        $this->load->helper('url');
    }

    // Main monitor page
    public function index()
    {
        $this->load->view('scan_monitor');
    }

    // AJAX endpoint returning JSON
    public function latest_scans()
    {
        $limit = (int)$this->input->get('limit', TRUE) ?: 100;
        $rows = $this->Scan_model->get_recent_scans($limit);

        $out = [];
        foreach ($rows as $r) {
            // mask aadhaar (show last 4)
            $aad_raw = isset($r['aadhaar_number']) ? preg_replace('/\D/', '', (string)$r['aadhaar_number']) : '';
            $aad_masked = strlen($aad_raw) >= 4 ? '**** **** ' . substr($aad_raw, -4) : '**** **** ' . $aad_raw;

            $out[] = [
                'scan_id'        => (int)$r['scan_id'],
                'registration_id'=> (int)$r['registration_id'],
                'name'           => htmlspecialchars($r['full_name'] ?? '—', ENT_QUOTES, 'UTF-8'),
                'phone'          => htmlspecialchars($r['mobile_number'] ?? '—', ENT_QUOTES, 'UTF-8'),
                'aadhaar_masked' => htmlspecialchars($aad_masked, ENT_QUOTES, 'UTF-8'),
                'scanned_at'     => date('Y-m-d H:i:s', strtotime($r['scanned_at'] ?? date('Y-m-d H:i:s'))),
                'result'         => htmlspecialchars($r['result'] ?? 'unknown', ENT_QUOTES, 'UTF-8'),
                'scanner'        => htmlspecialchars($r['scanner'] ?? '', ENT_QUOTES, 'UTF-8'),
                'qr_code_file'   => isset($r['qr_code_file']) ? htmlspecialchars(base_url($r['qr_code_file']), ENT_QUOTES, 'UTF-8') : null,
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $out]));
    }
}