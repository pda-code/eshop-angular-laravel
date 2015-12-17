//appModule.controller('OrderDetail_CreateOrEditController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http', 'CollectionService', 'DataContext', 'codeTrimRoot', function ($scope, $rootScope, $route, $routeParams, $location, $http, collectionService, dataContext, codeTrimRoot) {
//DatePickers
$scope.dtOpened = {};
$scope.dtOpen = function (id, $event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.dtOpened[id] = true;
};

//Collapse/Expand
$scope.expanded = {};
$scope.setExpanded = function (id) {
    if ($scope.expanded[id] === true) $scope.expanded[id] = false;
    else $scope.expanded[id] = true;
};

//Tabs
$scope.tabs = {};
$scope.setActiveTab = function (id) {
    if ($scope.collapsed[id] === true) $scope.collapsed[id] = false;
    else $scope.collapsed[id] = true;
};

var loadNavigationProperty = function (entity, navigationProperty, params) {
    var requestParams = params || {};
    var defaultParams = null;

    switch (navigationProperty) {

    case 'Order':

        if (!entity.OrderId) return;

        defaultParams = {
            id: entity.OrderId
        };
        requestParams = angular.extend(defaultParams, requestParams);

        var repo = dataContext.repository('Orders');
        repo.getById(requestParams).success(function (data) {
            entity[navigationProperty] = data;
        });

        break;

    case 'Product':

        if (!entity.ProductId) return;

        defaultParams = {
            id: entity.ProductId
        };
        requestParams = angular.extend(defaultParams, requestParams);

        var repo = dataContext.repository('Products');
        repo.getById(requestParams).success(function (data) {
            entity[navigationProperty] = data;
        });

        break;

    }
};

//Model
$scope.OrderDetail = null;

//Initialize

//Foreign Keys Lookups
$scope.$$lookups = {};

var repoForLookups = null;

repoForLookups = dataContext.repository('Orders');
repoForLookups.getAll({
    pageSize: 200
}).success(function (data) {
    $scope.$$lookups.OrderId = data.items;
});

repoForLookups = dataContext.repository('Products');
repoForLookups.getAll({
    pageSize: 200
}).success(function (data) {
    $scope.$$lookups.ProductId = data.items;
});

//Model
$scope.OrderDetail = null;

//Load model
var promise = null;
var queryStringParams = $location.search();
var repo = dataContext.repository('OrderDetails');

if (queryStringParams.id) {
    queryStringParams.includes = ['Order', 'Product'];
    promise = repo.getById(queryStringParams);
}
else promise = repo.getEmpty(queryStringParams);
promise.success(function (data) {

    if (data.OrderId === 0) data.OrderId = null;

    if (data.ProductId === 0) data.ProductId = null;

    $scope.OrderDetail = data;
});

//Validation translations
$scope.actions = {
    save: function () {
        if (!$scope.MyForm.$valid) {
            var validationErrros = [];
            var validationPromises = [];

            for (var key in $scope.OrderDetail)
            if ($scope.MyForm[key] && $scope.MyForm[key].$invalid) {
                if ($scope.MyForm[key].$error.required) validationPromises.push($translate('$App.validation.required', {
                    field: key
                }).then(function (text) {
                    validationErrros.push(text);
                }));

                if ($scope.MyForm[key].$error.number) validationPromises.push($translate('$App.validation.number', {
                    field: key
                }).then(function (text) {
                    validationErrros.push(text);
                }));

                if ($scope.MyForm[key].$error.email) validationPromises.push($translate('$App.validation.email', {
                    field: key
                }).then(function (text) {
                    validationErrros.push(text);
                }));
            }

            $q.all(validationPromises).then(function () {
                $rootScope.notification.show("validation", null, validationErrros);
                return false;
            });
            return false;
        }

        if ($scope.OrderDetail.Id > 0) return $scope.actions.update();
        else return $scope.actions.create();
    },
    update: function () {
        var json = JSON.stringify($scope.OrderDetail);

        return repo.update({
            id: $scope.OrderDetail.Id,
            includes: []
        },
        json).success(function (data) {
            //$rootScope.notification.show('success', null, []);
            $scope.actions.cancel();
        }).error($rootScope.consumeHttpError)
    },
    create: function () {
        var json = JSON.stringify($scope.OrderDetail);

        return repo.create({},
        json).success(function (data) {
            $scope.actions.cancel();
            //$scope.Order.Id(data.Id);
            //$rootScope.notification.show('success', null, []);
        }).error($rootScope.consumeHttpError)
    },
    cancel: function () {
        $window.history.back();
    }
};
