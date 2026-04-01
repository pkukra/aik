<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cheat extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')) {
            redirect('login');
        }

        // Ambil role
        if ($this->session->userdata('kd_unit') != '3') {
            redirect('dashboard');
        }
        $this->load->library('form_validation');
        $this->load->model('Kegiatan_model');
        $this->load->model('Subkegiatan_model');
        $this->load->model('Aktivitas_model');
    }

    // Halaman list unit
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $id = $this->input->get('id');
        $kegiatan = $this->Kegiatan_model->get_all_kegiatan();

        $list = [];
        foreach ($kegiatan as $k) {
            $k->sub = $this->Subkegiatan_model->get_subkegiatan_by_idkegiatan($k->id_kegiatan);
            $list[] = $k;
        }

        $data['list'] = $list;
        $data['user_id'] = $user_id;
        
        $this->load->view('templates/header');
        $this->load->view('cheat_list', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        $kegiatan = $this->input->post('kegiatan');
        $tanggal = $this->input->post('tanggal');
        $id_user = $this->input->post('id_user');
        // var_dump($kegiatan);
        // return;
        $data = array();
        foreach ($kegiatan as $id_kegiatan => $k) {
            if (isset($k['aktif']) && !empty($k['aktif'])) :
                if (isset($k['sub']) && !empty($k['sub'])) :
                    foreach ($k['sub'] as $id_sub => $on) {
                        $waktu_awal = $k['sub_waktu'][$id_sub];
                        $random_menit = rand(1, 20);

                        // gabungkan ke datetime dummy
                        $datetime = date(
                            'Y-m-d H:i:s',
                            strtotime($tanggal.' '.$waktu_awal.' +'.$random_menit.' minutes')
                        );
                        $data[] = array(
                            'id_kegiatan' => $id_kegiatan,
                            'id_sub'      => $id_sub,
                            'waktu_aktivitas'       => isset($datetime)? $datetime: date('H:i:s'),
                            'id_user' => $id_user,
                            'created_at' => date('Y-m-d H:i:s')
                        );
                    }
                
                else:
                    $waktu_awal2 = isset($k['waktu'])? $k['waktu']: date('H:i:s');
                    $random_menit2 = rand(1, 20);

                    // gabungkan ke datetime dummy
                    $datetime2 = date(
                        'Y-m-d H:i:s',
                        strtotime($tanggal.' '.$waktu_awal2.' +'.$random_menit2.' minutes')
                    );
                    $data[] = array(
                        'id_kegiatan'       => $id_kegiatan,
                        'id_sub'            => null,
                        'nama_aktivitas'    => $k['nama'],
                        'waktu_aktivitas'   => isset($datetime2) ? $datetime2 : date('H:i:s'),
                        'id_user'           => $id_user,
                        'created_at'        => date('Y-m-d H:i:s')
                    );
                endif;
            endif;
        }
        foreach($data as $d):
            $cek =  $this->Aktivitas_model->cek_aktivitas($d,$tanggal);
            if($cek):
                $this->Aktivitas_model->update($cek->id_aktivitas,$d);
            else:
                $this->Aktivitas_model->insert($d);
            endif;
        endforeach;
        redirect('aktivitas_user');
    }

}
