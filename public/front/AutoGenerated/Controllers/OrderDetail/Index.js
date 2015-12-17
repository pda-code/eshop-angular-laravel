//appModule.controller('OrderDetail_IndexController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http', 'CollectionService', 'DataContext', 'codeTrimRoot', function ($scope, $rootScope, $route, $routeParams, $location, $http, collectionService, dataContext, codeTrimRoot) {
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
$scope.OrderDetails = null;

//Initialize

$scope.OrderDetails = collectionService.createInstance('OrderDetail', 'OrderDetails');

$scope.OrderDetails.refresh().success(function () {
    $scope.$watch('OrderDetails.selectedItem', function (newVal, oldVal) {
        if (newVal === oldVal) return;
        if (!$scope.OrderDetails.selectedItem) return;

        var selectedItem = $scope.OrderDetails.selectedItem;
        var id = $scope.OrderDetails.selectedItem.Id;

        loadNavigationProperty(selectedItem, 'Order');

        loadNavigationProperty(selectedItem, 'Product');

    });
});
