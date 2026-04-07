<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
                <img src="img/pt.png" style="height:90px;">
            </ul>
        </nav>

        <div class="container-fluid">

            <h4 class="mb-3">Hasil Perhitungan Profile Matching + AHP</h4>

            <table class="table table-bordered text-center">
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Nilai Akhir</th>
                </tr>

                <?php foreach ($hasil as $id => $val): ?>
                    <tr>
                        <td>
                            <?php
                            $k = $this->db->get_where('karyawan', ['id_karyawan' => $id])->row();
                            echo $k->nama_karyawan;
                            ?>
                        </td>
                        <td>
                            <?= number_format($val, 4) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <a href="<?= base_url('ranking') ?>" class="btn btn-success mt-3">
                Lihat Ranking
            </a>

        </div>
    </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>©
                    <?php echo date("Y"); ?> PT Kanisius.
                </span>
            </div>
        </div>
    </footer>

</div>