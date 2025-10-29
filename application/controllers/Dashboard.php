<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // load model and helper for escaping
        $this->load->model('Dashboard_model');
        $this->load->helper('url');
        $this->load->helper('security'); // for xss_clean() if needed
    }

    public function index()
    {
        // fetch data from model
        $data['totalRegistrants']   = (int) $this->Dashboard_model->get_total_registrants();
        $data['qrIssued']           = (int) $this->Dashboard_model->get_total_qr_issued();
        $data['checkedIn']          = (int) $this->Dashboard_model->get_total_checked_in();
        $data['alerts']             = (int) $this->Dashboard_model->get_open_alerts();
        $data['recentRegistrants']  = $this->Dashboard_model->get_recent_registrants();

        // pass to view
        $this->load->view('dashboard', $data);
    }
}