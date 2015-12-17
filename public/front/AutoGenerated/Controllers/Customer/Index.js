//appModule.controller('Customer_IndexController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http', 'CollectionService', 'DataContext', 'codeTrimRoot', function ($scope, $rootScope, $route, $routeParams, $location, $http, collectionService, dataContext, codeTrimRoot) {
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

    case 'Orders':

        if (!entity.Id) return;

        defaultParams = {
            criteria: 'CustomerId=' + entity.Id
        };
        requestParams = angular.extend(defaultParams, requestParams);

        entity[navigationProperty] = collectionService.createInstance('Order', 'Orders', requestParams);
        entity[navigationProperty].refresh();

        break;

    }
};

//Model
$scope.Customers = null;

//Initialize

$scope.Customers = collectionService.createInstance('Customer', 'Customers');

$scope.Customers.refresh().success(function () {
    $scope.$watch('Customers.selectedItem', function (newVal, oldVal) {
        if (newVal === oldVal) return;
        if (!$scope.Customers.selectedItem) return;

        var selectedItem = $scope.Customers.selectedItem;
        var id = $scope.Customers.selectedItem.Id;

        loadNavigationProperty(selectedItem, 'Orders');

    });
});
