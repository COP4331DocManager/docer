(function(){
    //https://stackoverflow.com/questions/37042775/file-upload-with-other-data-in-angularjs-with-laravel
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.upload');

    app.controller('UploadController', UploadController);

    UploadController.$inject = ['$rootScope', '$scope', 'Restangular'];


    function UploadController($rootScope, $scope, Restangular){

        //https://stackoverflow.com/questions/37042775/file-upload-with-other-data-in-angularjs-with-laravel
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
            // Only remove if there are more than 1.
            if($scope.metaTags.length-1 >= 1)
            {
                var lastItem = $scope.metaTags.length-1;
                $scope.metaTags.splice(lastItem);
            }
        };

        $scope.uploadFile = function () {
            var f = document.getElementById('file').files[0],
              r = new FileReader();
            r.onloadend = function(e){
                var data = e.target.result;
                var upload = Restangular.all('document');
               upload.post(data);
                //send your binary data via $http or $resource or do anything else with it

            }
            r.readAsBinaryString(f);
        
        };

    }

})();
