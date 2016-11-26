(function(){
    var app = angular.module('app.upload');
    
    app.directive("upload", function(){
        return{
            restrict: 'E',
            templateUrl: "/app/components/upload/directives/uploadView.html",
            controller: "UploadController",
            controllerAs: "uploadCtrl"
        };
    })
})();