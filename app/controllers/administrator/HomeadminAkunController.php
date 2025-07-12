<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminAkunController
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
        
        public function IndexHomeadmin_Akun()
        {   
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } 

            $__data_login__ = $this->__query
                ->table('tbl_login')
                ->select('id_login AS id, user_login AS users, pass_login AS pass, nama_login AS nama, level_login AS level, status_login AS status')
                ->whereNot('level_login', '=', 'admin')
                ->orderBy('id_login', 'DESC')
                ->get(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__akun',
                    'header' => 'Akun',
                    'li_show_akun' => 'show',
                    'li_active_pegawai' => 'active',
                ],
                'datas' => $__data_login__,
            ]);
        }

        public function IndexHomeadmin_Akun_Simpan(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => isset($request['url']) ? $request['url'] : '',
                'url_success'   => isset($request['url_success']) ? $request['url_success'] : '',
                'username'      => $this->__helpers->clean_input($request['username'] ?? ''),
                'password'      => $this->__helpers->clean_input($request['password'] ?? ''),
                'nama'          => $this->__helpers->clean_input($request['nama'] ?? ''),
                'level'         => $this->__helpers->clean_input($request['level'] ?? ''),
            ]; 
            
            $_SESSION['old'] = [
                'username'      => $__clean_data['username'],
                'password'      => $__clean_data['password'],
                'nama'          => $__clean_data['nama'],
            ];

            if (!$this->__helpers->csrf_verify($__clean_data['csrf_token'] ?? '')) {
                $_SESSION['__Toast'] = 'Token invalid !';
                return redirect($__clean_data['url']);
            }

            $rules = [
                'csrf_token'   => 'required',
                'username'     => 'required|alphanum|min:6|max:30',
                'password'     => 'required|min:6|max:32',
                'nama'         => 'required|min:6|max:32',
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__session = [
                'user_login'    => $__clean_data['username'],
                'pass_login'    => $__clean_data['password'],
                'nama_login'    => $__clean_data['nama'],
                'level_login'   => $__clean_data['level'],
                'status_login'  => '1',
            ];  

            $__check_login__ = $this->__query
                ->table('tbl_login')
                ->select('id_login AS id')
                ->where('user_login', '=', $__session['user_login'])
                ->row();
            if (isset($__check_login__) && $__check_login__ == TRUE) {
                $_SESSION['__Toast'] = 'Username '.$__session['user_login'].' sudah terdaftar !';
                return redirect($__clean_data['url']);
            } 

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_login')
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

        public function IndexHomeadmin_Akun_Hapus($id = null)
        {
            $__clean_data = [
                'url'           => url('/homeadmin/akun'),
                'url_success'   => url('/homeadmin/akun'),
                'id'            => $this->__helpers->clean_input($id ?? ''),
            ]; 

            if ( !$__clean_data['id'] ) {
                $_SESSION['__Toast'] = 'Parameter tidak ada !';
                redirect($__clean_data['url']);
            }

            $__session = [
                'id_login'      => $__clean_data['id'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_login')
                        ->whereid('id_login', '=', $__session['id_login'])
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

        public function IndexHomeadmin_Akun_Ubah($id = null)
        {
            $__auth_login__ = $this->__session_auth->auth();
            if (!$__auth_login__->id || !$id) {
                $this->__helpers->TerminateSession();
                return redirect(url('/'));
                exit();
            } elseif (!$id) {
                $_SESSION['__Toast'] = 'Parameter tidak ada !';
                return redirect(url('/homeadmin/akun'));
                exit();
            } 

            $__data_login__ = $this->__query
                ->table('tbl_login')
                ->select('id_login AS id, user_login AS users, pass_login AS pass, nama_login AS nama, level_login AS level, status_login AS status')
                ->whereNot('level_login', '=', 'admin')
                ->where('id_login', '=', $id)
                ->orderBy('id_login', 'DESC')
                ->first(); 

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__akun_ubah',
                    'header' => 'Akun',
                    'li_show_akun' => 'show',
                    'li_active_pegawai' => 'active',
                ],
                'id' => $id,
                'datas' => $__data_login__,
            ]);
        }

        public function IndexHomeadmin_Akun_UbahSimpan(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => isset($request['url']) ? $request['url'] : '',
                'url_success'   => isset($request['url_success']) ? $request['url_success'] : '',
                'username'      => $this->__helpers->clean_input($request['username'] ?? ''),
                'password'      => $this->__helpers->clean_input($request['password'] ?? ''),
                'nama'          => $this->__helpers->clean_input($request['nama'] ?? ''),
                'level'         => $this->__helpers->clean_input($request['level'] ?? ''),
                'id'            => $this->__helpers->clean_input($request['id'] ?? ''),
            ]; 

            if (!$this->__helpers->csrf_verify($__clean_data['csrf_token'] ?? '')) {
                $_SESSION['__Toast'] = 'Token invalid !';
                return redirect($__clean_data['url']);
            }

            $rules = [
                'csrf_token'   => 'required',
                'id'           => 'required',
                'username'     => 'required|alphanum|min:6|max:30',
                'password'     => 'required|min:6|max:32',
                'nama'         => 'required|min:6|max:32',
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__session = [
                'user_login'    => $__clean_data['username'],
                'pass_login'    => $__clean_data['password'],
                'nama_login'    => $__clean_data['nama'],
                'level_login'   => $__clean_data['level'],
                'update_at'     => date('Y-m-d H:i:s'),
                'id_login'      => $__clean_data['id'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_login')
                        ->whereid('id_login', '=', $__session['id_login'])
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

        public function IndexHomeadmin_Akun_Status($id = null, $status = null)
        {
            $__clean_data = [
                'url'           => url('/homeadmin/akun'),
                'url_success'   => url('/homeadmin/akun'),
                'id'            => $this->__helpers->clean_input($id ?? ''),
                'status'        => $this->__helpers->clean_input($status ?? ''),
            ]; 

            if ( !$__clean_data['id'] ) {
                $_SESSION['__Toast'] = 'Parameter tidak ada !';
                redirect($__clean_data['url']);
            }

            if ($status == '1') {
                $_status = '1';
            } else {
                $_status = NULL;
            }

            $__session = [
                'status_login'  => $_status,
                'update_at'     => date('Y-m-d H:i:s'),
                'id_login'      => $__clean_data['id'],
            ];  

                try {
                    $this->__db->beginTransaction();

                    $__query_result = $this->__query
                        ->table('tbl_login')
                        ->whereid('id_login', '=', $__session['id_login'])
                        ->update( $__session );  
                    
                    if ( $__query_result['Error'] === '000' ) { 
                        $this->__db->commit();
                        $this->__helpers->EndSessionForm();
                        $_SESSION['__Toast'] = 'Berhasil Ubah Status Data !';
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