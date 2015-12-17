
//productsController
appModule.controller('productsController', ['$scope', '$rootScope', '$stateParams', '$state', 'dataContext', 'collectionService', function ($scope, $rootScope, $stateParams, $state, dataContext, collectionService) {

    $scope.app = $rootScope.app;
    $scope.layout = $scope.app.layout;

    $scope.selectedCategoryId = $stateParams.categoryId;

    // products
    var repo = dataContext.repository('catalog');
    $scope.service = collectionService.createInstance(repo.products, {categoryId: $scope.selectedCategoryId});
    $scope.service
        .refresh()
        .success(function (data) {
            //console.log(data);
        });

    $scope.changeLayout = function (layout) {
        $scope.layout = layout;
        $scope.app.setLayout(layout);
    }

    $scope.sortOptions = [
        {title: 'Default', column: null, direction: null},
        {title: 'Price Asceding', column: 'price', direction: 'asc'},
        {title: 'Price Descending', column: 'price', direction: 'desc'},
        {title: 'Popular', column: 'popular', direction: 'desc'},
        {title: 'Newest', column: 'newest', direction: 'desc'}
    ];

    $scope.sortOption=$scope.sortOptions[0];

    $scope.changeSorting = function () {

        $scope.service.load({sorting:[$scope.sortOption.column + ':' + $scope.sortOption.direction]});
    };

}]);