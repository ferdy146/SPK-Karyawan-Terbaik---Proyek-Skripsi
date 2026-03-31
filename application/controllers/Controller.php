<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->model("Model");
    }

    public function login()
    {
        $this->Model->login();
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect();
    }

    // http://localhost/template_penerbitan/
    public function index()
    {
        $this->load->view('login');
    }

    public function dashboard()
    {
        $this->load->view('header');
        $this->load->view('dashboard');
    }

    // DATA KARYAWAN
    public function data_karyawan()
    {
        $this->load->view('header');
        $this->load->view('karyawan/data_karyawan');
    }
    public function tambah_karyawan()
    {
        $this->load->view('header');
        $this->load->view('karyawan/tambah_karyawan');
    }

    public function edit_karyawan()
    {
        $id = $this->input->get('id');

        $data['karyawan'] = $this->db
            ->get_where('karyawan', ['id_karyawan' => $id])
            ->row_array();

        $this->load->view('header');
        $this->load->view('karyawan/edit_karyawan', $data);
    }


    // DATA NILAI
    public function data_nilai()
    {
        $this->load->view('header');
        $this->load->view('nilai/data_nilai');
    }

    public function tambah_data_nilai()
    {
        $data['karyawan'] = $this->db->get('karyawan')->result_array();
        $data['kriteria'] = $this->db->get('kriteria')->result_array();
        $this->load->view('header');
        $this->load->view('nilai/tambah_data_nilai', $data);
    }

    public function edit_data_nilai()
    {
        $id_karyawan = $this->input->get('id');

        if (!$id_karyawan) {
            redirect('data_nilai');
        }

        // ambil data karyawan
        $karyawan = $this->db->get_where('karyawan', ['id_karyawan' => $id_karyawan])->row_array();

        // ambil semua kriteria
        $kriteria = $this->db->get('kriteria')->result_array();

        // ambil nilai
        $query = $this->db->get_where('nilai_karyawan', ['id_karyawan' => $id_karyawan])->result_array();

        $nilai = [];
        foreach ($query as $n) {
            $nilai[$n['id_kriteria']] = $n['nilai'];
        }

        $data = [
            'id_karyawan' => $id_karyawan,
            'nama_karyawan' => $karyawan['nama_karyawan'],
            'kriteria' => $kriteria,
            'nilai' => $nilai
        ];

        $this->load->view('header');
        $this->load->view('nilai/edit_data_nilai', $data);
    }
}

