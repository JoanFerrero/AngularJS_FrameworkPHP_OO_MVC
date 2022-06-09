<?php
    class search_dao{
        static $_instance;

        private function __construct() {
        }
    
        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function select_categoria($db){
            $sql = "SELECT DISTINCT c.category_name FROM categories c";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_brand($db){
            $sql = "SELECT DISTINCT b.brand_name, b.id_brand
                    FROM cars c
                    INNER JOIN brand b
                    ON b.id_brand=c.id_brand
                    INNER JOIN categories ca";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_brand_category($db,$category){
            $sql = "SELECT DISTINCT b.brand_name, b.id_brand
                    FROM cars c
                    INNER JOIN brand b
                    ON b.id_brand=c.id_brand
                    INNER JOIN categories ca
                    ON c.id_category=ca.id_category
                    WHERE ca.category_name='" . $category . "'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_auto_category_brand($db, $category, $brand, $complet){
            $sql = "SELECT DISTINCT c.town 
                    FROM cars c
                    INNER JOIN categories ca
                    ON c.id_category = ca.id_category
                    INNER JOIN brand b 
                    ON c.id_brand = b.id_brand
                    WHERE b.brand_name = '" . $brand . "'
                    AND ca.category_name = '" . $category . "'
                    AND c.town LIKE '$complet%'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_auto_category($db, $category, $complet) {
            $sql = "SELECT DISTINCT c.town 
                    FROM cars c
                    INNER JOIN categories ca
                    ON c.id_category = ca.id_category
                    WHERE ca.category_name = '" . $category . "'
                    AND c.town LIKE '$complet%'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_auto($db, $complet){
            $sql = "SELECT DISTINCT c.town
                    FROM cars c
                    WHERE c.town LIKE '$complet%'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    }

?>