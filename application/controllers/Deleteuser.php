<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deleteuser extends CI_Controller {

    public function __construct(){
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')){
            redirect('login');
        }

        // Cek role admin
        if ($this->session->userdata('role') != 'admin') {
            if ($this->session->userdata('struktural') != '2') {
                show_error("Anda tidak memiliki akses");
            }
        }

        $this->load->model('User_model');
        $this->load->model('Unit_model');
    }

    // List user berdasarkan unit (pakai GET: ?id=xx)
    public function index(){
        $data['list'] = $this->User_model->get_all_deleteuser();

        $this->load->view('templates/header');
        $this->load->view('deleteuser_list', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        // Ambil user
        $id = $this->input->get('id');
        $data['user'] = $this->User_model->get_by_id($id);

        if (!$data['user']) {
            show_404();
        }

        // Ambil nama unit berdasar id_unit user
        $data['allunit'] = $this->User_model->get_unit();
        $data['unit'] = $this->User_model->get_nama_unit($data['user']->id_unit);

        $this->load->view('templates/header');
        $this->load->view('deleteuser_edit', $data); // view yg sudah Anda buat
        $this->load->view('templates/footer');
    }

    public function update($id)
    {
        $update = [
            'nama'     => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'role'     => $this->input->post('role'),
            'id_unit'  => $this->input->post('id_unit'),
        ];

        // Jika pilih YA (aktifkan)
        if ($this->input->post('aktifkan') == '1') {
            $update['del_by']  = null;
            $update['del_add'] = null;
        }

        // Jika password diganti
        if ($this->input->post('password')) {
            $update['password'] = password_hash(
                $this->input->post('password'),
                PASSWORD_DEFAULT
            );
        }

        $result = $this->User_model->update($id, $update);

        if ($result) {
            $this->session->set_flashdata('success', 'Data user berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Update gagal!');
        }

        redirect('deleteuser');
    }

     // Hapus user
    public function delete($id){
        $user = $this->User_model->get_by_id($id);

        $data = [
            'id'        => $user->id_user,
            'nama'      => $user->nama,
            'username'  => $user->username,
            'password'  => $user->password,
            'role'      => $user->role,
            'id_unit'   => $user->id_unit,
            'del_add'   => $user->deltime,
            'del_by'   => $user->delby,
        ];

        if($this->User_model->insert_logdelete($data)):
            $this->User_model->delete_user($id);
        endif;

        redirect('deleteuser');
    }
}
