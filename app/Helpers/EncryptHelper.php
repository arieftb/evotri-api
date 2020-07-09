<?php

namespace App\Helpers;

    class EncryptHelper
    {

        public function __construct()
        {
            //
        }

        public static function encryptPasword($password)
        {
            return password_hash($password, PASSWORD_BCRYPT);
        }
    }
?>