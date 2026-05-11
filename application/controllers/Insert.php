<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insert extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->model("Model");
    }

    // public function contoh2()
    // {
    //     $inputAjax = $this->input->post('inputAjax');

    //     $this->Model->contoh2($inputAjax);
    //     redirect('menu');
    // }

    public function tambah_karyawan()
    {
        // ambil data dari form
        $data = [
            'nama_karyawan' => $this->input->post('nama'),
            'divisi' => $this->input->post('divisi'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'alamat' => $this->input->post('alamat')
        ];

        // insert ke database
        $this->db->insert('karyawan', $data);

        // notifikasi
        $this->session->set_flashdata('type', 'alert-success');
        $this->session->set_flashdata('pesan', '<strong>Sukses!</strong> Data karyawan berhasil ditambahkan');

        redirect('data_karyawan');
    }

    public function delete_karyawan()
    {
        $id = $this->input->post('id_karyawan');

        $this->db->where('id_karyawan', $id);
        $this->db->delete('karyawan');
    }

    public function update_karyawan()
    {
        $id = $this->input->post('id_karyawan');

        $data = [
            'nama_karyawan' => $this->input->post('nama'),
            'divisi' => $this->input->post('divisi'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'alamat' => $this->input->post('alamat')
        ];

        $this->db->where('id_karyawan', $id);
        $this->db->update('karyawan', $data);

        $this->session->set_flashdata('type', 'alert-success');
        $this->session->set_flashdata('pesan', 'Data berhasil diupdate');

        redirect('data_karyawan');
    }

    public function tambah_nilai()
    {
        $id_karyawan = $this->input->post('id_karyawan');
        $nilai = $this->input->post('nilai'); // array

        foreach ($nilai as $id_kriteria => $n) {

            // ubah koma ke titik
            $n = str_replace(',', '.', $n);

            $data = [
                'id_karyawan' => $id_karyawan,
                'id_kriteria' => $id_kriteria,
                'nilai' => $n
            ];

            $this->db->insert('nilai_karyawan', $data);
        }

        redirect('data_nilai');
    }

    public function update_nilai()
    {
        $id_karyawan = $this->input->post('id_karyawan');
        $nilai = $this->input->post('nilai');

        foreach ($nilai as $id_kriteria => $n) {

            // ubah koma ke titik
            $n = floatval(str_replace(',', '.', $n));

            // cek apakah sudah ada
            $cek = $this->db->get_where('nilai_karyawan', [
                'id_karyawan' => $id_karyawan,
                'id_kriteria' => $id_kriteria
            ])->row_array();

            if ($cek) {
                // UPDATE
                $this->db->where('id_karyawan', $id_karyawan);
                $this->db->where('id_kriteria', $id_kriteria);
                $this->db->update('nilai_karyawan', ['nilai' => $n]);
            } else {
                // INSERT kalau belum ada
                $this->db->insert('nilai_karyawan', [
                    'id_karyawan' => $id_karyawan,
                    'id_kriteria' => $id_kriteria,
                    'nilai' => $n
                ]);
            }
        }

        redirect('data_nilai');
    }

    public function simpan_perbandingan()
    {
        $data = $this->input->post('nilai');

        if (!$data) {
            echo "<script>alert('Input tidak boleh kosong');window.history.back();</script>";
            exit;
        }

        $this->db->truncate('perbandingan_kriteria');

        foreach ($data as $i => $row) {
            foreach ($row as $j => $val) {

                // skip diagonal
                if ($i == $j) {
                    $val = 1;
                }

                $val = floatval($val);

                if ($val <= 0) {
                    $val = 1;
                }

                $this->db->insert('perbandingan_kriteria', [
                    'kriteria_1' => $i,
                    'kriteria_2' => $j,
                    'nilai' => $val
                ]);
            }
        }

        redirect('proses_ahp');
    }

    public function tambah_user()
    {
        // ambil input
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $role = $this->input->post('role');

        // cek email sudah ada atau belum
        $cek = $this->db
            ->get_where('users', ['email' => $email])
            ->row();

        if ($cek) {

            $this->session->set_flashdata('type', 'alert-danger');
            $this->session->set_flashdata('pesan', '<strong>Gagal!</strong> Email sudah digunakan');

            redirect('tambah_user');
            return;
        }

        // simpan user
        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => md5($password),
            'role' => $role
        ];

        $this->db->insert('users', $data);

        // notifikasi
        $this->session->set_flashdata('type', 'alert-success');
        $this->session->set_flashdata('pesan', '<strong>Sukses!</strong> Data user berhasil ditambahkan');

        redirect('kelola_user');
    }

    public function update_user()
    {
        $id = $this->input->post('id_user');

        $data = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'role' => $this->input->post('role')
        ];

        // cek password diubah atau tidak
        $password = $this->input->post('password');

        if (!empty($password)) {

            $data['password'] = md5($password);
        }

        $this->db->where('id_user', $id);
        $this->db->update('users', $data);

        $this->session->set_flashdata('type', 'alert-success');
        $this->session->set_flashdata('pesan', '<strong>Sukses!</strong> Data user berhasil diupdate');

        redirect('kelola_user');
    }

    public function delete_user()
    {
        $id = $this->input->get('id');

        // cek data user
        $user = $this->db
            ->get_where('users', ['id_user' => $id])
            ->row();

        // jika user tidak ditemukan
        if (!$user) {

            $this->session->set_flashdata('type', 'alert-danger');
            $this->session->set_flashdata('pesan', '<strong>Gagal!</strong> User tidak ditemukan');

            redirect('kelola_user');
            return;
        }

        // hapus user
        $this->db->where('id_user', $id);
        $this->db->delete('users');

        // notifikasi
        $this->session->set_flashdata('type', 'alert-success');
        $this->session->set_flashdata('pesan', '<strong>Sukses!</strong> Data user berhasil dihapus');

        redirect('kelola_user');
    }

}