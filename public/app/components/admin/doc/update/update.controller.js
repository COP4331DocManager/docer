(function(){
    var app = angular.module('app.admin.doc');

    app.controller("DocUpdateController", DocUpdateController);
    
    DocUpdateController.$inject = ['$scope', 'AdminDocService'];

    function DocUpdateController($scope, AdminDocService){
        var readCtrl = this;
        
        this.search = function() {
            AdminDocService.readDoc(readCtrl.docid).then(function(data){
                readCtrl.image = "/api/document/" + readCtrl.docid;
                readCtrl.groupid = data[0].group_id;
                $scope.metaTags = data[0].metaTags;
            });
        };
        
        this.update = function() {
            AdminDocService.updateDoc(readCtrl.docid, $scope.metaTags).then(function(data){
                $scope.message = data;
                alert(data);
            });
        };
   }
})();
