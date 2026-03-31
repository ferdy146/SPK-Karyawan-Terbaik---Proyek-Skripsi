<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Select extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->model("Model");
    }

    public function contoh1()
    {
        $data = $this->Model->contoh1()->result_array(); // buka class contoh1 di Model
        echo json_encode($data);
    }

    public function dashboard()
    {
        // total karyawan
        $total = $this->db->count_all('karyawan');

        // jumlah per divisi
        $bar = $this->db->where('divisi', 'BAR')->count_all_results('karyawan');
        $server = $this->db->where('divisi', 'SERVER')->count_all_results('karyawan');
        $kitchen = $this->db->where('divisi', 'KITCHEN')->count_all_results('karyawan');

        $data = [
            'jumlah_crm' => $total,
            'bar' => $bar,
            'server' => $server,
            'kitchen' => $kitchen
        ];

        echo json_encode($data);
    }

    public function data_nilai()
    {
        $query = "
        SELECT 
            k.id_karyawan,
            k.nama_karyawan,
            MAX(CASE WHEN n.id_kriteria=1 THEN n.nilai END) AS C1,
            MAX(CASE WHEN n.id_kriteria=2 THEN n.nilai END) AS C2,
            MAX(CASE WHEN n.id_kriteria=3 THEN n.nilai END) AS C3,
            MAX(CASE WHEN n.id_kriteria=4 THEN n.nilai END) AS C4,
            MAX(CASE WHEN n.id_kriteria=5 THEN n.nilai END) AS C5,
            MAX(CASE WHEN n.id_kriteria=6 THEN n.nilai END) AS C6,
            MAX(CASE WHEN n.id_kriteria=7 THEN n.nilai END) AS C7,
            MAX(CASE WHEN n.id_kriteria=8 THEN n.nilai END) AS C8
        FROM karyawan k
        LEFT JOIN nilai_karyawan n ON k.id_karyawan = n.id_karyawan
        GROUP BY k.id_karyawan
    ";

        echo json_encode($this->db->query($query)->result_array());
    }
}