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

    public function perbandingan_berpasangan()
    {
        $data['kriteria'] = $this->db->get('kriteria')->result();

        // ambil data lama
        $perbandingan = $this->db->get('perbandingan_kriteria')->result();

        $matrix = [];

        foreach ($perbandingan as $p) {
            $matrix[$p->kriteria_1][$p->kriteria_2] = $p->nilai;
        }

        $data['matrix'] = $matrix;

        $this->load->view('header');
        $this->load->view('ahp/perbandingan_berpasangan', $data);
    }

    public function proses_ahp()
    {
        $kriteria = $this->db->get('kriteria')->result();
        $n = count($kriteria);

        // ambil data perbandingan
        $data = $this->db->get('perbandingan_kriteria')->result();

        // =========================
        // VALIDASI DATA
        // =========================
        if (empty($data)) {
            echo "<script>alert('Data perbandingan belum diinput!');window.location='" . base_url('perbandingan_berpasangan') . "';</script>";
            exit;
        }

        // =========================
        // BUAT MATRIX AMAN
        // =========================
        $matrix = [];

        foreach ($kriteria as $i) {
            foreach ($kriteria as $j) {

                // default
                $matrix[$i->id_kriteria][$j->id_kriteria] = 1;

                if ($i->id_kriteria != $j->id_kriteria) {

                    foreach ($data as $d) {
                        if ($d->kriteria_1 == $i->id_kriteria && $d->kriteria_2 == $j->id_kriteria) {
                            $matrix[$i->id_kriteria][$j->id_kriteria] = (float) $d->nilai;
                            break;
                        }
                    }

                }
            }
        }

        // =========================
        // TOTAL KOLOM
        // =========================
        $total_kolom = [];

        foreach ($kriteria as $j) {
            $sum = 0;
            foreach ($kriteria as $i) {
                $sum += $matrix[$i->id_kriteria][$j->id_kriteria];
            }
            $total_kolom[$j->id_kriteria] = ($sum == 0 ? 1 : $sum);
        }

        // =========================
        // NORMALISASI
        // =========================
        $normal = [];

        foreach ($kriteria as $i) {
            foreach ($kriteria as $j) {

                $normal[$i->id_kriteria][$j->id_kriteria] =
                    $matrix[$i->id_kriteria][$j->id_kriteria] /
                    $total_kolom[$j->id_kriteria];

            }
        }

        // =========================
        // EIGEN VECTOR
        // =========================
        $eigen = [];

        foreach ($kriteria as $i) {

            $row = isset($normal[$i->id_kriteria]) ? $normal[$i->id_kriteria] : [];

            $eigen[$i->id_kriteria] =
                count($row) > 0 ? array_sum($row) / count($row) : 0;
        }

        // =========================
        // LAMBDA MAX
        // =========================
        $lambda = [];

        foreach ($kriteria as $i) {

            $jumlah = 0;

            foreach ($kriteria as $j) {

                $val = isset($matrix[$i->id_kriteria][$j->id_kriteria])
                    ? $matrix[$i->id_kriteria][$j->id_kriteria]
                    : 0;

                $eig = isset($eigen[$j->id_kriteria])
                    ? $eigen[$j->id_kriteria]
                    : 0;

                $jumlah += $val * $eig;
            }

            $eigen_i = isset($eigen[$i->id_kriteria]) && $eigen[$i->id_kriteria] != 0
                ? $eigen[$i->id_kriteria]
                : 1;

            $lambda[] = $jumlah / $eigen_i;
        }

        $lambda_max = count($lambda) > 0 ? array_sum($lambda) / count($lambda) : 0;

        // =========================
        // CI & CR
        // =========================
        $ci = ($n > 1) ? ($lambda_max - $n) / ($n - 1) : 0;

        $ri_table = [
            1 => 0,
            2 => 0,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49
        ];

        $ri = isset($ri_table[$n]) ? $ri_table[$n] : 1.49;

        $cr = ($ri == 0) ? 0 : $ci / $ri;

        // =========================
        // SIMPAN BOBOT (AMAN)
        // =========================
        if ($cr < 0.1) {

            $this->db->truncate('ahp_bobot');

            foreach ($eigen as $id => $bobot) {

                $this->db->insert('ahp_bobot', [
                    'id_kriteria' => $id,
                    'bobot' => $bobot
                ]);
            }
        }

        // =========================
        // KIRIM KE VIEW
        // =========================
        $data = [
            'matrix' => $matrix,
            'normal' => $normal,
            'eigen' => $eigen,
            'lambda_max' => $lambda_max,
            'ci' => $ci,
            'cr' => $cr,
            'konsisten' => $cr < 0.1
        ];

        $this->load->view('header');
        $this->load->view('ahp/proses_ahp', $data);
    }

    public function proses_pm()
    {
        $karyawan = $this->db->get('karyawan')->result();
        $kriteria = $this->db->get('kriteria')->result();
        $bobot = $this->db->get('ahp_bobot')->result();

        // ubah jadi array
        $bobot_ahp = [];
        foreach ($bobot as $b) {
            $bobot_ahp[$b->id_kriteria] = $b->bobot;
        }

        // ambil nilai
        $nilai = $this->db->get('nilai_karyawan')->result();

        $data_nilai = [];
        foreach ($nilai as $n) {
            $data_nilai[$n->id_karyawan][$n->id_kriteria] = $n->nilai;
        }

        // fungsi konversi nilai
        function konversi_nilai($nilai)
        {
            if ($nilai >= 90)
                return 4;
            elseif ($nilai >= 75)
                return 3;
            elseif ($nilai >= 50)
                return 2;
            else
                return 1;
        }

        function bobot_gap($gap)
        {
            $map = [
                0 => 5,
                1 => 4.5,
                -1 => 4,
                2 => 3.5,
                -2 => 3,
                3 => 2.5,
                -3 => 2,
                4 => 1.5,
                -4 => 1
            ];
            return isset($map[$gap]) ? $map[$gap] : 1;
        }

        $hasil = [];

        foreach ($karyawan as $k) {

            $total = 0;

            foreach ($kriteria as $kr) {

                $nilai_k = $data_nilai[$k->id_karyawan][$kr->id_kriteria];

                $bobot_nilai = konversi_nilai($nilai_k);

                $gap = $bobot_nilai - $kr->nilai_target;

                $bobotGap = bobot_gap($gap);

                $total += $bobotGap * $bobot_ahp[$kr->id_kriteria];
            }

            $hasil[$k->id_karyawan] = $total;
        }

        // simpan hasil
        $this->db->truncate('hasil_akhir');

        foreach ($hasil as $id => $nilai) {
            $this->db->insert('hasil_akhir', [
                'id_karyawan' => $id,
                'nilai_akhir' => $nilai
            ]);
        }

        $this->load->view('header');
        $this->load->view('pm/pm_ahp', ['hasil' => $hasil]);
    }

    public function ranking()
    {
        $data['ranking'] = $this->db->query("
        SELECT k.nama_karyawan, h.nilai_akhir
        FROM hasil_akhir h
        JOIN karyawan k ON k.id_karyawan = h.id_karyawan
        ORDER BY h.nilai_akhir DESC
    ")->result();

        $this->load->view('header');
        $this->load->view('ranking/ranking', $data);
    }
}

