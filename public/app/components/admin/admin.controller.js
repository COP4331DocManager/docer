(function(){
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.admin');

    app.controller('AdminPannelController', AdminPannelController);

    AdminPannelController.$inject = ['$scope', '$http'];
    function AdminPannelController($scope, $http){
        $http.get('/api/get-admin-page-info')
            .success(function (data) {
                $scope.running = data.running;
                $scope.total_user = data.total_user;
                $scope.total_doc = data.total_doc;
        }).error(function (data) {
            $scope.running = "Yes";
            $scope.total_user = 54;
            $scope.total_doc = 4324;
        });
    }
})();
