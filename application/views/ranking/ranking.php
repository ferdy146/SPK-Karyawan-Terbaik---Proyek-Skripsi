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

            <!-- TITLE -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">

                <h3 class="mb-0 text-gray-800">
                    Ranking Karyawan Terbaik
                </h3>

                <a href="<?= base_url('pm_ahp') ?>" class="btn btn-primary shadow-sm">
                    <i class="fa fa-arrow-left"></i>
                    Kembali ke Profile Matching
                </a>

            </div>

            <!-- CARD JUARA -->
            <?php if (!empty($ranking)): ?>

                <div class="row mb-4">

                    <div class="col-xl-12 col-md-12">

                        <div class="card border-left-success shadow h-100 py-2">

                            <div class="card-body">

                                <div class="row no-gutters align-items-center">

                                    <div class="col mr-2">

                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">

                                            Karyawan Terbaik

                                        </div>

                                        <div class="h4 mb-0 font-weight-bold text-gray-800">

                                            <?= $ranking[0]->nama_karyawan ?>

                                        </div>

                                        <div class="mt-2">

                                            Nilai Akhir :
                                            <b>
                                                <?= number_format($ranking[0]->nilai_akhir, 9) ?>
                                            </b>

                                        </div>

                                    </div>

                                    <div class="col-auto">

                                        <i class="fa fa-trophy fa-3x text-warning"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

            <!-- TABEL RANKING -->
            <div class="card shadow mb-4">

                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">

                        Hasil Ranking Metode AHP + Profile Matching

                    </h6>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered text-center">

                            <thead class="bg-primary text-white">

                                <tr>

                                    <th width="100">
                                        Ranking
                                    </th>

                                    <th>
                                        Nama Karyawan
                                    </th>

                                    <th width="250">
                                        Nilai Akhir
                                    </th>

                                    <th width="180">
                                        Status
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                $no = 1;

                                foreach ($ranking as $r):
                                    ?>

                                    <tr <?= ($no == 1) ? 'style="background:#fff9db;font-weight:bold;"' : '' ?>>

                                        <!-- RANK -->
                                        <td>

                                            <?php if ($no == 1): ?>

                                                <span class="badge badge-success p-2">
                                                    🥇 Ranking 1
                                                </span>

                                            <?php elseif ($no == 2): ?>

                                                <span class="badge badge-info p-2">
                                                    🥈 Ranking 2
                                                </span>

                                            <?php elseif ($no == 3): ?>

                                                <span class="badge badge-warning p-2">
                                                    🥉 Ranking 3
                                                </span>

                                            <?php else: ?>

                                                <span class="badge badge-secondary p-2">
                                                    <?= $no ?>
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                        <!-- NAMA -->
                                        <td>

                                            <?= $r->nama_karyawan ?>

                                        </td>

                                        <!-- NILAI -->
                                        <td class="font-weight-bold">

                                            <?= rtrim(rtrim(number_format($r->nilai_akhir, 9, '.', ''), '0'), '.') ?>

                                        </td>

                                        <!-- STATUS -->
                                        <td>

                                            <?php if ($no == 1): ?>

                                                <span class="badge badge-success p-2">

                                                    Karyawan Terbaik

                                                </span>

                                            <?php else: ?>

                                                <span class="badge badge-primary p-2">

                                                    Kandidat

                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                    <?php
                                    $no++;
                                endforeach;
                                ?>

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
                    © <?= date("Y"); ?> PT Candra Karya Group.
                </span>

            </div>

        </div>

    </footer>

</div>

<script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>