(function(){
    var app = angular.module('app.admin.doc');

    app.controller("ReadController", ReadController);
    
    ReadController.$inject = ['$scope', 'AdminDocService'];

    function ReadController($scope, AdminDocService){
        
        this.search = function() {
            AdminDocService.readUser(this.userid).then(function(data){
                $scope.name = data.name;
                $scope.email = data.email;
                $scope.create = data.created_at;
                $scope.update = data.updated_at;
            });
        };
   }
})();
