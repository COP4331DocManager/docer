(function(){

 var app = angular.module('app.home');

	//controls the groups assigned to a user and how they are displayed
    app.directive('groupList', function(){
		return{
			restrict: 'E',
			templateUrl: "/app/components/home/directives/selectGroup/groupsView.html",
            controller: "HomeController",
            controllerAs:"vm"
		};
	});

})();
