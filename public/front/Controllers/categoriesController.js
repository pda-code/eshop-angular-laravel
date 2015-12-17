//categories controller
appModule.controller('categoriesController', ['$scope', '$rootScope', '$stateParams', '$state', 'dataContext', 'collectionService', function ($scope, $rootScope, $stateParams, $state, dataContext, collectionService) {

    $scope.selectedCategoryId = $stateParams.categoryId;

    // get categories with preselection
    var repo = dataContext.repository('catalog');
    repo.topWithPreselection({id: $scope.selectedCategoryId, children_count: true, products_count: true})
        .success(function (data) {
            $scope.categories = data;
        });

    repo.attributes({id: $scope.selectedCategoryId})
        .success(function (data) {
            //console.log(data);
            $scope.groups=data;
        });


    $scope.toggleExpand = function (item) {
        if (item.expanded === true)
            item.expanded = false
        else if (item.loaded === true)
            item.expanded = true
        else
            repo.subcategories({id: item.id, children_count: true, products_count: true})
                .success(function (data) {
                    item.children = data;
                    item.expanded = true;
                    item.loaded = true;
                });
    }

    $scope.selectCategory = function (categoryId) {

        $state.go('categories.detail', {categoryId: categoryId});
        $scope.selectedCategoryId = categoryId;




        //$location.path('/categories/' + $scope.selectedCategoryId, false);


        //Categories
        /*
         var repo = dataContext.repository('catalog');
         $scope.service = collectionService.createInstance(repo.products, {categoryId: $scope.selectedCategoryId});
         $scope.service
         .refresh()
         .success(function (data) {
         });
         */
    }

    //$scope.selectCategory($routeParams.categoryId);
}]);