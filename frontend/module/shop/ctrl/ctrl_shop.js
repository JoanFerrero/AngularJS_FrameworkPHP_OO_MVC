app.controller('controller_shop', function($scope, $rootScope, $route, $window, cars, services_shop, services_maps) {

    $scope.load_details = function() {
        location.href = "#/product/" + this.car.id;
    };

    $scope.filter_products = function(filter_Order, filter_Brand, filter_Kilometers, filter_Combustible, filter_Change) {
        var filters = [];

        if(filter_Order) {
            filters.push(['order', filter_Order]);
        }

        if(filter_Brand) {
            filters.push(['brand', filter_Brand]);
        }

        if(filter_Kilometers) {
            filters.push(['kilometres', filter_Kilometers]);
        }

        if(filter_Combustible) {
            filters.push(['combustible', filter_Combustible]);
        }

        if(filter_Change) {
            filters.push(['change', filter_Change]);
        }
        console.log(filters);        
        localStorage.setItem('filters', JSON.stringify(filters));
        $route.reload();
    }

    $scope.add_favs = function(){
        if(localStorage.token){
            let path_like = $route.current.originalPath.split('/');
            if(path_like[1] == 'shop'){
                services_shop.services_add_favs(this.car.id, localStorage.token);

                if(this.car.like == "fxa-heart_like"){
                    this.car.like = "fa-heart_like";
                }else{
                    this.car.like = "fxa-heart_like";
                }
            } else {
                services_shop.services_add_favs(this.list_product.id, localStorage.token);

                if(this.list_product.like == "fxa-heart_like"){
                    this.list_product.like = "fa-heart_like";
                }else{
                    this.list_product.like = "fxa-heart_like";
                }
            }
        } else {
            location.href = "#/login";
        }
    }

    let path = $route.current.originalPath.split('/');
    if(path[1] === 'shop'){
        localStorage.setItem('zone', 'shop');
        $rootScope.show_list_product = true;
        $scope.show_list_filters = true;
        $scope.show_details = false;
        $rootScope.show_not_products = false;
        if(localStorage.filters_home){
            var local = JSON.parse(localStorage.filters_home);
            localStorage.removeItem('filters_home');
            services_shop.filter_Home(local);
            services_shop.load_favs();
        }else if(localStorage.filters_search){
            var local = JSON.parse(localStorage.filters_search);
            localStorage.removeItem('filters_search');
            services_shop.filters_Search(local);
            services_shop.load_favs();
        }else if(localStorage.filters){
            var local = JSON.parse(localStorage.filters);
            services_shop.filters_shop(local);
        }else{
            if(cars == 0){
                $rootScope.show_not_products = true;
            } else {
                $rootScope.cars = cars;
                services_maps.add_map(cars);
                services_shop.load_favs();
            }
        }
    } else if(path[1] === 'product'){
        localStorage.setItem('zone', $route.current.params.token);
        $rootScope.show_list_product = false;
        $scope.show_list_filters = false;
        $scope.show_details = true;
        services_shop.details($route.current.params.token);
    }

    $scope.more = function() {
        services_shop.more_related(4);
    }

    $scope.filter_remove = function(){
        localStorage.removeItem('filters');
        $rootScope.show_higtlike = false;
        $window.location.reload();
    }
})