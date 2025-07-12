<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminDiskonController
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

        public function IndexHomeadmin_Diskon()
        {
            $datas = $this->__query
                ->table('tbl_diskon')
                ->select('id_diskon AS id, keterangan, nominal, tgl')
                ->orderBy('tgl', 'DESC')
                ->get();

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                //'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__diskon',
                    'header' => 'Diskon',
                    'li_show_obat' => 'show',
                    'li_active_diskon' => 'active',
                ],
                'data' => $datas,
            ]);
        }

        public function IndexHomeadmin_Diskon_Simpan(array $data)
        {
            $datas = [
                'keterangan' => $data['keterangan'],
                'nominal' => $data['nominal'],
                'tgl' => $data['tanggal'],
            ];

            $simpan = $this->__query->table('tbl_diskon')->insert($datas);
            $_SESSION['__Toast'] = 'Berhasil simpan data';
            return redirect(url('/homeadmin/diskon'));
        }

        public function IndexHomeadmin_Diskon_Ubah($id)
        {
            $datas = $this->__query
                ->table('tbl_diskon')
                ->select('id_diskon AS id, keterangan, nominal, tgl')
                ->where('id_diskon', '=', $id)
                ->orderBy('tgl', 'DESC')
                ->first();
            if(!$datas){
                $_SESSION['__Toast'] = 'Tidak ada data di database';
                redirect(url('/homeadmin/diskon'));
            }

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                //'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__diskon_ubah',
                    'header' => 'Diskon',
                    'li_show_obat' => 'show',
                    'li_active_diskon' => 'active',
                ],
                'id' => $id,
                'data' => $datas,
            ]);
        }

        public function IndexHomeadmin_Diskon_Ubah_Simpan(array $data)
        {
            $datas = [
                'id_diskon' => $data['id'],
                'keterangan' => $data['keterangan'],
                'nominal' => $data['nominal'],
                'tgl' => $data['tanggal'],
            ];

            $ubah = $this->__query
                ->table('tbl_diskon')
                ->whereid('id_diskon', '=', $datas['id_diskon'])
                ->update($datas);
            $_SESSION['__Toast'] = 'Berhasil ubah data';
            redirect(url('/homeadmin/diskon'));
        }

        public function IndexHomeadmin_Diskon_Hapus($id)
        {
            if (!$id) {
                $_SESSION['__Toast'] = 'Data parameter tidak ada';
                redirect(url('/homeadmin/diskon'));
            }

            $datas = [
                'id_diskon' => $id,
            ];

            $hapus = $this->__query
                ->table('tbl_diskon')
                ->whereid('id_diskon', '=', $datas['id_diskon'])
                ->delete($datas);
            $_SESSION['__Toast'] = 'Berhasil hapus data';
            redirect(url('/homeadmin/diskon'));
        }
    }