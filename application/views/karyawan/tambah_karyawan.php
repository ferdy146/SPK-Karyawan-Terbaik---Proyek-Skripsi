<?php
defined('BASEPATH') or exit('No direct script access allowed');

// cek apakah belum login
if (!isset($_SESSION['login'])) {
    $this->session->set_flashdata('type', 'alert-danger');
    $this->session->set_flashdata('pesan', '<strong>Error!</strong> Anda harus login terlebih dahulu');
    redirect();
    exit;
}

// cek role admin
if ($_SESSION['role'] != 'admin') {
    $this->session->set_flashdata('type', 'alert-danger');
    $this->session->set_flashdata('pesan', '<strong>Akses Ditolak!</strong> Halaman ini hanya untuk Admin');
    redirect('dashboard');
    exit;
}
?>

<div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="navbar-nav ml-auto">
                <img src="img/pt.png" style="height:90px; width:auto;">
            </ul>
        </nav>

        <div class="container-fluid">

            <!-- TITLE -->
            <h2 class="font-weight-bold text-dark mb-4">
                Tambah Data Karyawan
            </h2>

            <!-- FORM -->
            <div class="card shadow col-md-12">
                <div class="card-body">

                    <form action="<?= base_url('Insert/tambah_karyawan') ?>" method="POST">

                        <div class="row">

                            <!-- Nama -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Masukkan nama karyawan" required>
                                </div>
                            </div>

                            <!-- Divisi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Divisi <span class="text-danger">*</span></label>
                                    <select name="divisi" class="form-control" required>
                                        <option value="">-- Pilih Salah Satu --</option>
                                        <option value="BAR">BAR</option>
                                        <option value="SERVER">SERVER</option>
                                        <option value="KITCHEN">KITCHEN</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Jenis Kelamin (RADIO) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label><br>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="LAKI-LAKI" required>
                                        <label class="form-check-label">Laki-laki</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="PEREMPUAN">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                            </div>

                            <!-- Alamat (full width) -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control" rows="4"
                                        placeholder="Masukkan alamat lengkap" required></textarea>
                                </div>
                            </div>

                            <!-- BUTTON -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>

                                    <a href="<?= base_url('data_karyawan') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="text-center my-auto">
                <span>©
                    <?= date("Y"); ?> PT Candra Karya Group
                </span>
            </div>
        </div>
    </footer>

</div>

<!-- SCRIPT -->
<script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('js/sb-admin-2.js') ?>"></script>