<?php

    date_default_timezone_set('Asia/Jakarta');
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    if (session_status() === PHP_SESSION_NONE) {
        ob_start();
        session_start();
    } 

    try {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['beli']['hp']) || !isset($_SESSION['beli']['nama'])) {
            echo '<div class="col-12"><div class="alert alert-warning">Silakan lengkapi data pembeli terlebih dahulu.</div></div>';
            exit;
        }

        @require_once dirname(__DIR__) . '/base/__Base_Url.php';
        @require_once dirname(__DIR__) . '/base/__Connection.php';
        @require_once dirname(__DIR__) . '/app/helpers/__Helpers.php';
        @require_once dirname(__DIR__) . '/app/helpers/__Query.php';
        @require_once dirname(__DIR__) . '/app/core/__Router.php';

        $__db__ = new __Database;
        $__helpers = new __Helpers();
        $__query = new __Query($__db__);
        $csrf = $__helpers->csrf_input(); 

        $kategori = $_POST['kategori_id'] ?? null;
        $__datas__ = $__query
            ->table('tbl_obat')
            ->select('id_obat AS id, kategori, nama_obat AS nama, jumlah_obat AS jumlah, exp_obat AS exp, beli_obat AS beli, jual_obat AS jual');
        if (isset($kategori) && $kategori == TRUE) {
            $__datas__ = $__datas__->where('kategori', '=', $kategori);
        } 
            $__datas__ = $__datas__->orderBy('id_obat', 'DESC')->get();  

        if (empty($__datas__)) {
            echo '<div class="col-12"><div class="alert alert-warning">Tidak ada obat ditemukan.</div></div>';
            exit;
        }
        
        foreach ($__datas__ as $obat) {
    ?>
<div class="col-xl-3 col-md-4 col-sm-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <?= $csrf; ?>
                <div class="row no-gutters align-items-center mb-2">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <?= $obat->nama; ?>
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp. <?= $__helpers->Uang($obat->jual); ?>
                        </div>
                        <small>(Stok <?= $obat->jumlah; ?>) - <?= $obat->exp; ?></small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-medkit fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="row">
                        <div class="col-3">
                            <button class="btn btn-outline-danger btn-block btn-minus" data-id="<?= $obat->id; ?>"
                                data-harga="<?= $obat->jual; ?>">-</button>
                        </div>
                        <div class="col-6">
                            <input class="form-control text-center jumlah-beli" id="jumlah_<?= $obat->id; ?>" value="0"
                                readonly>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-outline-primary btn-block btn-plus" data-id="<?= $obat->id; ?>"
                                data-harga="<?= $obat->jual; ?>" data-stok="<?= $obat->jumlah; ?>">+</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
}

    } catch (Exception $e) {
        echo '<div class="col-12"><div class="alert alert-danger">Error: ' . $e->getMessage() . '</div></div>';
    }