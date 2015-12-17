//appModule.controller('Product_IndexController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http', 'CollectionService', 'DataContext', 'codeTrimRoot', function ($scope, $rootScope, $route, $routeParams, $location, $http, collectionService, dataContext, codeTrimRoot) {
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

    case 'Category':

        if (!entity.CategoryId) return;

        defaultParams = {
            id: entity.CategoryId
        };
        requestParams = angular.extend(defaultParams, requestParams);

        var repo = dataContext.repository('ProductCategories');
        repo.getById(requestParams).success(function (data) {
            entity[navigationProperty] = data;
        });

        break;

    case 'OrderDetails':

        if (!entity.Id) return;

        defaultParams = {
            criteria: 'ProductId=' + entity.Id
        };
        requestParams = angular.extend(defaultParams, requestParams);

        entity[navigationProperty] = collectionService.createInstance('OrderDetail', 'OrderDetails', requestParams);
        entity[navigationProperty].refresh();

        break;

    }
};

//Model
$scope.Products = null;

//Initialize

$scope.Products = collectionService.createInstance('Product', 'Products');

$scope.Products.refresh().success(function () {
    $scope.$watch('Products.selectedItem', function (newVal, oldVal) {
        if (newVal === oldVal) return;
        if (!$scope.Products.selectedItem) return;

        var selectedItem = $scope.Products.selectedItem;
        var id = $scope.Products.selectedItem.Id;

        loadNavigationProperty(selectedItem, 'Category');

        loadNavigationProperty(selectedItem, 'OrderDetails');

    });
});
