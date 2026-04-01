<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Log_login_model');
    }

    public function index(){
        $this->load->view('login_view');
    }

    // public function auth(){
    //     $username = $this->input->post('username');
    //     $password = $this->input->post('password');

    //     // Ambil user berdasarkan username saja
    //     $user = $this->User_model->get_by_username($username);

    //     if ($user && password_verify($password, $user->password)) {
            
    //         // Set session
    //         $this->session->set_userdata([
    //             'user_id' => $user->id,
    //             'nama' => $user->nama,
    //             'username' => $user->username,
    //             'role' => $user->role,
    //             'struktural' => $user->id_unit,
    //             'kd_unit' => $user->kd_unit,
    //         ]);

    //         redirect('dashboard');

    //     } else {
    //         $this->session->set_flashdata('msg', 'Username atau password salah');
    //         redirect('login');
    //     }
    // }

    public function auth(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_username($username);

        if ($user && password_verify($password, $user->password)) {

            // Set session
            $this->session->set_userdata([
                'user_id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'role' => $user->role,
                'struktural' => $user->id_unit,
                'kd_unit' => $user->kd_unit,
            ]);

            // === LOG LOGIN ===
            $log = [
                'user_id'    => $user->id,
                'username'   => $user->username,
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent(),
                'login_time' => date('Y-m-d H:i:s')
            ];
            $this->Log_login_model->insert_log($log);

            redirect('dashboard');

        } else {
            $this->session->set_flashdata('msg', 'Username atau password salah');
            redirect('login');
        }
    }


    public function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }

}
