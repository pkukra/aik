<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')) {
            redirect('login');
        }
        $this->load->model('Aktivitas_model');
        $this->load->model('Subkegiatan_model');
        $this->load->model('Kegiatan_model');
    }

    // Halaman list unit
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('login');
        }

        // ===============================
        // PERIODE 12 BULAN TERAKHIR
        // ===============================
        $bulan_akhir = date('Y-m'); // bulan sekarang
        $bulan_awal  = date('Y-m', strtotime('-11 months'));

        $list = $this->Aktivitas_model
            ->count_aktivitas_12_bulan($user_id, $bulan_awal, $bulan_akhir);

        $labels   = [];
        $dataPoin = [];

        foreach ($list as $l) {
            if ((int)$l->total_poin > 0) {
                // contoh: Jan 2025
                $labels[]   = date('M Y', strtotime($l->bulan . '-01'));
                $dataPoin[] = (int)$l->total_poin;
            }
        }

        $data = [
            'labels'       => $labels,
            'dataPoin'     => $dataPoin,
            'bulan_awal'   => $bulan_awal,
            'bulan_akhir'  => $bulan_akhir
        ];

        $this->load->view('templates/header');
        $this->load->view('chart_list', $data);
        $this->load->view('templates/footer');
    }

    public function detail()
    {
        $user_id = $this->session->userdata('user_id');
        $blntahun   = $this->input->get('p');
        

        $aktivitas = $this->Aktivitas_model
            ->aktivitas_user_bybulantahun($user_id, $blntahun);
        foreach ($aktivitas as $l) {
            $day = date('Y-m-d',strtotime($l->waktu_aktivitas));
            $kegiatan = $this->Aktivitas_model->get_by_date($user_id, $day);
            $totharian = 0;
            foreach ($kegiatan as $k) {
                $totharian += $k->poin;
            }
            $l->kegiatan_detail = $kegiatan;
            $l->totharian = $totharian;
        }

        $data['list'] = $aktivitas;

        $this->load->view('templates/header');
        $this->load->view('chartdetail_list', $data);
        $this->load->view('templates/footer');
    }


}
