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
    }

    public function registration()
    {
        $this->load->view('form/registration');
    }

    public function submit_registration()
    {
        // Configure upload defaults
        $config['upload_path']   = './uploads/aadhaar/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE;

        // Create folder if not exists
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        // Normalize single-file uploads into array format so we can process one or many entries uniformly
        if (isset($_FILES['userfile']) && isset($_FILES['userfile']['name']) && !is_array($_FILES['userfile']['name'])) {
            foreach ($_FILES['userfile'] as $k => $v) {
                $_FILES['userfile'][$k] = [$v];
            }
        }

        // Read posted arrays
        $full_names = $this->input->post('full_name');
        if (empty($full_names) || !is_array($full_names)) {
            $this->session->set_flashdata('alert', [
                'type' => 'error',
                'message' => 'No registration data submitted.'
            ]);
            redirect('form/registration');
            return;
        }

        $total = count($full_names);
        $successful = 0;
        $errors = [];

        // loop through each submitted registration and process (best-effort: continue on errors)
        for ($i = 0; $i < $total; $i++) {
            $aadhaar_file = null;

            // handle file for this index
            if (isset($_FILES['userfile']['name'][$i]) && $_FILES['userfile']['name'][$i] !== '') {
                // prepare a single-file array expected by CI Upload
                $_FILES['userfile_single'] = [
                    'name'     => $_FILES['userfile']['name'][$i],
                    'type'     => $_FILES['userfile']['type'][$i],
                    'tmp_name' => $_FILES['userfile']['tmp_name'][$i],
                    'error'    => $_FILES['userfile']['error'][$i],
                    'size'     => $_FILES['userfile']['size'][$i]
                ];

                // ensure upload library is initialized (reset per iteration)
                $this->upload->initialize($config, TRUE);

                if (!$this->upload->do_upload('userfile_single')) {
                    $errors[] = 'Upload failed for entry #' . ($i + 1) . ': ' . $this->upload->display_errors('', '');
                    // skip this entry and continue with others
                    continue;
                }

                $upload_data = $this->upload->data();
                $aadhaar_file = $upload_data['file_name'];
            } else {
                $errors[] = 'No Aadhaar image provided for entry #' . ($i + 1);
                continue;
            }

            // collect fields (index-based arrays)
            $full_name_val    = isset($_POST['full_name'][$i]) ? trim($_POST['full_name'][$i]) : null;
            $aadhaar_number   = isset($_POST['aadhaar_number'][$i]) ? trim($_POST['aadhaar_number'][$i]) : null;
            $mobile_number    = isset($_POST['mobile_number'][$i]) ? trim($_POST['mobile_number'][$i]) : null;
            $email            = isset($_POST['email'][$i]) ? trim($_POST['email'][$i]) : null;
            $emergency_name   = isset($_POST['emergency_name'][$i]) ? trim($_POST['emergency_name'][$i]) : null;
            $emergency_number = isset($_POST['emergency_number'][$i]) ? trim($_POST['emergency_number'][$i]) : null;

            // basic validation
            if (empty($full_name_val) || empty($aadhaar_number) || empty($mobile_number) || empty($emergency_name) || empty($emergency_number)) {
                $errors[] = 'Missing required fields for entry #' . ($i + 1);
                // cleanup uploaded file for this index
                @unlink($config['upload_path'] . $aadhaar_file);
                continue;
            }

            if (strlen($aadhaar_number) !== 12 || !ctype_digit($aadhaar_number)) {
                $errors[] = 'Aadhaar must be 12 digits for entry #' . ($i + 1);
                @unlink($config['upload_path'] . $aadhaar_file);
                continue;
            }

            // prepare data for insert
            $data = [
                'full_name'        => $full_name_val,
                'aadhaar_number'   => $aadhaar_number,
                'aadhaar_file'     => $aadhaar_file,
                'mobile_number'    => $mobile_number,
                'email'            => $email,
                'emergency_name'   => $emergency_name,
                'emergency_number' => $emergency_number,
                'created_at'       => date('Y-m-d H:i:s')
            ];

            $insert_id = $this->RegistrationModel->insert_registration($data);
            if ($insert_id) {
                $successful++;
                log_message('info', 'Registration inserted, id: ' . $insert_id . ', aadhaar: ' . $aadhaar_number);
            } else {
                $db_error = $this->db->error();
                $errors[] = 'DB insert failed for entry #' . ($i + 1) . ': ' . (isset($db_error['message']) ? $db_error['message'] : 'unknown');
                log_message('error', 'Registration insert failed. DB error: ' . json_encode($db_error));
                @unlink($config['upload_path'] . $aadhaar_file);
            }
        }

        // feedback
        $msgParts = [];
        if ($successful > 0) {
            $msgParts[] = $successful . ' registration(s) saved.';
        }
        if (!empty($errors)) {
            $msgParts[] = 'Errors: ' . implode(' | ', $errors);
        }

        $this->session->set_flashdata('alert', [
            'type' => empty($errors) ? 'success' : ($successful > 0 ? 'warning' : 'error'),
            'message' => implode(' ', $msgParts)
        ]);

        redirect('form/registration');
    }
}
