<?php
    class shop_model {
        private $bll;
        static $_instance;

        function __construct() {
            $this -> bll = shop_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_list_products() {
            return $this -> bll -> get_allCars_BLL();
        }

        public function get_list_filtersHome_products($args) {
            return $this -> bll -> get_CarsFiltersHome_BLL($args);
        }

        public function get_list_filtersShop_products($args) {
            return $this -> bll -> get_CarsFiltersShop_BLL($args);
        }

        public function get_list_filtersSearch_products($args){
            return $this -> bll -> get_CarsFiltersSearch_BLL($args);
        }

        public function get_details($args) {
            return $this -> bll -> get_details_BLL($args);
        }

        public function get_more_related($args){
            return $this -> bll -> get_more_related_BLL($args);
        }

        // public function get_pagination() {
        //     return $this -> bll -> get_pagination_BLL();
        // }

        // public function get_pagination_filters($args) {
        //     return $this -> bll -> get_pagination_filters_BLL($args);
        // }

        // public function get_count_more_related($args){
        //     return $this -> bll -> get_count_more_related_BLL($args);
        // }

        // public function get_count_search_menu($args) {
        //     return $this -> bll -> get_count_search_menu_BLL($args);
        // }

        public function get_load_like($args){
            return $this -> bll -> get_load_like_BLL($args);
        }

        public function get_click_like($args) {
            return $this -> bll -> get_click_like_BLL($args);
        }
    }
?>