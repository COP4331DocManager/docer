(function(){
    var app = angular.module('app.admin.user');

    app.directive("userDestroy", function(){
        return{
            restrict: 'E',
            scope: {show: '='},
            templateUrl: "/app/components/admin/user/destroy/destroyView.html",
            controller: 'DestroyController',
            controllerAs: "destroyCtrl"
        };
    })
})();
