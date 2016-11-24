(function(){

 var app = angular.module('app.group');

	//controls the groups assigned to a user and how they are displayed
    app.directive('listGroups', function(){
		return{
			restrict: 'E',
			templateUrl: "/app/components/group/directives/selectGroup/groupsView.html",
            controller: "GroupController",
            controllerAs:"vm"
		};
	});

})();
