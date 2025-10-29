<?php
defined('BASEPATH') or exit('No direct script access allowed');
class form extends CI_Controller
{
    public function registration()
    {
        $this->load->view('form/registration');
    }
}
