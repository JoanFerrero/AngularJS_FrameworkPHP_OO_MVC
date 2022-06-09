app.controller('controller_contact', function($scope, services, toastr) {

    $scope.regName = /^[A-Za-z\s]{4,60}$/;
    $scope.regEmail = /^[A-Za-z0-9._-]{3,20}@[a-z]{3,6}.[a-z]{2,4}$/;
    $scope.regMatter = /^[A-Za-z-\s]{6,60}$/;
    $scope.regMessage = /^[A-Za-z0-9-\s.]{10,200}$/;
    
    $scope.sendEmail = function() {
        toastr.success('The email has been sended, you will receive an answer as soon as posible.' ,'Email sended');
    }// end_$sendEmail
});