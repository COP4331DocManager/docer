(function(){
    var app = angular.module('app.account');

    app.controller("AccountController", AccountController);
    
    AccountController.$inject = ['$scope', 'AdminUserService', '$http'];

    function AccountController($scope, AdminUserService, $http){
        
        this.update = function() {
            var name = $scope.globals.currentUser.user.name;
            var email = $scope.globals.currentUser.user.email;
            var id = $scope.globals.currentUser.user.id;
            var pass = this.pass;
            
            $http.post('/api/update-user', { id: id, name: name, email: email, pass: pass})
                .success(function (data) {
                    alert("success")
                })
                .error(function () {
                    alert("Error");
                });
        };
   }
})();
