(function(){
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.home');

    app.controller('HomeController', HomeController);

    HomeController.$inject = ['$rootScope', '$scope', 'Restangular', 'HomeInfo', 'HomeData'];
    function HomeController($rootScope, $scope, Restangular, HomeInfo, HomeData){
        
        
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
        
        var data = {
            "groups": [
              {
              "id": 1,
              "name": "memes",
              "members": [
                {
                  "id": 1,
                  "name": "Shitfuck"
                },
                {
                  "id": 2,
                  "name": "Asshole"
                }
              ] 
                },
                {
              "id": 2,
              "name": "Trump",
              "members": [
                {
                  "id": 2,
                  "name": "Donkey Fucker"
                },
                {
                  "id": 3,
                  "name": "Mountain Goat of Anal Destruction"
                }
              ]
            }
              ],
              "documents": [
                {
                  "document_id": 13,
                  "group_id": 1,
                  "metaTags": []
                },
                {
                  "document_id": 14,
                  "group_id": 1,
                  "metaTags": [
                    {
                      "name": "name",
                      "value": "Wv8QdXY.jpg"
                    }
                  ]
                },
                {
                  "document_id": 33,
                  "group_id": 1,
                  "metaTags": [
                    {
                      "name": "name",
                      "value": "security-101-book-e1477949975330.jpg"
                    }
                  ]
                },
                {
                  "document_id": 40,
                  "group_id": 1,
                  "metaTags": [
                    {
                      "name": "name",
                      "value": "tiny_hippo.png"
                    }
                  ]
                }
              ]
            };
            
            this.groups = data['groups'];
            this.documents = data['documents']
        
            HomeData.addData(data);

    }

})();
