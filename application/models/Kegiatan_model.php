<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_kegiatan() {
        return $this->db->where('del_add', null)->order_by('id_kegiatan', 'asc')->get('kegiatan')->result();
    }
    public function get_icon() {
        return $this->db->order_by('id_icon', 'asc')->get('fa_icon')->result();
    }
    public function get_all_subkegiatan($id) {
        return $this->db->where('del_add', null)->get_where('subkegiatan', ['id_kegiatan' => $id])->result();
    }
    public function get_by_id($id) {
        return $this->db->get_where('kegiatan', ['id_kegiatan' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('kegiatan', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_kegiatan', $id)->update('kegiatan', $data);
    }

}
