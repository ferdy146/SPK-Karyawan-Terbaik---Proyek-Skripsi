<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
<style>
    #tabel {
        font-size: 13px;
    }

    #tabel th,
    #tabel td {
        padding: 6px 8px;
        vertical-align: middle;
    }

    #tabel td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Hover effect */
    .table tbody tr:hover {
        background-color: #f5f7fa;
    }

    /* Header lebih clean */
    .table th {
        background-color: #f8f9fc;

    }
</style>
<!-- untuk daftar menu dst, cek header.php-->

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

            <!-- TITLE -->
            <h2 class="font-weight-bold text-dark mb-4">
                Data Nilai Karyawan
            </h2>

            <!-- button Tambah -->
            <div class="form-group row">
                <a href="tambah_data_nilai" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
            </div>

            <div class="row">
                <div class="col">
                    <table id="tabel" class="table table-bordered table-striped nowrap" style="width:100%">
                        <thead class="text-center" style="color: black;">
                            <tr>
                                <th style="width:5%">Nama</th>
                                <th style="width:5%">C1</th>
                                <th style="width:5%">C2</th>
                                <th style="width:5%">C3</th>
                                <th style="width:5%">C4</th>
                                <th style="width:5%">C5</th>
                                <th style="width:5%">C6</th>
                                <th style="width:5%">C7</th>
                                <th style="width:5%">C8</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody" name="tbody" style="color: black;">

                        </tbody>
                    </table>
                </div>
            </div>
            <br>
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

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.js"></script>

<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="vendor/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="vendor/datatables/dataTables.select.min.js"></script>

<!-- CKEditor -->
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/translations/id.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- xlsx -->
<script type="text/javascript" src="vendor/xlsx/xlsx.fix.js"></script>

<script>
    // gunakan Javascript dan jQuery
    // bisa cek untuk contoh membuat form: https://getbootstrap.com/docs/4.0/components/forms/

    $(document).ready(function () {

        $('#tabel').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?= base_url('Select/data_nilai') ?>",
                "type": "POST",
                "dataSrc": ""
            },
            "columns": [
                { "data": "nama_karyawan", className: "text-center" },
                { "data": "C1", className: "text-center" },
                { "data": "C2", className: "text-center" },
                { "data": "C3", className: "text-center" },
                { "data": "C4", className: "text-center" },
                { "data": "C5", className: "text-center" },
                { "data": "C6", className: "text-center" },
                { "data": "C7", className: "text-center" },
                { "data": "C8", className: "text-center" },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row) {
                        return `
                        <a href="<?= base_url("edit_data_nilai?id=") ?>${row.id_karyawan}" 
                        class="btn btn-warning btn-sm mr-1 px-2 py-1">
                        <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    `;
                    }
                }
            ],
            "bSort": false,
            "pageLength": 10
        });

    });

    // menggunakan AJAX untuk membuat tabel dari data tabel
    // AJAX (View) -> Controller -> Model -> dapat hasil
    function getDataNilai() {
        var html = '';

        $.ajax({
            url: "<?= base_url('Select/data_nilai') ?>",
            method: "POST",
            dataType: "JSON",
            success: function (data) {

                for (var i = 0; i < data.length; i++) {

                    html += '<tr>';
                    html += '<td class="text-center">' + data[i].nama_karyawan + '</td>';
                    html += '<td class="text-center">' + data[i].C1 + '</td>';
                    html += '<td class="text-center">' + data[i].C2 + '</td>';
                    html += '<td class="text-center">' + data[i].C3 + '</td>';
                    html += '<td class="text-center">' + data[i].C4 + '</td>';
                    html += '<td class="text-center">' + data[i].C5 + '</td>';
                    html += '<td class="text-center">' + data[i].C6 + '</td>';
                    html += '<td class="text-center">' + data[i].C7 + '</td>';
                    html += '<td class="text-center">' + data[i].C8 + '</td>';

                    // AKSI
                    html += '<td class="text-center">';

                    html += '<a href="<?= base_url("edit_data_nilai?id=") ?>' + data[i].id_karyawan + '" class="btn btn-warning btn-sm mr-1 px-2 py-1">';
                    html += '<i class="fas fa-edit mr-1"></i> Edit';
                    html += '</a>';

                    html += '</td>';
                    html += '</tr>';
                }

                $("#tbody").html(html);
            }
        });
    }


    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');

        if (confirm("Yakin ingin menghapus data ini?")) {
            $.ajax({
                url: "<?= base_url('Insert/delete_karyawan') ?>",
                method: "POST",
                data: { id_karyawan: id },
                success: function () {
                    alert("Data berhasil dihapus");
                    location.reload();
                }
            });
        }
    });
</script>

</body>

</html>