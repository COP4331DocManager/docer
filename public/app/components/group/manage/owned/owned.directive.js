(function(){

 var app = angular.module('app.group');

 	app.directive('owned', function(){
		return{
			restrict: 'E',
			templateUrl: "/app/components/group/manage/ownedView.html",
            controller: 'GroupController',
            controllerAs: 'vm'

		};
	});

})();
