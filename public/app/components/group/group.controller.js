(function () {
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.group');

    app.controller('GroupController', GroupController);

    GroupController.inject = ['$scope', 'Restangular', '$http'];
    function GroupController($scope, Restangular, $http) {
        $scope.groupName = '';
        $scope.userName = '';
        $scope.createGroupMessage = '';
        $scope.createGroupStatus = '';
        $scope.addGroupMemberMessage = '';
        $scope.dropGroupMemberMessage = '';
        $scope.promoteGroupMemberMessage = '';
        $scope.showCreateStatus = false;
        $scope.showLeaveStatus = false;
        $scope.showaddMemberStatusStatus = false;
        $scope.showDropMemberStatusStatus = false;
        $scope.showPromoteMemberStatusStatus = false;

        $scope.submitCreateGroup = function () {
            if ($scope.groupName) {
                var groupName = {name: $scope.groupName};
                $http.post('/api/create-group', groupName)
                    .success(function (data) {
                        $scope.createGroupMessage = 'The group has been created';
                        $scope.createGroupStatus = 'success';
                        $scope.showCreateStatus = true;
                        $scope.data.groups.push(data);
                    }).error(function (data) {
                    $scope.createGroupMessage = 'An error has occurred';
                    $scope.createGroupStatus = 'danger';
                    $scope.showCreateStatus = true;
                });
            }
        };
        $scope.createGroup = $scope.submitCreateGroup;

        // This leaves the user form the current group.
        $scope.submitLeaveGroup = function () {
            var leaveGroup = {group_id: $scope.current.group.id, self: true};
            $http.post('/api/delete-member', leaveGroup)
                .success(function (data) {
                    $scope.leaveGroupMessage = 'You have left the group';
                    $scope.leaveGroupStatus = 'success';
                    $scope.showLeaveStatus = true;
                    $scope.getData(); 
                }).error(function (data) {
                $scope.leaveGroupMessage = 'An error has occurred';
                $scope.leaveGroupStatus = 'danger';
                $scope.showLeaveStatus = true;
            });
        };
        $scope.leaveGroup = $scope.submitLeaveGroup;



        // Add member to a group
        $scope.submitAddGroupMember = function () {
            console.log($scope.userName);
            if ($scope.userName) {
                var addMember = {group_id: $scope.current.group.id, user: $scope.userName};
                $http.post('/api/add-member', addMember)
                    .success(function (data) {
                        $scope.addGroupMemberMessage = 'You have added the group member';
                        $scope.addGroupMemberStatus = 'success';
                        $scope.showAddMemberStatusStatus = true;
                        $scope.current.group = data;
                        $scope.getData();
                        $scope.$apply;
                    }).error(function (data) {
                    $scope.addGroupMemberMessage = 'An error has occurred';
                    $scope.addGroupMemberStatus = 'danger';
                    $scope.showAddMemberStatusStatus = true;
                });
            }
        };
        $scope.addGroupMember = $scope.submitAddGroupMember;

        $scope.getData = function(){
            $http.get('/api/home')
                .success(function (data){
                    $scope.data = data;
                    $scope.$apply;
                });

        }
        // Drop member from a group
        $scope.submitDropGroupMember = function () {
            var dropMember = {group_id: $scope.current.group.id, user_id: $scope.current.member.id};
            $http.post('/api/delete-member', dropMember)
                .success(function (data) {
                    $scope.dropGroupMemberMessage = 'You have dropped the group member';
                    $scope.dropGroupMemberStatus = 'success';
                    $scope.showDropMemberStatusStatus = true;
                    $scope.current.group = data;
                    $scope.getData();
                    
                }).error(function (data) {
                $scope.dropGroupMemberMessage = 'An error has occurred';
                $scope.dropGroupMemberStatus = 'danger';
                $scope.showDropMemberStatusStatus = true;
            });
        };
        $scope.dropGroupMember = $scope.submitDropGroupMember;



        // Promote member to a group leader
        $scope.submitPromoteGroupMember = function () {
            var promoteMember = {group_id: $scope.current.group.id, user_id: $scope.current.member.id};
            $http.post('/api/promote-member', promoteMember)
                .success(function (data) {
                    $scope.promoteGroupMemberMessage = 'You have promoted the group member';
                    $scope.promoteGroupMemberStatus = 'success';
                    $scope.showPromoteMemberStatusStatus = true;
                }).error(function (data) {
                $scope.promoteGroupMemberMessage = 'An error has occurred';
                $scope.promoteGroupMemberStatus = 'danger';
                $scope.showPromoteMemberStatusStatus = true;
            });
        };
        $scope.promoteGroupMember = $scope.submitPromoteGroupMember;
    }

})();
