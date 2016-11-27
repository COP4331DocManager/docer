(function(){

 var app = angular.module('app.search');

	//controls the groups assigned to a user and how they are displayed
    app.directive('searchCurrentDoc', function(){
		return{
			restrict: 'E',
			templateUrl: "/app/components/search/directives/currentDoc/currentDocView.html",
            controller: "SearchController",
            controllerAs:"searchCtrl"
		};
	});

})();
