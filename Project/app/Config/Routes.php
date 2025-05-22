<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Login routes (bebas akses)
$routes->get('/login', 'LoginController::showLoginForm');
$routes->post('/login', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');

// Group routes dengan filter auth dan role, sesuaikan nama filter dengan kebutuhan
$routes->group('', ['filter' => 'auth'], function($routes) {

    // Halaman utama dan home khusus role (contoh filter role)
    $routes->get('/', 'LoginController::redirectBySession');
    $routes->get('/homeAdmin', 'Home::index');
    $routes->get('/homePetugas', 'Home::petugas');
    $routes->get('/homeMahasiswa', 'Home::Mahasiswa');

    // SPP
    $routes->get('/spp', 'SppController::index');
    $routes->get('/spp/home', 'SppController::index');
    $routes->get('/spp/create', 'SppController::create');
    $routes->post('/spp/store', 'SppController::store');
    $routes->get('/spp/edit/(:num)', 'SppController::edit/$1');
    $routes->post('/spp/update/(:num)', 'SppController::update/$1');
    $routes->get('/spp/delete/(:num)', 'SppController::delete/$1');
    $routes->post('/spp/delete/(:num)', 'SppController::delete/$1');

    // Jurusan
    $routes->get('/jurusan', 'JurusanController::index');
    $routes->get('/jurusan/home', 'JurusanController::index');
    $routes->get('/jurusan/create', 'JurusanController::create');
    $routes->post('/jurusan/store', 'JurusanController::store');
    $routes->get('/jurusan/edit/(:num)', 'JurusanController::edit/$1');
    $routes->post('/jurusan/update/(:num)', 'JurusanController::update/$1');
    $routes->get('/jurusan/delete/(:num)', 'JurusanController::delete/$1');
    $routes->post('/jurusan/delete/(:num)', 'JurusanController::delete/$1');

    // Profil
    $routes->get('/profil', 'ProfilController::index');
    $routes->post('/profil/update/(:num)', 'ProfilController::update/$1');

    // Petugas
    $routes->get('/petugas', 'PetugasController::index');
    $routes->get('/petugas/home', 'PetugasController::index');
    $routes->get('/petugas/create', 'PetugasController::create');
    $routes->post('/petugas/store', 'PetugasController::store');
    $routes->get('/petugas/edit/(:num)', 'PetugasController::edit/$1');
    $routes->post('/petugas/update/(:num)', 'PetugasController::update/$1');
    $routes->get('/petugas/delete/(:num)', 'PetugasController::delete/$1');
    $routes->post('/petugas/delete/(:num)', 'PetugasController::delete/$1');
    $routes->get('/petugas/detail/(:segment)', 'PetugasController::detail/$1');
    $routes->get('/petugas/reset/(:num)', 'PetugasController::reset/$1');

    // Mahasiswa
    $routes->get('/mahasiswa', 'MahasiswaController::index');
    $routes->get('/mahasiswa/home', 'MahasiswaController::index');
    $routes->get('/mahasiswa/create', 'MahasiswaController::create');
    $routes->post('/mahasiswa/store', 'MahasiswaController::store');
    $routes->get('/mahasiswa/edit/(:num)', 'MahasiswaController::edit/$1');
    $routes->post('/mahasiswa/update/(:num)', 'MahasiswaController::update/$1');
    $routes->get('/mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1');
    $routes->post('/mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1');
    $routes->get('/mahasiswa/detail/(:segment)', 'MahasiswaController::detail/$1');
    $routes->post('/mahasiswa/reset/(:num)', 'MahasiswaController::reset/$1');
    $routes->get('/mahasiswa/(:num)/buat-pembayaran', 'MahasiswaController::buatPembayaran/$1');
    $routes->get('/mahasiswa/(:num)/detail', 'MahasiswaController::detail/$1');
    $routes->get('/mahasiswa/fromAdd/(:num)', 'MahasiswaController::fromAdd/$1');
    $routes->post('mahasiswa/saveSPP', 'MahasiswaController::saveSPP');

    // Pembayaran
    $routes->get('/pembayaran', 'Pembayaran::index');
    $routes->get('/pembayaran/show', 'Pembayaran::show');
    $routes->get('/pembayaran/input', 'Pembayaran::input');
    $routes->post('/pembayaran/input/bayar', 'Pembayaran::bayar');
    $routes->get('/pembayaran/formBayar/(:num)', 'Pembayaran::formBayar/$1');
    $routes->post('pembayaran/validasi/(:num)', 'Pembayaran::validasi/$1');
    $routes->get('/laporan/keuangan', 'LaporanController::index');
});
