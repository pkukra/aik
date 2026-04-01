<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct(){
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')){
            redirect('login');
        }


        $this->load->model('User_model');
        $this->load->model('Unit_model');
    }

    public function index()
    {
        $id = $this->input->get('id');
        $id_session = $this->session->userdata('user_id'); 

        // ❌ BLOKIR JIKA ID TIDAK SAMA
        if ($id != $id_session) {
            show_error('Akses ditolak', 403);
        }
        // Ambil user
        $data['user'] = $this->User_model->get_by_id($id);

        // Ambil nama unit berdasar id_unit user
        $data['unit'] = $this->User_model->get_nama_unit($data['user']->id_unit);

        $this->load->view('templates/header');
        $this->load->view('setting_list', $data); // view yg sudah Anda buat
        $this->load->view('templates/footer');
    }

    // Proses update user
    public function update($id)
    {
        $update = [
            'nama'     => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'role'     => $this->input->post('role'),
            'id_unit'  => $this->input->post('id_unit'),  // penting: sesuai dengan naming view
        ];

        // Jika password diganti
        if ($this->input->post('password')) {
            $update['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT); // plaintext (sesuai model Anda)
        }

        // Update melalui model

        $result = $this->User_model->update($id, $update);

        if ($result) {
            $this->session->set_flashdata('success', 'Data Account berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Update gagal! Tidak ada data yang berubah.');
        }
        // Redirect ke halaman user per unit
        redirect('dashboard');
    }

}
