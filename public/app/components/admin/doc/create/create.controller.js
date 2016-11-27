(function(){
    var app = angular.module('app.admin.doc');

    app.controller("DocCreateController", DocCreateController);
    
    DocCreateController.$inject = ['$scope', '$http', 'AdminDocService'];

    function DocCreateController($scope, $http, AdminDocService){

        this.create = function() {
            AdminDocService.createDoc($scope.currentFile, 
                                      this.groupid, 
                                      $scope.metaTags).then(function(data){
                $scope.message = data;
            });
        };
        
        $scope.uploadedFile = function(element) {
            $scope.currentFile = element.files[0];
            var reader = new FileReader();
            
            reader.onload = function(event) {
                $scope.image_source = event.target.result
                $scope.$apply(function($scope) {
                    $scope.files = element.files;
                });
            }
            reader.readAsDataURL(element.files[0]);
        }

   }
})();