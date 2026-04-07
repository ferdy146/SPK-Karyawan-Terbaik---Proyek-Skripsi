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

            <h4 class="mb-3">Input Perbandingan Berpasangan (AHP)</h4>

            <p>
                <b>Petunjuk:</b><br>
                1 = Sama penting |
                3 = Sedikit lebih penting |
                5 = Lebih penting |
                7 = Sangat penting |
                9 = Mutlak lebih penting <br>
                Nilai 0.xx = kebalikannya
            </p>

            <form method="post" action="<?= base_url('Insert/simpan_perbandingan') ?>">

                <table class="table table-bordered text-center align-middle">

                    <tr class="bg-primary text-white">
                        <th>Kriteria</th>
                        <?php foreach ($kriteria as $k): ?>
                            <th><?= $k->kode ?></th>
                        <?php endforeach; ?>
                    </tr>

                    <?php foreach ($kriteria as $i): ?>
                        <tr>
                            <th class="bg-light"><?= $i->kode ?></th>

                            <?php foreach ($kriteria as $j): ?>
                                <td>

                                    <?php if ($i->id_kriteria == $j->id_kriteria): ?>

                                        <input type="text" class="form-control text-center" value="1" readonly>

                                    <?php elseif ($i->id_kriteria < $j->id_kriteria): ?>

                                        <?php
                                        $value = isset($matrix[$i->id_kriteria][$j->id_kriteria])
                                            ? $matrix[$i->id_kriteria][$j->id_kriteria]
                                            : 1;

                                        $opsi = [
                                            1,
                                            2,
                                            3,
                                            4,
                                            5,
                                            6,
                                            7,
                                            8,
                                            9,
                                            0.5,
                                            0.333,
                                            0.25,
                                            0.2,
                                            0.167,
                                            0.143,
                                            0.125,
                                            0.111
                                        ];
                                        ?>

                                        <select name="nilai[<?= $i->id_kriteria ?>][<?= $j->id_kriteria ?>]"
                                            class="form-control perbandingan" data-i="<?= $i->id_kriteria ?>"
                                            data-j="<?= $j->id_kriteria ?>">

                                            <?php foreach ($opsi as $o): ?>
                                                <option value="<?= $o ?>" <?= ($value == $o ? 'selected' : '') ?>>
                                                    <?= $o ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>

                                    <?php else: ?>

                                        <?php
                                        $val = isset($matrix[$j->id_kriteria][$i->id_kriteria])
                                            ? number_format($matrix[$j->id_kriteria][$i->id_kriteria], 2)
                                            : '';
                                        ?>

                                        <input type="text" class="form-control text-center"
                                            id="inv_<?= $i->id_kriteria ?>_<?= $j->id_kriteria ?>" value="<?= $val ?>" readonly>

                                    <?php endif; ?>

                                </td>
                            <?php endforeach; ?>

                        </tr>
                    <?php endforeach; ?>

                </table>

                <button type="submit" class="btn btn-primary mt-3">
                    Simpan & Proses AHP
                </button>

            </form>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>© <?= date("Y"); ?> PT Kanisius.</span>
            </div>
        </div>
    </footer>

</div>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {

        $('.perbandingan').change(function () {

            let i = $(this).data('i');
            let j = $(this).data('j');
            let val = parseFloat($(this).val());

            if (!val || val == 0) val = 1;

            let inverse = (1 / val).toFixed(2);

            $('#inv_' + j + '_' + i).val(inverse);
        });
    });
</script>