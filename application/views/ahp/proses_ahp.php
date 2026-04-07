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

            <div class="mb-3">
                <a href="<?= base_url('perbandingan_berpasangan') ?>" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Atur Perbandingan Berpasangan
                </a>
            </div>

            <h4 class="mb-3">Matriks Perbandingan</h4>
            <table class="table table-bordered text-center">
                <?php foreach ($matrix as $i => $row): ?>
                    <tr>
                        <?php foreach ($row as $val): ?>
                            <td>
                                <?= number_format($val, 3) ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h4 class="mt-4 mb-3">Normalisasi Matriks</h4>
            <table class="table table-bordered text-center">
                <?php foreach ($normal as $i => $row): ?>
                    <tr>
                        <?php foreach ($row as $val): ?>
                            <td>
                                <?= number_format($val, 3) ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h4 class="mt-4 mb-3">Eigen Vector</h4>
            <table class="table table-bordered text-center">
                <tr>
                    <th>Kriteria</th>
                    <th>Bobot</th>
                </tr>
                <?php foreach ($eigen as $i => $val): ?>
                    <tr>
                        <td>C
                            <?= $i ?>
                        </td>
                        <td>
                            <?= number_format($val, 4) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h4 class="mt-4">Uji Konsistensi</h4>
            <table class="table table-bordered">
                <tr>
                    <td>Lambda Max</td>
                    <td>
                        <?= $lambda_max ?>
                    </td>
                </tr>
                <tr>
                    <td>CI</td>
                    <td>
                        <?= $ci ?>
                    </td>
                </tr>
                <tr>
                    <td>CR</td>
                    <td>
                        <?= $cr ?>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <?php if ($konsisten): ?>
                            <span class="badge badge-success">Konsisten</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Tidak Konsisten</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <a href="<?= base_url('pm_ahp') ?>" class="btn btn-primary mt-3">
                Lanjut ke Profile Matching
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