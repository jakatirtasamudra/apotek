<?php

    // identifikasi set base url
    define('BASE_URL', 'http://localhost/apotek/');

    // cek kondisi function digunakan
    if ( !function_exists('__Base_Url') ) {
        // set nama function
        function __Base_Url() {
            // mengembalikan nilai function
            return BASE_URL;
        }
    }

    if ( !function_exists('__Path') ) {
        function __Path() {
            return '/apotek';
        }
    }

    if ( !function_exists('__Aplikasi') ) {
        function __Aplikasi() {
            // identifikasi data array dalam function, cara panggil __Aplikasi()['Nama']
            return [
                'Nama'      => 'Apotek',
                'Aplikasi'  => 'Apotek',
                'Singkat'   => 'Apo',
                'Logo'      => __Base_Url() . 'src/resources/pict/__logo.jpg',
                'Kop'       => __Base_Url() . 'src/resources/pict/__kop.png',
                ];
        }
    }