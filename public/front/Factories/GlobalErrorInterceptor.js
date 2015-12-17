appModule.factory('globalErrorInterceptor',['$rootScope','$q', function($rootScope, $q) {
    return {
        'responseError': function(r) {
            $rootScope.consumeHttpError(r);
            return $q.reject(r);
        }
    };
}]);
