<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->helper(['url','security']);
    }

    public function index()
    {
        $data['totalRegistrants']   = (int) $this->Dashboard_model->get_total_registrants();
        $data['qrIssued']           = (int) $this->Dashboard_model->get_total_qr_issued();
        $data['checkedIn']          = (int) $this->Dashboard_model->get_total_checked_in();
        $data['alerts']             = (int) $this->Dashboard_model->get_open_alerts();
        $data['recentRegistrants']  = $this->Dashboard_model->get_recent_registrants();

        $this->load->view('dashboard', $data);
    }
}