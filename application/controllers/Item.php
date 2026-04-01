<?php
class Item extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if ($this->session->userdata('role') != 'user') {
            show_error("Anda tidak memiliki akses");
        }
        $this->load->model('Item_model');
    }

    public function index(){
        $data['items'] = $this->Item_model->get_all();
        $this->load->view('templates/header');
        $this->load->view('item_list', $data);
        $this->load->view('templates/footer');
    }
}
