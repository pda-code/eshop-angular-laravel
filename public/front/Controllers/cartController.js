//cardController
appModule.controller('cartController', ['$scope', '$rootScope', 'dataContext', function ($scope, $rootScope, dataContext) {

    angular.forEach($scope.app.shoppingCart.items,function(item,key){
        item.tmpQuantity=item.quantity;
    });

    $scope.updateCart=function() {
        angular.forEach($scope.app.shoppingCart.items, function (item, key) {

            if (item.tmpQuantity == '')
                item.quantity = 1;
            else if (isNaN(parseInt(item.tmpQuantity)))
                item.quantity = 1;
            else
                item.quantity = item.tmpQuantity;
        });

        angular.forEach($scope.app.shoppingCart.items, function (item, key) {
            item.tmpQuantity = item.quantity;
        });
    }
}]);