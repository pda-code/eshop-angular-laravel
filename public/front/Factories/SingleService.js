appModule.factory('SingleService', ['DataContext', '$rootScope', '$location', function (dataContext, $rootScope, $location) {

    var service = function (entityName, entitySetName, params) {
        var self = this;
    };

    return {
        createInstance: function (entityName, entitySetName, params) {
            return new service(entityName, entitySetName, params);
        }
    };
}]);