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

        $perbandingan = $this->db->get('perbandingan_kriteria')->result();

        if (!$perbandingan) {
            echo "<script>alert('Data perbandingan belum diinput');window.location='" . base_url('perbandingan_berpasangan') . "';</script>";
            exit;
        }

        // =========================
        // MATRIX
        // =========================
        $matrix = [];

        foreach ($kriteria as $i) {

            foreach ($kriteria as $j) {

                if ($i->id_kriteria == $j->id_kriteria) {

                    $matrix[$i->id_kriteria][$j->id_kriteria] = 1;

                } else {

                    $nilai = $this->db
                        ->get_where('perbandingan_kriteria', [
                            'kriteria_1' => $i->id_kriteria,
                            'kriteria_2' => $j->id_kriteria
                        ])
                        ->row();

                    $matrix[$i->id_kriteria][$j->id_kriteria] =
                        $nilai ? (float) $nilai->nilai : 1;
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

            $total_kolom[$j->id_kriteria] = $sum;
        }

        // =========================
        // NORMALISASI
        // =========================
        $normal = [];

        foreach ($kriteria as $i) {

            foreach ($kriteria as $j) {

                $normal[$i->id_kriteria][$j->id_kriteria] =
                    $matrix[$i->id_kriteria][$j->id_kriteria]
                    / $total_kolom[$j->id_kriteria];
            }
        }

        // =========================
        // EIGEN VECTOR
        // =========================
        $eigen = [];

        foreach ($normal as $i => $row) {

            $eigen[$i] = array_sum($row) / $n;
        }

        // =========================
        // LAMBDA MAX 
        // =========================

        $lambda_detail = [];

        $lambda_max = 0;

        foreach ($kriteria as $k) {

            $id = $k->id_kriteria;

            // jumlah kolom
            $jumlah_kolom = $total_kolom[$id];

            // eigen vector
            $eigen_vector = $eigen[$id];

            // hasil perkalian
            $hasil = $jumlah_kolom * $eigen_vector;

            // total eigen max
            $lambda_max += $hasil;

            // simpan detail
            $lambda_detail[$id] = [
                'jumlah_kolom' => $jumlah_kolom,
                'eigen' => $eigen_vector,
                'hasil' => $hasil
            ];
        }

        // =========================
        // CI
        // =========================
        $ci = ($lambda_max - $n) / ($n - 1);

        // =========================
        // RI
        // =========================
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

        $ri = $ri_table[$n];

        // =========================
        // CR
        // =========================
        $cr = $ci / $ri;

        // =========================
        // SIMPAN BOBOT
        // =========================
        if ($cr < 0.1) {

            // =========================
            // SIMPAN BOBOT AHP
            // =========================

            $this->db->truncate('ahp_bobot');

            foreach ($eigen as $id => $bobot) {

                $this->db->insert('ahp_bobot', [
                    'id_kriteria' => $id,
                    'bobot' => number_format($bobot, 10, '.', '')
                ]);
            }
        }

        // =========================
        // KIRIM DATA
        // =========================
        $data = [
            'matrix' => $matrix,
            'normal' => $normal,
            'eigen' => $eigen,
            'lambda_detail' => $lambda_detail,
            'lambda_max' => $lambda_max,
            'ci' => $ci,
            'cr' => $cr,
            'ri' => $ri,
            'konsisten' => ($cr < 0.1)
        ];

        $this->load->view('header');
        $this->load->view('ahp/proses_ahp', $data);
    }

    public function proses_pm()
    {
        // =========================
        // AMBIL DATA
        // =========================

        $karyawan = $this->db->get('karyawan')->result();
        $kriteria = $this->db->get('kriteria')->result();
        $nilai = $this->db->get('nilai_karyawan')->result();
        $bobot = $this->db->get('ahp_bobot')->result();

        // =========================
        // BOBOT AHP
        // =========================

        $bobot_ahp = [];

        foreach ($bobot as $b) {

            $bobot_ahp[$b->id_kriteria] = $b->bobot;
        }

        // =========================
        // NILAI KARYAWAN
        // =========================

        $data_nilai = [];

        foreach ($nilai as $n) {

            $data_nilai[$n->id_karyawan][$n->id_kriteria] = $n->nilai;
        }

        // =========================
        // PROFILE IDEAL
        // =========================

        $profile_ideal = [];

        foreach ($kriteria as $k) {

            $profile_ideal[$k->id_kriteria] = [
                'kode' => $k->kode,
                'target' => $k->nilai_target
            ];
        }

        // =========================
        // FUNGSI KONVERSI NILAI
        // =========================

        function konversi_nilai_pm($nilai)
        {
            // 90 - 100
            if ($nilai >= 90 && $nilai <= 100) {

                return 4;

            }
            // 75.1 - 89
            elseif ($nilai >= 75.1 && $nilai <= 89.9) {

                return 3;

            }
            // 50.1 - 75
            elseif ($nilai >= 50.1 && $nilai <= 75) {

                return 2;

            }
            // 1 - 50
            elseif ($nilai >= 1 && $nilai <= 50) {

                return 1;

            }
            // default
            else {

                return 0;

            }
        }

        // =========================
        // FUNGSI BOBOT GAP
        // =========================

        function konversi_gap_pm($gap)
        {
            $bobot = [
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

            return isset($bobot[$gap]) ? $bobot[$gap] : 1;
        }

        // =========================
        // ARRAY HASIL
        // =========================

        $konversi_nilai = [];
        $gap = [];
        $bobot_gap = [];
        $hasil_detail = [];
        $hasil_akhir = [];

        // =========================
        // PROSES PM + AHP
        // =========================

        foreach ($karyawan as $k) {

            $id_karyawan = $k->id_karyawan;

            $total = 0;

            foreach ($kriteria as $kr) {

                $id_kriteria = $kr->id_kriteria;

                // =========================
                // NILAI ASLI
                // =========================

                $nilai_asli = isset($data_nilai[$id_karyawan][$id_kriteria])
                    ? $data_nilai[$id_karyawan][$id_kriteria]
                    : 0;

                // =========================
                // KONVERSI NILAI
                // =========================

                $nilai_konversi = konversi_nilai_pm($nilai_asli);

                $konversi_nilai[$id_karyawan][$id_kriteria] = $nilai_konversi;

                // =========================
                // HITUNG GAP
                // =========================

                $selisih_gap = $nilai_konversi - $kr->nilai_target;

                $gap[$id_karyawan][$id_kriteria] = $selisih_gap;

                // =========================
                // BOBOT GAP
                // =========================

                $nilai_bobot_gap = konversi_gap_pm($selisih_gap);

                $bobot_gap[$id_karyawan][$id_kriteria] = $nilai_bobot_gap;

                // =========================
                // HITUNG NILAI AKHIR
                // =========================

                $bobotAHP = isset($bobot_ahp[$id_kriteria])
                    ? $bobot_ahp[$id_kriteria]
                    : 0;

                $hasil = $nilai_bobot_gap * $bobotAHP;

                $hasil_detail[$id_karyawan][$id_kriteria] = $hasil;

                $total += $hasil;
            }

            // =========================
            // TOTAL NILAI AKHIR
            // =========================

            $hasil_akhir[$id_karyawan] = $total;
        }
        // =========================
        // SIMPAN HASIL AKHIR
        // =========================

        $this->db->truncate('hasil_akhir');

        foreach ($hasil_akhir as $id => $nilai) {

            $this->db->insert('hasil_akhir', [
                'id_karyawan' => $id,
                'nilai_akhir' => number_format($nilai, 9, '.', '')
            ]);
        }

        // =========================
        // KIRIM DATA KE VIEW
        // =========================

        $data = [
            'karyawan' => $karyawan,
            'kriteria' => $kriteria,
            'profile_ideal' => $profile_ideal,
            'konversi_nilai' => $konversi_nilai,
            'gap' => $gap,
            'bobot_gap' => $bobot_gap,
            'hasil_detail' => $hasil_detail,
            'hasil_akhir' => $hasil_akhir,
            'bobot_ahp' => $bobot_ahp
        ];

        $this->load->view('header');
        $this->load->view('pm/pm_ahp', $data);
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

    public function kelola_user()
    {
        $data['users'] = $this->db
            ->order_by('id_user', 'DESC')
            ->get('users')
            ->result();

        $this->load->view('header');
        $this->load->view('user/user', $data);
    }

    public function tambah_user()
    {
        $this->load->view('header');
        $this->load->view('user/tambah_user');
    }

    public function edit_user()
    {
        $id = $this->input->get('id');

        $data['user'] = $this->db
            ->get_where('users', ['id_user' => $id])
            ->row_array();

        $this->load->view('header');
        $this->load->view('user/edit_user', $data);
    }
}

