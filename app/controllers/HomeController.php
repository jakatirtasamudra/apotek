<?php

    class HomeController
    {
        protected $__db;
        protected $__helpers;
        protected $__query;

        public function __construct()
        {
            $this->__db = new __Database;
            $this->__helpers = new __Helpers();
            $this->__query = new __Query( $this->__db );
        }
        
        public function IndexHome()
        {
            if (isset($_SESSION['beli']) && $_SESSION['beli'] == TRUE) {
                $__pembeli__ = $this->__query
                    ->table('tbl_pembeli')
                    ->select('id_pembeli AS id, hp, nama')
                    ->where('hp', '=', $_SESSION['beli']['hp'])
                    ->orderBy('id_pembeli', 'DESC')
                    ->first();
                if (isset($__pembeli__) && $__pembeli__ == TRUE) {
                    $__datas__ = $this->__query
                        ->table('tbl_obat')
                        ->select('id_obat AS id, kategori, nama_obat AS nama, jumlah_obat AS jumlah, exp_obat AS exp, beli_obat AS beli, jual_obat AS jual')
                        ->orderBy('id_obat', 'DESC')
                        ->get(); 

                    $__kategoris__ = $this->__query
                        ->table('tbl_obat')
                        ->select('kategori')
                        ->groupBy('kategori')
                        ->get();
                }
            }

            return view('__home', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'pembeli' => $__pembeli__,
                'datas' => $__datas__,
                'kategori_list' => $__kategoris__,
            ]);
        }

        public function IndexHome_Beli(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => url('/'),
                'hp'            => $this->__helpers->clean_input($request['hp'] ?? ''),
                'nama'          => $this->__helpers->clean_input($request['nama'] ?? ''),
            ]; 
            
            $_SESSION['old'] = [
                'hp'            => $__clean_data['hp'],
                'nama'          => $__clean_data['nama'],
            ];

            if (!$this->__helpers->csrf_verify($__clean_data['csrf_token'] ?? '')) {
                $_SESSION['__Toast'] = 'Token invalid !';
                return redirect($__clean_data['url']);
            }

            $rules = [
                'csrf_token'   => 'required',
                'hp'           => 'required|numeric|max:15',
                'nama'         => 'required|min:2|max:255',
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__pembeli__ = $this->__query
                ->table('tbl_pembeli')
                ->select('id_pembeli AS id, hp, nama')
                ->where('hp', '=', $__clean_data['hp'])
                ->orderBy('id_pembeli', 'DESC')
                ->first();
            if (isset($__pembeli__) && $__pembeli__ == TRUE) {
                $__session = [
                    'hp'        => $__pembeli__->hp,
                    'nama'      => $__pembeli__->nama,
                    'update_at' => date('Y-m-d H:i:s'),
                ]; 
            } else {
                $__session = [
                    'hp'        => $__clean_data['hp'],
                    'nama'      => $__clean_data['nama'],
                ];  
            }

                try {
                    $this->__db->beginTransaction();

                    if (isset($__pembeli__) && $__pembeli__ == TRUE) {
                        $__query_result = $this->__query
                            ->table('tbl_pembeli')
                            ->whereid('hp', '=', $__session['hp'])
                            ->update( $__session ); 
                    } else {
                        $__query_result = $this->__query
                            ->table('tbl_pembeli')
                            ->insert( $__session ); 
                    }

                    if ( $__query_result['Error'] === '000' ) { 
                        $this->__db->commit();
                        $this->__helpers->EndSessionForm();
                        $_SESSION['beli'] = [
                            'hp' => $__session['hp'],
                            'nama' => $__session['nama'],
                        ];
                        $_SESSION['__Toast'] = 'Silahkan pilih kebutuhan Obat kamu !';
                        return redirect($__clean_data['url']);
                    } else {
                        $this->__db->rollback();
                        $_SESSION['__Toast'] = 'Error Query !';
                        return redirect($__clean_data['url']);
                    }
                        
                } catch ( PDOException $e ) {
                    $this->__db->rollback();
                    $_SESSION['__Toast'] = 'Error ' . $e->getMessage() . ' !';
                    return redirect($__clean_data['url']);
                }
        }
    }