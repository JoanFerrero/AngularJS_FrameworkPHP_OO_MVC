app.factory('services_shop', ['services', '$rootScope','services_maps', function(services, $rootScope, services_maps) {
    let service = {details: details,more_related:more_related,filter_Home: filter_Home, filters_shop: filters_shop, filters_Search: filters_Search, load_favs: load_favs, load_fav_details: load_fav_details, services_add_favs: services_add_favs, highlike: highlike};
    return service;

    function details(id) {
        services.post('shop', 'details', {id: id})
        .then(function(data) {
            $rootScope.list_products = data[0];
            $rootScope.list_products_imgs = data[1];
            localStorage.setItem('id_more_related', JSON.stringify(id));
            localStorage.setItem('category_more_related', JSON.stringify(data[0][0].category_name));
            more_related();
            services_maps.add_map_details(data);
            load_fav_details();
        }, function() {
            console.log('error');
        });
    }

    function more_related(num = undefined) {
        var cars_array = [];
        var cars_array1 = [];
        var id = localStorage.id_more_related;
        var category = localStorage.category_more_related;

        services.post('shop', 'more_related', {id: id.replace(/['"]+/g, ''), category: category.replace(/['"]+/g, '')})
        .then(function(data) {
            $rootScope.show_more_cars = true;
            $rootScope.Show_more_not_cars = false;
            for (let i = 0; i < data.length; i++) {
                cars_array.push(data[i]);
            }
            if(cars_array.length === 0){
                $rootScope.show_more_cars = false;
                $rootScope.Show_more_not_cars = false;
                $rootScope.more_relateds = cars_array;
            } else {
                if(num != undefined){
                    if(data.length == 2){
                        for(let j = 0; j < 2; j++) {
                            cars_array1.push(data[j]);
                        }
                        $rootScope.show_more_cars = false;
                        $rootScope.Show_more_not_cars = true;

                    }else{
                        for(let j = 0; j < num; j++) {
                            cars_array1.push(data[j]);
                        }
                    }
                }else{
                    for(let j = 0; j < 2; j++) {
                        cars_array1.push(data[j]);
                    }
                }
                $rootScope.more_relateds = cars_array1;
            }
        }, function() {
            console.log('error');
        });
    }

    function filter_Home(filters) {
        services.post('shop', 'list_filtersHome_products', {filters: filters})
        .then(function(data) {
            if(data == 0){
                $rootScope.show_list_product = false;
                $rootScope.show_not_products = true;
            } else {
                $rootScope.cars = data;
                services_maps.add_map(data);
                load_favs();
            }
        }, function() {
            console.log('error');
        });
    }

    function filters_shop(filters) {
        services.post('shop', 'list_filtersShop_products', {filters: filters})
        .then(function(data) {
            if(data == 0){
                $rootScope.show_list_product = false;
                $rootScope.show_not_products = true;
            } else {
                $rootScope.cars = data;
                services_maps.add_map(data);
                load_favs();
            }
            highlike(filters);
        }, function() {
            console.log('error');
        });
    }

    function highlike(filters){
        var filters_highlike = [];
        for (let i = 0; i < filters.length; i++) {
            filters_highlike.push(filters[i][0]);
        }   
        $rootScope.filtro_scope = filters_highlike;
        $rootScope.show_higtlike = true;
    }

    function filters_Search(filters) {
        services.post('shop', 'list_filtersSearch_products', {filters: filters})
        .then(function(data) {
            if(data == 0){
                $rootScope.show_list_product = false;
                $rootScope.show_not_products = true;
            } else {
                $rootScope.cars = data;
                services_maps.add_map(data);
                load_favs();
            }
        }, function() {
            console.log('error');
        });
    }

    function load_favs() {
        if(localStorage.token){
            services.post('shop', 'load_like', {token: localStorage.token})
            .then(function(data) {
                for(var i = 0; i < $rootScope.cars.length; i++){
                    $rootScope.cars[i].like = "fa-heart_like";
                    var product = $rootScope.cars[i];
                    for(var j = 0; j < data.length; j++){
                        if(data[j].id_vehiculo == product.id){
                            product.like = "fxa-heart_like";
                        };
                    }
                    $rootScope.cars[i].like = product.like;
                }
            }, function() {
                console.log('error');
            });
        } else {
            for(var k = 0; k < $rootScope.cars.length; k++){
                $rootScope.cars[k].like = "fa-heart_like";
            }
        }
    }

    function load_fav_details() {
        if(localStorage.token){
            services.post('shop', 'load_like', {token: localStorage.token})
            .then(function(data) {
                for(var i = 0; i < $rootScope.list_products.length; i++){
                    $rootScope.list_products[i].like = "fa-heart_like";
                    var product = $rootScope.list_products[i];
                    for(var j = 0; j < data.length; j++){
                        if(data[j].id_vehiculo == product.id){
                            product.like = "fxa-heart_like";
                        };
                    }
                    $rootScope.list_product[i].like = product.like;
                }
            }, function() {
                console.log('error');
            });
        } else {
            $rootScope.list_products[0].like = "fa-heart_like";
        }
    }

    function services_add_favs(id_car, token) {
        services.post('shop', 'click_like', {id: id_car, token: token})
        .then(function(data){
        }, function() {
            console.log('error');
        });
    }
}]);