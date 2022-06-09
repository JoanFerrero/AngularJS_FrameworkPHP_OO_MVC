app.factory('services_search', ['services', '$rootScope', function(services, $rootScope) {
    let service = {search_category: search_category, search_brand: search_brand, search_autocomplete: search_autocomplete, search: search};
    return service;

    function search_category() {
        services.post('search', 'categoria')
        .then(function(data) {
            $rootScope.categorys_search = data;
        }, function() {
            console.log('error');
        });
    }

    function search_brand(category = undefined) {
        console.log(category);
        if(category == undefined) {
            console.log('undefined');
        } else {
            services.post('search', 'brand', {category: category})
            .then(function(data) {
                console.log(data);
                $rootScope.brands_search = data;
            }, function() {
                console.log('error');
            });
        }
    }

    function search_autocomplete(category = undefined, brand = undefined, autocomplete = undefined){        
        if(autocomplete != "") {
            services.post('search', 'autocomplete', {category: category, brand: brand, autocomplete: autocomplete})
            .then(function(data) {
                console.log(data);
                $rootScope.autocoms = data;
            }, function() {
                console.log('error');
            });
        }
    }

    function search(category = undefined, brand = undefined, autocomplete = undefined) {
        if(category || brand || autocomplete != undefined && autocomplete != ""){
            var filters = [];
        }

        if(category){
            filters.push(["category_search", category]);
        }
        if(brand){
            filters.push(["brand_search", brand]);
        }
        if(autocomplete != undefined && autocomplete != ""){ 
            filters.push(["autocomplete_search", autocomplete]);     
        }
        
        if(filters){
            localStorage.setItem("filters_search", JSON.stringify(filters));
            location.href = "#/shop/";
        }
    }
}]);