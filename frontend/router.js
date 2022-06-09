
var app = angular.module('AngularJS_FrameworkPHP_OO_MVC', ['ngRoute', 'toastr', 'ui.bootstrap']);

app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when("/home", {
            templateUrl: "frontend/module/home/view/home.html",
            controller: "controller_home",
            resolve: {
                carousel: function (services) {
                    return services.get('home','carousel');
                },
                categoria: function (services) {
                    return services.get('home','categoria');
                },
                type: function (services) {
                    return services.get('home','type');
                },
                books: function(services) {
                    return services.get_api('https://www.googleapis.com/books/v1/volumes?q=search+terms+cars');
                }
            }
        })//end home
        .when("/shop", {
            templateUrl: "frontend/module/shop/view/shop.html", 
            controller: "controller_shop",
            resolve: {
                cars: function (services) {
                    return services.get('shop','list_products');
                }
                
                //map_data: function (services) {
                //    return services.get('shop','list_products');
                //},
            }
        })//end shop
        .when("/product/:token", {
            templateUrl: "frontend/module/shop/view/shop.html", 
            controller: "controller_shop",
            resolve: {
                cars: function () {}
            }
        })//end product
        .when("/login", {
            templateUrl: "frontend/module/login/view/login.html", 
            controller: "controller_login"
        })//end login
        .when("/logout", {
            templateUrl: "frontend/module/login/view/login.html", 
            controller: "controller_login"
        })//end logout
        .when("/register", {
            templateUrl: "frontend/module/login/view/login.html",
            controller: "controller_login"
        })//end register
        .when("/verify/:token", {
            templateUrl: "frontend/module/login/view/login.html", 
            controller: "controller_login"            
        })//end verify
        .when("/recover", {
            templateUrl: "frontend/module/login/view/login.html",
            controller: "controller_login"
        })
        .when("/recover/:token", {
            templateUrl: "frontend/module/login/view/login.html",
            controller: "controller_login"            
        })//end recover
        .when("/contact", {
            templateUrl: "frontend/module/contact/view/contact_list.html",
            controller: "controller_contact"
        })//end contact
        .otherwise("/home");//end default 
}]);

app.run(function($rootScope, services, services_search, services_securitylogin){

    if(localStorage.token){
        $rootScope.show_login_menu = false;
        $rootScope.show_logout = true;
    } else {
        $rootScope.show_login_menu = true;
        $rootScope.show_logout = false;
    }

    if(localStorage.token){
        services_securitylogin.protecturl(time = 0);
        services_securitylogin.protecttime(time = 0);
        services_securitylogin.regeneratetoken()
    }

    services_search.search_category();

    $rootScope.click_brand = function(category){
        services_search.search_brand(category);
    }

    $rootScope.click_autocomplete = function(category = undefined, brand = undefined, autocomplete = undefined){
        services_search.search_autocomplete(category, brand, autocomplete);
    }

    $rootScope.click_search = function(category = undefined, brand = undefined, autocomplete = undefined) {
        services_search.search(category, brand, autocomplete);
    }
});


