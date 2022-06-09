<?php
    class login_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function count_register_email($db, $email){
			$sql = "SELECT COUNT(u.email_user) AS count FROM users u WHERE u.email_user='". $email ."'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
		}

        function count_register_username($db, $username) {
            $sql = "SELECT COUNT(u.username) AS count FROm users u WHERE u.username='". $username ."'"; 

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function register_email($db, $email) {
            $sql = "SELECT * FROM users u WHERE u.email_user='". $email ."'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function insert_user($db, $username, $email, $hashed_pass, $avatar, $token){
            $sql ="INSERT INTO users (username, password_user, email_user, type_user, avatar_user, token_email,activate)
            VALUES ('$username','$hashed_pass','$email','client','$avatar', '$token', 0)";
            
            return $db->ejecutar($sql);
        }

        function select_user($db, $username){
            $sql = "SELECT * FROM users u WHERE u.username='$username'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_user_email($db, $email){
            $sql = "SELECT * FROM users u WHERE u.email_user='". $email ."'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function select_verify_email($db, $token_email) {
            $sql = "SELECT token_email FROM users WHERE token_email='$token_email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        function update_verify_email($db, $token_email) {
            $sql = "UPDATE users SET activate = 1, token_email='' WHERE token_email='$token_email'";
            
            return $db->ejecutar($sql);
        }

        function update_recovery ($db, $email, $password, $token) {
            $sql = "UPDATE users SET activate = 0, token_email='$token', password_user='$password' WHERE email_user='$email'";

            return $db->ejecutar($sql);
        }

        public function insert_social_login($db, $username, $email) {	
			$sql = "INSERT INTO users (username, email_user, type_user,activate)
            VALUES ('$username','$email','client', 1)";

			return $db->ejecutar($sql);
		}

        public function select_data_social_login($db, $email){
            $sql = "SELECT * FROM users u WHERE u.email_user='$email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_user_email_password($db, $email) {
            $sql = "SELECT `password_user` FROM users WHERE email_user='$email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    }