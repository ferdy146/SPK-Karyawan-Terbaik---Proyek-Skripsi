<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Seleksi</title>
    <link rel="icon" href="img/logo.png">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="css/modal-login.css">

</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-users"></i>
                    <!-- cari ikon di: https://fontawesome.com/v5/search?q=laptop-medical&o=r -->
                </div>
                <div class="sidebar-brand-text mx-3">Seleksi Karyawan Terbaik</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                    aria-expanded="true" aria-controls="collapseUser" id="menuUser">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Login sebagai
                        <?= ucfirst($_SESSION['role']); ?>
                    </span>
                </a>
                <div id="collapseUser" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu:</h6>
                        <a class="collapse-item" href="<?= base_url('Controller/logout') ?>">Logout</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Fitur Menu Role Admin -->
            <?php if ($_SESSION['role'] == 'admin') { ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('data_karyawan') ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Data Karyawan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('data_nilai') ?>">
                        <i class="fas fa-fw fa-clipboard"></i>
                        <span>Data Nilai</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('proses_ahp') ?>">
                        <i class="fas fa-fw fa-tasks"></i>
                        <span>Proses AHP</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('pm_ahp') ?>">
                        <i class="fas fa-fw fa-microchip"></i>
                        <span>Profile Matching dan Pembobotan AHP</span>
                    </a>
                </li>

            <?php } ?>


            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('ranking') ?>">
                    <i class="fas fa-fw fa-trophy"></i>
                    <span>Peringkat</span>
                </a>
            </li>

            <!-- Fitur Menu Role Admin -->
            <?php if ($_SESSION['role'] == 'admin') { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('kelola_user') ?>">
                        <i class="fas fa-fw fa-user-cog"></i>
                        <span>Kelola User</span>
                    </a>
                </li>
            <?php } ?>

            <hr class="sidebar-divider my-0">

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo" id="menuMenu">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>SPK Seleksi Karyawan Terbaik</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu:</h6>
                        <a class="collapse-item" href="menu" style="white-space: normal;">Menu</a>
                    </div>
                </div>
            </li> -->
        </ul>