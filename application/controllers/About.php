<?php

class About extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['judul'] = 'Recyloop.id';

        $this->load->view('templates/home_header', $data);
        $this->load->view('home/about/about', $data);
        $this->load->view('templates/home_footer');
    }
}