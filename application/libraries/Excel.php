<?php

class Excel extends PHPExcel
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
    }
}