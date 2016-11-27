(function(){
    var app = angular.module('app.admin.doc');

    app.controller("DocReadController", DocReadController);
    
    DocReadController.$inject = ['$scope', 'AdminDocService'];

    function DocReadController($scope, AdminDocService){
        var readCtrl = this;
        
        this.search = function() {
            AdminDocService.readDoc(readCtrl.docid).then(function(data){
                readCtrl.image = "/api/document/" + readCtrl.docid;
                readCtrl.groupid = data[0].group_id;
                readCtrl.metaTags = data[0].metaTags;
            });
        };
   }
})();
