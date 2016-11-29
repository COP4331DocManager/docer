(function(){

    'use strict';
    var app = angular.module('app.search');

    app.controller('SearchController',SearchController );

    SearchController.$inject = ['$scope', '$http'];

    function SearchController($scope, $http){
        $scope.current = {};
        $scope.current.slide = 0;
        
        $scope.getSlide = function(slideIndex){
            return $scope.searchResults[$scope.current.slide];
        };
    };
    
})();
