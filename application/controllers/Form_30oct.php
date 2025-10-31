<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('RegistrationModel');
        $this->load->helper(['form', 'url']);
        $this->load->library('session');
        $this->load->database(); // ensure DB is loaded
        $this->load->library('upload'); // load here for clarity
        $this->load->model('Form_model'); // Make sure this line exists
    }

    public function registration()
    {
        $this->load->view('form/registration');
    }

    public function submit_registration()
{
    // Configure upload
    $config['upload_path']   = './uploads/aadhaar/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size']      = 2048; // 2MB
    $config['encrypt_name']  = TRUE;

    // Create folder if not exists
    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
    }

    $this->upload->initialize($config);

    // Aadhaar image upload
    if (!$this->upload->do_upload('userfile')) {
        $error_msg = $this->upload->display_errors('', '');
        $this->session->set_flashdata('alert', [
            'type' => 'error',
            'message' => 'Failed to upload Aadhaar image. Reason: ' . $error_msg
        ]);
        redirect('form/registration');
        return;
    }

    $upload_data = $this->upload->data();
    $aadhaar_file = $upload_data['file_name'];

    // Prepare form data
    $data = [
        'full_name'        => $this->input->post('full_name'),
        'aadhaar_number'   => $this->input->post('aadhaar_number'),
        'aadhaar_image'    => $aadhaar_file,
        'mobile_number'    => $this->input->post('mobile_number'),
        'email'            => $this->input->post('email'),
        'emergency_name'   => $this->input->post('emergency_name'),
        'emergency_number' => $this->input->post('emergency_number'),
        'status'           => 'pending',
        'created_at'       => date('Y-m-d H:i:s')
    ];

    // Aadhaar validation
    if (strlen($data['aadhaar_number']) !== 12 || !ctype_digit($data['aadhaar_number'])) {
        $this->session->set_flashdata('alert', [
            'type' => 'error',
            'message' => 'Aadhaar number must be 12 digits.'
        ]);
        redirect('form/registration');
        return;
    }

    // Insert to DB
    $insert_id = $this->RegistrationModel->insert_registration($data);

    if ($insert_id) {
        // Generate QR code automatically after registration
        $this->generate_qr_for_user($insert_id);

        $this->session->set_flashdata('alert', [
            'type' => 'success',
            'message' => 'Registration successful! QR code generated.'
        ]);
    } else {
        $db_error = $this->db->error();
        log_message('error', 'DB insert failed: ' . json_encode($db_error));
        $this->session->set_flashdata('alert', [
            'type' => 'error',
            'message' => 'Database insertion failed.'
        ]);
        @unlink($config['upload_path'] . $aadhaar_file);
    }

    redirect('form/registration');
}

    // Show registrations in a table
    public function view_registrations()
    {
        $data['registrations'] = $this->Form_model->get_all_registrations();
        $this->load->view('view_registrations', $data);
    }

    // Handle Accept/Reject button clicks (AJAX)
    // public function update_status()
    // {
    //     $id = $this->input->post('id');
    //     $status = $this->input->post('status');

    //     if ($this->Form_model->update_status($id, $status)) {
    //         echo json_encode(['success' => true]);
    //     } else {
    //         echo json_encode(['success' => false]);
    //     }
    // }
    
    public function update_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (empty($id) || empty($status)) {
            echo json_encode(['success' => false, 'error' => 'Missing required data']);
            return;
        }

        $updated = $this->Form_model->update_status($id, $status);
        if (!$updated) {
            echo json_encode(['success' => false, 'error' => 'Failed to update status']);
            return;
        }

        // Proceed only if accepted
        if (strtolower($status) === 'accepted') {

            $fullName = trim($this->input->post('full_name'));
            $aadhaar = trim($this->input->post('aadhaar_number'));
            $registration = trim($this->input->post('registration_number'));
            $user_email = trim($this->input->post('email'));

            if (empty($fullName) || empty($aadhaar) || empty($registration) || empty($user_email)) {
                echo json_encode(['success' => false, 'error' => 'Missing user data']);
                return;
            }

            // Include QR library
            $qrLib = APPPATH . 'libraries/phpqrcode-master/qrlib.php';
            if (!file_exists($qrLib)) {
                echo json_encode(['success' => false, 'error' => 'QR library missing']);
                return;
            }
            require_once($qrLib);

            // Directory for QR codes
            $qrDir = FCPATH . 'uploads/qrcodes/';
            if (!is_dir($qrDir))
                mkdir($qrDir, 0777, true);

            // File name format: registration_name_QR.png
            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fullName);
            $safeReg = preg_replace('/[^A-Za-z0-9_\-]/', '_', $registration);
            $fileName = "{$safeReg}_{$safeName}_QR.png";
            $filePath = $qrDir . $fileName;

            // Generate QR
            $qrData = "Name: {$fullName}\nAadhaar: {$aadhaar}\nRegistration ID: {$registration}";
            QRcode::png($qrData, $filePath, QR_ECLEVEL_L, 6, 4);

            // ✅ Send Email with attached QR
            $this->load->library('email');
            $this->load->config('email');

            $this->email->from('someshwarkanthale0@gmail.com', 'Helicopter Show 2025');
            $this->email->to($user_email);
            $this->email->subject("Your Entry Pass - Helicopter Show 2025");

            // HTML message
            $message = "
        <div style='font-family:Poppins, sans-serif; color:#333;'>
            <h3>Dear {$fullName},</h3>
            <p>Thank you for registering with us!</p>
            <p>Your entry pass for the <strong>Helicopter Show 2025</strong> is below:</p>
            <ul>
                <li><strong>Registration ID:</strong> {$registration}</li>
                <li><strong>Date:</strong> 1 November 2025</li>
                <li><strong>Time:</strong> 12:00 PM</li>
                <li><strong>Venue:</strong> CATS Upanagar, Nashik</li>
            </ul>
            <p>Please find your QR code attached below.</p>
            <br>
            <p>Warm regards,<br><strong>Helicopter Show Team</strong></p>
        </div>";

            // Attach the QR image (not inline, to avoid protected property)
            $this->email->message($message);
            $this->email->attach($filePath);

            // Send the email
            if (!$this->email->send()) {
                echo json_encode(['success' => false, 'error' => 'Email failed: ' . $this->email->print_debugger()]);
                return;
            }
        }

        echo json_encode(['success' => true]);
    }

     public function view_registration($id) {
        $data['student'] = $this->Form_model->get_registration_by_id($id);
        $this->load->view('superadmin/Student_detail', $data);
    }
    
  private function generate_qr_for_user($id)
{
    // Load DB
    $this->load->database();

    // ✅ Load the PHP QR library
    require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');

    // Generate a random token
    $token = bin2hex(random_bytes(10));

    // The QR will encode this content
    $qrContent = site_url('verify/' . $id . '?token=' . $token);

    // Create QR directory if not exists
    $qrDir = FCPATH . 'uploads/qrcodes/';
    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0755, true);
    }

    // File name & path
    $fileName = 'QR_' . $id . '_' . time() . '.png';
    $filePath = $qrDir . $fileName;

    // ✅ Generate the QR Code image
    QRcode::png($qrContent, $filePath, QR_ECLEVEL_L, 5, 2);

    // ✅ Save QR info in the database
    $this->db->where('id', $id)->update('registration', [
        'qr_code_file' => 'uploads/qrcodes/' . $fileName,
        'qr_token'     => $token,
        'qr_issued'    => 1
    ]);
}
    
}
