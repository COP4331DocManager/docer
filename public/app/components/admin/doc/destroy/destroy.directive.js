(function(){
    var app = angular.module('app.admin.doc');

    app.directive("docDestroy", function(){
        return{
            restrict: 'E',
            scope: {show: '='},
            templateUrl: "/app/components/admin/doc/destroy/destroyView.html",
            controller: 'DestroyController',
            controllerAs: "destroyCtrl"
        };
    })
})();
