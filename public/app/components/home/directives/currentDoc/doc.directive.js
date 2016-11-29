(function(){

 var app = angular.module('app.home');

	//controls the groups assigned to a user and how they are displayed
    app.directive('docInfo', function(){
		return{
			restrict: 'E',
			templateUrl: "/app/components/home/directives/currentDoc/docView.html"
		};
	});

})();
