//appModule.controller('Address_IndexController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http', 'CollectionService', 'DataContext', 'codeTrimRoot', function ($scope, $rootScope, $route, $routeParams, $location, $http, collectionService, dataContext, codeTrimRoot) {
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

    case 'BillingOrder':

        if (!entity.Id) return;
        defaultParams = {
            id: entity.Id
        };
        requestParams = angular.extend(defaultParams, requestParams);

        var repo = dataContext.repository('Orders');

        repo.getById(requestParams).success(function (data) {
            entity[navigationProperty] = data;
        });

        break;

    }
};

//Model
$scope.Addresses = null;

//Initialize

$scope.Addresses = collectionService.createInstance('Address', 'Addresses');

$scope.Addresses.refresh().success(function () {
    $scope.$watch('Addresses.selectedItem', function (newVal, oldVal) {
        if (newVal === oldVal) return;
        if (!$scope.Addresses.selectedItem) return;

        var selectedItem = $scope.Addresses.selectedItem;
        var id = $scope.Addresses.selectedItem.Id;

        loadNavigationProperty(selectedItem, 'BillingOrder');

    });
});
