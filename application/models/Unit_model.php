<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->where('del_add', null)->order_by('id', 'asc')->get('units')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('units', ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('units', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('units', $data);
    }

}
