<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminStokController
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
        
        public function IndexHomeadmin_Stok()
        {   
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } 

            $__datas__ = $this->__query
                ->table('tbl_obat')
                ->select('id_obat AS id, kategori, nama_obat AS nama, jumlah_obat AS jumlah, exp_obat AS exp, beli_obat AS beli, jual_obat AS jual')
                ->orderBy('id_obat', 'DESC')
                ->get(); 

            $__kategoris__ = $this->__query
                ->table('tbl_kategori')
                ->select('id_kategori AS id, nama')
                ->orderBy('id_kategori', 'DESC')
                ->get(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__stok',
                    'header' => 'Stok',
                    'li_show_obat' => 'show',
                    'li_active_stok' => 'active',
                ],
                'datas' => $__datas__,
                'kategoris' => $__kategoris__,
            ]);
        }

        public function IndexHomeadmin_Stok_Simpan(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => isset($request['url']) ? $request['url'] : '',
                'url_success'   => isset($request['url_success']) ? $request['url_success'] : '',
                'nama'          => $this->__helpers->clean_input($request['nama'] ?? ''),
                'jumlah'        => $this->__helpers->clean_input($request['jumlah'] ?? ''),
                'exp'           => $this->__helpers->clean_input($request['exp'] ?? ''),
                'kategori'      => $this->__helpers->clean_input($request['kategori'] ?? ''),
                'beli'          => $this->__helpers->clean_input($request['beli'] ?? ''),
                'jual'          => $this->__helpers->clean_input($request['jual'] ?? ''),
            ]; 
            
            $_SESSION['old'] = [
                'nama'          => $__clean_data['nama'],
                'jumlah'        => $__clean_data['jumlah'],
                'exp'           => $__clean_data['exp'],
                'beli'          => $__clean_data['beli'],
                'jual'          => $__clean_data['jual'],
            ];

            if (!$this->__helpers->csrf_verify($__clean_data['csrf_token'] ?? '')) {
                $_SESSION['__Toast'] = 'Token invalid !';
                return redirect($__clean_data['url']);
            }

            $rules = [
                'csrf_token'   => 'required',
                'nama'         => 'required|min:2|max:255',
                'jumlah'       => 'required|numeric',
                'exp'          => 'required',
                'beli'         => 'required|numeric',
                'jual'         => 'required|numeric',
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__session = [
                'kategori'      => $__clean_data['kategori'],
                'nama_obat'     => $__clean_data['nama'],
                'jumlah_obat'   => $__clean_data['jumlah'],
                'exp_obat'      => $__clean_data['exp'],
                'beli_obat'     => $__clean_data['beli'],
                'jual_obat'     => $__clean_data['jual'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_obat')
                        ->insert( $__session ); 
                    
                    if ( $__query_result['Error'] === '000' ) { 
                        $this->__db->commit();
                        $this->__helpers->EndSessionForm();
                        $_SESSION['__Toast'] = 'Berhasil Simpan Data !';
                        return redirect($__clean_data['url_success']);
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

        public function IndexHomeadmin_Stok_Hapus($id = null)
        {
            $__clean_data = [
                'url'           => url('/homeadmin/stok'),
                'url_success'   => url('/homeadmin/stok'),
                'id'            => $this->__helpers->clean_input($id ?? ''),
            ]; 

            if ( !$__clean_data['id'] ) {
                $_SESSION['__Toast'] = 'Parameter tidak ada !';
                redirect($__clean_data['url']);
            }

            $__session = [
                'id_obat' => $__clean_data['id'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_obat')
                        ->whereid('id_obat', '=', $__session['id_obat'])
                        ->delete( $__session );  
                    
                    if ( $__query_result['Error'] === '000' ) { 
                        $this->__db->commit();
                        $this->__helpers->EndSessionForm();
                        $_SESSION['__Toast'] = 'Berhasil Hapus Data !';
                        return redirect($__clean_data['url_success']);
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

        public function IndexHomeadmin_Stok_Ubah($id = null)
        {
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id || !$id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } elseif (!$id) {
                $_SESSION['__Toast'] = 'Parameter tidak ada !';
                return redirect(url('/homeadmin/stok'));
                exit();
            } 

            $__datas__ = $this->__query
                ->table('tbl_obat')
                ->select('id_obat AS id, kategori, nama_obat AS nama, jumlah_obat AS jumlah, exp_obat AS exp, beli_obat AS beli, jual_obat AS jual')
                ->where('id_obat', '=', $id)
                ->orderBy('id_obat', 'DESC')
                ->first(); 

            $__kategoris__ = $this->__query
                ->table('tbl_kategori')
                ->select('id_kategori AS id, nama')
                ->orderBy('id_kategori', 'DESC')
                ->get(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__stok_ubah',
                    'header' => 'Kategori',
                    'li_show_obat' => 'show',
                    'li_active_stok' => 'active',
                ],
                'id' => $id,
                'datas' => $__datas__,
                'kategoris' => $__kategoris__,
            ]);
        }

        public function IndexHomeadmin_Stok_UbahSimpan(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => isset($request['url']) ? $request['url'] : '',
                'url_success'   => isset($request['url_success']) ? $request['url_success'] : '',
                'nama'          => $this->__helpers->clean_input($request['nama'] ?? ''),
                'jumlah'        => $this->__helpers->clean_input($request['jumlah'] ?? ''),
                'exp'           => $this->__helpers->clean_input($request['exp'] ?? ''),
                'kategori'      => $this->__helpers->clean_input($request['kategori'] ?? ''),
                'beli'          => $this->__helpers->clean_input($request['beli'] ?? ''),
                'jual'          => $this->__helpers->clean_input($request['jual'] ?? ''),
                'id'            => $this->__helpers->clean_input($request['id'] ?? ''),
            ]; 

            if (!$this->__helpers->csrf_verify($__clean_data['csrf_token'] ?? '')) {
                $_SESSION['__Toast'] = 'Token invalid !';
                return redirect($__clean_data['url']);
            }

            $rules = [
                'csrf_token'   => 'required',
                'id'           => 'required',
                'nama'         => 'required|min:2|max:255',
                'jumlah'       => 'required|numeric',
                'exp'          => 'required',
                'beli'         => 'required|numeric',
                'jual'         => 'required|numeric',
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__session = [
                'kategori'      => $__clean_data['kategori'],
                'nama_obat'     => $__clean_data['nama'],
                'jumlah_obat'   => $__clean_data['jumlah'],
                'exp_obat'      => $__clean_data['exp'],
                'beli_obat'     => $__clean_data['beli'],
                'jual_obat'     => $__clean_data['jual'],
                'update_at'     => date('Y-m-d H:i:s'),
                'id_obat'       => $__clean_data['id'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_obat')
                        ->whereid('id_obat', '=', $__session['id_obat'])
                        ->update( $__session ); 
                    
                    if ( $__query_result['Error'] === '000' ) { 
                        $this->__db->commit();
                        $this->__helpers->EndSessionForm();
                        $_SESSION['__Toast'] = 'Berhasil Ubah Data !';
                        return redirect($__clean_data['url_success']);
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