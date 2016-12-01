(function(){
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.home');

    app.controller('HomeController', HomeController);

    HomeController.$inject = ['$rootScope', '$scope', 'Restangular', 'HomeInfo', 'HomeData','$http', 'AdminDocService'];
    function HomeController($rootScope, $scope, Restangular, HomeInfo, HomeData, $http, AdminDocService){

      $http.get('/api/home')
            .success(function (data) {
                $scope.data = data;
                $scope.slides = data['documents'];
                   $scope.getSlide = function(slideIndex){
                            return $scope.slides[$scope.current.slide];
                    };
        }).error(function (data) {
          $scope.data = data;
        });

        
        this.update = function() {
            var pos = $scope.current.slide;
            var slide = $scope.slides[pos];
            
            AdminDocService.updateDoc(slide.document_id, slide.metaTags).then(function(data){
                $scope.message = data;
                alert(data);
            });
        };
        
        $scope.homeAddNewChoice = function() {
            $scope.slides[$scope.current.slide].metaTags.push({name: '', value: ''});
        };

        // Remove key/value pair.
        $scope.homeRemoveChoice = function() {
            // Only remove if there are more than 1.
            if($scope.slides[$scope.current.slide].metaTags.length-1 >= 1)
            {
                var lastItem = $scope.slides[$scope.current.slide].metaTags.length-1;
                $scope.slides[$scope.current.slide].metaTags.splice(lastItem);
            }
        };
        
    }

})();
