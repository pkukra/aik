<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas_user extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if(!$this->session->userdata('user_id')){
            redirect('login');
        }
        $this->load->model('Kegiatan_model');
        $this->load->model('Aktivitas_model');
    }

    public function index()
    {
        $kegiatan = $this->Kegiatan_model->get_all_kegiatan();
        $user_id  = $this->session->userdata('user_id');

        $totbulan = 0;
        $list     = [];

        foreach ($kegiatan as $k) {
            $poin  = $k->poin;
            $count = $this->Aktivitas_model
                        ->count_aktivitas($k->id_kegiatan, $user_id);

            $total = $poin * $count;

            $list[] = (object)[
                'id_kegiatan'   => $k->id_kegiatan,
                'nama_kegiatan' => $k->nama_kegiatan,
                'poin'          => $poin,
                'icon'          => $k->icon,
                'total'         => $total
            ];

            $totbulan += $total;
        }

        /* =========================
        PROGRESS BAR LOGIC
        ========================= */
        $maxPoin = 2000; // target poin
        $persen  = ($totbulan / $maxPoin) * 100;

        if ($persen > 100) {
            $persen = 100;
        }

        $persen = round($persen);

        // Warna progress otomatis
        if ($persen < 25) {
            $barColor = 'secondary';
        } elseif ($persen < 50) {
            $barColor = 'danger';
        } 
        elseif ($persen < 75) {
            $barColor = 'warning';
        }else {
            $barColor = 'success';
        }

        /* ========================= */

        $data['list']       = $list;
        $data['totbulan']   = $totbulan;
        $data['persen']     = $persen;
        $data['barColor']   = $barColor;
        $data['colors']     = ['primary','secondary','success','info','warning','danger'];
        $data['bulan'] = $this->bulan_indo(date('m'));
        

        $this->load->view('templates/header');
        $this->load->view('aktivitas_user', $data);
        $this->load->view('templates/footer');
    }

    public function bulan_indo($bulan)
    {
        $bulanIndo = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return $bulanIndo[$bulan];
    }

}
