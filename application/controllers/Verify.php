<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verify extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index($id = null)
    {
        // if no ID in URL
        if (empty($id)) {
            show_error('No ID provided in QR code URL', 400);
            return;
        }

        // get token from URL (?token=xxxxx)
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

        if ($query->num_rows() > 0) {
            $data['record'] = $query->row();
            $data['status'] = 'valid';
        } else {
            $data['status'] = 'invalid';
        }

        // Load verification view
        $this->load->view('verify/verify_view', $data);
    }
}