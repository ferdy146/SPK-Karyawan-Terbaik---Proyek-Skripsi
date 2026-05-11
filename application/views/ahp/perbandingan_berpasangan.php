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

            <h4 class="mb-3">
                Input Perbandingan Berpasangan (AHP)
            </h4>

            <div class="alert alert-info">

                <b>Petunjuk Skala AHP :</b>
                <br><br>

                <b>1</b> = Sama penting<br>
                <b>3</b> = Sedikit lebih penting<br>
                <b>5</b> = Lebih penting<br>
                <b>7</b> = Sangat penting<br>
                <b>9</b> = Mutlak lebih penting<br><br>

                Nilai pecahan:
                <br>

                <b>1/2</b> = Kebalikan dari 2<br>
                <b>1/3</b> = Kebalikan dari 3<br>
                dst.

            </div>

            <form method="post" action="<?= base_url('Insert/simpan_perbandingan') ?>">

                <div class="table-responsive">

                    <table class="table table-bordered text-center align-middle">

                        <!-- HEADER -->
                        <tr class="bg-primary text-white">

                            <th width="200">
                                Kriteria
                            </th>

                            <?php foreach ($kriteria as $k): ?>

                                <th>
                                    <?= $k->kode ?>
                                </th>

                            <?php endforeach; ?>

                        </tr>

                        <!-- ISI -->
                        <?php foreach ($kriteria as $i): ?>

                            <tr>

                                <!-- NAMA BARIS -->
                                <th class="bg-light">

                                    <?= $i->kode ?>

                                </th>

                                <?php foreach ($kriteria as $j): ?>

                                    <td>

                                        <!-- DIAGONAL -->
                                        <?php if ($i->id_kriteria == $j->id_kriteria): ?>

                                            <input type="text" class="form-control text-center font-weight-bold bg-light" value="1"
                                                readonly>

                                        <?php else: ?>

                                            <?php
                                            $value = isset($matrix[$i->id_kriteria][$j->id_kriteria])
                                                ? $matrix[$i->id_kriteria][$j->id_kriteria]
                                                : '';
                                            ?>

                                            <select name="nilai[<?= $i->id_kriteria ?>][<?= $j->id_kriteria ?>]"
                                                class="form-control perbandingan text-center" data-i="<?= $i->id_kriteria ?>"
                                                data-j="<?= $j->id_kriteria ?>">

                                                <option value="">
                                                    -- pilih --
                                                </option>

                                                <!-- SKALA 1 - 9 -->
                                                <?php for ($x = 1; $x <= 9; $x++): ?>

                                                    <option value="<?= number_format($x, 10, '.', '') ?>"
                                                        <?= (number_format((float) $value, 10, '.', '') == number_format($x, 10, '.', '')) ? 'selected' : '' ?>>

                                                        <?= $x ?>

                                                    </option>

                                                <?php endfor; ?>

                                                <!-- PECAHAN -->
                                                <?php
                                                $pecahan = [
                                                    "1/2" => 1 / 2,
                                                    "1/3" => 1 / 3,
                                                    "1/4" => 1 / 4,
                                                    "1/5" => 1 / 5,
                                                    "1/6" => 1 / 6,
                                                    "1/7" => 1 / 7,
                                                    "1/8" => 1 / 8,
                                                    "1/9" => 1 / 9
                                                ];
                                                ?>

                                                <?php foreach ($pecahan as $label => $val): ?>

                                                    <option value="<?= number_format($val, 10, '.', '') ?>"
                                                        <?= (number_format((float) $value, 10, '.', '') == number_format($val, 10, '.', '')) ? 'selected' : '' ?>>

                                                        <?= $label ?>

                                                    </option>

                                                <?php endforeach; ?>

                                            </select>

                                        <?php endif; ?>

                                    </td>

                                <?php endforeach; ?>

                            </tr>

                        <?php endforeach; ?>

                    </table>

                </div>

                <button type="submit" class="btn btn-primary mt-3">

                    <i class="fa fa-save"></i>

                    Simpan & Proses AHP

                </button>

            </form>

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

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SCRIPT AUTO RECIPROCAL -->
<script>

    $(document).ready(function () {

        $('.perbandingan').change(function () {

            let i = $(this).data('i');
            let j = $(this).data('j');

            let val = parseFloat($(this).val());

            // validasi
            if (!val || val <= 0) {
                return;
            }

            // reciprocal
            let inverse = 1 / val;

            // samakan decimal dengan option
            inverse = inverse.toFixed(10);

            // target select lawan
            let target = $('select[data-i="' + j + '"][data-j="' + i + '"]');

            // set value otomatis
            target.val(inverse);

        });

    });
</script>