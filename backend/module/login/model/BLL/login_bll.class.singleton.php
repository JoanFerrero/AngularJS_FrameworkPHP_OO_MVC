<?php
	class login_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = login_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_register_email_BLL($args) {
			return $this -> dao -> count_register_email($this->db, $args);
		}

		public function get_register_username_BLL($args) {
			return $this -> dao -> count_register_username($this->db, $args);
		}

		public function get_register_BLL($args) {
            $hashed_pass = password_hash($args[2], PASSWORD_DEFAULT, ['cost' => 6]);
            $hashavatar = md5(strtolower(trim($args[0]))); 
            $avatar = "https://robohash.org/$hashavatar";
			$token = common::generate_Token_secure(20);
			$this -> dao -> insert_user($this->db, $args[0], $args[1], $hashed_pass, $avatar, $token);
			return $token;
		}

		public function get_email_BLL($result, $args) {
			if($result){
				$message = [ 'type' => 'validate', 
							 'token' => $result, 
							 'toEmail' => $args[1]];
				$email = json_encode(mail::send_email($message), true);
				return $message;
			}else{
				return "fail";
			}
		}

		public function get_login_BLL($args) {
			$user = $this -> dao -> select_user($this->db, $args[0]);
			if (password_verify($args[1], $user[0]['password_user'])) {
				if($user[0]['activate']==1){
					$jwt = jwt_process::encode($user[0]['username'], $user[0]['id_user']);
					$_SESSION['user'] = $user[0]['username'];
					$_SESSION['tiempo'] = time();
					return $jwt;
				} else {
					return "notVerificate";
				}
			}
			return "error";
		}

		public function get_login_SL_BLL($args) {
			$user = $this -> dao -> select_user_email($this->db, $args);
			if ($user) {
				$jwt = jwt_process::encode($user[0]['username'], $user[0]['id_user']);
				$_SESSION['user'] = $user[0]['username'];
				$_SESSION['tiempo'] = time();
				return $jwt;
			}
			return "error";
		}

		public function get_social_login_BLL($args) {
			$id_user = $args['id'];
			$username = $args['username'];
			$email = $args['email'];
			
			if(!$this -> dao ->register_email($this ->db, $email)){
				if ($this -> dao -> insert_social_login($this->db, $username, $email)){
					$data = $this -> dao -> select_data_social_login($this->db, $email);
					$_SESSION['user'] = $username;
					$_SESSION['tiempo'] = time();
					$jwt = jwt_process::encode($username, $data[0]['id_user']);
					return $jwt;
				}
			} else {
				$data = $this -> dao -> select_data_social_login($this->db, $email);
				$jwt = jwt_process::encode($username, $data[0]['id_user']);
				$_SESSION['user'] = $username;
				$_SESSION['tiempo'] = time();
				return $jwt;
			}
		}

		public function get_data_user_BLL($args) {
			$jwt = jwt_process::decode($args);
			return $this -> dao -> select_user($this->db, $jwt['username']);
		}

		public function get_logout_BLL() {
			unset($_SESSION['user']);
			unset($_SESSION['tiempo']);
			return "Done";
		}

		public function get_controluser_BLL($args) {
			$jwt = jwt_process::decode($args);
			if (isset($_SESSION['user']) || $_SESSION['user'] == $jwt['username']){
                return "okey";
            } else if ($_SESSION['user'] != $jwt['username']){
                return "ok"; 
            }
		}

		public function get_actividad_BLL() {
			if(isset($_SESSION["user"])) {
				if (!isset($_SESSION["tiempo"])) {  
					return "inactivo";
				} else {  
					if((time() - $_SESSION["tiempo"]) >= 1800) {  
						return "inactivo";
					}else{
						return "activo";
					}
				}
			}else {
				return "null";
			}
		}

		public function get_refresh_token_BLL($args) {
			$jwt = jwt_process::decode($args);

			$user = $this -> dao -> select_user($this->db, $jwt['username']);

			$jwt = jwt_process::encode($user[0]['username'], $user[0]['id_user']);

			return $jwt;
		}

		public function get_verify_email_BLL($args) {
			if($this -> dao -> select_verify_email($this->db, $args)){
				$this -> dao -> update_verify_email($this->db, $args);
				return 'verify';
			}
			return 'fail';
		}

		public function get_email_recover_BLL($args) {
			$password = $this -> dao -> select_user_email_password($this->db, $args);
			if(!$password[0]['password_user']){
				return 'error_recover';
			} else {
				if($args){
					$message = [ 'type' => 'recover', 
								'token' => $args, 
								'toEmail' => $args];
					$email = json_encode(mail::send_email($message), true);
					return $email;
				}else{
					return "fail";
				}
			}
		}

		public function get_new_password_BLL($args) {
			$hashed_pass = password_hash($args[0], PASSWORD_DEFAULT, ['cost' => 6]);
			$token = common::generate_Token_secure(20);
			$this -> dao -> update_recovery($this ->db, $args[1], $hashed_pass, $token);
			return $token;
		}
    }