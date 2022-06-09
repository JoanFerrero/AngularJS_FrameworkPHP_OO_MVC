<?php
    class common {
        public static function load_error() {
            require_once (VIEW_PATH_INC . 'top_page.php');
            require_once (VIEW_PATH_INC . 'header.php');
            require_once (VIEW_PATH_INC . 'error404.html');
            require_once (VIEW_PATH_INC . 'footer.html');
        }
        
        public static function load_view($topPage, $view) {
            $topPage = VIEW_PATH_INC . $topPage;
            if ((file_exists($topPage)) && (file_exists($view))) {
                require_once ($topPage);
                require_once (VIEW_PATH_INC . 'header.html');
                require_once (VIEW_PATH_INC . 'menu.html');
                require_once ($view);
                require_once (VIEW_PATH_INC . 'footer.html');
            }else {
                echo "error";
                self::load_error();
            }
        }

        public static function load_model($model, $function = null, $args = null) {
            $dir = explode('_', $model);
            $path = constant('MODEL_' . strtoupper($dir[0])) .  $model . '.class.singleton.php';
                if (file_exists($path)) {
                    require_once ($path);
                    if (method_exists($model, $function)) {
                        $obj = $model::getInstance();
                        if ($args != null) {
                            return call_user_func(array($obj, $function), $args);
                        }
                        return call_user_func(array($obj, $function));
                    }
                }
            throw new Exception();
        }

        public static function generate_token_secure($longitud){
            if ($longitud < 4) {
                $longitud = 4;
            }
            return bin2hex(openssl_random_pseudo_bytes(($longitud - ($longitud % 2)) / 2));
        }
    }
?>