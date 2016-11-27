(function () {
    //Read up here http://stackoverflow.com/questions/21444100/angularjs-how-to-http-get-data-and-store-it-in-service

    'use strict';
    var app = angular.module('app.admin.doc');

    app.service('AdminDocService', AdminDocService);

    AdminDocService.$inject = ["$http", "$q"];

    function AdminDocService($http, $q){
        return {
            createDoc:function(image_file, group, meta_tags){
                var defer = $q.defer();
                //TODO: write meta tags to DB. Backend endpoint not exist yet!
                $http({
                    method  : 'POST',
                    url     : '/api/document',
                    processData: false,
                    transformRequest: function (data) {
                        var formData = new FormData();
                        formData.append("user_upload", image_file);  
                        formData.append("group", group);
                        return formData;  
                    },  
                    headers: {
                        'Content-Type': undefined
                    }
                }).success(function(data){
                    defer.resolve("Success");
                }).error(function(data){
                    defer.resolve("Something gone wrong");
                });
                    
                return defer.promise;
            },
            readDoc:function(doc_id){
                var defer = $q.defer();
                $http.get('/api/document/' + doc_id + '/info')
                    .success(function (data) {
                        if(data.length == 0)
                            defer.resolve([{"group_id" : -1, "metaTags" : []}]);
                        else
                            defer.resolve(data);
                    }).error(function(data){
                        defer.resolve([{"group_id" : -1, "metaTags" : []}]);
                    });
                return defer.promise;
            },
            destroyDoc:function(doc_id){
                var defer = $q.defer();
                $http.delete('/api/document/' + doc_id)
                    .success(function (data) {
                        defer.resolve(data);
                    }).error(function(data){
                        defer.resolve("Something gone wrong");
                    });
                return defer.promise;
            },
        }
    }
})();