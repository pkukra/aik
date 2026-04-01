<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends CI_Controller {

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
        $this->load->model('Kegiatan_model');
        $this->load->model('Subkegiatan_model');
    }

    // Halaman list unit
    public function index()
    {
        $kegiatan = $this->Kegiatan_model->get_all_kegiatan();

        $list = [];

        foreach ($kegiatan as $k) {
            $sub = $this->Kegiatan_model->get_all_subkegiatan($k->id_kegiatan);
            // Gabungkan dalam satu object
            $list[] = (object)[
                'id_kegiatan'   => $k->id_kegiatan,
                'nama_kegiatan' => $k->nama_kegiatan,
                'poin' => $k->poin,
                'icon' => $k->icon,
                'sub'           => $sub
            ];
        }

        $data['list'] = $list;

        
        
        $this->load->view('templates/header');
        $this->load->view('kegiatan_list', $data);
        $this->load->view('templates/footer');
    }


    // Halaman tambah
    public function add() {
        $data['icon'] = $this->Kegiatan_model->get_icon();
        $this->load->view('templates/header');
        $this->load->view('kegiatan_add',$data);
        $this->load->view('templates/footer');
    }

    // Proses simpan
    public function save() {
        $data = [
            'nama_kegiatan' => $this->input->post('nama_kegiatan'),
            'poin' => $this->input->post('poin'),
            'icon' => $this->input->post('icon'),
        ];
        $this->Kegiatan_model->insert($data);
        redirect('kegiatan');
    }

    // Halaman edit
    public function edit($id) {
        $data['detail'] = $this->Kegiatan_model->get_by_id($id);
        $data['icon'] = $this->Kegiatan_model->get_icon();
        if (!$data['detail']) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('kegiatan_edit', $data);
        $this->load->view('templates/footer');
    }

    // Proses update
    public function update($id) {
        $data = [
            'nama_kegiatan' => $this->input->post('nama_unit'),
            'poin' => $this->input->post('poin'),
            'icon' => $this->input->post('icon'),
        ];

        $this->Kegiatan_model->update($id, $data);
        redirect('kegiatan');
    }

    // Hapus unit
    public function delete($id) {
        $update = [
            'del_add'     => date('Y-m-d H:i:s'),
            'del_by' => $this->session->userdata('user_id'),
        ];
        $this->Subkegiatan_model->update($id,$update);
        $this->Kegiatan_model->update($id,$update);
        redirect('kegiatan');
    }
}
