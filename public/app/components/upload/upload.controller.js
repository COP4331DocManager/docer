(function(){
    //https://stackoverflow.com/questions/37042775/file-upload-with-other-data-in-angularjs-with-laravel
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.upload');

    app.controller('UploadController', UploadController);

    UploadController.$inject = ['$rootScope', '$scope', 'Restangular', '$http'];


    function UploadController($rootScope, $scope, Restangular, $http){

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

        $scope.metaTags = [{name: '', value: ''}];

        $scope.addNewChoice = function() {
            $scope.metaTags.push({name: '', value: ''});
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
        
        $scope.uploadDocument = function() {
            $http({
                method  : 'POST',
                url     : '/api/document',
                processData: false,
                transformRequest: function (data) {
                    var formData = new FormData();
                    formData.append("user_upload", $scope.currentFile);  
                    formData.append("group", 1);
                    formData.append("metaTags", $scope.metaTags);
                    return formData;  
                },  
                headers: {
                    'Content-Type': undefined
                }
            }).success(function(data){
                alert("Success");
            }).error(function(data){
                alert("Something gone wrong");
            });
        }

        $scope.uploadedFile = function(element) {
            $scope.currentFile = element.files[0];
            var reader = new FileReader();
            
            reader.onload = function(event) {
                $scope.image_source = event.target.result
                $scope.$apply(function($scope) {
                    $scope.files = element.files;
                });
            }
            reader.readAsDataURL(element.files[0]);
        }

    }

})();
