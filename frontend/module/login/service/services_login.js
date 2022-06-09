app.factory('services_login', ['services', '$rootScope', 'toastr', function(services, $rootScope, toastr) {
    let service = {service_login: service_login, services_logout: services_logout, service_register: service_register,verify_email: verify_email, service_recover: service_recover, service_recover_password:service_recover_password};
    return service;

    function service_login(username, password) {
        services.post('login', 'login', {username: username, password: password})
        .then(function(data) {
            if(data != '"error"'){
                localStorage.setItem('token', data);
                var zone = localStorage.getItem('zone');
                if (zone == "shop"){
                    location.href = "#/" + zone;
                } else if(zone == "home"){
                    location.href = "#/" + zone;
                }else{
                    location.href = "#/product/" + zone;
                }
                window.location.reload();
            } else {
                toastr.info("This account doesn't exist.");
            }
        }, function() {
            console.log('error');
        });
    }

    function services_logout() {
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

    function service_register(username, password, email){
        services.post('login','register', {username: username, email: email, password: password})
        .then(function(data){
            if(data == '"error"'){
                toastr.info("This email or name is used.");
            } else {
                location.href = "#/login ";
            }
        }, function(){
            console.log('error');
        })
    }

    function verify_email(token){
        services.post('login', 'verify_email',{token: token})
        .then(function(data){
            location.href = "#/login ";
        }), function(){
            console.log('error');
        }
    }

    function service_recover(email){
        services.post('login','send_recover_email', {email: email})
        .then(function(data){
            console.log(data);
            if(data == '"error"'){
                toastr.info("This email not registered.");
            } else{
                toastr.info("This email is send.");
            }
        }, function(){
            console.log('error');
        })
    }

    function service_recover_password(password, email){
        services.post('login','new_password', {password: password, email: email})
        .then(function(data){
            location.href = "#/login ";
        }, function(){
            console.log('error');
        })
    }
}]);
