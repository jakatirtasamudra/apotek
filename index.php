<?php

    // ini untuk setting default lokasi waktu
    date_default_timezone_set('Asia/Jakarta');
    // ini untuk log error
    error_reporting(E_ALL);
    // ini untuk tampilkan error 1->tampil, 0->tidak tampil
    ini_set('display_errors', 1);
    // identifikasi session
    if (session_status() === PHP_SESSION_NONE) {
        // set session awal
        ob_start();
        // mulai session
        session_start();
    }
    
    // require_once untuk memanggil file
    @require_once __DIR__ . '/base/__Base_Url.php';
    @require_once __DIR__ . '/base/__Connection.php';
    
    @require_once __DIR__ . '/routes/web.php';


    