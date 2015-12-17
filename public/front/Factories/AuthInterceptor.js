appModule.factory('authInterceptor',['$rootScope','$q','$window', function($rootScope, $q, $window) {
    return {
        request: function (config) {
            config.headers = config.headers || {};

            if ($window.sessionStorage.auth_token)
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.auth_token;

            if ($window.sessionStorage.language_id)
                config.headers['language_id'] = $window.sessionStorage.language_id;

            if ($window.sessionStorage.currency_id)
                config.headers['currency_id'] = $window.sessionStorage.currency_id;

            //if ($window.sessionStorage.zone_id)
            //    config.headers['zone_id'] = $window.sessionStorage.zone_id;

            return config;
        },
        response: function (response) {
            if (response.status === 401) {
                // handle the case where the user is not authenticated
            }
            return response || $q.when(response);
        },
        responseError: function (response) {
            //if (response.status !== 401)
            $rootScope.consumeHttpError(response.data,response.status,response.headers,response.config);
            return $q.reject(response);
        }
    };
}]);