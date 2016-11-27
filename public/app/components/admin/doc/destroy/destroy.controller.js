(function(){
    var app = angular.module('app.admin.doc');

    app.controller("DocDestroyController", DocDestroyController);
    
    DocDestroyController.$inject = ['$scope', 'AdminDocService'];

    function DocDestroyController($scope, AdminDocService){
        
        var destroyCtrl = this;
        
        this.search = function() {
            AdminDocService.readDoc(destroyCtrl.docid).then(function(data){
                $scope.message = ""
                destroyCtrl.image = "/api/document/" + destroyCtrl.docid;
                destroyCtrl.groupid = data[0].group_id;
                destroyCtrl.metaTags = data[0].metaTags;
            });
        };
        
        this.destroy = function() {
            AdminDocService.destroyDoc(destroyCtrl.docid).then(function(data){
                 $scope.message = data;
                 alert(data);
            });
        };
   }
})();
