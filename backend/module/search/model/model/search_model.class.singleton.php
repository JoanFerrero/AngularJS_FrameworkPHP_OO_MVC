<?php
    class search_model {
        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = search_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_categoria() {
            return $this -> bll -> get_categoria_BLL();
        }

        public function get_brand($args) {
            return $this -> bll -> get_brand_BLL($args);
        }

        public function get_autocomplete($args) {
            return $this -> bll -> get_auto_BLL($args);
        }
    }