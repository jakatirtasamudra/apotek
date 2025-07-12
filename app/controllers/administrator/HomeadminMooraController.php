<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminMooraController
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
        
        public function IndexHomeadmin_Moora()
        {   
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } 

            $__kriteria__ = [
                'HARGA' => [
                    'bobot' => 0.2,
                    'tipe'  => 'COST'
                ],
                'EFEKTIVITAS' => [
                    'bobot' => 0.2,
                    'tipe'  => 'BENEFIT'
                ],
                'EFEK SAMPING RENDAH' => [
                    'bobot' => 0.2,
                    'tipe'  => 'BENEFIT'
                ],
                'CEPAT REAKSI' => [
                    'bobot' => 0.2,
                    'tipe'  => 'BENEFIT'
                ],
                'TERSEDIA DI APOTEK' => [
                    'bobot' => 0.1,
                    'tipe'  => 'BENEFIT'
                ],
                'EXPIRED OBAT' => [
                    'bobot' => 0.1,
                    'tipe'  => 'BENEFIT'
                ],
            ];

            $__data_row__ = [];
            $__datas__ = $this->__query
                ->table('tbl_pembeli')
                ->select('id_pembeli AS id, nama')
                ->orderBy('id_pembeli', 'DESC')
                ->get(); 
            foreach($__datas__ as $datas) {
                $__data_row__[] = [
                    'nama' => $datas->nama,
                    'c1' => rand(1,5),
                    'c2' => rand(1,5),
                    'c3' => rand(1,5),
                    'c4' => rand(1,5),
                    'c5' => rand(1,5),
                ];
            }

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__moora',
                    'header' => 'Moora',
                    'li_show_metode' => 'show',
                    'li_active_moora' => 'active',
                ],
                'datas' => $__data_row__,
                'kriteria' => $__kriteria__,
            ]);
        }
    }