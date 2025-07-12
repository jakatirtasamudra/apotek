<?php

    date_default_timezone_set('Asia/Jakarta');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if (session_status() === PHP_SESSION_NONE) {
        ob_start();
        session_start();
    } 

    try {

        $hp      = $_POST['hp'] ?? null;
        $aksi    = $_POST['aksi'] ?? null; 

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['beli']['hp']) || !$hp || $aksi != 'bayar' || !isset($_SESSION['beli']['nama'])) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
            exit;
        }

        @require_once dirname(__DIR__) . '/base/__Base_Url.php';
        @require_once dirname(__DIR__) . '/base/__Connection.php';
        @require_once dirname(__DIR__) . '/app/helpers/__Helpers.php';
        @require_once dirname(__DIR__) . '/app/helpers/__Query.php';

        $__db__ = new __Database;
        $__helpers = new __Helpers();
        $__query = new __Query($__db__);

        $existing = $__query
            ->table('tbl_transaksi')
            ->select('id_transaksi AS id, hp, id_obat')
            ->where('hp', '=', $hp)
            ->whereNull('bayar')
            ->first(); 
        if ($existing) {
            try {
                $__db__->beginTransaction();

                $data = [
                    'bayar'         => '1',
                    'tglbayar'      => date('Y-m-d H:i:s'),
                    'hp'            => $hp,
                ];
                $result = $__query
                    ->table('tbl_transaksi')
                    ->whereid('hp', '=', $data['hp'])
                    ->update($data); 
                if (isset($result['Error']) || $result['Error'] == '000') {
                    $__db__->commit();
                    $__helpers->TerminateSession();
                    $__helpers->EndSessionForm();
                    echo json_encode(['status' => 'success', 'message' => 'Pembayaran berhasil disimpan.']);
                    exit;
                } else {
                    $__db__->rollback();
                    echo json_encode(['status' => 'error', 'message' => 'DB Error: Gagal menyimpan']);
                    exit;
                }
            } catch (PDOException $e) {
                $__db__->rollback();
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => '']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }