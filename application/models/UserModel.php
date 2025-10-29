<?php

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class UserModel extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }
}
