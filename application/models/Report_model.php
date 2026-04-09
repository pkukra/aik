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
            ->select('users.id_unit,users.nama,units.nama_unit')
            ->from('users')
            ->join('units','units.id = users.id_unit')
            ->where('users.del_add IS NULL', null, false)
            ->where('users.del_by IS NULL', null, false)
            ->order_by('id_unit', 'asc')
            ->get()
            ->result();
    }

    public function get_report_with_poin($m, $y)
    {
        $this->db->select('
            u.id,
            u.nama,
            u.id_unit,
            n.nama_unit,
            COALESCE(SUM(k.poin),0) as total_poin
        ');

        $this->db->from('users u');

        $this->db->join('aktivitas a', "
            a.id_user = u.id
            AND MONTH(a.waktu_aktivitas) = ".$this->db->escape($m)."
            AND YEAR(a.waktu_aktivitas) = ".$this->db->escape($y)."
        ", 'left');

        $this->db->join('kegiatan k', 'k.id_kegiatan = a.id_kegiatan', 'left');
        $this->db->join('units n', 'n.id = u.id_unit');

        $this->db->group_by('u.id');
        $this->db->order_by('u.id_unit', 'ASC');

        return $this->db->get()->result();
    }
}
