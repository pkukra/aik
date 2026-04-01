<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

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
        $this->load->model('Unit_model');
    }

    // Halaman list unit
    public function index() {
        $data['list'] = $this->Unit_model->get_all();
        $this->load->view('templates/header');
        $this->load->view('unit_list', $data);
        $this->load->view('templates/footer');
    }

    // Halaman tambah
    public function add() {
        $this->load->view('templates/header');
        $this->load->view('unit_add');
        $this->load->view('templates/footer');
    }

    // Proses simpan
    public function save() {
        $data = [
            'nama_unit' => $this->input->post('nama_unit'),
            'kode_unit' => $this->input->post('kode_unit'),
        ];

        $this->Unit_model->insert($data);
        redirect('unit');
    }

    // Halaman edit
    public function edit($id) {
        $data['detail'] = $this->Unit_model->get_by_id($id);

        if (!$data['detail']) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('unit_edit', $data);
        $this->load->view('templates/footer');
    }

    // Proses update
    public function update($id) {
        $data = [
            'nama_unit' => $this->input->post('nama_unit'),
            'kode_unit' => $this->input->post('kode_unit'),
        ];

        $this->Unit_model->update($id, $data);
        redirect('unit');
    }

    // Hapus unit
    public function delete($id) {
        $update = [
            'del_add'     => date('Y-m-d H:i:s'),
            'del_by' => $this->session->userdata('user_id'),
        ];
        $this->Unit_model->update($id,$update);
        redirect('unit');
    }
}
