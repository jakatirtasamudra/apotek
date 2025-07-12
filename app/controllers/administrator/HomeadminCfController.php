<?php

    @require_once dirname(__DIR__,2) . '/middleware/AuthMiddleware.php';

    class HomeadminCfController
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

        public function hitungCF()
        {
            // === 1. DATA GEJALA ===
            $gejala = [
                'G01' => 'Demam',
                'G02' => 'Batuk',
                'G03' => 'Sesak Napas',
                'G04' => 'Pilek',
                'G05' => 'Nyeri Tenggorokan',
                'G06' => 'Sakit Kepala',
                'G07' => 'Nafas Berbunyi',
                'G08' => 'Letih',
                'G09' => 'Mual',
                'G10' => 'Diare',
                'G11' => 'Mata Merah',
                'G12' => 'Gatal Kulit',
                'G13' => 'Ruam Kulit',
                'G14' => 'Hidung Tersumbat',
                'G15' => 'Bersin',
                'G16' => 'Nafas Cepat',
                'G17' => 'Sakit Dada',
                'G18' => 'Sulit Tidur',
                'G19' => 'Suhu Tubuh Tinggi',
                'G20' => 'Nafsu Makan Turun',
                'G21' => 'Keringat Dingin',
                'G22' => 'Sakit Perut',
                'G23' => 'Muntah',
                'G24' => 'Sakit Otot',
                'G25' => 'Mata Berair',
            ];

            // === 2. DATA PENYAKIT ===
            $penyakit = [
                'D01' => 'Influenza',
                'D02' => 'Asma',
                'D03' => 'ISPA',
                'D04' => 'Sembelit',
            ];

            // === 3. ATURAN CF: (CF pakar) ===
            $cf_rules = [
                'D01' => [ 'G01' => 0.8, 'G02' => 0.6, 'G04' => 0.7 ],
                'D02' => [ 'G02' => 0.7, 'G03' => 0.9, 'G07' => 0.8 ],
                'D03' => [ 'G01' => 0.5, 'G02' => 0.4, 'G03' => 0.6, 'G16' => 0.5 ],
                'D04' => [ 'G04' => 0.3, 'G11' => 0.8, 'G14' => 0.4 ],
            ];

            // === 4. INPUT DARI USER (simulasi) ===
            $cf_user = [
                'G01' => 0.8,
                'G02' => 0.6,
                'G03' => 0.7,
                'G04' => 0.5,
            ];

            // === 5. PROSES HITUNG ===
            $hasil_cf = [];

            foreach ($cf_rules as $kode_penyakit => $daftar_gejala) {
                $cf_combine = 0;

                foreach ($daftar_gejala as $kode_gejala => $cf_pakar) {
                    if (isset($cf_user[$kode_gejala])) {
                        $cf_user_value = $cf_user[$kode_gejala];
                        $cf = $cf_user_value * $cf_pakar;

                        $cf_combine = $cf_combine == 0 ? $cf : $cf_combine + $cf * (1 - $cf_combine);
                    }
                }

                $hasil_cf[] = [
                    'kode' => $kode_penyakit,
                    'nama' => $penyakit[$kode_penyakit],
                    'nilai' => number_format($cf_combine, 4, '.', '')
                ];
            }

            // Urutkan nilai CF tertinggi
            usort($hasil_cf, fn($a, $b) => $b['nilai'] <=> $a['nilai']);

            return $hasil_cf;
        }
        
        public function IndexHomeadmin_Cf()
        {   
            $hasil_cf = $this->hitungCF();

            return view('administrator/__homeadmin', [
                'csrf' => $this->__helpers->csrf_input(),
                'helpers' => $this->__helpers,
                'auth' => $__auth_login__,
                '__mod__' => [
                    'content' => '__cf',
                    'header' => 'CF',
                    'li_show_metode' => 'show',
                    'li_active_cf' => 'active',
                ],
                'hasil_cf' => $hasil_cf,
            ]);
        }
    }