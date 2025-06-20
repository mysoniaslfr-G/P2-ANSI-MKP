<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Login & logout
$routes->get('/login', 'LoginController::showLoginForm');
$routes->post('/login', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');
$routes->get('/', 'Home::index');


// ========== MAHASISWA ==========
$routes->group('Mahasiswa', ['filter' => 'role:Mahasiswa'], function($routes) {
    $routes->get('/', 'Home::Mahasiswa');
});
$routes->group('', ['filter' => 'role:Mahasiswa'], function($routes) {
    $routes->get('pembayaran/input', 'Pembayaran::input');
    $routes->post('pembayaran/simpanBayar', 'Pembayaran::simpanBayar');

    // Sisa pembayaran
    $routes->get('pembayaran/bayar/(:num)', 'Pembayaran::bayar/$1');
    $routes->get('pembayaran/sisa/(:num)', 'Pembayaran::formSisa/$1');
    $routes->post('pembayaran/storeSisa', 'Pembayaran::storeSisa');
    $routes->get('pembayaran/edit/(:num)', 'Pembayaran::formEditSisa/$1');
    $routes->post('pembayaran/update/(:num)', 'Pembayaran::updateSisa/$1');
});

// ========== PETUGAS ==========
$routes->group('Petugas', ['filter' => 'role:Petugas'], function($routes) {
    $routes->get('/', 'Home::petugas');
});


// ========== ADMIN ==========
$routes->group('Admin', ['filter' => 'role:Admin'], function($routes) {
    $routes->get('/', 'Home::admin');

});

// ========== ADMIN ==========
$routes->group('', ['filter' => 'role:Admin'], function($routes) {

    // Master Data
    $routes->get('spp', 'SppController::index');
    $routes->get('spp/create', 'SppController::create');
    $routes->post('spp/store', 'SppController::store');
    $routes->get('spp/edit/(:num)', 'SppController::edit/$1');
    $routes->post('spp/update/(:num)', 'SppController::update/$1');
    $routes->get('spp/delete/(:num)', 'SppController::delete/$1');

    $routes->get('prodi', 'JurusanController::index');
    $routes->get('prodi/create', 'JurusanController::create');
    $routes->post('prodi/store', 'JurusanController::store');
    $routes->get('prodi/edit/(:num)', 'JurusanController::edit/$1');
    $routes->post('prodi/update/(:num)', 'JurusanController::update/$1');
    $routes->get('prodi/delete/(:num)', 'JurusanController::delete/$1');

    $routes->get('mahasiswa', 'MahasiswaController::index');
    $routes->get('mahasiswa/create', 'MahasiswaController::create');
    $routes->post('mahasiswa/store', 'MahasiswaController::store');
    $routes->get('mahasiswa/edit/(:num)', 'MahasiswaController::edit/$1');
    $routes->post('mahasiswa/update/(:num)', 'MahasiswaController::update/$1');
    $routes->get('mahasiswa/delete/(:num)', 'MahasiswaController::delete/$1');
    $routes->get('mahasiswa/detail/(:segment)', 'MahasiswaController::detail/$1');
    $routes->post('mahasiswa/reset/(:num)', 'MahasiswaController::reset/$1');
    $routes->get('mahasiswa/(:num)/buat-pembayaran', 'MahasiswaController::buatPembayaran/$1');
    $routes->post('mahasiswa/saveSPP', 'MahasiswaController::saveSPP');

    $routes->get('petugas', 'PetugasController::index');
    $routes->get('petugas/create', 'PetugasController::create');
    $routes->post('petugas/store', 'PetugasController::store');
    $routes->get('petugas/edit/(:num)', 'PetugasController::edit/$1');
    $routes->post('petugas/update/(:num)', 'PetugasController::update/$1');
    $routes->get('petugas/delete/(:num)', 'PetugasController::delete/$1');
    $routes->get('petugas/detail/(:segment)', 'PetugasController::detail/$1');
    $routes->get('petugas/reset/(:num)', 'PetugasController::reset/$1');
});


$routes->group('', ['filter' => 'role:Admin,Petugas'], function($routes) {
    // Pembayaran
    $routes->get('pembayaran', 'Pembayaran::index');
    $routes->get('pembayaran/show', 'Pembayaran::show');
    $routes->post('pembayaran/updateStatus/(:num)', 'Pembayaran::updateStatus/$1');

    // Laporan
    $routes->get('laporan', 'LaporanController::index');
    $routes->get('laporan/keuangan', 'LaporanController::index');
    $routes->get('laporan/pdf', 'LaporanController::pdf');
    $routes->get('laporan/excel', 'LaporanController::excel');
});


$routes->group('', ['filter' => 'role:Admin,Petugas,Mahasiswa'], function($routes) {
    $routes->get('/profil', 'ProfilController::index');
    $routes->post('/profil/update/(:num)', 'ProfilController::update/$1');
});
  