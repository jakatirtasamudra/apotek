<?php

    class AuthMiddleware
    {
        private $__db;
        private $__query;
        private $__helpers;
        
        public function __construct($__query , $db , $__helpers)
        {
            $this->__db = $db;
            $this->__query = $__query;
            $this->__helpers = $__helpers;
        }
        
        public function auth()
        {
            if (!isset($_SESSION['__Administrator__'])) {
                return redirect(url('/'));
                exit();
            }
            $auth = $this->__query
                ->table('tbl_login')
                ->select('id_login AS id, nama_login AS nama, level_login AS level')
                ->where('id_login', '=', $_SESSION['__Administrator__']['__Id'])
                ->where('nama_login', '=', $_SESSION['__Administrator__']['__Nama'])
                ->where('level_login', '=', $_SESSION['__Administrator__']['__Level'])
                ->where('status_login', '=', '1')
                ->orderBy('id_login', 'DESC')
                ->limit(1)
                ->first();  
            if (!$auth) {
                unset($_SESSION['__Administrator__']);
                return redirect(url('/'));
                exit();
            }
            return $auth;
        }
    }