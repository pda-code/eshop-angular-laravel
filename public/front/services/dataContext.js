// DataContext
appModule.service('dataContext', ['$http', function ($http) {

    var self = this;

    self.repository = function (repositoryName) {

         var apiRoot = 'http://195.251.253.15:8080/eShopLaravel/public/api/';

         //bind params
         var bindParametersFn = function (url, params) {
             var replacedUrl = url;
             if (params)
                 for (key in params)
                     replacedUrl = replacedUrl.replace(':' + key, params[key]);
             return replacedUrl;
         };

        /**
         * The workhorse; converts an object to x-www-form-urlencoded serialization.
         * @param {Object} obj
         * @return {String}
         */
        var paramFn = function(obj) {
            var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

            for (name in obj) {
                value = obj[name];

                if (value instanceof Array) {
                    for (i = 0; i < value.length; ++i) {
                        subValue = value[i];
                        fullSubName = name + '[' + i + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += paramFn(innerObj) + '&';
                    }
                }
                else if (value instanceof Object) {
                    for (subName in value) {
                        subValue = value[subName];
                        fullSubName = name + '[' + subName + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += paramFn(innerObj) + '&';
                    }
                }
                else if (value !== undefined && value !== null)
                    query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
            }
            return query.length ? query.substr(0, query.length - 1) : query;
        };




        var repo = {};

        // end points
        repo.routes = {all: {url: repositoryName, method: 'GET'}}

        switch (repositoryName) {
            case 'customers':
                angular.extend(repo.routes, {login: {url:  repositoryName + '/login', method: 'POST'}});
                angular.extend(repo.routes, {logout: {url:  repositoryName + '/logout', method: 'POST'}});
                angular.extend(repo.routes, {register: {url:  repositoryName + '/register', method: 'POST'}});
                angular.extend(repo.routes, {update: {url:  repositoryName + '/update/:id', method: 'PUT'}});
                angular.extend(repo.routes, {destroy: {url:  repositoryName + '/destroy/:id', method: 'DELETE'}});
                angular.extend(repo.routes, {empty: {url:  repositoryName + '/new', method: 'GET'}});
                break;

            case 'store':
                angular.extend(repo.routes, {countriesAndZones: {url:  repositoryName + '/countries-zones', method: 'GET'}});
                angular.extend(repo.routes, {flush: {url:  repositoryName + '/flush', method: 'GET'}});
                angular.extend(repo.routes, {settings: {url:  repositoryName + '/context', method: 'GET'}});
                angular.extend(repo.routes, {addToCart: {url:  repositoryName + '/cart/:cart_type/:id', method: 'POST'}});
                angular.extend(repo.routes, {removeFromCart: {url:  repositoryName + '/cart/:cart_type/:id', method: 'DELETE'}});
                angular.extend(repo.routes, {cartContents: {url: repositoryName + '/cart/:cart_type', method: 'GET'}});
                angular.extend(repo.routes, {changeLanguage: {url: repositoryName+ '/context/changeLanguage', method: 'PUT'}});
                angular.extend(repo.routes, {changeCurrency: {url: repositoryName+ '/context/changeCurrency', method: 'PUT'}});
                break;

            case 'catalog':
                angular.extend(repo.routes, {top: {url:  repositoryName + '/top', method: 'GET'}});
                angular.extend(repo.routes, {topWithPreselection: {url:  repositoryName + '/top-with-preselection/:id', method: 'GET'}});
                angular.extend(repo.routes, {subcategories: {url:  repositoryName + '/:id/categories', method: 'GET'}});
                angular.extend(repo.routes, {attributes: {url:  repositoryName + '/:id/attributes', method: 'GET'}});
                angular.extend(repo.routes, {products: {url: repositoryName + '/:categoryId/products', method: 'GET'}});
                angular.extend(repo.routes, {product: {url: repositoryName + '/products/:id', method: 'GET'}});
                angular.extend(repo.routes, {productReviews: {url: repositoryName + '/products/:id/reviews', method: 'GET'}});
                angular.extend(repo.routes, {productSpecs: {url: repositoryName + '/products/:id/specs', method: 'GET'}});
                angular.extend(repo.routes, {compare: {url: repositoryName + '/compare-products', method: 'GET'}});

            case 'reviews':
                angular.extend(repo.routes, {create: {url: repositoryName , method: 'POST'}});
                angular.extend(repo.routes, {update: {url: repositoryName + '/:id', method: 'PUT'}});
                break;

            case 'countries':
                angular.extend(repo.routes, {create: {url: repositoryName , method: 'POST'}});
                angular.extend(repo.routes, {update: {url: repositoryName + '/:id', method: 'PUT'}});
                break;

            case 'zones':
                angular.extend(repo.routes, {create: {url: repositoryName , method: 'POST'}});
                angular.extend(repo.routes, {update: {url: repositoryName + '/:id', method: 'PUT'}});
                break;

            case 'addresses':
                angular.extend(repo.routes, {create: {url: repositoryName , method: 'POST'}});
                angular.extend(repo.routes, {update: {url: repositoryName + '/:id', method: 'PUT'}});
                angular.extend(repo.routes, {empty: {url: repositoryName + '/new', method: 'GET'}});
                break;

            case 'payment-methods':
                angular.extend(repo.routes, {create: {url: repositoryName , method: 'POST'}});
                angular.extend(repo.routes, {update: {url: repositoryName + '/:id', method: 'PUT'}});
                break;

            case 'shipping-methods':
                angular.extend(repo.routes, {create: {url: repositoryName , method: 'POST'}});
                angular.extend(repo.routes, {update: {url: repositoryName + '/:id', method: 'PUT'}});
                break;

            case 'orders':
                angular.extend(repo.routes, {checkoutOptions: {url: repositoryName  + '/checkout-options', method: 'GET'}});
                angular.extend(repo.routes, {checkoutOrder: {url: repositoryName  + '/checkout-order', method: 'PUT'}});
                angular.extend(repo.routes, {create: {url: repositoryName , method: 'POST'}});
                angular.extend(repo.routes, {update: {url: repositoryName + '/:id', method: 'PUT'}});
                break;

        }

        for (key in repo.routes) {
            repo[key] = (function (key) {
                return function (params, data) {
                    var method = repo.routes[key].method;
                    var url = apiRoot + bindParametersFn(repo.routes[key].url, params);

                    //SOS-1: if $http.params must be an object else error raised
                    //SOS-2: $http.params: params DO NOT serialize arrays and php do not understand. We pass x-www-form-urlencoded format in url
                    if (method=="GET" && angular.isObject(params))
                        url = url + '?' + paramFn(params);


                    return $http({
                        url: url,
                        method: method,
                        data: data
                    });
                }
            })(key);
        }

        return repo;
    };
}]);

