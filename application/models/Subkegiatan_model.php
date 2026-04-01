<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subkegiatan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_subkegiatan() {
        return $this->db->order_by('id_sub', 'asc')->get('subkegiatan')->result();
    }

    public function get_subkegiatan_by_idkegiatan($id) {
        return $this->db->where('del_add', null)->get_where('subkegiatan', ['id_kegiatan' => $id])->result();
    }
    public function get_by_id($id) {
        return $this->db->get_where('subkegiatan', ['id_sub' => $id])->row();
    }
    public function get_kegiatan($id) {
        return $this->db->get_where('kegiatan', ['id_kegiatan' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('subkegiatan', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_sub', $id)->update('subkegiatan', $data);
    }

}
