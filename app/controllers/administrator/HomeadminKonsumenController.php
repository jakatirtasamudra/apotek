<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminKonsumenController
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
        
        public function IndexHomeadmin_Konsumen()
        {   
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } 

            $__datas__ = $this->__query
                ->table('tbl_pembeli')
                ->select('id_pembeli AS id, hp, nama')
                ->orderBy('id_pembeli', 'DESC')
                ->get(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__konsumen',
                    'header' => 'Konsumen',
                    'li_show_transaksi' => 'show',
                    'li_active_konsumen' => 'active',
                ],
                'datas' => $__datas__,
            ]);
        }
    }