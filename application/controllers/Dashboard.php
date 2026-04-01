<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if(!$this->session->userdata('user_id')){
            redirect('login');
        }
        $this->load->model('Kegiatan_model');
        $this->load->model('Aktivitas_model');
    }

    public function test(){
        echo "Dashboard";
    }

    public function index(){

        $role = $this->session->userdata('role');
        $kegiatan = $this->Kegiatan_model->get_all_kegiatan();
        $user_id = $this->session->userdata('user_id');
        $struktural = $this->session->userdata('struktural');

        $totbulan = 0;
        $list = [];
        // foreach ($kegiatan as $k) {
        //     $poin = $k->poin;
        //     $count = $this->Aktivitas_model->count_aktivitas($k->id_kegiatan,$user_id);
        //     $total =  $poin * $count;
        //     // Gabungkan dalam satu object
        //     $list[] = (object)[
        //         'id_kegiatan'   => $k->id_kegiatan,
        //         'nama_kegiatan' => $k->nama_kegiatan,
        //         'poin' => $poin,
        //         'icon' => $k->icon,
        //         'total'  => $total
        //     ];
        //     $totbulan= $totbulan+$total;
        // }

        $data['list'] = $list;

        $data['totbulan'] = $totbulan;
        $data['struktural'] = $struktural;
        $data['user_id'] = $user_id;

        $data['colors'] = ['primary','secondary','success','info','warning','danger'];
        if ($role == 'admin') {
            $this->load->view('templates/header');
            $this->load->view('dashboard_admin',$data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('dashboard_user',$data);
            $this->load->view('templates/footer');
        }
    }
}
