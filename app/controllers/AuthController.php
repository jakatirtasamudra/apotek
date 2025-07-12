<?php

    class AuthController
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
        
        public function IndexLogin()
        {
            return view('auth/__login', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                '__mod__' => [
                    '__content__' => '__home',
                    '__active__' => 'active',
                    '__header' => __Aplikasi()['Nama'],
                ],
            ]);
        }

        public function IndexLogin_Proses(array $request)
        {
            $__clean_data = [
                'csrf_token'    => $this->__helpers->clean_input($request['csrf_token'] ?? ''),
                'url'           => url('/login'),
                'url_success'   => url('/homeadmin'),
                'username'      => $this->__helpers->clean_input($request['username'] ?? ''),
                'password'      => $this->__helpers->clean_input($request['password'] ?? ''),
            ];

            $_SESSION['old'] = [
                'username'      => $__clean_data['username'],
            ];

            if (!$this->__helpers->csrf_verify($__clean_data['csrf_token'] ?? '')) {
                return redirect($__clean_data['url']);
            }

            $rules = [
                'csrf_token'   => 'required',
                'username'     => 'required|alphanum|min:5|max:30',
                'password'     => 'required|min:6|max:32',
            ];
            $errors = $this->__helpers->validate($request, $rules);
            if (!empty($errors)) {
                return redirect($__clean_data['url']);
            }

            $__data_auth__ = $this->__query
                ->table('tbl_login')
                ->select('id_login AS id, user_login AS users, pass_login AS pass, nama_login AS nama, level_login AS level, status_login AS status')
                ->where('user_login', '=', $__clean_data['username'])
                ->where('pass_login', '=', $__clean_data['password'])
                ->where('status_login', '=', '1')
                ->orderBy('id_login', 'DESC')
                ->limit(1)
                ->first();  

            if ( $__data_auth__->id == TRUE && $__data_auth__->users === $__clean_data['username'] && $__data_auth__->pass === $__clean_data['password'] ) {
                $this->__helpers->TerminateSession();
                $this->__helpers->EndSessionForm();
                $_SESSION['__Administrator__'] = [
                    '__Id'      => $__data_auth__->id,
                    '__Nama'    => $__data_auth__->nama,
                    '__Level'   => $__data_auth__->level,
                    '__Log'     => date('Y-m-d H:i:s'),
                ];
                $_SESSION['__Toast'] = 'Selamat Datang Di Aplikasi '.__Aplikasi()['Nama'].' !';
                return redirect($__clean_data['url_success']);
                exit();
            }

            $this->__helpers->error('Data Login User Yang Di Input Tidak Terdaftar !');
            return redirect($__clean_data['url']);
        }

        public function IndexLogout(array $request)
        {
            $this->__helpers->TerminateSession();
            $this->__helpers->EndSessionForm();
            $this->__helpers->error('Berhasil Logout Dari Aplikasi !');
            return redirect(url('/login'));
            exit();
        }
    }