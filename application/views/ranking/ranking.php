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

            <h3 class="mb-4">Ranking Karyawan Terbaik</h3>

            <table class="table table-bordered text-center">
                <tr>
                    <th>Ranking</th>
                    <th>Nama Karyawan</th>
                    <th>Nilai Akhir</th>
                </tr>

                <?php $no = 1;
                foreach ($ranking as $r): ?>
                    <tr>
                        <td>
                            <?= $no++ ?>
                        </td>
                        <td>
                            <?= $r->nama_karyawan ?>
                        </td>
                        <td>
                            <?= number_format($r->nilai_akhir, 4) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>

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