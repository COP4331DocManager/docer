(function(){
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.nav');

    app.controller("NavSearch", NavSearch);

    NavSearch.$inject = ['$rootScope', '$scope', '$http', '$location'];
    function NavSearch($rootScope, $scope, $http, $location)
    {
        
        $rootScope.searchQuery = ""; //initialize at start
        
        this.search = function ()
        {
            $http.post('/api/search', $rootScope.searchQuery)
                .success(function(data){
                    $rootScope.searchResults = data;
                    $location.path('/search');
                }).error(function (data) {
                    $rootScope.searchResults = "ERROR";
                    $location.path('/search');
            }); 
        }

    }

})();
