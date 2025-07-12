<?php

    date_default_timezone_set('Asia/Jakarta');
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    if (session_status() === PHP_SESSION_NONE) {
        ob_start();
        session_start();
    } 

    try {

        $hp         = $_POST['hp'] ?? null;
        $id_obat    = $_POST['id_obat'] ?? null;
        $jumlah     = (int) ($_POST['jumlah'] ?? 0);
        $harga      = (int) ($_POST['harga'] ?? 0);
        $load_data  = (int) ($_POST['load_data'] ?? 0);

        if ($load_data == '1') {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['beli']['hp']) || !is_numeric($hp) || !isset($_SESSION['beli']['nama']) || !isset($load_data)) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
                exit;
            }
        } else {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['beli']['hp']) || !is_numeric($hp) || !is_numeric($id_obat) || $jumlah < 0 || $harga < 0 || !isset($_SESSION['beli']['nama'])) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
                exit;
            }
        }

        @require_once dirname(__DIR__) . '/base/__Base_Url.php';
        @require_once dirname(__DIR__) . '/base/__Connection.php';
        @require_once dirname(__DIR__) . '/app/helpers/__Helpers.php';
        @require_once dirname(__DIR__) . '/app/helpers/__Query.php';

        $__db__ = new __Database;
        $__helpers = new __Helpers();
        $__query = new __Query($__db__);

        if ($load_data != '1') {
            $existing = $__query
                ->table('tbl_transaksi')
                ->select('id_transaksi AS id, hp, id_obat')
                ->where('hp', '=', $hp)
                ->where('id_obat', '=', $id_obat)
                ->whereNull('bayar')
                ->first();

                try {
                    $__db__->beginTransaction();

                    if ($jumlah > 0) {
                        $data = [
                            'hp'        => $hp,
                            'id_obat'   => $id_obat,
                            'jumlah'    => $jumlah,
                            'harga'     => $harga,
                        ];
                        if ($existing) { 
                            $data['update_at'] = date('Y-m-d H:i:s'); 
                            $data['id_transaksi'] = $existing->id; 
                            $result = $__query
                                ->table('tbl_transaksi')
                                ->whereid('id_transaksi', '=', $data['id_transaksi'])
                                ->whereid('hp', '=', $data['hp'])
                                ->whereid('id_obat', '=', $data['id_obat'])
                                ->update($data); 
                        } else {
                            $data['nama'] = $_SESSION['beli']['nama'];  
                            $result = $__query->table('tbl_transaksi')->insert($data);
                        }
                    } else {
                        if ($existing) {
                            $data = [
                                'id_transaksi'  => $existing->id,
                                'hp'            => $hp,
                                'id_obat'       => $id_obat,
                            ];
                            $result = $__query->table('tbl_transaksi')
                                ->whereid('id_transaksi', '=', $data['id_transaksi'])
                                ->whereid('hp', '=', $data['hp'])
                                ->whereid('id_obat', '=', $data['id_obat'])
                                ->delete($data);
                        }
                    }

                    if (!isset($result['Error']) || $result['Error'] !== '000') {
                        $__db__->rollback();
                        throw new Exception("DB Error: Gagal menyimpan");
                    }

                    $__db__->commit();
                } catch (PDOException $e) {
                    $__db__->rollback();
                    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                    exit;
                }
        }

        $list = $__query
            ->table('tbl_transaksi')
            ->select('id_transaksi AS id, hp, nama, id_obat, jumlah, harga, tgl')
            ->where('hp', '=', $hp)
            ->whereNull('bayar')
            ->orderBy('id_transaksi', 'DESC')
            ->get();
        $total = 0;
        $html = '<ul class="list-group">';
        foreach ($list as $item) {
            $obat = $__query
                ->table('tbl_obat')
                ->select('id_obat AS id, kategori, nama_obat AS nama, jumlah_obat AS jumlah, exp_obat AS exp, beli_obat AS beli, jual_obat AS jual')
                ->where('id_obat', '=', $item->id_obat)
                ->orderBy('id_obat', 'DESC')
                ->first(); 
            $nama_obat = $obat ? $obat->nama : '[Obat tidak ditemukan]';
            $sub = $item->jumlah * $item->harga;
            $total += $sub;
            $html .= "<li class='list-group-item d-flex justify-content-between'>
                        <span>{$nama_obat} - {$item->harga} x {$item->jumlah}</span>
                        <span>Rp. " . number_format($sub) . "</span>
                    </li>";
        }
        $html .= "<li class='list-group-item font-weight-bold d-flex justify-content-between'>
                    <span>Total</span><span>Rp. " . number_format($total) . "</span></li>";
        $html .= '</ul>';
        // <br><button class="btn btn-success btn-block __btnBayar">Bayar</button>';

        // Anggap $list = list dari transaksi user saat ini
        $data_transaksi = [];
        foreach ($list as $item) {
            $data_transaksi[] = [
                'id_obat' => $item->id_obat,
                'jumlah'  => $item->jumlah
            ];
        }
        // Tambahkan input hidden untuk dibaca JS
        echo '<input type="hidden" id="data-transaksi-json" value=\'' . json_encode($data_transaksi) . '\'>';

        echo $html;

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }