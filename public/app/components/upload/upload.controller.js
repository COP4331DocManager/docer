(function(){
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.upload');

    app.controller('UploadController', UploadController);

    UploadController.$inject = ['$rootScope', '$scope'];


    function UploadController($rootScope, $scope){

        //
        //  Restangular.all('test').getList().then(function(response) {
        //     var plain = response.plain();
        //     $scope.slides = plain;
        //     //console.log("carousel rest: ", plain);
        // });
        //
        //
        // HomeInfo.getData().then(function(data){
        //   console.log(data);
        //   //HomeData.addData(data.groups);
        //   //console.log(HomeData.getGroups());
        // });

        $scope.metaTags = [{key: '', value: ''}];

        $scope.addNewChoice = function() {
            $scope.metaTags.push({key: '', value: ''});
        };

        // Remove key/value pair.
        $scope.removeChoice = function() {
            // Only remove
            if($scope.metaTags.length-1 >= 1)
            {
                var lastItem = $scope.metaTags.length-1;
                $scope.metaTags.splice(lastItem);
            }
        };

    }

})();
