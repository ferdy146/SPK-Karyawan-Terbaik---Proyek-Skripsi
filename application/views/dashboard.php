<?php
defined('BASEPATH') or exit('No direct script access allowed');


// cek apakah belum login
if (!isset($_SESSION['login'])) {
    $this->session->set_flashdata('type', 'alert-danger');
    $this->session->set_flashdata('pesan', '<strong>Error!</strong> Anda harus login terlebih dahulu');
    redirect();
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
        <!-- Pesan Sukses Login -->
        <div class="form-group row">
            <div class="col-sm-12">
                <?php if (isset($_SESSION["pesan"])) { ?>
                    <div class="alert <?= $_SESSION['type'] ?> alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?= $_SESSION['pesan'] ?>

                    </div>
                    <?php unset($_SESSION['pesan']);
                } ?>
            </div>
        </div>

        <div class="container-fluid">
            <div class="mb-4">
                <h2 class="font-weight-bold text-dark">
                    Halo,
                    <?= $_SESSION['nama']; ?> 👋
                    </h5>
            </div>

            <div class="container-fluid">

                <!-- Greeting -->
                <?php if ($_SESSION['role'] == 'admin') { ?>

                    <!-- Role ADMIN untuk ICON -->
                    <div class="row">

                        <!-- Jumlah Karyawan -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2 card-hover"
                                onclick="window.location='<?= base_url('data_karyawan') ?>'"
                                style="cursor:pointer; border-left:4px solid #6f42c1;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="h6 font-weight-bold text-uppercase mb-1" style="color:#6f42c1;">
                                                Jumlah Karyawan
                                            </div>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800" id="jumlah_crm">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x " style="color:#6f42c1;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BAR -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2 card-hover"
                                onclick="window.location='<?= base_url('data_karyawan') ?>'"
                                style="cursor:pointer; border-left:4px solid #1cc88a;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="h6 font-weight-bold text-uppercase mb-1" style="color:#1cc88a;">
                                                Divisi BAR
                                            </div>
                                            <div class="h4 font-weight-bold text-gray-800" id="jumlah_bar">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-coffee fa-2x " style="color:#1cc88a;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SERVER -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2 card-hover"
                                onclick="window.location='<?= base_url('data_karyawan') ?>'"
                                style="cursor:pointer; border-left:4px solid #36b9cc;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="h6 font-weight-bold text-uppercase mb-1" style="color:#36b9cc;">
                                                Divisi SERVER
                                            </div>
                                            <div class="h4 font-weight-bold text-gray-800" id="jumlah_server">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-tie fa-2x " style="color:#36b9cc;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KITCHEN -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2 card-hover"
                                onclick="window.location='<?= base_url('data_karyawan') ?>'"
                                style="cursor:pointer; border-left:4px solid #f6c23e;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="h6 font-weight-bold text-uppercase mb-1" style="color:#f6c23e;">
                                                Divisi KITCHEN
                                            </div>
                                            <div class="h4 font-weight-bold text-gray-800" id="jumlah_kitchen">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-utensils fa-2x" style="color:#f6c23e;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php } else { ?>

                    <!-- Role KARYAWAN -->

                    <div class="bg-white rounded shadow p-4" style="max-width:1250px;">

                        <h4 class="font-weight-bold text-dark mb-3">
                            Selamat Datang di Sistem Seleksi Karyawan Terbaik
                        </h4>

                        <p class="text-muted">
                            Anda dapat melihat peringkat hasil seleksi dengan memilih menu
                            <strong>Peringkat</strong> di sidebar.
                        </p>

                        <div style="background:#e7f1ff; border-left:4px solid #0041A3; padding:15px; border-radius:6px;">
                            <p class="mb-0 text-dark" style="font-size:14px;">
                                <strong>Informasi:</strong>
                                Sistem ini menggunakan metode AHP dan Profile Matching
                                untuk menentukan hasil seleksi karyawan.
                            </p>
                        </div>

                    </div>

                <?php } ?>

            </div>
        </div>
    </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>©️
                    <?= date("Y"); ?> PT Kanisius.
                </span>
            </div>
        </div>
    </footer>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<style>
    .card-hover {
        transition: all 0.25s ease;
    }

    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-hover:hover .icon-hover {
        transform: scale(1.1);
        color: #007bff !important;
    }

    .icon-hover {
        transition: all 0.25s ease;
    }
</style>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Script Section (SAMAKAN DENGAN tiket_sarpras) -->
<script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('js/sb-admin-2.js') ?>"></script>

<script>
    $(document).ready(function () {
        $('#menuMenu').trigger('click');
        loadDashboard();
    });

    function loadDashboard() {
        $.ajax({
            url: "<?= base_url('Select/dashboard') ?>",
            method: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#jumlah_crm').text(data.jumlah_crm);
                $('#jumlah_bar').text(data.bar);
                $('#jumlah_server').text(data.server);
                $('#jumlah_kitchen').text(data.kitchen);
            }
        });
    }
</script>