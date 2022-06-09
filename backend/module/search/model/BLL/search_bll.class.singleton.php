<?php
	class search_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = search_dao::getInstance();
			$this->db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_categoria_BLL() {
			return $this -> dao -> select_categoria($this->db);
		}

        public function get_brand_BLL($args) {
			return $this -> dao -> select_brand_category($this->db, $args);
        }

		public function get_auto_BLL($args) {
			if($args[0] == null && $args[1] == null) {
				return $this -> dao -> select_auto($this->db, $args[2]);
			} if ($args[0] != null && $args[1] == null) {
				return $this -> dao -> select_auto_category($this->db, $args[0], $args[3]);
			} else {
				return $this -> dao -> select_auto_category_brand($this->db, $args[0], $args[1], $args[2]);
			}
			//return $this -> dao -> select_auto($this->db, $args);
		}
    }
?>