<?php
class login_model {
    private $bll;
    static $_instance;
    
    function __construct() {
        $this -> bll = login_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get_register($args) {
        $result1 = $this -> bll -> get_register_email_BLL($args[1]);
        $result2 = $this -> bll -> get_register_username_BLL($args[0]);
        
        if($result1[0]['count']=="0" && $result2[0]['count']=="0"){
            $result =  $this -> bll -> get_register_BLL($args);
            return $this -> bll -> get_email_BLL($result, $args);
        } else {
            return 'error';
        }
    }

    public function get_login($args) {
        return $this -> bll -> get_login_BLL($args);
    }
    
    public function get_login_SL($args) {
        return $this -> bll -> get_login_SL_BLL($args);
    }

    public function get_social_login($args) {
        return $this -> bll -> get_social_login_BLL($args);
    }

    public function get_data_user($args) {
        return $this -> bll -> get_data_user_BLL($args);
    }

    public function get_logout() {
        return $this -> bll -> get_logout_BLL();
    }

    public function get_controluser($args) {
        return $this -> bll -> get_controluser_BLL($args);
    }

    public function get_actividad() {
        return $this -> bll -> get_actividad_BLL();
    }

    public function get_refresh_token($args) {
        return $this -> bll -> get_refresh_token_BLL($args);
    }

    public function get_verify_email($args) {
        $verify = $this -> bll -> get_verify_email_BLL($args);
        if (!empty($verify)) {
            return;
        }
    }

    public function get_recover_email($args) {
        $result1 = $this -> bll -> get_register_email_BLL($args);
        if($result1[0]['count']==1){
            return $this -> bll -> get_email_recover_BLL($args);
        }
        return 'error';
        
    }

    public function get_new_password($args) {
        $result = $this -> bll -> get_new_password_BLL($args);
        
        return $this -> bll -> get_email_BLL($result, $args);
    }
}
