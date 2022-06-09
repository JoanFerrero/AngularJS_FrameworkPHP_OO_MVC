<?php
    class jwt_process {
        public static function encode($user, $id) {
            $jwt = parse_ini_file(MODEL_PATH . "jwt.ini", true);
            $header = $jwt['primera_sección']['header'];
            $secret = $jwt['primera_sección']['secret'];
            $payload = '{"iat":"'.time().'","exp":"'.time() + (60*60).'","username":"'.$user.'","id":"'.$id.'"}';
            $JWT = new jwt;
            $token = $JWT->encode($header, $payload, $secret);
            return $token; 
        }

        public static function decode($token) {
            $jwt = parse_ini_file(MODEL_PATH . "jwt.ini", true);
            $JWT = new jwt();
            $json = $JWT -> decode(preg_replace('/(^[\"\']|[\"\']$)/', '', $token), $jwt['primera_sección']['secret']);
            $json = json_decode($json, TRUE);
            return $json;
        }
    }