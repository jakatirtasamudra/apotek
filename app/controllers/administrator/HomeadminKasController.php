<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminKasController
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

        public function IndexHomeadmin_Kas()
        {
            $datas = $this->__query
                ->table('tbl_kas')
                ->select('id_kas AS id, keterangan, nominal, debet, kredit, tgl')
                ->orderBy('tgl', 'DESC')
                ->get();

            $status = array('debet', 'kredit');

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                //'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__kas',
                    'header' => 'Kas',
                    'li_show_obat' => 'show',
                    'li_active_kas' => 'active',
                ],
                'data' => $datas,
                'status' => $status,
            ]);
        }

        public function IndexHomeadmin_Kas_Simpan(array $data)
        {
            if ($data['status'] == 'debet') {
                $debet = $data['nominal'];
                $kredit = '0';
            } else {
                $debet = '0';
                $kredit = $data['nominal'];
            }
            $datas = [
                'keterangan' => $data['keterangan'],
                'nominal' => $data['nominal'],
                'debet' => $debet,
                'kredit' => $kredit,
                'tgl' => $data['tanggal'],
            ];

            $simpan = $this->__query->table('tbl_kas')->insert($datas);
            if ($simpan) {
                $_SESSION['__Toast'] = 'Berhasil simpan data';
            } else {
                $_SESSION['__Toast'] = 'Tidak Berhasil simpan data';
            }
            return redirect(url('/homeadmin/kas'));
        }

        public function IndexHomeadmin_Kas_Ubah($id)
        {
            $datas = $this->__query
                ->table('tbl_kas')
                ->select('id_kas AS id, keterangan, nominal, debet, kredit, tgl')
                ->where('id_kas', '=', $id)
                ->orderBy('tgl', 'DESC')
                ->first();
            if(!$datas){
                $_SESSION['__Toast'] = 'Tidak ada data di database';
                redirect(url('/homeadmin/kas'));
            }

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                //'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__kas_ubah',
                    'header' => 'Kas',
                    'li_show_obat' => 'show',
                    'li_active_kas' => 'active',
                ],
                'id' => $id,
                'data' => $datas,
            ]);
        }

        public function IndexHomeadmin_Kas_Ubah_Simpan(array $data)
        {
            if ($data['status'] == 'debet') {
                $debet = $data['nominal'];
                $kredit = '0';
            } else {
                $debet = '0';
                $kredit = $data['nominal'];
            }
            $datas = [
                'id_kas' => $data['id'],
                'keterangan' => $data['keterangan'],
                'nominal' => $data['nominal'],
                'debet' => $debet,
                'kredit' => $kredit,
                'tgl' => $data['tanggal'],
            ];

            $ubah = $this->__query
                ->table('tbl_kas')
                ->whereid('id_kas', '=', $datas['id_kas'])
                ->update($datas);
            if ($ubah) {
                $_SESSION['__Toast'] = 'Berhasil ubah data';
            } else {
                $_SESSION['__Toast'] = 'Tidak Berhasil ubah data';
            }
            redirect(url('/homeadmin/kas'));
        }

        public function IndexHomeadmin_Kas_Hapus($id)
        {
            if (!$id) {
                $_SESSION['__Toast'] = 'Data parameter tidak ada';
                redirect(url('/homeadmin/kas'));
            }

            $datas = [
                'id_kas' => $id,
            ];

            $hapus = $this->__query
                ->table('tbl_kas')
                ->whereid('id_kas', '=', $datas['id_kas'])
                ->delete($datas);
            if ($hapus) {
                $_SESSION['__Toast'] = 'Berhasil hapus data';
            } else {
                $_SESSION['__Toast'] = 'Tidak Berhasil hapus data';
            }
            redirect(url('/homeadmin/kas'));
        }
    }