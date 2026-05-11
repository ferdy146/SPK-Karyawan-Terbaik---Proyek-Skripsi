<div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <button class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="navbar-nav ml-auto">
                <img src="<?= base_url('img/pt.png') ?>" style="height:90px;">
            </ul>

        </nav>

        <div class="container-fluid">

            <h3 class="mb-4">
                Proses Profile Matching + Pembobotan AHP
            </h3>

            <!-- ================================= -->
            <!-- PROFILE IDEAL -->
            <!-- ================================= -->

            <h4>1. Profile Ideal Karyawan</h4>

            <table class="table table-bordered text-center">

                <tr class="bg-primary text-white">

                    <th>Kriteria</th>
                    <th>Profile Ideal</th>

                </tr>

                <?php foreach ($profile_ideal as $p): ?>

                    <tr>

                        <td>
                            <?= $p['kode'] ?>
                        </td>

                        <td>
                            <?= $p['target'] ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

            <!-- ================================= -->
            <!-- KONVERSI NILAI -->
            <!-- ================================= -->

            <h4 class="mt-5">
                2. Konversi Bobot Nilai Karyawan
            </h4>

            <table class="table table-bordered text-center">

                <tr class="bg-success text-white">

                    <th>Nama Karyawan</th>

                    <?php foreach ($kriteria as $k): ?>

                        <th>
                            <?= $k->kode ?>
                        </th>

                    <?php endforeach; ?>

                </tr>

                <?php foreach ($karyawan as $kar): ?>

                    <tr>

                        <td>
                            <?= $kar->nama_karyawan ?>
                        </td>

                        <?php foreach ($kriteria as $k): ?>

                            <td>

                                <?= $konversi_nilai[$kar->id_karyawan][$k->id_kriteria] ?>

                            </td>

                        <?php endforeach; ?>

                    </tr>

                <?php endforeach; ?>

            </table>

            <!-- ================================= -->
            <!-- GAP -->
            <!-- ================================= -->

            <h4 class="mt-5">
                3. Perhitungan GAP
            </h4>

            <table class="table table-bordered text-center">

                <tr class="bg-warning">

                    <th>Nama Karyawan</th>

                    <?php foreach ($kriteria as $k): ?>

                        <th>
                            <?= $k->kode ?>
                        </th>

                    <?php endforeach; ?>

                </tr>

                <?php foreach ($karyawan as $kar): ?>

                    <tr>

                        <td>
                            <?= $kar->nama_karyawan ?>
                        </td>

                        <?php foreach ($kriteria as $k): ?>

                            <td>

                                <?= $gap[$kar->id_karyawan][$k->id_kriteria] ?>

                            </td>

                        <?php endforeach; ?>

                    </tr>

                <?php endforeach; ?>

            </table>

            <!-- ================================= -->
            <!-- BOBOT GAP -->
            <!-- ================================= -->

            <h4 class="mt-5">
                4. Konversi Bobot GAP
            </h4>

            <table class="table table-bordered text-center">

                <tr class="bg-info text-white">

                    <th>Nama Karyawan</th>

                    <?php foreach ($kriteria as $k): ?>

                        <th>
                            <?= $k->kode ?>
                        </th>

                    <?php endforeach; ?>

                </tr>

                <?php foreach ($karyawan as $kar): ?>

                    <tr>

                        <td>
                            <?= $kar->nama_karyawan ?>
                        </td>

                        <?php foreach ($kriteria as $k): ?>

                            <td>

                                <?= $bobot_gap[$kar->id_karyawan][$k->id_kriteria] ?>

                            </td>

                        <?php endforeach; ?>

                    </tr>

                <?php endforeach; ?>

            </table>

            <!-- ================================= -->
            <!-- NILAI AKHIR -->
            <!-- ================================= -->

            <h4 class="mt-5">
                5. Perhitungan Nilai Akhir Menggunakan Bobot AHP
            </h4>

            <table class="table table-bordered text-center">

                <tr class="bg-dark text-white">

                    <th>Nama Karyawan</th>

                    <?php foreach ($kriteria as $k): ?>

                        <th>
                            <?= $k->kode ?>
                            <br>
                            (<?= number_format($bobot_ahp[$k->id_kriteria], 3) ?>)
                        </th>

                    <?php endforeach; ?>

                    <th>Total</th>

                </tr>

                <?php foreach ($karyawan as $kar): ?>

                    <tr>

                        <td>
                            <?= $kar->nama_karyawan ?>
                        </td>

                        <?php
                        $total = 0;
                        ?>

                        <?php foreach ($kriteria as $k): ?>

                            <?php
                            $nilai = $hasil_detail[$kar->id_karyawan][$k->id_kriteria];

                            $total += $nilai;
                            ?>

                            <td>

                                <?= number_format($nilai, 3) ?>

                            </td>

                        <?php endforeach; ?>

                        <td class="font-weight-bold bg-warning">

                            <?= number_format($total, 9) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

            <!-- ================================= -->
            <!-- HASIL AKHIR -->
            <!-- ================================= -->

            <h4 class="mt-5">
                6. Nilai Akhir Karyawan
            </h4>

            <table class="table table-bordered text-center">

                <tr class="bg-primary text-white">

                    <th>Nama Karyawan</th>
                    <th>Nilai Akhir</th>

                </tr>

                <?php foreach ($karyawan as $kar): ?>

                    <tr>

                        <td>
                            <?= $kar->nama_karyawan ?>
                        </td>

                        <td class="font-weight-bold">

                            <?= number_format($hasil_akhir[$kar->id_karyawan], 9) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

            <a href="<?= base_url('ranking') ?>" class="btn btn-success mt-3">

                <i class="fa fa-trophy"></i>

                Lihat Ranking

            </a>

        </div>

    </div>

    <!-- FOOTER -->
    <footer class="sticky-footer bg-white">

        <div class="container my-auto">

            <div class="copyright text-center my-auto">

                <span>
                    © <?= date("Y"); ?> PT Candra Karya Group.
                </span>

            </div>

        </div>

    </footer>

</div>