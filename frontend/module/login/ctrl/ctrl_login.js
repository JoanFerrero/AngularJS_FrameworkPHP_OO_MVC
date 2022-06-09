app.controller('controller_login', function($scope, $route, $rootScope, toastr, services_login, services_social) {

    $scope.regex_username = /^[A-Za-z0-9._-]{5,15}$/;
    $scope.regex_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    $scope.regex_password = /^[A-Za-z0-9._-]{5,20}$/;

    if (!$rootScope.ini_social_login) {
        $rootScope.ini_social_login = 0;
    }
    if ($rootScope.ini_social_login == 0) {
        services_social.initialize();
        $rootScope.ini_social_login = 1;
    }

    $scope.login = function(){
        services_login.service_login($scope.username,$scope.password);
    }

    $scope.register = function(){
        services_login.service_register($scope.register_username,$scope.register_password, $scope.register_email);
    }

    $scope.recover = function(){
        services_login.service_recover($scope.recover_email);
    }    

    $scope.recover_password = function() {
        services_login.service_recover_password($scope.recover_PW, $route.current.params.token);
    }

    $scope.login_google = function() {
        services_social.google();
    }

    let path = $route.current.originalPath.split('/');
    if(path[1] === 'login') {
        $rootScope.show_login = true;
        $rootScope.show_register = false;
        $rootScope.show_recover = false;
        $rootScope.show_recoverpassword = false;
    }else if(path[1] === 'logout'){
        services_login.services_logout();
    } else if(path[1] === 'register'){
        $rootScope.show_register = true;
        $rootScope.show_login = false;
        $rootScope.show_recover = false;
        $rootScope.show_recoverpassword = false;
    }else if(path[1] === 'verify'){
        services_login.verify_email($route.current.params.token);
    }else if(path[1] === 'recover'){
        if($route.current.params.token) {
            $rootScope.show_recoverpassword = true;
            $rootScope.show_register = false;
            $rootScope.show_login = false;
            $rootScope.show_recover = false;
        } else {
            $rootScope.show_recover = true;
            $rootScope.show_register = false;
            $rootScope.show_login = false;
            $rootScope.show_recoverpassword = false;
        }
    }
})