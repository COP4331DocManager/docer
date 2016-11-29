(function(){
    var app = angular.module('app.nav');
    
   app.directive('navSearch', function(){
        return{
            restrict: 'E',
            templateUrl: "/app/shared/navigation/directives/navSearch/navSearch.html",
            controller: "NavSearch",
            controllerAs: "navSearch"
        };
    });

})();