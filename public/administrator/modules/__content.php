<?php

    if ( $__mod__['content'] == '__home' ) {

        require_once __DIR__ . '/__home.php';

    } elseif ( $__mod__['content'] == '__akun' ) {

        require_once __DIR__ . '/__akun.php';

    } elseif ( $__mod__['content'] == '__akun_ubah' ) {

        require_once __DIR__ . '/__akun_ubah.php';

    } elseif ( $__mod__['content'] == '__kategori' ) {

        require_once __DIR__ . '/__kategori.php';

    } elseif ( $__mod__['content'] == '__kategori_ubah' ) {

        require_once __DIR__ . '/__kategori_ubah.php';

    } elseif ( $__mod__['content'] == '__stok' ) {

        require_once __DIR__ . '/__stok.php';

    } elseif ( $__mod__['content'] == '__stok_ubah' ) {

        require_once __DIR__ . '/__stok_ubah.php';

    } elseif ( $__mod__['content'] == '__penjualan' ) {

        require_once __DIR__ . '/__penjualan.php';

    } elseif ( $__mod__['content'] == '__keuangan' ) {

        require_once __DIR__ . '/__keuangan.php';

    } elseif ( $__mod__['content'] == '__konsumen' ) {

        require_once __DIR__ . '/__konsumen.php';

    } elseif ( $__mod__['content'] == '__moora' ) {

        require_once __DIR__ . '/__moora.php';

    } elseif ( $__mod__['content'] == '__cf' ) {

        require_once __DIR__ . '/__cf.php';

    } elseif ( $__mod__['content'] == '__diskon' ) {

        require_once __DIR__ . '/__diskon.php';

    } elseif ( $__mod__['content'] == '__diskon_ubah' ) {

        require_once __DIR__ . '/__diskon_ubah.php';

    } elseif ( $__mod__['content'] == '__kas' ) {

        require_once __DIR__ . '/__kas.php';

    } elseif ( $__mod__['content'] == '__kas_ubah' ) {

        require_once __DIR__ . '/__kas_ubah.php';

    } else {

        require_once __DIR__ . '/__error.php';

    }