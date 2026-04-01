<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')) {
            redirect('login');
        }

        // Ambil role
        if ($this->session->userdata('role') == 'admin') {
            show_error('Anda tidak memiliki akses ke halaman ini.');
        }
        $this->load->library('form_validation');
        $this->load->model('Aktivitas_model');
        $this->load->model('Subkegiatan_model');
    }

    // Halaman list unit
    public function index2()
    {
        $user_id = $this->session->userdata('user_id');
        $id = $this->input->get('id');
        $data['list'] = $this->Aktivitas_model->get_aktivitas_by_user($user_id,$id);
        $data['kegiatan'] = $this->Subkegiatan_model->get_kegiatan($id);
        
        print_r($data);
        return;
        
        $this->load->view('templates/header');
        $this->load->view('aktivitas_list', $data);
        $this->load->view('templates/footer');
    }
    
    // Halaman list unit
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $id = $this->input->get('id');
        $data['list'] = $this->Aktivitas_model->get_aktivitas_by_user($user_id,$id);
        $data['kegiatan'] = $this->Subkegiatan_model->get_kegiatan($id);
        
        $this->load->view('templates/header');
        $this->load->view('aktivitas_list', $data);
        $this->load->view('templates/footer');
    }


    // Halaman tambah
    public function add() {
        $id = $this->input->get('id');
        $data['sub'] = $this->Subkegiatan_model->get_subkegiatan_by_idkegiatan($id);
        $data['kegiatan'] = $this->Subkegiatan_model->get_kegiatan($id);
        $data['id_kegiatan'] = $id;
        $this->load->view('templates/header');
        $this->load->view('aktivitas_add',$data);
        $this->load->view('templates/footer');
    }

    public function save() {
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jam', 'Jam', 'required');
        $this->form_validation->set_rules('id_kegiatan', 'Kegiatan', 'required');
        if ($this->input->post('id_kegiatan') == 19) {
            if (empty($_FILES['upload']['name'])) {
                show_error('Upload wajib untuk kegiatan ini');
            }
        }

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            return;
        }

        $id_kegiatan = $this->input->post('id_kegiatan');

        //filter
        $tanggal = $this->input->post('tanggal');
        $id_kegiatan = $this->input->post('id_kegiatan');

        $hari = date('N', strtotime($tanggal));
        if ($id_kegiatan == 15 && $hari != 2) show_error('Tanggal tidak valid');
        if ($id_kegiatan == 16 && $hari != 5) show_error('Tanggal tidak valid');


        $jam = $this->input->post('jam');
        $waktu_aktivitas = $tanggal.' '.$jam;

        // ⬇️ WAJIB default
        $upload = null;

        // ================= UPLOAD FILE =================
        $upload = null;

        if (!empty($_FILES['upload']['name'])) {

            $config['upload_path']   = FCPATH . 'uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 10240; // 10MB
            $config['file_name']     = 'img_' . uniqid() . '_' . time();

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('upload')) {
                echo $this->upload->display_errors();
                exit;
            }

            $dataUpload = $this->upload->data();
            $upload = $dataUpload['file_name'];

            // ================= COMPRESS IMAGE =================
            $this->load->library('image_lib');

            $config_img['image_library']  = 'gd2';
            $config_img['source_image']   = $dataUpload['full_path'];
            $config_img['maintain_ratio'] = TRUE;
            $config_img['quality']        = '60%'; // 🔥 KOMPRES
            $config_img['width']          = 1280;  // resize max width

            $this->image_lib->initialize($config_img);
            $this->image_lib->resize();
            $this->image_lib->clear();
            // ===================================================
        }

        // ===============================================

        $data = [
            'id_kegiatan'     => $id_kegiatan,
            'id_sub'          => $this->input->post('id_sub'),
            'nama_aktivitas'  => $this->input->post('nama_aktivitas'),
            'waktu_aktivitas' => $waktu_aktivitas,
            'keterangan'      => $this->input->post('keterangan'),
            'filename'        => $upload, // ✅ bisa NULL
            'id_user'         => $this->session->userdata('user_id'),
            'created_at'      => date('Y-m-d H:i:s'),
        ];

        $this->Aktivitas_model->insert($data);
        redirect('aktivitas?id='.$id_kegiatan);
    }


    // Halaman edit
    public function edit($id) {
        $data['detail'] = $this->Aktivitas_model->get_by_id($id);
        $data['icon'] = $this->Aktivitas_model->get_icon();
        if (!$data['detail']) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('aktivitas_edit', $data);
        $this->load->view('templates/footer');
    }

    // Proses update
    public function update($id) {
        $data = [
            'nama_aktivitas' => $this->input->post('nama_unit'),
            'poin' => $this->input->post('poin'),
            'icon' => $this->input->post('icon'),
        ];

        $this->Aktivitas_model->update($id, $data);
        redirect('aktivitas');
    }

    // Hapus unit
    public function delete($id) {
        $data = $this->Aktivitas_model->get_by_id($id);
        $id_kegiatan = $data->id_kegiatan;
        $insert = [
            'id_aktivitas'     => $data->id_aktivitas,
            'id_kegiatan'      => $data->id_kegiatan,
            'id_sub'           => $data->id_sub,
            'nama_aktivitas'   => $data->nama_aktivitas,
            'waktu_aktivitas'  => $data->waktu_aktivitas,
            'keterangan'       => $data->keterangan,
            'filename'         => $data->filename,
            'id_user'          => $data->id_user,
            'created_at'       => $data->created_at,
            'del_add'       => date('Y-m-d H:i:s')
        ];

        $this->Aktivitas_model->log_delete($insert);
        $this->Aktivitas_model->delete($id);
        redirect('aktivitas?id='.$id_kegiatan);
    }
}
