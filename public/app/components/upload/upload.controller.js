(function(){
    //https://stackoverflow.com/questions/37042775/file-upload-with-other-data-in-angularjs-with-laravel
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.upload');

    app.controller('UploadController', UploadController);

    UploadController.$inject = ['$rootScope', '$scope', 'Restangular', '$http', 'AdminDocService'];


    function UploadController($rootScope, $scope, Restangular, $http, AdminDocService){

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
            AdminDocService.createDoc($scope.currentFile, 
                                      $scope.current.group.id, 
                                      $scope.metaTags).then(function(data){
                $scope.doc_upload_message = data;
                alert(data);
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
