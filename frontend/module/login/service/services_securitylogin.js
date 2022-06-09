app.factory('services_securitylogin', ['services', '$rootScope', 'toastr', function(services, $rootScope, toastr) {
    let service = { protecturl: protecturl, protecttime: protecttime, regeneratetoken: regeneratetoken};
    return service;

    function protecturl(time) {
        var token = localStorage.getItem('token');
        if(token != null) {
            services.post('login','controluser', {token: token})
            .then(function(data){
                if (data=="ok"){
                    if (time == 0){
                        toastr["warning"]("Debes realizar login");
                        time++;
                    }
                    setInterval(function(){
                        logout();
                    }, 5000);
                }
            }, function(){
                console.log('error');
            });
        }
    }

    //MVC OO 

    function protecttime(time){
        var token = localStorage.getItem('token');
        if(token != null) {
            setInterval(function(){
                services.post('login','actividad', {token: token})
                .then(function(data){
                    console.log(data);
                    //data = 'inactivo';
                    if(data=="inactivo"){
                        if (time == 0){
                            toastr["warning"]("Se va ha cerrar la cuenta por inactividad.");
                            time++;
                        }
                        setInterval(function(){
                            logout();
                        }, 5000);
                    }
                }, function(){
                    console.log('error');
                });
            }, 60000);
        }    
    }

    function regeneratetoken(){
        var token = localStorage.getItem('token');
        if(token != null) {
            setInterval(function(){
                services.post('login','refresh_token', {token: token})
                .then(function(data){
                    localStorage.setItem("token", data);
                }, function(){
                    console.log('error');
                });
            }, 60000);
        }
    }

    function logout(){
        localStorage.removeItem('token');
        var zone = localStorage.getItem('zone');
        if (zone == "shop"){
            location.href = "#/" + zone;
        } else if(zone == "home"){
            location.href = "#/" + zone;
        }else{
            location.href = "#/product/" + zone;
        }
        window.location.reload();
    }
}]);