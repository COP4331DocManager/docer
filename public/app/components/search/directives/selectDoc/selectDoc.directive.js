(function(){

 var app = angular.module('app.search');

	//controls the groups assigned to a user and how they are displayed
/*
    var CurrentGroup = function($scope)
	{

		//use some data service to do a rest call to a database

		  $scope.users = [
			{id:1, text:"Harambe"},
            {id:2, text:"Trump"},
            {id:3, text:"Pepe"},
            {id:1, text:"Memzzz"},
            {id:2, text:"DOGE"},
            {id:3, text:"DOGEDOGE"}
        ];

	};
    CurrentGroup.$inject = ['$scope'];
*/
 	app.directive('searchSelectDoc', function(){
		return{
			restrict: 'E',
			templateUrl: "/app/components/group/directives/currentGroup/currentGroupView.html",
            // controller: "SearchController",
            // controllerAs: 'searchCtrl'
		};
	});

})();
