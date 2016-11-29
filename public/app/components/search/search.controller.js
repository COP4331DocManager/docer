(function(){

    'use strict';
    var app = angular.module('app.search');

    app.controller('SearchController',SearchController );

    SearchController.$inject = ['$scope', '$http'];

    function SearchController($scope, $http){
        $http.get('/api/home')
                .success(function (data) {
                    $scope.data = data;
                    $scope.slides = data['documents'];
                       $scope.getSlide = function(slideIndex){
                                console.log(slideIndex);
                                console.log($scope.slides[$scope.current.slide]);
                                return $scope.slides[$scope.current.slide];
                        };
            }).error(function (data) {
              $scope.data = "SHEEEET";
            });   
        
    };
    
})();
