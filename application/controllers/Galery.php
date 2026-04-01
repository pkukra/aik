<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galery extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Galery_model');

        // Cek login
        if(!$this->session->userdata('user_id')) {
            redirect('login');
        }

    }

    // Halaman list unit
    public function index()
    {
        
        $this->load->view('templates/header');
        $this->load->view('galery');
        $this->load->view('templates/footer');
    }

    public function photo()
    {
        $perPage = $this->input->get('limit') ? (int)$this->input->get('limit') : 18;
        $page    = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $idUser  = $this->input->get('idUser') ? (int)$this->input->get('idUser') : 0;

        $start = ($page - 1) * $perPage;

        $total = $this->Galery_model->count_aktivitas_user($idUser);
        $pages = ceil($total / $perPage);

        $rows = $this->Galery_model->get_photos($perPage, $start, $idUser);

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                "id"            => $row['id'],
                "title"         => $row['title'],
                "url"           => $row['filename'],
                "nama_aktivitas"=> $row['nama_aktivitas'],
                "description"   => $row['description'],
                "date"          => $row['waktu_aktivitas'],
                "kegiatan"      => $row['nama_kegiatan'],
                "subkegiatan"   => $row['nama_subkegiatan'],
                "unit"          => $row['nama_unit'],
            ];
        }

        echo json_encode([
            "page"  => $page,
            "pages" => $pages,
            "total" => $total,
            "data"  => $data,
            "id"    => $idUser
        ]);
    }

}
