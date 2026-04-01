<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')){
            redirect('login');
        }

        // Cek role admin
        if ($this->session->userdata('role') != 'admin') {
            IF($this->session->userdata('struktural') == NULL){
                show_error("Anda tidak memiliki akses");
            }
        }
        $this->load->model('User_model');
        $this->load->model('Unit_model');
    }

    // List user berdasarkan unit (pakai GET: ?id=xx)
    public function index(){
        $unit_id = $this->input->get('id');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['unit'] = $this->Unit_model->get_by_id($unit_id);
        $data['list'] = $this->User_model->get_all_by_unitid($unit_id);

        $this->load->view('templates/header');
        $this->load->view('user_list', $data);
        $this->load->view('templates/footer');
    }

    // Form tambah user
    public function add(){
        $unit_id = $this->input->get('id');
        $data['units'] = $this->Unit_model->get_all();
        $data['unit'] = $this->Unit_model->get_by_id($unit_id);

        $this->load->view('templates/header');
        $this->load->view('user_add', $data);
        $this->load->view('templates/footer');
    }

    // Simpan user baru
    public function save(){
        $data = [
            'nama'      => $this->input->post('nama'),
            'username'  => $this->input->post('username'),
            'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role'      => $this->input->post('role'),
            'id_unit'   => $this->input->post('id_unit'),
        ];

        $this->User_model->insert($data);
        redirect('user?id='.$data['id_unit']);
    }

    // Form edit user
    public function edit($id)
    {
        // Ambil user
        $data['user'] = $this->User_model->get_by_id($id);

        if (!$data['user']) {
            show_404();
        }

        // Ambil nama unit berdasar id_unit user
        $data['allunit'] = $this->User_model->get_unit();
        $data['unit'] = $this->User_model->get_nama_unit($data['user']->id_unit);

        $this->load->view('templates/header');
        $this->load->view('user_edit', $data); // view yg sudah Anda buat
        $this->load->view('templates/footer');
    }

    // Proses update user
    public function update($id)
    {
        $update = [
            'nama'     => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'role'     => $this->input->post('role'),
            'id_unit'  => $this->input->post('id_unit_update'),  // penting: sesuai dengan naming view
        ];

        $id_unit = $this->input->post('id_unit');
        // Jika password diganti
        if ($this->input->post('password')) {
            $update['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT); // plaintext (sesuai model Anda)
        }

        // Update melalui model

        $result = $this->User_model->update($id, $update);

        if ($result) {
            $this->session->set_flashdata('success', 'Data user berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Update gagal! Tidak ada data yang berubah.');
        }
        // Redirect ke halaman user per unit
        redirect('user?id=' . $id_unit);
    }


    // Hapus user
    public function delete($id){
        $user = $this->User_model->get_by_id($id);
        $id_unit = $user->id_unit;

        $update = [
            'del_add'     => date('Y-m-d H:i:s'),
            'del_by' => $this->session->userdata('user_id'),
        ];

        $this->User_model->update($id,$update);
        redirect('user?id='.$id_unit);
    }

    public function add_supervisor($id){
        $user = $this->User_model->get_by_id($id);
        $id_unit = $user->id_unit;
        
        $data = [
            'id_unit'  => $id_unit,
            'id_user'  => $id,
        ];

        $this->User_model->insert_struktural($data);
        redirect('user?id='.$data['id_unit']);
    }
    public function update_supervisor($id){
        $user = $this->User_model->get_by_id($id);
        $id_unit = $user->id_unit;
        
        $data = [
            'id_unit'  => $id_unit,
            'id_user'  => $id,
        ];

        $this->User_model->update_struktural($data);
        redirect('user?id='.$data['id_unit']);
    }
    public function delete_supervisor(){
        $id_struktural = $this->input->get('id');
        $id_unit       = $this->input->get('u');

        if (!$id_struktural) {
            show_error('ID struktural tidak ditemukan');
        }

        $this->User_model->delete_struktural($id_struktural);

        redirect('user?id='.$id_unit);
    }

     // AJAX cek username
    public function username()
    {
        $username = $this->input->post('username');

        // validasi dasar
        if (!$username) {
            echo json_encode([
                'status'  => false,
                'message' => 'Username tidak boleh kosong'
            ]);
            return;
        }

        // cek ke database
        $cek = $this->User_model->get_by_username($username);

        if ($cek) {
            echo json_encode([
                'status'   => false,
                'message'  => 'Username sudah digunakan <span class="text-primary">' . $cek->nama . ' (' . $cek->nama_unit . ')</span>',
                'username' => $username
            ]);
        } else {
            echo json_encode([
                'status'   => true,
                'message'  => 'Username tersedia',
                'username' => $username
            ]);
        }
    }
}
