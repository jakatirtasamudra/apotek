<?php

    class __Helpers
    {
        public static function old($key) {
            return $_SESSION['old'][$key] ?? '';
        }

        public static function error($message = null) {
            if ($message !== null) {
                $_SESSION['notif'][] = $message;
                return true;
            }

            if (isset($_SESSION['notif'])) {
                $errors = $_SESSION['notif'];
                unset($_SESSION['notif']);
                return $errors;
            }

            return null;
        }

        public static function allerror() {
            if (isset($_SESSION['flash']) && is_array($_SESSION['flash'])) {
                $errors = [];
                foreach ($_SESSION['flash'] as $fieldErrors) {
                    foreach ($fieldErrors as $error) {
                        $errors[] = $error;
                    }
                }
                unset($_SESSION['flash']); 
                return $errors;
            }
            return null;
        }

        public static function flash($key, $message = null) {
            if ($message !== null) {
                $_SESSION['_flash'][$key] = $message;
            } elseif (isset($_SESSION['_flash'][$key])) {
                $msg = $_SESSION['_flash'][$key];
                unset($_SESSION['_flash'][$key]);
                return $msg;
            }
            return null;
        }

        public static function validate($data, $rules = []) {
            $errors = [];

            foreach ($rules as $field => $ruleSet) {
                $value = trim($data[$field] ?? '');
                $rulesArr = explode('|', $ruleSet);

                foreach ($rulesArr as $rule) {
                    if ($rule === 'required' && $value === '') {
                        $errors[$field][] = "$field wajib diisi.";
                    }

                    if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = "$field format wajib email.";
                    }

                    if (strpos($rule, 'min:') === 0) {
                        $min = (int) explode(':', $rule)[1];
                        if (strlen($value) < $min) {
                            $errors[$field][] = "$field harus mininal $min karakter.";
                        }
                    }

                    if (strpos($rule, 'max:') === 0) {
                        $max = (int) explode(':', $rule)[1];
                        if (strlen($value) > $max) {
                            $errors[$field][] = "$field tidak boleh melebihi $max karakter.";
                        }
                    }

                    if ($rule === 'numeric' && !is_numeric($value)) {
                        $errors[$field][] = "$field format wajib angka.";
                    }

                    if ($rule === 'alpha' && !ctype_alpha($value)) {
                        $errors[$field][] = "$field hanya boleh berisi huruf.";
                    }

                    if ($rule === 'alphanum' && !ctype_alnum($value)) {
                        $errors[$field][] = "$field hanya boleh berisi huruf dan angka.";
                    }

                    if (strpos($rule, 'match:') === 0) {
                        $other = explode(':', $rule)[1];
                        if (!isset($data[$other]) || $value !== $data[$other]) {
                            $errors[$field][] = "$field harus sama dengan $other.";
                        }
                    }

                    if (strpos($rule, 'in:') === 0) {
                        $allowed = explode(',', explode(':', $rule)[1]);
                        if (!in_array($value, $allowed)) {
                            $errors[$field][] = "$field harus menjadi salah satu dari: " . implode(', ', $allowed);
                        }
                    }

                    if (strpos($rule, 'between:') === 0) {
                        [$min, $max] = explode(',', explode(':', $rule)[1]);
                        if (strlen($value) < (int)$min || strlen($value) > (int)$max) {
                            $errors[$field][] = "$field harus antara $min dan $max karakter.";
                        }
                    }

                    if (strpos($rule, 'length:') === 0) {
                        $length = (int) explode(':', $rule)[1];
                        if (strlen($value) !== $length) {
                            $errors[$field][] = "$field harus tepat $length karakter.";
                        }
                    }

                    if (strpos($rule, 'regex:') === 0) {
                        $pattern = substr($rule, 6); 
                        if (!preg_match($pattern, $value)) {
                            $errors[$field][] = "$field formatnya tidak valid.";
                        }
                    }
                }
            }

            if (!empty($errors)) {
                $_SESSION['flash'] = $errors;
            }
            
            return $errors;
        }

        public static function csrf_token() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (empty($_SESSION['__csrf_token'])) {
                $_SESSION['__csrf_token'] = bin2hex(random_bytes(32));
            }

            return $_SESSION['__csrf_token'];
        }

        public static function csrf_input() {
            $token = self::csrf_token();
            return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
        }

        public static function csrf_verify($token) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            return isset($_SESSION['__csrf_token']) && hash_equals($_SESSION['__csrf_token'], $token);
        }

        function clean_input($value) {
            return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES);
        }


        public static function TerminateSession()
        {
            $_SESSION = [];
            session_unset();
            session_destroy();
            session_start();
        }

        public static function EndSessionForm()
        {
            unset($_SESSION['old'], $_SESSION['flash'], $_SESSION['_flash'], $_SESSION['__csrf_token'], $_SESSION['notif']);
        }

        public static function FormatAngkaNol($nomor, $jumlahNol = 3, $char = '0') 
        {
            $jumlahNomor = strlen((string) $nomor);
            $ulangNol = $jumlahNol - $jumlahNomor;
            return str_repeat($char, $ulangNol) . $nomor;
        }

        public static function RomawiBulan($bln) 
        {
            switch ($bln) {
                case 1:
                    return "I";
                    break;
                case 2:
                    return "II";
                    break;
                case 3:
                    return "III";
                    break;
                case 4:
                    return "IV";
                    break;
                case 5:
                    return "V";
                    break;
                case 6:
                    return "VI";
                    break;
                case 7:
                    return "VII";
                    break;
                case 8:
                    return "VIII";
                    break;
                case 9:
                    return "IX";
                    break;
                case 10:
                    return "X";
                    break;
                case 11:
                    return "XI";
                    break;
                case 12:
                    return "XII";
                    break;
            }
        }

        public static function Uang($uang) 
        {
            $rp = "";
            $digit = strlen($uang);
            while ($digit > 3) {
                $rp = "." . substr($uang, -3) . $rp;
                $lebar = strlen($uang) - 3;
                $uang = substr($uang, 0, $lebar);
                $digit = strlen($uang);
            }
            $rp = $uang . $rp . ",-";
            return $rp;
        }
    }