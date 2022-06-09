<?php
    class shop_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function allcars($db) {
            $sql = "SELECT c.id, c.province, c.fecha, c.price, b.brand_name, m.model_name, t.type_name, ca.category_name, c.img_car, c.kilometres, c.lat, c.lon
                        FROM cars c
                        INNER JOIN brand b
                        ON b.id_brand=c.id_brand
                        INNER JOIN model m
                        ON m.id_model=c.id_model
                        INNER JOIN type t
                        ON t.id_type=c.id_type
                        INNER JOIN categories ca
                        ON ca.id_category=c.id_category ORDER BY count DESC";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function onecar($db, $id) {
            $sql = "SELECT c.id, b.brand_name, m.model_name, c.price, c.province, c.town, c.puertas, c.lat, c.lon, c.fecha, ca.category_name
                        FROM cars c
                        INNER JOIN brand b
                        ON b.id_brand=c.id_brand
                        INNER JOIN model m
                        ON m.id_model=c.id_model
                        INNER JOIN type t
                        ON t.id_type=c.id_type
                        INNER JOIN categories ca
                        ON ca.id_category=c.id_category
                        where c.id='$id'" ;
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        
        function update_count($db, $id) {
            $sql = "UPDATE cars c SET c.count = c.count + 1 WHERE c.id=" . $id;
    
            $db->ejecutar($sql);
            return;
        }

        function img_car($db, $id) {
            $sql = "SELECT * FROM img i
                    WHERE id_img ='$id'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function all_cars_filters($db, $WHERE){
            
            $sql = "SELECT c.id, c.province, c.fecha, c.price, b.brand_name, m.model_name, t.type_name, ca.category_name, c.img_car, c.kilometres, c.lat, c.lon
                        FROM cars c
                        INNER JOIN brand b
                        ON b.id_brand=c.id_brand
                        INNER JOIN model m
                        ON m.id_model=c.id_model
                        INNER JOIN type t
                        ON t.id_type=c.id_type
                        INNER JOIN categories ca
                        ON ca.id_category=c.id_category " . $WHERE;
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function count_cars_filters($db, $WHERE){
            $sql = "SELECT COUNT(*) AS n_cars
                    FROM cars c
                    INNER JOIN brand b
                    ON b.id_brand=c.id_brand
                    INNER JOIN model m
                    ON m.id_model=c.id_model
                    INNER JOIN type t
                    ON t.id_type=c.id_type
                    INNER JOIN categories ca
                    ON ca.id_category=c.id_category " . $WHERE;
    
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function sql_query_filtersHome($args){


            $WHERE= "";

            if($args[0][0] == "id_brand") {
                $WHERE= "WHERE c.id_brand=" . $args[0][1];
            }
            if($args[0][0] == "id_category") {
                $WHERE= "WHERE c.id_category=" . $args[0][1];
            }
            if($args[0][0] == "id_type") {
                $WHERE= "WHERE c.id_type=" . $args[0][1];
            }

            return $WHERE;
        }

        function sql_query_filtersShop($args) {

            $WHERE= "";
            $num = 0;
            for ($i=0; $i < count($args); $i++){
                if($num == 0) {
                    if($args[$i][0] == "brand") {
                        $WHERE= $WHERE ." WHERE c.id_brand=" . $args[$i][1];
                        $num ++;
                    }
                    if($args[$i][0] == "kilometres") {
                        $WHERE= $WHERE ." WHERE c.kilometres <= " . $args[$i][1];
                        $num ++;
                    }
                    if($args[$i][0] == "combustible") {
                        $WHERE= $WHERE ." WHERE c.id_type=" . $args[$i][1];
                        $num ++;
                    }
                    if($args[$i][0] == "change") {
                        $WHERE= $WHERE ." WHERE c.id_setting=" . $args[$i][1];
                        $num ++;
                    }
                } else if($num == 1){
                    if($args[$i][0] == "brand") {
                        $WHERE= $WHERE .  " AND c.id_brand=" . $args[$i][1];
                    }
                    if($args[$i][0] == "kilometres") {
                        $WHERE= $WHERE .  " AND c.kilometres <= " . $args[$i][1];
                    }
                    if($args[$i][0] == "combustible") {
                        $WHERE= $WHERE .  " AND c.id_type=" . $args[$i][1];
                    }
                    if($args[$i][0] == "change") {
                        $WHERE= $WHERE .  " AND c.id_setting=" . $args[$i][1];
                    }
                }
            }

            for ($i=0; $i < count($args); $i++){
                if($args[$i][0] == "order") {
                    if($args[0][1] == 1) {
                        $WHERE= $WHERE ." ORDER BY price DESC";
                    } else if($args[0][1] == 2) {
                        $WHERE= $WHERE . " ORDER BY kilometres DESC";
                    }
                }
            }
            return $WHERE;
        }

        function sql_query_filtersSearch($args){
            $num = 0;
            $WHERE= "";
            for ($i=0; $i < count($args); $i++){
                if($args[$i][0] == 'category_search'){
                    if($num == 0) {
                        $WHERE = $WHERE . "WHERE ca.category_name=" . "'" . $args[$i][1] . "'";
                        $num = 1;
                    }else{
                        $WHERE = $WHERE . " AND ca.category_name=" . "'" . $args[$i][1] . "'";
                    }
                }

                if($args[$i][0] == 'brand_search'){
                    if($num == 0) {
                        $WHERE = $WHERE . "WHERE b.brand_name=" . "'" . $args[$i][1] . "'";
                        $num = 1;
                    }else{
                        $WHERE = $WHERE . " AND b.brand_name=" . "'" . $args[$i][1] . "'";
                    }
                }

                if($args[$i][0] == 'autocomplete_search'){
                    if($num == 0) {
                        $WHERE = $WHERE . "WHERE c.town=" . "'" . $args[$i][1] . "'";
                        $num = 1;
                    }else{
                        $WHERE = $WHERE . " AND c.town=" . "'" . $args[$i][1] . "'";
                    }
                }
            }
            return $WHERE;
        }

        function select_pagination($db){
            $sql = "SELECT COUNT(*) AS n_cars FROM cars";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_search_menu($db, $WHERE){
            $sql = "SELECT COUNT(*) AS n_cars
                    FROM cars c
                    INNER JOIN brand b
                    ON b.id_brand=c.id_brand
                    INNER JOIN model m
                    ON m.id_model=c.id_model
                    INNER JOIN type t
                    ON t.id_type=c.id_type
                    INNER JOIN categories ca
                    ON ca.id_category=c.id_category " . $WHERE;
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_count_more_related($db,$id,$category){
            $sql = "SELECT COUNT(*) AS n_cars
                FROM cars c
                INNER JOIN brand b
                ON b.id_brand=c.id_brand
                INNER JOIN model m
                ON m.id_model=c.id_model
                INNER JOIN type t
                ON t.id_type=c.id_type
                INNER JOIN categories ca
                ON ca.id_category=c.id_category WHERE ca.category_name= '" . $category . "' AND c.id <>" . $id;

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_more_related($db,$id,$category){
            $sql = "SELECT c.id, c.province, c.fecha, c.price, b.brand_name, m.model_name, t.type_name, ca.category_name, c.img_car, c.kilometres, c.lat, c.lon
                FROM cars c
                INNER JOIN brand b
                ON b.id_brand=c.id_brand
                INNER JOIN model m
                ON m.id_model=c.id_model
                INNER JOIN type t
                ON t.id_type=c.id_type
                INNER JOIN categories ca
                ON ca.id_category=c.id_category WHERE ca.category_name='". str_replace(' ', '', $category) . "' AND c.id <>" . $id;
                
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_load_likes($db,$user){
            $sql = "SELECT l.id_vehiculo FROM likes l INNER JOIN users u on l.id_usuario=u.id_user WHERE u.username='$user'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);

        }

        function select_likes($db,$id,$user){
            $sql = "SELECT l.id_vehiculo, u.username, u.id_user FROM likes l INNER JOIN users u ON u.id_user=l.id_usuario WHERE u.username='$user' AND l.id_vehiculo=$id";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function insert_likes($db,$id,$user){
            $sql = "INSERT INTO likes (id_vehiculo, id_usuario) VALUES ($id,$user)";

            $db->ejecutar($sql);
            return 'like';
        }

        function delete_likes($db,$id,$user){
            $sql = "DELETE FROM likes WHERE id_usuario=$user AND id_vehiculo=$id";

            $db->ejecutar($sql);
            return 'unlike';
        }
    }