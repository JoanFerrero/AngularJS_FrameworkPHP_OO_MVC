<?php
    class home_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function select_data_carousel($db) { 
            $sql = "SELECT * FROM brand";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_data_categoria($db) { 
            $sql = "SELECT * FROM categories LIMIT 3";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_data_type($db) { 
            $sql = "SELECT * FROM type LIMIT 3";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        } 
    }
