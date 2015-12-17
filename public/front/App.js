'use strict';

var appModule = angular.module('App', ['ngRoute', 'ngTouch', 'ngSanitize', 'ui.bootstrap', 'ui.router', 'ncy-angular-breadcrumb', 'angular-loading-bar', 'jcs-autoValidate', 'pascalprecht.translate', 'bootstrapLightbox']);
appModule.constant("CSRF_TOKEN", '8hNK9B1X2fBUc0DWSYgSYPylQMtzb8G2bnyefZMk');

appModule.config(['$stateProvider', '$urlRouterProvider', '$httpProvider','$breadcrumbProvider', 'cfpLoadingBarProvider', '$translateProvider',
    function ($stateProvider, $urlRouterProvider, $httpProvider,$breadcrumbProvider, cfpLoadingBarProvider, $translateProvider) {

        $breadcrumbProvider.setOptions({
            prefixStateName: 'home'
        });

        //Global Error Handling
        //$httpProvider.interceptors.push('globalErrorInterceptor');
        $httpProvider.interceptors.push('authInterceptor');

        //loading bar
        cfpLoadingBarProvider.includeSpinner = true;
        cfpLoadingBarProvider.includeBar = true;
        cfpLoadingBarProvider.latencyThreshold = 100;
        cfpLoadingBarProvider.startSize = 0.07;
        cfpLoadingBarProvider.parentSelector = '.loading-bar-container';

        $urlRouterProvider.otherwise("home");

        //states
        $stateProvider
            .state('home', {url: "/", templateUrl: "front/partials/home.blade.php", controller: 'homeController'})

            .state('cart', {
                url: '/cart',
                templateUrl: 'front/partials/cart.html',
                controller: 'cartController',
                label: 'cart'
            })
            .state('wishlist', {
                url: '/wishlist',
                templateUrl: 'front/partials/wishlist.html',
                controller: 'wishlistController',
                label: 'wishlist'
            })
            .state('compare', {
                url: '/compare',
                templateUrl: 'front/partials/compare.html',
                controller: 'compareController',
                label: 'compare'
            })

            .state('login', {
                url: '/login',
                templateUrl: 'front/partials/login.html',
                controller: 'loginController',
                label: 'account'
            })
            .state('register', {
                url: '/register',
                templateUrl: 'front/partials/register.html',
                controller: 'registerController',
                label: 'register'
            })
            .state('account', {
                url: '/account',
                templateUrl: 'front/partials/account.html',
                controller: 'homeController',
                label: 'wishlist'
            })
            .state('contact', {
                url: '/contact',
                templateUrl: 'front/partials/contact.html',
                controller: 'contactController'
            })
            .state('checkout', {
                url: '/checkout',
                templateUrl: 'front/partials/checkout.html',
                controller: 'checkoutController'
            })
            .state('checkout-success', {
                url: '/checkout',
                templateUrl: 'front/partials/checkout_success.html',
                controller: 'checkoutSuccessController'
            })
            .state('categories', {
                abstract: true,
                url: '/categories',
                templateUrl: 'front/partials/categories.html'
            })
            .state('categories.detail', {
                url: '/:categoryId',
                views: {
                    'navigation': {
                        templateUrl: 'front/partials/categories.nav.html',
                        controller: 'categoriesController'
                    },
                    'products': {
                        templateUrl: 'front/partials/products.html',
                        controller: 'productsController'
                    }
                }
            })
            .state('product', {
                url: '/products/:productId',
                templateUrl: 'front/partials/product.html',
                controller: 'productController'
            })
            .state('pager', {
                url: '/pager',
                templateUrl: 'front/partials/pager.html',
                controller: 'pagerController'
            })


        //translation
        $translateProvider.translations('en', {
            HOME: 'Home',
            WISHLIST_CART: 'Wishlist',
            SHOPPING_CART: 'Cart',
            COMPARE_CART: 'Compare'
        });
        $translateProvider.translations('el', {
            HOME: 'Αρχική',
            WISHLIST_CART: 'Λίστα Επιθυμιών',
            SHOPPING_CART: 'Καλάθι',
            COMPARE_CART: 'Σύγκριση'

        });

        $translateProvider.preferredLanguage('en');

    }]);

