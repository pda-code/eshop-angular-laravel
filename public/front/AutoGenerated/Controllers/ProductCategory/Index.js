//appModule.controller('ProductCategory_IndexController', ['$scope', '$rootScope', '$route', '$routeParams', '$location', '$http', 'CollectionService', 'DataContext', 'codeTrimRoot', function ($scope, $rootScope, $route, $routeParams, $location, $http, collectionService, dataContext, codeTrimRoot) {
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

    case 'Products':

        if (!entity.Id) return;

        defaultParams = {
            criteria: 'CategoryId=' + entity.Id
        };
        requestParams = angular.extend(defaultParams, requestParams);

        entity[navigationProperty] = collectionService.createInstance('Product', 'Products', requestParams);
        entity[navigationProperty].refresh();

        break;

    }
};

//Model
$scope.ProductCategories = null;

//Initialize

$scope.ProductCategories = collectionService.createInstance('ProductCategory', 'ProductCategories');

$scope.ProductCategories.refresh().success(function () {
    $scope.$watch('ProductCategories.selectedItem', function (newVal, oldVal) {
        if (newVal === oldVal) return;
        if (!$scope.ProductCategories.selectedItem) return;

        var selectedItem = $scope.ProductCategories.selectedItem;
        var id = $scope.ProductCategories.selectedItem.Id;

        loadNavigationProperty(selectedItem, 'Products');

    });
});
