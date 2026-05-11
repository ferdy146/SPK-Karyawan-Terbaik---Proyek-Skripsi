<?php
defined('BASEPATH') or exit('No direct script access allowed');

// cek login
if (!isset($_SESSION['login'])) {

    $this->session->set_flashdata('type', 'alert-danger');
    $this->session->set_flashdata('pesan', '<strong>Error!</strong> Anda harus login terlebih dahulu');

    redirect();
    exit;
}

// cek role
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
                <img src="img/pt.png" style="height:90px; width:auto;">
            </ul>

        </nav>

        <!-- CONTENT -->
        <div class="container-fluid">

            <div class="d-sm-flex align-items-center justify-content-between mb-4">

                <h3 class="mb-0 text-gray-800">
                    Kelola Data User
                </h3>

                <a href="<?= base_url('tambah_user') ?>" class="btn btn-primary shadow-sm">

                    <i class="fas fa-plus fa-sm text-white-50"></i>

                    Tambah Data

                </a>

            </div>

            <!-- CARD -->
            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        List Data User

                    </h6>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered text-center" width="100%" cellspacing="0">

                            <thead class="bg-primary text-white">

                                <tr>

                                    <th width="8%">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th width="15%">Role</th>
                                    <th width="20%">Aksi</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if (!empty($users)): ?>

                                    <?php $no = 1; ?>

                                    <?php foreach ($users as $u): ?>

                                        <tr>

                                            <td>
                                                <?= $no++; ?>
                                            </td>

                                            <td>
                                                <?= $u->nama ?>
                                            </td>

                                            <td>
                                                <?= $u->email ?>
                                            </td>

                                            <td>

                                                <?php if ($u->role == 'admin'): ?>

                                                    <span class="badge badge-success p-2">

                                                        Admin

                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge badge-secondary p-2">

                                                        Karyawan

                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                            <td>

                                                <a href="<?= base_url('edit_user?id=' . $u->id_user) ?>"
                                                    class="btn btn-warning btn-sm">

                                                    <i class="fa fa-edit"></i>

                                                    Edit

                                                </a>

                                                <a href="<?= base_url('Insert/delete_user?id=' . $u->id_user) ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus user ini ?')">

                                                    <i class="fa fa-trash"></i>

                                                    Hapus

                                                </a>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>

                                        <td colspan="5">

                                            Data user belum tersedia

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <footer class="sticky-footer bg-white">

        <div class="container my-auto">

            <div class="copyright text-center my-auto">

                <span>
                    © <?php echo date("Y"); ?> PT Candra Karya Group.
                </span>

            </div>

        </div>

    </footer>

</div>