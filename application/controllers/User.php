<?php

class User extends CI_Controller
{
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        echo 'Selamat Datang ' . $data['user']['name'];
    }

    // INFORMASI PROFILE
    public function my_profile()
    {
        $data = [
            'judul' => 'Profil Saya',
            'user' => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array()
        ];

        $this->load->view("templates/admin/header", $data);
        $this->load->view("templates/admin/sidebar", $data);
        $this->load->view("templates/admin/topbar", $data);
        $this->load->view('user/konfigurasi_user/my_profile', $data);
        $this->load->view("templates/admin/footer");
    }

    // PENGATURAN INFORMASI PROFILE
    public function edit_profile()
    {
        $data = [
            'judul' => 'Ubah Profil',
            'user' => $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array()
        ];

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view("templates/admin/header", $data);
            $this->load->view("templates/admin/sidebar", $data);
            $this->load->view("templates/admin/topbar", $data);
            $this->load->view('user/konfigurasi_user/edit_profile', $data);
            $this->load->view("templates/admin/footer");
        } else {
            $nama = $this->input->post('nama', true);
            $email = $this->input->post('email', true);
            $uploadImage = $_FILES['photo']['name'];

            if ($uploadImage) {
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = '4096';
                $config['max_width'] = '3084';
                $config['max_height'] = '3084';
                $config['upload_path'] = './assets/images/user/profile/';
                $config['file_name'] = 'user_' . $data['user']['nama'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('photo')) {
                    $gambarLama = $data['user']['photo'];
                    if ($gambarLama != 'default.png') {
                        unlink(FCPATH . 'assets/images/user/profile/' . $gambarLama);
                    }

                    $gambarBaru = $this->upload->data('file_name');
                    $this->db->set('photo', $gambarBaru);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('nama', $nama);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div style="color: #FFF; background: #1f283E;" id="successInput" class="alert alert-success" role="alert">Berhasil Menerapkan Perubahan</div>');
            redirect('user/my_profile');
        }
    }

    public function ubah_password()
    {
        $data['judul'] = 'Ubah Password';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'Password Baru', 'required|trim|min_length[5]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Konfirmasi Password Baru', 'required|trim|min_length[5]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin/header', $data);
            $this->load->view('templates/admin/sidebar', $data);
            $this->load->view('templates/admin/topbar', $data);
            $this->load->view('user/konfigurasi_user/ubah_password', $data);
            $this->load->view('templates/admin/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password saat ini salah.</div>');
                redirect('user/ubah_password');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password saat ini</div>');
                    redirect('user/ubah_password');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('username', $this->session->userdata('username'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password berhasil diubah!</div>');
                    redirect('user/my_profile');
                }
            }
        }
    }
}
