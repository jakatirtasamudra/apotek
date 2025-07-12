<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminController
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
        
        public function IndexHomeadmin()
        {   
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } 

            $__total_obat__ = $this->__query
                ->table('tbl_obat')
                ->selectCount('id_obat')
                ->first(); 
            $__total_kategori__ = $this->__query
                ->table('tbl_kategori')
                ->selectCount('id_kategori')
                ->first(); 
            $__total_pegawai__ = $this->__query
                ->table('tbl_login')
                ->selectCount('id_login')
                ->whereNot('level_login', '=', 'admin')
                ->first(); 
            $__total_user__ = $this->__query
                ->table('tbl_pembeli')
                ->selectCount('id_pembeli')
                ->first(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__home',
                    'header' => 'Beranda',
                ],
                'total_obat' => $__total_obat__,
                'total_kategori' => $__total_kategori__,
                'total_pegawai' => $__total_pegawai__,
                'total_user' => $__total_user__,
            ]);
        }
    }