<?php
defined('BASEPATH') or exit('No direct script access allowed');

// cek login
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

        <!-- HEADER -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="navbar-nav ml-auto">
                <img src="<?= base_url('img/pt.png') ?>" style="height:90px; width:auto;">
            </ul>

        </nav>

        <!-- CONTENT -->
        <div class="container-fluid">

            <!-- TITLE -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">

                <h3 class="mb-0 text-gray-800">

                    Edit Data User

                </h3>

                <a href="<?= base_url('kelola_user') ?>" class="btn btn-secondary shadow-sm">

                    <i class="fas fa-arrow-left fa-sm text-white-50"></i>

                    Kembali

                </a>

            </div>

            <!-- CARD -->
            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Form Edit User

                    </h6>

                </div>

                <div class="card-body">

                    <form method="post" action="<?= base_url('Insert/update_user') ?>">

                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

                        <!-- NAMA -->
                        <div class="form-group">

                            <label>
                                Nama Lengkap
                            </label>

                            <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?>" required>

                        </div>

                        <!-- EMAIL -->
                        <div class="form-group">

                            <label>
                                Email
                            </label>

                            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>"
                                required>

                        </div>

                        <!-- PASSWORD -->
                        <div class="form-group">

                            <label>
                                Password
                            </label>

                            <input type="password" name="password" class="form-control"
                                placeholder="Kosongkan jika tidak diubah">

                            <small class="text-muted">
                                Kosongkan jika password tidak ingin diubah
                            </small>

                        </div>

                        <!-- ROLE -->
                        <div class="form-group">

                            <label>
                                Role
                            </label>

                            <select name="role" class="form-control" required>

                                <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>

                                    Admin

                                </option>

                                <option value="karyawan" <?= ($user['role'] == 'karyawan') ? 'selected' : '' ?>>

                                    Karyawan

                                </option>

                            </select>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-primary">

                            <i class="fa fa-save"></i>

                            Update Data

                        </button>

                        <a href="<?= base_url('kelola_user') ?>" class="btn btn-secondary">

                            Batal

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <footer class="sticky-footer bg-white">

        <div class="container my-auto">

            <div class="copyright text-center my-auto">

                <span>
                    ©
                    <?= date("Y"); ?> PT Candra Karya Group.
                </span>

            </div>

        </div>

    </footer>

</div>