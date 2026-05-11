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

                <!-- HEADER -->
                <tr class="bg-primary text-white">
                    <th>Kriteria</th>

                    <?php foreach ($matrix as $key => $row): ?>
                        <th>C<?= $key ?></th>
                    <?php endforeach; ?>

                </tr>

                <!-- ISI MATRIX -->
                <?php foreach ($matrix as $i => $row): ?>

                    <tr>

                        <th class="bg-light">
                            C<?= $i ?>
                        </th>

                        <?php foreach ($row as $val): ?>
                            <td>
                                <?= number_format($val, 3) ?>
                            </td>
                        <?php endforeach; ?>

                    </tr>

                <?php endforeach; ?>

                <!-- JUMLAH KOLOM -->
                <tr class="bg-warning font-weight-bold">

                    <th>Jumlah</th>

                    <?php
                    $jumlahKolom = [];

                    foreach ($matrix as $i => $row) {
                        foreach ($row as $j => $val) {

                            if (!isset($jumlahKolom[$j])) {
                                $jumlahKolom[$j] = 0;
                            }

                            $jumlahKolom[$j] += $val;
                        }
                    }

                    foreach ($jumlahKolom as $total):
                        ?>

                        <td>
                            <?= number_format($total, 2) ?>
                        </td>

                    <?php endforeach; ?>

                </tr>

            </table>

            <h4 class="mt-4 mb-3">Normalisasi Matriks</h4>

            <table class="table table-bordered text-center">

                <!-- HEADER -->
                <tr class="bg-success text-white">

                    <th>Kriteria</th>

                    <?php foreach ($normal as $key => $row): ?>
                        <th>C<?= $key ?></th>
                    <?php endforeach; ?>

                    <th>Jumlah</th>
                    <th>Eigen Vector</th>

                </tr>

                <!-- ISI -->
                <?php foreach ($normal as $i => $row): ?>

                    <tr>

                        <th class="bg-light">
                            C<?= $i ?>
                        </th>

                        <?php
                        $jumlahBaris = 0;
                        ?>

                        <?php foreach ($row as $val): ?>

                            <?php
                            $jumlahBaris += $val;
                            ?>

                            <td>
                                <?= number_format($val, 3) ?>
                            </td>

                        <?php endforeach; ?>

                        <!-- JUMLAH -->
                        <td class="font-weight-bold bg-warning">
                            <?= number_format($jumlahBaris, 2) ?>
                        </td>

                        <!-- EIGEN -->
                        <td class="font-weight-bold bg-info text-white">
                            <?= number_format($eigen[$i], 9) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>


            <h4 class="mt-4 mb-3">Perhitungan λ Max</h4>

            <table class="table table-bordered text-center">

                <tr class="bg-dark text-white">

                    <th>Kriteria</th>
                    <th>Jumlah Kolom</th>
                    <th>Eigen Vector</th>
                    <th>Jumlah Kolom × Eigen Vector</th>

                </tr>

                <?php foreach ($lambda_detail as $i => $d): ?>

                    <tr>

                        <td>
                            C<?= $i ?>
                        </td>

                        <td>
                            <?= number_format($d['jumlah_kolom'], 3) ?>
                        </td>

                        <td>
                            <?= number_format($d['eigen'], 3) ?>
                        </td>

                        <td class="font-weight-bold">

                            <?= number_format($d['hasil'], 3) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <tr class="bg-warning font-weight-bold">

                    <td colspan="3">

                        Eigen Max (λmax)

                    </td>

                    <td>

                        <?= number_format($lambda_max, 9) ?>

                    </td>

                </tr>

            </table>

            <!-- Uji Konsisten -->

            <h4 class="mt-4">Uji Konsistensi</h4>

            <table class="table table-bordered">

                <tr>
                    <th width="40%">Rumus</th>
                    <th>Hasil</th>
                </tr>

                <tr>
                    <td>
                        λ Max
                    </td>
                    <td>
                        <?= number_format($lambda_max, 9) ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        CI = (λmax - n) / (n-1)
                    </td>
                    <td>
                        CI = (<?= number_format($lambda_max, 9) ?> - <?= count($matrix) ?>) /
                        (<?= count($matrix) ?> -
                        <?= 1 ?>)
                        <br>

                        <b>
                            <?= number_format($ci, 9) ?>
                        </b>
                    </td>
                </tr>

                <tr>
                    <td>
                        CR = CI / RI
                    </td>
                    <td>

                        CR = <?= number_format($ci, 9) ?> / <?= $ri ?>

                        <br>

                        <b>
                            <?= number_format($cr, 9) ?>
                        </b>

                    </td>
                </tr>

                <tr>

                    <td>Status Konsistensi</td>

                    <td>

                        <?php if ($konsisten): ?>

                            <span class="badge badge-success p-2">
                                Konsisten (CR < 0.1) </span>

                                <?php else: ?>

                                    <span class="badge badge-danger p-2">
                                        Tidak Konsisten (CR > 0.1)
                                    </span>

                                <?php endif; ?>

                    </td>

                </tr>

            </table>

            <?php if ($konsisten): ?>

                <a href="<?= base_url('pm_ahp') ?>" class="btn btn-primary mt-3">
                    Lanjut ke Profile Matching
                </a>

            <?php else: ?>

                <button class="btn btn-danger mt-3" disabled>
                    CR Tidak Konsisten
                </button>

            <?php endif; ?>

        </div>
    </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>©
                    <?php echo date("Y"); ?> PT Candra Karya Group.
                </span>
            </div>
        </div>
    </footer>

</div>