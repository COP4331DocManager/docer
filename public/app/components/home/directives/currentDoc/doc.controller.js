(function(){

    'use strict';
    var app = angular.module('app.home');

    app.controller('GroupController', GroupController);

    GroupController.$inject = ['$scope', 'HomeData'];
    function GroupController($scope, HomeData){
        console.log("Useless right now")   
    }
      
  


})();
