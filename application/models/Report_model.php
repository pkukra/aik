<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_report_by_unit($id) {
        return $this->db
            ->select('*')
            ->from('users')
            ->where('id_unit', $id)
            ->order_by('username', 'asc')
            ->get()
            ->result();
    }
    public function get_report_all() {
        return $this->db
            ->select('users.*,units.nama_unit')
            ->from('users')
            ->join('units','units.id = users.id_unit')
            ->where('users.del_add IS NULL', null, false)
            ->where('users.del_by IS NULL', null, false)
            ->order_by('id_unit', 'asc')
            ->get()
            ->result();
    }

    
}
