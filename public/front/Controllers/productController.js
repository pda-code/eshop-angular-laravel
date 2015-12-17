appModule.controller('productController', ['$scope', '$rootScope', '$stateParams','$state', 'dataContext', 'collectionService', 'Lightbox', function ($scope, $rootScope, $stateParams, $state, dataContext, collectionService, Lightbox) {

    var repo = dataContext.repository('catalog');
    $scope.service = collectionService.createInstance(repo.productReviews,{id: $stateParams.productId,paging:[5]});

    $scope.quantity = 1;
    $scope.activeTab = 'description';
    $scope.reviewsLoaded = false;
    $scope.specsLoaded = false;

    $scope.lightBoxImages = [];
    $scope.review = {};

    $scope.submitReview = function () {
        var repo = dataContext.repository('reviews');
        repo.create(null, $scope.review)
            .success(function (data) {
                $scope.reviewForm.$setPristine();
                $scope.review = {}
            });
    }


    // get product
    repo.product({id: $stateParams.productId, update_views:true})
        .success(function (data) {
            $scope.product = data;
            $scope.lightBoxImages.push({url: 'images/' + $scope.product.image, caption: ''});
            angular.forEach($scope.product.images, function (value, key) {
                $scope.lightBoxImages.push({url: 'images/' + value.image, caption: ''});
            });
        });

    $scope.changeTab = function (tab) {
        if ($scope.activeTab === tab) return;

        if (tab === 'reviews' && $scope.reviewsLoaded === false) {
            $scope.service
                .refresh()
                .success(function (data) {
                    $scope.activeTab = tab;
                    $scope.reviewsLoaded = true;
                });
        }
        else
            $scope.activeTab = tab;

        if (tab === 'specs' && $scope.specsLoaded === false) {
            // get categories with preselection
            repo.productSpecs({id: $stateParams.productId})
                .success(function (data) {
                    console.log(data);
                    $scope.specs = data;
                    $scope.activeTab = tab;
                    $scope.specsLoaded = true;
                });
        }
        else
            $scope.activeTab = tab;

    };

    $scope.overStar = null;
    $scope.percent = 0;

    $scope.hoveringOver = function (value) {
        $scope.overStar = value;
        $scope.percent = 100 * (value / 5);
    };

    /*
    $scope.addToCart = function (cart_type, id) {
        if (angular.isNumber($scope.quantity))
            $rootScope.addToCart(cart_type, id, $scope.quantity)
        else
            $scope.quantity = 1;
    };
    */

    $scope.openLightboxModal = function (index) {
        Lightbox.openModal($scope.lightBoxImages, index);
    };

}]);
