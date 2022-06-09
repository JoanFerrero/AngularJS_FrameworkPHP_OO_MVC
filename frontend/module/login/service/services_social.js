app.factory('services_social', ['services', '$rootScope', 'toastr', function(services, $rootScope, toastr) {
    let service = {initialize: initialize, social_login: social_login,google: google};
    return service;

    function initialize() {
        var config = {
            apiKey: "AIzaSyDUHGv52hvi-Jv4tmmn2if1FsBqYmCuFlo",
            authDomain: "testproject-bae1b.firebaseapp.com",
            projectId: "testproject-bae1b",
            storageBucket: "",
            messagingSenderId: "G-0370B3YPK5"
        };
        firebase.initializeApp(config);
    }

    function google(){

        let provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('email');
        let authService = firebase.auth();

        authService.signInWithPopup(provider)
        .then(function(result) {
            social_login({id:result.user.uid, username:result.user.displayName, email:result.user.email});
        })
        .catch(function(error) {
            console.log('Se ha encontrado un error:', error);
        });
    }

    function social_login(profile){
        services.post('login','social_login', {profile: profile})
        .then(function(data){
            console.log(data);
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
        }, function(){
            console.log('error');
        });
    }
}]);