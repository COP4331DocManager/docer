(function() {
  'use strict';

  angular
    .module('app.manage.groups')
    .config(configFunction);

  configFunction.$inject = ['$routeProvider'];

  function configFunction($routeProvider) {
    $routeProvider.when('/admin/groups', {
      templateUrl: 'app/components/group/create/createView.html'
    });
  }

})();