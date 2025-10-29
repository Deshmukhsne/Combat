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
    public function view_registrations()
{
    // optional: fetch data from DB here
    // $data['registrations'] = $this->Dashboard_model->get_all_registrations();

    // load the view safely
    $this->load->view('view_registrations');
}

public function registration_form()
{
    // optional: you can pass prefilled data or configs later
    $this->load->view('form/registration');
}

public function export_csv()
{
    $this->load->database();

    // Fetch all registration data
    $query = $this->db->get('registration');
    $registrations = $query->result_array();

    // Set CSV headers
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=registrations_' . date('Y-m-d_H-i-s') . '.csv');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Write the column headers
    if (!empty($registrations)) {
        fputcsv($output, array_keys($registrations[0]));
    }

    // Write the rows
    foreach ($registrations as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}

}