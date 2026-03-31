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

            <h2 class="font-weight-bold text-dark mb-4">
                Edit Nilai Karyawan
            </h2>

            <div class="card shadow col-md-12">
                <div class="card-body">

                    <form action="<?= base_url('Insert/update_nilai') ?>" method="POST">

                        <!-- hidden id -->
                        <input type="hidden" name="id_karyawan" value="<?= $id_karyawan ?>">

                        <div class="row">

                            <!-- Nama (CENTER) -->
                            <div class="col-md-12 text-center mb-4">
                                <label><b>Nama</b></label>
                                <input type="text" class="form-control text-center" value="<?= $nama_karyawan ?>"
                                    readonly style="max-width:400px; margin:auto;">
                            </div>

                            <!-- hidden id -->
                            <input type="hidden" name="id_karyawan" value="<?= $id_karyawan ?>">

                            <?php
                            // bagi kriteria jadi 2 kolom
                            $total = count($kriteria);
                            $half = ceil($total / 2);

                            $kiri = array_slice($kriteria, 0, $half);
                            $kanan = array_slice($kriteria, $half);
                            ?>

                            <!-- KOLOM KIRI -->
                            <div class="col-md-6">
                                <?php foreach ($kiri as $k) {
                                    $id_k = $k['id_kriteria'];
                                    ?>
                                    <div class="form-group">
                                        <label>
                                            <b><?= $k['nama_kriteria'] ?></b> (<b><?= $k['kode'] ?></b>)
                                        </label>

                                        <input type="number" step="0.01" name="nilai[<?= $id_k ?>]"
                                            class="form-control nilai"
                                            value="<?= isset($nilai[$id_k]) ? $nilai[$id_k] : '' ?>" required>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- KOLOM KANAN -->
                            <div class="col-md-6">
                                <?php foreach ($kanan as $k) {
                                    $id_k = $k['id_kriteria'];
                                    ?>
                                    <div class="form-group">
                                        <label>
                                            <b><?= $k['nama_kriteria'] ?></b> (<b><?= $k['kode'] ?></b>)
                                        </label>

                                        <input type="number" step="0.01" name="nilai[<?= $id_k ?>]"
                                            class="form-control nilai"
                                            value="<?= isset($nilai[$id_k]) ? $nilai[$id_k] : '' ?>" required>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- BUTTON -->
                            <div class="col-md-12 mt-3 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update
                                </button>

                                <a href="<?= base_url('data_nilai') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
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

<script>
    $(document).on('input', '.nilai', function () {
        this.value = this.value
            .replace(/[^0-9.,]/g, '')
            .replace(',', '.');
    });
</script>