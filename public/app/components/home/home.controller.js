(function(){
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.home');

    app.controller('HomeController', HomeController);

    HomeController.$inject = ['$rootScope', '$scope', 'Restangular', 'HomeInfo', 'HomeData','$http'];
    function HomeController($rootScope, $scope, Restangular, HomeInfo, HomeData, $http){

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

        


    }

})();
