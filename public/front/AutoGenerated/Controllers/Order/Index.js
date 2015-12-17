//appModule.controller('Order_IndexController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http', 'CollectionService', 'DataContext', 'codeTrimRoot', function ($scope, $rootScope, $route, $routeParams, $location, $http, collectionService, dataContext, codeTrimRoot) {
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

    case 'BillingAddress':

        if (!entity.Id) return;
        defaultParams = {
            id: entity.Id
        };
        requestParams = angular.extend(defaultParams, requestParams);

        var repo = dataContext.repository('Addresses');

        repo.getById(requestParams).success(function (data) {
            entity[navigationProperty] = data;
        });

        break;

    case 'Customer':

        if (!entity.CustomerId) return;

        defaultParams = {
            id: entity.CustomerId
        };
        requestParams = angular.extend(defaultParams, requestParams);

        var repo = dataContext.repository('Customers');
        repo.getById(requestParams).success(function (data) {
            entity[navigationProperty] = data;
        });

        break;

    case 'OrderDetails':

        if (!entity.Id) return;

        defaultParams = {
            criteria: 'OrderId=' + entity.Id
        };
        requestParams = angular.extend(defaultParams, requestParams);

        entity[navigationProperty] = collectionService.createInstance('OrderDetail', 'OrderDetails', requestParams);
        entity[navigationProperty].refresh();

        break;

    case 'Tags':

        if (!entity.Id) return;

        var defaultParams = {
            criteria: 'Orders.Any(Id=' + entity.Id + ')'
        };
        requestParams = angular.extend(defaultParams, requestParams);

        entity[navigationProperty] = collectionService.createInstance('Tag', 'Tags', requestParams);
        entity[navigationProperty].refresh();

        break;

    }
};

//Model
$scope.Orders = null;

//Initialize

$scope.Orders = collectionService.createInstance('Order', 'Orders');

$scope.Orders.refresh().success(function () {
    $scope.$watch('Orders.selectedItem', function (newVal, oldVal) {
        if (newVal === oldVal) return;
        if (!$scope.Orders.selectedItem) return;

        var selectedItem = $scope.Orders.selectedItem;
        var id = $scope.Orders.selectedItem.Id;

        loadNavigationProperty(selectedItem, 'BillingAddress');

        loadNavigationProperty(selectedItem, 'Customer');

        loadNavigationProperty(selectedItem, 'OrderDetails');

        loadNavigationProperty(selectedItem, 'Tags');

    });
});
