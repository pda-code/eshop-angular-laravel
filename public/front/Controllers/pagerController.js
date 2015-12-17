//pagerController
appModule.controller('pagerController', ['$scope', '$rootScope','collectionService', 'dataContext', function ($scope, $rootScope,collectionService, dataContext) {

    var repo = dataContext.repository('catalog');
    $scope.service = collectionService.createInstance(repo.productReviews,{id: 1,paging:[2]});

    $scope.service
        .refresh()
        .success(function (data) {
        });
}]);