appModule.run(['$http', '$route', '$rootScope', '$state', '$stateParams', '$location', '$window', '$templateCache', 'CSRF_TOKEN', 'validator', 'bootstrap3ElementModifier', function ($http, $route, $rootScope, $state, $stateParams, $location, $window, $templateCache, CSRF_TOKEN, validator, bootstrap3ElementModifier) {

    validator.setValidElementStyling(false);
    validator.setInvalidElementStyling(true);
    bootstrap3ElementModifier.enableValidationStateIcons(false);


    // It's very handy to add references to $state and $stateParams to the $rootScope
    // so that you can access them from any scope within your applications.For example,
    // <li ng-class="{ active: $state.includes('contacts.list') }"> will set the <li>
    // to active whenever 'contacts.list' or one of its decendents is active.
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;

    //$http.defaults.headers.common['csrf_token'] = CSRF_TOKEN;


     $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
        $rootScope.notification.hide();
        //  var authorised;
        //  if (next.requiresLogin === true && $window.sessionStorage.authToken==null) {
        //          $location.path("/login").replace();
        //  }
    });


    //Notification
    $rootScope.notification = {
        subscribers: [],
        show: function (subscriber, type, header, messages) {
            this.subscribers[subscriber] =
            {
                type: type,
                subscriber: subscriber,
                header: header,
                messages: angular.isArray(messages) ? messages : [messages]
            }
        },
        alertType: function (subscriber) {
            if (!this.subscribers[subscriber]) return null;
            switch (this.subscribers[subscriber].type) {
                case 'error':
                    return 'alert-danger';
                    break;
                case 'validation':
                    return 'alert-danger';
                case 'success':
                    return 'alert-success';
                    break;
            }
        },
        hide: function (subscriber) {
            if (!this.subscribers[subscriber]) return;
            delete this.subscribers[subscriber];
        },
        isVisible: function (subscriber) {
            if (!this.subscribers[subscriber]) return false;
            return (this.subscribers[subscriber].type != null);
        },
        header: function (subscriber) {
            if (!this.subscribers[subscriber]) return null;
            return this.subscribers[subscriber].header;
        },
        messages: function (subscriber) {
            if (!this.subscribers[subscriber]) return null;
            return this.subscribers[subscriber].messages;
        },
        toggleDisplay: function (subscriber) {
            //$scope.show = !!(this.type && this.headerMessage && this.messages);
        }
    };


    //Consume error
    $rootScope.consumeHttpError = function (data,status,headers,config) {
        var arr = [];
        switch (status) {
            case 401:
            //    arr.push("401 - Unauthorized");
                break;
            case 404:
            //    arr.push("401 - Not Found");
                break;

            //Serever side - validations (400 - Bad Request)
            case 400:
            //    for (var key in data)
            //        arr.push(key + ': ' + data[key]);
                break;

            default:
                for (var key in data['error'])
                    arr.push(key + ': ' + data['error'][key]);
        }
        if (arr.length > 0) {
            $rootScope.notification.show('global', 'error', "Error", arr);
        }
    };

    $rootScope.getValidationErrors = function (data) {
        var arr=[];
        angular.forEach(data,function (item,key){
            angular.forEach(item,function (message,key) {
                arr.push(message);
            });
        });

        return arr;
    };

    $state.go('home');
}]);

appModule.controller('appController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http','$filter', '$window', 'uiHelper', '$translate', 'dataContext', 'collectionService', 'app','cart', function ($scope, $rootScope, $route, $routeParams, $location, $http, $filter, $window, uiHelper, $translate, dataContext, collectionService, app,cart) {

    app.init();
    $rootScope.app = app;

    // meta
    $scope.ui = uiHelper.createInstance();
    $scope.ui.setMeta('', '', '');

    // get categories
    var repo = dataContext.repository('catalog');
    repo.top({children_count: true, products_count: true, depth: 3})
        .success(function (data) {
            $scope.categories = data;
        });

    $rootScope.flush = function () {
        var repo = dataContext.repository('store');
        repo.flush()
            .success(function (data) {
                $rootScope.notification.show('success', 'Success', 'session flushed')
            });
    };
}]);

