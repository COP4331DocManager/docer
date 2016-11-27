(function(){

    'use strict';
    var app = angular.module('app.search');

    app.controller('SearchController',SearchController );

    SearchController.$inject = ['$scope', 'Restangular', 'HomeInfo', 'HomeData'];

    function SearchController($scope){
        console.log("Useless right now")   
    }

})();
