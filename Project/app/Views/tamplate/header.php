<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MKP 2025 | <?= getTitle(); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('template/plugins/fontawesome-free/css/all.min.css') ?>">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('template/css/adminlte.min.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=base_url('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <!-- sweetalert2 -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('template/plugins/sweetalert2/sweetalert2.css') ?>">
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
              ><i class="fas fa-bars"></i
            ></a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img
                src="<?= base_url('public/img/' . (session('gambar') ?? 'avatar2.png')) ?>" class="img-circle elevation-2" alt="User  Image"
              />
            </div>
            <div class="info">
              <a href="<?= base_url('/profil')?>" class="d-block"><?= $_SESSION['username']; ?></a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

              <!-- Menu untuk Mahasiswa -->
              <?php if (session()->get('level') === 'Mahasiswa') : ?>
                <li class="nav-item">
                  <a href="<?= base_url('Mahasiswa') ?>" class="nav-link <?= menuActive(['Mahasiswa']) ?>">
                    <i class="nav-icon fas fa-university"></i>
                    <p>Home Mahasiswa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('/pembayaran/input') ?>" class="nav-link <?= menuActive(['pembayaran']) ?>">
                    <i class="nav-icon fas fa-money-check"></i>
                    <p>Input Pembayaran</p>
                  </a>
                </li>
              <?php endif; ?>

              <!-- Menu untuk Petugas -->
              <?php if (session()->get('level') === 'Petugas') : ?>
                <li class="nav-item">
                  <a href="<?= base_url('Petugas') ?>" class="nav-link <?= menuActive(['Petugas']) ?>">
                    <i class="nav-icon fas fa-university"></i>
                    <p>Home Petugas</p>
                  </a>
                </li>
              <?php endif; ?>

              <!-- Menu untuk Admin -->
              <?php if (session()->get('level') === 'Admin') : ?>
                <li class="nav-item">
                  <a href="<?= base_url('Admin') ?>" class="nav-link <?= menuActive(['Admin']) ?>">
                    <i class="nav-icon fas fa-university"></i>
                    <p>Home Admin</p>
                  </a>
                </li>

                <li class="nav-item <?= menuOpen(['spp', 'prodi', 'mahasiswa', 'petugas']) ?>"> <!-- Ganti 'jurusan' menjadi 'prodi' -->
                  <a href="#" class="nav-link <?= menuActive(['spp', 'prodi', 'mahasiswa', 'petugas']) ?>">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                      Data Master
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?= base_url('/spp') ?>" class="nav-link <?= menuActive(['spp']) ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>SPP</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?= base_url('/prodi') ?>" class="nav-link <?= menuActive(['prodi']) ?>"> <!-- Ganti 'jurusan' menjadi 'prodi' -->
                        <i class="far fa-circle nav-icon"></i>
                        <p>Prodi</p> <!-- Ganti 'Jurusan' menjadi 'Prodi' -->
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?= base_url('/mahasiswa') ?>" class="nav-link <?= menuActive(['mahasiswa']) ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Mahasiswa</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?= base_url('/petugas') ?>" class="nav-link <?= menuActive(['petugas']) ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Petugas</p>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php endif; ?>

              <!-- Menu Pembayaran untuk Admin & Petugas -->
              <?php if (in_array(session()->get('level'), ['Admin', 'Petugas'])) : ?>
                <li class="nav-item">
                  <a href="<?= base_url('/pembayaran') ?>" class="nav-link <?= menuActive(['pembayaran']) ?>">
                    <i class="nav-icon fas fa-money-bill-wave"></i>
                    <p>Pembayaran</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('/laporan/keuangan') ?>" class="nav-link <?= menuActive(['laporan']) ?>">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Laporan</p>
                  </a>
                </li>
              <?php endif; ?>

              <!-- Menu Logout -->
              <li class="nav-item">
                <a href="<?= base_url('/logout') ?>" class="nav-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>Log Out</p>
                </a>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"><?= getTitle(); ?></h1>
              </div>
              <!-- /.col -->
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
