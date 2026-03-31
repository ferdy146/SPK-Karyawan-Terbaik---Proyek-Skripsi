<?php

class model extends CI_Model
{
    public function login()
    {
        // ambil input
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));

        // ambil data user berdasarkan email
        $this->db->where('email', $email);
        $user = $this->db->get('users')->row_array();

        // cek apakah user ada
        if ($user) {

            // cek password
            if ($password == $user['password']) {

                // set session
                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // notifikasi sukses
                $this->session->set_flashdata('type', 'alert-success');
                $this->session->set_flashdata('pesan', '<strong>Sukses!</strong> Anda berhasil login.');

                redirect('dashboard');

            } else {

                // password salah
                $this->session->set_flashdata('type', 'alert-danger');
                $this->session->set_flashdata('pesan', '<strong>Gagal!</strong> Password salah');
                redirect();
            }

        } else {

            // email tidak ditemukan
            $this->session->set_flashdata('type', 'alert-danger');
            $this->session->set_flashdata('pesan', '<strong>Gagal!</strong> Email tidak ditemukan');
            redirect();
        }
    }

    public function contoh1()
    {
        $query = "SELECT id_karyawan, nama_karyawan, divisi, jenis_kelamin, tanggal_lahir, alamat FROM karyawan";
        return $this->db->query($query);
    }

    public function get_karyawan_by_id($id)
    {
        return $this->db->get_where('karyawan', ['id_karyawan' => $id])->row_array();
    }

}