<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct(){
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')){
            redirect('login');
        }

        // Cek role admin
        // if ($this->session->userdata('role') != 'admin' || $this->session->userdata('user_id') != '99') {
        //     show_error("Anda tidak memiliki akses");
        // }

        $this->load->model('User_model');
        $this->load->model('Unit_model');
    }

    // List user berdasarkan unit (pakai GET: ?id=xx)
    public function index(){
        $m = date('m');
        $y = date('Y');

        $data['m'] = $m;
        $data['y'] = $y;
        $unit = $this->Unit_model->get_all();
        $list = [];
        foreach ($unit as $k) {
            $total = $this->User_model->count_user_by_unit($k->id);
            // Gabungkan dalam satu object
            $list[] = (object)[
                'id'   => $k->id,
                'nama_unit' => $k->nama_unit,
                'total'  => $total
            ];
        }

        $data['list'] = $list;
        $data['colors'] = ['primary','success','info','warning','danger'];

        $this->load->view('templates/header');
        $this->load->view('laporan_list', $data);
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
            'id_unit'  => $this->input->post('id_unit'),  // penting: sesuai dengan naming view
        ];

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
        redirect('user?id=' . $update['id_unit']);
    }


    // Hapus user
    // public function delete($id){
    //     $user = $this->User_model->get_by_id($id);
    //     $id_unit = $user->id_unit;

    //     $this->User_model->delete($id);
    //     redirect('user?id='.$id_unit);
    // }
}
