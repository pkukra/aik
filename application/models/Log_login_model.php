<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log_login_model extends CI_Model {

    public function insert_log($data)
    {
        return $this->db->insert('log_login', $data);
    }

}