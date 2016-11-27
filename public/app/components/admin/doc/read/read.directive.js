(function(){
    var app = angular.module('app.admin.doc');

    app.directive("docRead", function(){
        return{
            restrict: 'E',
            scope: {show: '='},
            templateUrl: "/app/components/admin/doc/read/readView.html",
            controller: 'DocReadController',
            controllerAs: "readCtrl"
        };
    })
})();
