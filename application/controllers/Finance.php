<?php
class Finance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('FinanceModel');
        $this->load->language('form_validation', 'indonesian');
    }

    public function index()
    {
        $finance1 = $this->FinanceModel->getFinanceById(1);
        $finance2 = $this->FinanceModel->getFinanceById(2);
        // $data['data_deposit'] = $this->FinanceModel->getDeposit();
        $data['menu'] = $this->db->get('deposit')->result_array();

        $data['judul'] = "Data Keuangan Internal";
        $data['transaksi'] = $this->FinanceModel->getFinance();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['saldoModalAwal'] = $finance1['saldo'];
        $data['tgl_update1'] = $finance1['tgl_update'];
        $data['jam_update1'] = $finance1['jam_update'];
        $data['username_update1'] = $finance1['username'];
        $data['saldoKasSaatIni'] = $finance2['saldo'];
        $data['tgl_update2'] = $finance2['tgl_update'];
        $data['jam_update2'] = $finance2['jam_update'];
        $data['username_update2'] = $finance2['username'];

        $this->form_validation->set_rules('saldo', 'Saldo', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view("templates/admin/header", $data);
            $this->load->view("templates/admin/sidebar", $data);
            $this->load->view("templates/admin/topbar", $data);
            $this->load->view("admin/finance/index", $data);
            $this->load->view("templates/admin/footer");
        } else {
            $id = $this->input->post('id');
            $dataFinance = [
                'saldo' => $this->input->post('saldo'),
                'tgl_update' => date('Y-m-d'),
                'jam_update' => date('H:i:s'),
                'username' => $this->session->userdata('username'),
            ];

            if ($this->FinanceModel->updateFinance($id, $dataFinance)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data keuangan telah diperbarui!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal memperbarui data keuangan!</div>');
            }
            redirect('finance');
        }
    }

    public function tambahSaldo()
    {
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than[0]', array(
            'required' => 'Jumlah wajib diisi!',
            'numeric' => 'Jumlah harus berupa angka!',
            'greater_than' => 'Jumlah harus lebih dari 0!'
        ));
        $this->form_validation->set_rules('metode', 'Metode', 'required', array('required' => 'Metode wajib diisi!'));
        $this->form_validation->set_rules('sumber', 'Sumber', 'required', array('required' => 'Sumber wajib diisi!'));
        // $this->form_validation->set_message('required', 'Jumlah wajib diisi!');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>');
            redirect('finance');
            return;
        }

        $id = $this->input->post('id');
        $metode =  $this->input->post('metode');
        $jumlah = $this->input->post('jumlah');
        $sumber = $this->input->post('sumber');
        $tanggal = $this->input->post('tanggal');
        // $tanggal_formatted = date('Y-m-d', strtotime(str_replace('-', '/', $tanggal)));
        $config['upload_path']   = 'assets/finance';
        $config['allowed_types'] = 'jpg|png|pdf|doc|docx';
        $config['max_size'] = 2048; // 2MB
        $file_count = count(glob($config['upload_path'] . '/*'));
        $this->load->library('upload', $config);


        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            $original_name = $upload_data['file_name'];
            $file_count++;
            $sequence_number = sprintf("%03d", $file_count);
            $new_file_name = 'logdeposit_' . $sequence_number . '_' . $original_name;

            $dataDeposit = [
                'id_finance' => $id,
                'metode' => $metode,
                'tanggal' => $tanggal,
                'sumber' => $sumber,
                'image' => $new_file_name
            ];

            rename($config['upload_path'] . '/' . $original_name, $config['upload_path'] . '/' . $new_file_name);
            $this->db->insert('deposit', $dataDeposit);

            if ($this->FinanceModel->tambahSaldo($id, $jumlah)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Saldo berhasil ditambahkan!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan saldo!</div>');
            }
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambah saldo! Wajib menambahkan bukti resi atau foto.</div>');
            // $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambah saldo! Error: ' . $error . '</div>');
        }
        redirect('finance');
    }

    // public function tambahSaldo()
    // {
    //     $this->form_validation->set_rules('jumlah', 'Jumlah', 'required', array('required' => 'Jumlah wajib diisi!'));
    //     $this->form_validation->set_message('required', 'Jumlah wajib diisi!');

    //     if ($this->form_validation->run() == false) {
    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>');
    //         redirect('finance');
    //         return;
    //     }

    //     $id = $this->input->post('id');
    //     $jumlah = $this->input->post('jumlah');
    //     $config['upload_path']   = 'assets/finance';
    //     $config['allowed_types'] = 'jpg|png|pdf|doc|docx';
    //     $config['max_size'] = 2048; // 2MB

    //     $this->load->library('upload', $config);

    //     if ($this->upload->do_upload('file_deposit')) {
    //         $upload_data = $this->upload->data();
    //         $original_name = $upload_data['file_name'];
    //         $file_count = count(glob($config['upload_path'] . '/*'));
    //         $file_count++;
    //         $sequence_number = sprintf("%03d", $file_count);
    //         $new_file_name = 'log_' . $sequence_number . '_' . $original_name;
    //         rename($config['upload_path'] . '/' . $original_name, $config['upload_path'] . '/' . $new_file_name);

    //         $file_path = base_url('assets/finance/' . $new_file_name);

    //         $dataDeposit = [
    //             'id_finance' => $id,
    //             'file_path' => $file_path,
    //         ];

    //         $this->db->insert('deposit', $dataDeposit);

    //         if ($this->FinanceModel->tambahSaldo($id, $jumlah)) {
    //             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Saldo berhasil ditambahkan!</div>');
    //         } else {
    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menambahkan saldo!</div>');
    //         }
    //     } else {
    //         $error = $this->upload->display_errors();
    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengunggah bukti deposit! Error: ' . $error . '</div>');
    //     }
    //     redirect('finance');
    // }
}
