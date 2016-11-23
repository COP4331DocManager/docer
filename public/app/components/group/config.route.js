(function() {
  'use strict';

  angular
    .module('app.group')
    .config(configFunction);

  configFunction.$inject = ['$routeProvider'];

  function configFunction($routeProvider) {
    $routeProvider.when('/group', {
      templateUrl: 'app/components/group/manageGroups.html'
    });
  }

})();
