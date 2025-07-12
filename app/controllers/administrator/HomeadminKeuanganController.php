<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminKeuanganController
    {
        protected $__db;
        protected $__helpers;
        protected $__query;

        public function __construct()
        {
            $this->__db = new __Database;
            $this->__helpers = new __Helpers();
            $this->__query = new __Query( $this->__db );
            $this->__session_auth = new AuthMiddleware( $this->__query , $this->__db , $this->__helpers );
        }
        
        public function IndexHomeadmin_Keuangan()
        {   
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } 

            $tgl1 = filter_input(INPUT_POST, 'tgl1', FILTER_SANITIZE_STRING);
            $tgl2 = filter_input(INPUT_POST, 'tgl2', FILTER_SANITIZE_STRING);

            $__datas__ = $this->__query
                ->table('tbl_transaksi')
                ->select('id_transaksi AS id, hp, nama, id_obat, jumlah, harga, tgl, bayar, tglbayar')
                ->where('bayar', '=', '1');
            if ($tgl1 && $tgl2) {
                $__datas__ = $__datas__->whereDate('tglbayar', '>=', $tgl1)->whereDate('tglbayar', '<=', $tgl2);
            }
            $__datas__ = $__datas__->orderBy('id_transaksi', 'DESC')->get();   

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'query' => $this->__query,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__keuangan',
                    'header' => 'Keuangan',
                    'li_show_obat' => 'show',
                    'li_active_keuangan' => 'active',
                ],
                'datas' => $__datas__,
            ]);
        }
    }