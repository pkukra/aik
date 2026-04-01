<?php
class User_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    // LOGIN (password masih plain)
    public function get_login($username, $password){
        return $this->db->get_where('users', [
            'username' => $username,
            'password' => $password
        ])->row();
    }

    public function get_struktural($id)
    {
        return $this->db
            ->where('id_struktural', $id)
            ->get('struktural')
            ->num_rows();
    }

    // Ambil list user berdasarkan unit
    public function get_all_by_unitid($id) {
        return $this->db
        ->select('users.id AS id_user, users.*, units.*, struktural.id_struktural, struktural.id_user as id_us')
        ->from('users')
        ->join('units', 'units.id = users.id_unit', 'left')
        ->join('struktural', 'struktural.id_user = users.id', 'left')
        ->where('users.id_unit', $id)
        ->where('users.del_add', null)
        ->order_by('(CASE WHEN users.id = struktural.id_user THEN 0 ELSE 1 END)', '', false)
        ->order_by('users.id', 'ASC')
        ->get()
        ->result();
    }

    // Ambil list user berdasarkan unit
    public function get_all_deleteuser() {
        return $this->db
        ->select('users.id AS id_user, users.*, units.*, struktural.id_struktural, struktural.id_user as id_us')
        ->from('users')
        ->join('units', 'units.id = users.id_unit', 'left')
        ->join('struktural', 'struktural.id_unit = units.id', 'left')
        ->where('users.del_add IS NOT NULL', null, false)
        ->order_by('users.id', 'ASC')
        ->get()
        ->result();
    }

    // Ambil nama unit
    public function get_nama_unit($id) {
        return $this->db
            ->select('nama_unit')
            ->from('units')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row();
    }
    public function get_unit() {
        return $this->db
            ->select('*')
            ->from('units')
            ->get()
            ->result();
    }

    // Ambil user berdasarkan username
    public function get_by_username($username)
    {
        return $this->db
            ->select('users.*,users.id_unit as kd_unit, struktural.*,units.nama_unit')
            ->from('users')
            ->join('struktural', 'struktural.id_user = users.id', 'left')
            ->join('units', 'units.id = users.id_unit', 'left')
            ->where('users.username', $username)
            ->get()
            ->row();
    }

    // Tambah user
    public function insert($data){
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    public function insert_logdelete($data){
        $this->db->insert('users_delete', $data);
        return $this->db->insert_id();
    }
    public function delete_user($id) {
        return $this->db->where('id', $id)->delete('users');
    }

    public function insert_struktural($data){
        $this->db->insert('struktural', $data);
        return $this->db->insert_id();
    }
    public function update_struktural($data){
        $this->db->where('id_unit', $data['id_unit']);
        $this->db->update('struktural', [
            'id_user' => $data['id_user']
        ]);
    }
    public function delete_struktural($id) {
        return $this->db->where('id_struktural', $id)->delete('struktural');
    }

    // Tambah method untuk CRUD User
    // ======================================

    // Ambil user by id
    public function get_by_id($id){
        return $this->db
            ->select('users.id AS id_user, users.*,users.del_add as deltime, users.del_by as delby, units.*')   // optional
            ->from('users')
            ->join('units', 'units.id = users.id_unit', 'left')
            ->where('users.id', $id)
            ->get()
            ->row();
    }

    // Update user
    public function update($id, $data){
        return $this->db
            ->where('id', $id)
            ->update('users', $data);
    }


    public function count_user_by_unit($id_unit)
    {
        return $this->db
            ->where('id_unit', $id_unit)
            ->count_all_results('users');
    }

    public function cek_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->get('users')
            ->num_rows();
    }

}
