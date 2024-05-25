<?php

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
        $this->load->model('LimbahModel');
    }

    public function index()
    {
        $data = [
            'judul'  => 'Recyloop - Penukaran Limbah Daur Ulang',
            'user'   => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array(),
            'limbah' => $this->LimbahModel->getLimbah()
        ];

        $this->load->view('templates/member/header', $data);
        $this->load->view('templates/member/sidebar', $data);
        $this->load->view('member/member-section1', $data);
        $this->load->view('member/member-section2', $data);
        $this->load->view('member/member-section3', $data);
        $this->load->view('member/member-section4', $data);
        $this->load->view('member/member-section5', $data);
        $this->load->view('member/member-section6', $data);
        $this->load->view('templates/member/footer');
    }

    public function about()
    {
        $data = [
            'judul' => 'Recyloop - Penukaran Limbah Daur Ulang',
            'user' => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array()
        ];

        $this->load->view('templates/member/header', $data);
        $this->load->view('templates/member/sidebar', $data);
        $this->load->view('member/about/about-section1', $data);
        $this->load->view('member/about/about-section2', $data);
        $this->load->view('member/about/about-section3', $data);
        $this->load->view('member/about/about-section4', $data);
        $this->load->view('member/about/about-section5', $data);
        $this->load->view('member/about/about-section6', $data);
        $this->load->view('member/about/about-footer');
        $this->load->view('templates/member/footer');
    }
}
