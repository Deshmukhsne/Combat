<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RegistrationModel');
        $this->load->helper(['form', 'url']);
    }

    public function registration()
    {
        $this->load->view('form/registration');
    }

    public function submit_registration()
    {
        // Upload Aadhaar image
        $config['upload_path']   = './uploads/aadhaar/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile') && !isset($_FILES['userfile'])) {
            echo "<script>alert('Failed to upload Aadhaar image');</script>";
            redirect('form/registration', 'refresh');
        } else {
            $upload_data = $this->upload->data();
            $aadhaar_image = $upload_data['file_name'];
        }

        // Prepare form data
        $data = [
            'full_name'        => $this->input->post('full_name'),
            'aadhaar_number'   => $this->input->post('aadhaar_number'),
            'aadhaar_image'    => $aadhaar_image,
            'mobile_number'    => $this->input->post('mobile_number'),
            'email'            => $this->input->post('email'),
            'emergency_name'   => $this->input->post('emergency_name'),
            'emergency_number' => $this->input->post('emergency_number'),
        ];

        // Save to DB
        if ($this->RegistrationModel->insert_registration($data)) {
            echo "<script>alert('Registration successful!'); window.location='" . base_url('form/registration') . "';</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again.');</script>";
        }
    }
}
