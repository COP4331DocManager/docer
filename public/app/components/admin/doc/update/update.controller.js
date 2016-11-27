(function(){
    var app = angular.module('app.admin.doc');

    app.controller("UpdateController", UpdateController);
    
    UpdateController.$inject = ['$scope', 'AdminDocService'];

    function UpdateController($scope, AdminDocService){
        
        this.search = function() {
            AdminDocService.readUser(this.userid).then(function(data){
                $scope.name = data.name;
                $scope.email = data.email;
                $scope.create = data.created_at;
                $scope.update = data.updated_at;
            });
        };
        
        this.update = function() {
            console.log($scope.name);
            console.log($scope.email);
            AdminDocService.updateUser(this.userid, $scope.name, $scope.email).then(function(data){
                $scope.message = data;
            });
        };
   }
})();
