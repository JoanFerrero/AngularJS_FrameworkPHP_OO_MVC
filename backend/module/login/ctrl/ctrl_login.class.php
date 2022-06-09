<?php
    class ctrl_login {
        function login() {
            echo json_encode(common::load_model('login_model', 'get_login', [$_POST['username'], $_POST['password']]));
        }

        function login_SL() {
            echo json_encode(common::load_model('login_model', 'get_login_SL', $_POST['email']));
        }

        function social_login() {
            echo json_encode(common::load_model('login_model', 'get_social_login', $_POST['profile']));
        }
    
        function register() {
            echo json_encode(common::load_model('login_model', 'get_register', [$_POST['username'], $_POST['email'], $_POST['password']]));
        }

        function verify_email() {
            echo json_encode(common::load_model('login_model', 'get_verify_email', $_POST['token']));
        }

        function send_recover_email() {
            echo json_encode(common::load_model('login_model', 'get_recover_email', $_POST['email']));
        }

        function new_password() {
            echo json_encode(common::load_model('login_model', 'get_new_password', [$_POST['password'], $_POST['email']]));
        }  
    
        function logout() {
            echo json_encode(common::load_model('login_model', 'get_logout'));
        } 

        function data_user() {
            echo json_encode(common::load_model('login_model', 'get_data_user', $_POST['token']));
        }

        function controluser() {
            echo json_encode(common::load_model('login_model','get_controluser', $_POST['token']));
        }

        function actividad() {
            echo json_encode(common::load_model('login_model','get_actividad'));
        }

        function refresh_token() {
            echo json_encode(common::load_model('login_model','get_refresh_token', $_POST['token']));
        }
    }
    
?>