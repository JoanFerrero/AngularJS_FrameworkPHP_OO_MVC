function protecturl(time) {
    var token = localStorage.getItem('token');
    if(token != null) {
        ajaxPromise('index.php?module=login&op=controluser', 
        'POST', 'JSON', {token: token})
        .then(function(result) {
            if (result=="ok"){
                if (time == 0){
                    toastr["warning"]("Debes realizar login");
                    time++;
                }
                setInterval(function(){
                    logout_control();
                }, 5000);
            }
        }).catch(function() {});
    }
}

function protecttime(time){
    var token = localStorage.getItem('token');
    if(token != null) {
        setInterval(function(){
            ajaxPromise('index.php?module=login&op=actividad', 
            'POST', 'JSON')    
            .then(function(result) {
                if(result=="inactivo"){
                    if (time == 0){
                        toastr["warning"]("Se va ha cerrar la cuenta por inactividad.");
                        time++;
                    }
                    setInterval(function(){
                        logout();
                    }, 5000);
                }
            }).catch(function() {});
        }, 600000);
    }    
}

function regeneratetoken(){
    var token = localStorage.getItem('token');
    if(token != null) {
        setInterval(function(){
            var token = localStorage.getItem('token');
            ajaxPromise('index.php?module=login&op=refresh_token', 
            'POST', 'JSON', {token: token})
            .then(function(result) {
                localStorage.setItem("token", result);
            }).catch(function() {});
        }, 600000);
    }
}

$(document).ready(function(){
    protecttime(time = 0);
	protecturl(time = 0);
    regeneratetoken();
});