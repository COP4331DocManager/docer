(function () {
    'use strict';

    angular
        .module('app')
        .controller('RegisterController', RegisterController);

    RegisterController.$inject = ['UserService', '$location', '$rootScope', 'FlashService', 'AuthenticationService'];
    function RegisterController(UserService, $location, $rootScope, FlashService, AuthenticationService) {
        var vm = this;

        vm.register = register;

        function register() {
            vm.dataLoading = true;
            UserService.Register(vm.user)
                .then(function (response) {
                    if (response.token) {
                        FlashService.Success('Registration successful', true);
                        AuthenticationService.SetCredentials(response.user, response.token);
                        $location.path('/');
                    } else {
                        //TODO: better error message
                        console.log("register error: ", response);
                        FlashService.Error(response);
                        vm.dataLoading = false;
                    }
            });
        }
    }

})();