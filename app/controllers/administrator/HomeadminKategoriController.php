<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminKategoriController
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
        
        public function IndexHomeadmin_Kategori()
        {   
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } 

            $__datas__ = $this->__query
                ->table('tbl_kategori')
                ->select('id_kategori AS id, nama')
                ->orderBy('id_kategori', 'DESC')
                ->get(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__kategori',
                    'header' => 'Kategori',
                    'li_show_obat' => 'show',
                    'li_active_kategori' => 'active',
                ],
                'datas' => $__datas__,
            ]);
        }

        public function IndexHomeadmin_Kategori_Simpan(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => isset($request['url']) ? $request['url'] : '',
                'url_success'   => isset($request['url_success']) ? $request['url_success'] : '',
                'nama'          => $this->__helpers->clean_input($request['nama'] ?? ''),
            ]; 
            
            $_SESSION['old'] = [
                'nama'          => $__clean_data['nama'],
            ];

            if (!$this->__helpers->csrf_verify($__clean_data['csrf_token'] ?? '')) {
                $_SESSION['__Toast'] = 'Token invalid !';
                return redirect($__clean_data['url']);
            }

            $rules = [
                'csrf_token'   => 'required',
                'nama'         => 'required|min:2|max:255',
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__session = [
                'nama' => $__clean_data['nama'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_kategori')
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

        public function IndexHomeadmin_Kategori_Hapus($id = null)
        {
            $__clean_data = [
                'url'           => url('/homeadmin/kategori'),
                'url_success'   => url('/homeadmin/kategori'),
                'id'            => $this->__helpers->clean_input($id ?? ''),
            ]; 

            if ( !$__clean_data['id'] ) {
                $_SESSION['__Toast'] = 'Parameter tidak ada !';
                redirect($__clean_data['url']);
            }

            $__session = [
                'id_kategori' => $__clean_data['id'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_kategori')
                        ->whereid('id_kategori', '=', $__session['id_kategori'])
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

        public function IndexHomeadmin_Kategori_Ubah($id = null)
        {
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id || !$id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } elseif (!$id) {
                $_SESSION['__Toast'] = 'Parameter tidak ada !';
                return redirect(url('/homeadmin/kategori'));
                exit();
            } 

            $__data_login__ = $this->__query
                ->table('tbl_kategori')
                ->select('id_kategori AS id, nama')
                ->where('id_kategori', '=', $id)
                ->orderBy('id_kategori', 'DESC')
                ->first(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__kategori_ubah',
                    'header' => 'Kategori',
                    'li_show_obat' => 'show',
                    'li_active_kategori' => 'active',
                ],
                'id' => $id,
                'datas' => $__data_login__,
            ]);
        }

        public function IndexHomeadmin_Kategori_UbahSimpan(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => isset($request['url']) ? $request['url'] : '',
                'url_success'   => isset($request['url_success']) ? $request['url_success'] : '',
                'nama'          => $this->__helpers->clean_input($request['nama'] ?? ''),
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
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__session = [
                'nama'          => $__clean_data['nama'],
                'update_at'     => date('Y-m-d H:i:s'),
                'id_kategori'   => $__clean_data['id'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_kategori')
                        ->whereid('id_kategori', '=', $__session['id_kategori'])
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