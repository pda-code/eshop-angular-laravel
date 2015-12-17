//compareController
appModule.controller('compareController', ['$scope', '$rootScope', '$stateParams', '$state', 'dataContext','app', function ($scope, $rootScope, $stateParams, $state, dataContext,app) {

    $scope.init=function()
    {
        var ids=app.comparison.getProductIds();
        var repo = dataContext.repository('catalog');
        repo.compare({product_ids:ids})
            .success(function (data) {
                console.log(data);
                $scope.noItems=false;
                $scope.compareData=data;
            })
            .error(function (data, status, headers, config) {
                switch (status) {
                    case 400:
                        break
                }
            })
    };

    if (app.comparison.items.length>0)
        $scope.init();


    $scope.findValue=function(productsId, products)
    {
        var item=null;
        angular.forEach(products, function(product) {
            if (product.id == productsId) item=product;
        });

        return (item)?item.value:'-';
    }



    $scope.remove=function(id,index) {
        app.comparison.remove({id:id});
        $scope.compareData.products.splice(index, 1);

        //app.removeFromCart(app.cartTypes.COMPARE, id)
        //    .success(function () {
        //        $scope.noItems=app.compareCart().itemsCount()==0;
        //    });
    }
}]);