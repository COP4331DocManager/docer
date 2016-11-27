(function(){
    var app = angular.module('app.admin.doc');

    app.controller("DestroyController", DestroyController);
    
    DestroyController.$inject = ['$scope', 'AdminUserService'];

    function DestroyController($scope, AdminDocService){
        
        this.search = function() {
            AdminDocService.readUser(this.userid).then(function(data){
                $scope.name = data.name;
                $scope.email = data.email;
                $scope.create = data.created_at;
                $scope.update = data.updated_at;
            });
        };
        
        this.destroy = function() {
            AdminDocService.destroyUser(this.userid).then(function(data){
                $scope.message = data;
            });
        };
   }
})();
