<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subkegiatan extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')) {
            redirect('login');
        }

        // Ambil role
        if ($this->session->userdata('role') != 'admin') {
            show_error('Anda tidak memiliki akses ke halaman ini.');
        }
        $this->load->library('form_validation');
        $this->load->model('Subkegiatan_model');
    }

    // Halaman list unit
    public function index() {
        $id = $this->input->get('id');
        $data['kegiatan'] = $this->Subkegiatan_model->get_kegiatan($id);
        $data['list'] = $this->Subkegiatan_model->get_subkegiatan_by_idkegiatan($id);
        $this->load->view('templates/header');
        $this->load->view('subkegiatan_list', $data);
        $this->load->view('templates/footer');
    }

    // Halaman tambah
    public function add() {
        $id = $this->input->get('id');
        $data['kegiatan'] = $this->Subkegiatan_model->get_kegiatan($id);
        $this->load->view('templates/header');
        $this->load->view('subkegiatan_add',$data);
        $this->load->view('templates/footer');
    }

    // Proses simpan
    public function save() {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $data = [
            'id_kegiatan' => $id_kegiatan,
            'nama_subkegiatan' => $this->input->post('nama_subkegiatan'),
        ];
        $this->Subkegiatan_model->insert($data);
        redirect('subkegiatan?id='.$id_kegiatan);
    }

    // Halaman edit
    public function edit($id) {
        $data['detail'] = $this->Subkegiatan_model->get_by_id($id);

        if (!$data['detail']) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('subkegiatan_edit', $data);
        $this->load->view('templates/footer');
    }

    // Proses update
    public function update($id) {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $data = [
            'nama_subkegiatan' => $this->input->post('nama_subkegiatan'),
        ];

        $this->Subkegiatan_model->update($id, $data);
        redirect('subkegiatan?id='.$id_kegiatan);
    }

    // Hapus unit
    public function delete($id) {
        $subkegiatan = $this->Subkegiatan_model->get_by_id($id);
        $id_kegiatan = $subkegiatan->id_kegiatan;

        $update = [
            'del_add'     => date('Y-m-d H:i:s'),
            'del_by' => $this->session->userdata('user_id'),
        ];

        $this->Subkegiatan_model->update($id,$update);
        redirect('subkegiatan?id='.$id_kegiatan);
    }
}
