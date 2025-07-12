<?php

    // ini untuk panggil file base nya
    @require_once dirname(__DIR__) . '/app/helpers/__Helpers.php';
    @require_once dirname(__DIR__) . '/app/helpers/__Query.php';
    @require_once dirname(__DIR__) . '/app/core/__Router.php';
    
    // panggil class router
    $router = new Router();

    // panggil nama method dan controller pada class
    $router->get('/', ['HomeController', 'IndexHome']);
    $router->post('/beli', ['HomeController', 'IndexHome_Beli']);
    
    $router->get('/login', ['AuthController', 'IndexLogin']);
    $router->post('/login/proses', ['AuthController', 'IndexLogin_Proses']);

    $router->post('/logout', ['AuthController', 'IndexLogout']);


    $router->get('/homeadmin', ['HomeadminController', 'IndexHomeadmin']);

    $router->get('/homeadmin/akun', ['HomeadminAkunController', 'IndexHomeadmin_Akun']);
    $router->post('/homeadmin/akun/simpan', ['HomeadminAkunController', 'IndexHomeadmin_Akun_Simpan']);
    $router->get('/homeadmin/akun/hapus/{id}', ['HomeadminAkunController', 'IndexHomeadmin_Akun_Hapus']);
    $router->get('/homeadmin/akun/ubah/{id}', ['HomeadminAkunController', 'IndexHomeadmin_Akun_Ubah']);
    $router->post('/homeadmin/akun/ubah/simpan', ['HomeadminAkunController', 'IndexHomeadmin_Akun_UbahSimpan']);
    $router->get('/homeadmin/akun/status/{id}/{status}', ['HomeadminAkunController', 'IndexHomeadmin_Akun_Status']);

    $router->get('/homeadmin/kategori', ['HomeadminKategoriController', 'IndexHomeadmin_Kategori']);
    $router->post('/homeadmin/kategori/simpan', ['HomeadminKategoriController', 'IndexHomeadmin_Kategori_Simpan']);
    $router->get('/homeadmin/kategori/hapus/{id}', ['HomeadminKategoriController', 'IndexHomeadmin_Kategori_Hapus']);
    $router->get('/homeadmin/kategori/ubah/{id}', ['HomeadminKategoriController', 'IndexHomeadmin_Kategori_Ubah']);
    $router->post('/homeadmin/kategori/ubah/simpan', ['HomeadminKategoriController', 'IndexHomeadmin_Kategori_UbahSimpan']);

    $router->get('/homeadmin/stok', ['HomeadminStokController', 'IndexHomeadmin_Stok']);
    $router->post('/homeadmin/stok/simpan', ['HomeadminStokController', 'IndexHomeadmin_Stok_Simpan']);
    $router->get('/homeadmin/stok/hapus/{id}', ['HomeadminStokController', 'IndexHomeadmin_Stok_Hapus']);
    $router->get('/homeadmin/stok/ubah/{id}', ['HomeadminStokController', 'IndexHomeadmin_Stok_Ubah']);
    $router->post('/homeadmin/stok/ubah/simpan', ['HomeadminStokController', 'IndexHomeadmin_Stok_UbahSimpan']);

    $router->get('/homeadmin/penjualan', ['HomeadminPenjualanController', 'IndexHomeadmin_Penjualan']);

    $router->get('/homeadmin/keuangan', ['HomeadminKeuanganController', 'IndexHomeadmin_Keuangan']);
    $router->post('/homeadmin/keuangan', ['HomeadminKeuanganController', 'IndexHomeadmin_Keuangan']);

    $router->get('/homeadmin/konsumen', ['HomeadminKonsumenController', 'IndexHomeadmin_Konsumen']);

    $router->get('/homeadmin/moora', ['HomeadminMooraController', 'IndexHomeadmin_Moora']);
    
    $router->get('/homeadmin/cf', ['HomeadminCfController', 'IndexHomeadmin_Cf']);

    $router->get('/homeadmin/diskon', ['HomeadminDiskonController', 'IndexHomeadmin_Diskon']);
    $router->post('/homeadmin/diskon/simpan', ['HomeadminDiskonController', 'IndexHomeadmin_Diskon_Simpan']);
    $router->get('/homeadmin/diskon/{id}', ['HomeadminDiskonController', 'IndexHomeadmin_Diskon_Ubah']);
    $router->post('/homeadmin/diskon/ubahsimpan', ['HomeadminDiskonController', 'IndexHomeadmin_Diskon_Ubah_Simpan']);
    $router->get('/homeadmin/diskon/hapus/{id}', ['HomeadminDiskonController', 'IndexHomeadmin_Diskon_Hapus']);

    $router->get('/homeadmin/kas', ['HomeadminKasController', 'IndexHomeadmin_Kas']);
    $router->post('/homeadmin/kas/simpan', ['HomeadminKasController', 'IndexHomeadmin_Kas_Simpan']);
    $router->get('/homeadmin/kas/{id}', ['HomeadminKasController', 'IndexHomeadmin_Kas_Ubah']);
    $router->post('/homeadmin/kas/ubahsimpan', ['HomeadminKasController', 'IndexHomeadmin_Kas_Ubah_Simpan']);
    $router->get('/homeadmin/kas/hapus/{id}', ['HomeadminKasController', 'IndexHomeadmin_Kas_Hapus']);
    
    $router->dispatch(); 