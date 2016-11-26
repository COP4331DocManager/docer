(function(){
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.upload');

    app.controller('UploadController', UploadController);

    UploadController.$inject = ['$rootScope', '$scope', 'Restangular', 'HomeInfo', 'HomeData'];
    function UploadController($rootScope, $scope, Restangular, HomeInfo, HomeData){
        
        
         Restangular.all('test').getList().then(function(response) {
            var plain = response.plain();
            $scope.slides = plain;
            //console.log("carousel rest: ", plain);
        });


        HomeInfo.getData().then(function(data){
          console.log(data);
          var stuff = data;
          console.log(stuff)
          //HomeData.addData(data.groups);
          //console.log(HomeData.getGroups());
        });
    
   
    
        };
            
        }
        this.groups = data['groups'];
        this.documents = data['documents']
    
        HomeData.addData(data);

    }

})();
