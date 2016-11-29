(function(){
    var app = angular.module('app.nav');
    
   app.directive('navigation', function(){
        return{
            restrict: 'E',
            templateUrl: "/app/shared/navigation/navView.html"
        };
    });

})();