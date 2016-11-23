(function(){

 var app = angular.module('app.group');


 	app.directive('notOwned', function(){
		return{
			restrict: 'E',
			templateUrl: "/app/components/group/manage/notOwned/notOwnedView.html",
            controller: 'GroupController',
            controllerAs: 'vm'

		};
	});

})();
