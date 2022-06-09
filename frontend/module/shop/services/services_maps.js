app.factory('services_maps', ['services', '$rootScope', function(services, $rootScope) {
    let service = {add_map: add_map, add_map_details: add_map_details};
    return service;

    function add_map(data) {
        
        mapboxgl.accessToken = 'pk.eyJ1Ijoiam9hbmZlcnJlcm8iLCJhIjoiY2t6eWhqb2VyMDBkYjNqcXBnaHN6MjB6bSJ9.zpFPnjEX0wwofE3XkiQvMw';
        const map = new mapboxgl.Map({
            container: 'maps',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-3.6949319255831123, 40.62639425934758],
            zoom: 4
        });

        for (row in data) {
            const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
                "<a href='#/product/"+data[row].id+"'>"+
                "<div class='details' id='"+ data[row].id +"'>"+
                "<img class='img_mapbox' src='frontend/"+ data[row].img_car+"'><h3 class='mt-TitleBasic-title_map '>"+ data[row].price+"&nbsp;€</h3>"+
                "<h2 class='mt-CardBasic-title data-testid='card-ad-title'>"+data[row].brand_name+" "+data[row].model_name+"</h2><ul class='mt-CardAd-attr'>"+
                "<li class='mt-CardAd-attrItem'>"+data[row].province+"</li><li class='mt-CardAd-attrItem'>"+data[row].category_name+"</li><li class='mt-CardAd-attrItem'>"+data[row].fecha+"</li>"+
                "</ul></div></div></div></div></div></a>"
            );

            const ubicacion0 = data[row].lon;
            const ubicacion1 =  data[row].lat;
            
            const market = new mapboxgl.Marker()
            .setLngLat([ubicacion0 , ubicacion1])
            .setPopup(popup)
            .addTo(map);
        }
    }

    function add_map_details(data) {

        mapboxgl.accessToken = 'pk.eyJ1Ijoiam9hbmZlcnJlcm8iLCJhIjoiY2t6eWhqb2VyMDBkYjNqcXBnaHN6MjB6bSJ9.zpFPnjEX0wwofE3XkiQvMw';
        const map1 = new mapboxgl.Map({
            container: 'maps_details',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [data[0][0].lon, data[0][0].lat],
            zoom: 4
        });

        
        const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
            "<div class='details' id='"+ data[0][0].id +"'>"+
            "<img class='img_mapbox' src='frontend/"+ data[1][0].img_car+"'><h3 class='mt-TitleBasic-title_map '>"+ data[0][0].price+"&nbsp;€</h3>"+
            "<h2 class='mt-CardBasic-title data-testid='card-ad-title'>"+data[0][0].brand_name+" "+data[0][0].model_name+"</h2><ul class='mt-CardAd-attr'>"+
            "<li class='mt-CardAd-attrItem'>"+data[0][0].province+"</li><li class='mt-CardAd-attrItem'>"+data[0][0].category_name+"</li><li class='mt-CardAd-attrItem'>"+data[0][0].fecha+"</li>"+
            "</ul></div></div></div></div></div>"
        );

        const ubicacion0 = data[0][0].lon;
        const ubicacion1 =  data[0][0].lat;
        
        const market = new mapboxgl.Marker()
        .setLngLat([ubicacion0 , ubicacion1])
        .setPopup(popup)
        .addTo(map1);
        
    }
}]);