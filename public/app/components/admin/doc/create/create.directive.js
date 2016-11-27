(function(){
    var app = angular.module('app.admin.doc');

    app.directive("docCreate", function(){
        return{
            restrict: 'E',
            scope: {show: '='},
            templateUrl: "/app/components/admin/doc/create/createView.html",
            controller: 'DocCreateController',
            controllerAs: "createCtrl"
        };
    })
})();
