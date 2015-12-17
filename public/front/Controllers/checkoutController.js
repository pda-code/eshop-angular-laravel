//checkoutController
appModule.controller('checkoutController', ['$scope', '$rootScope','$state','dataContext','addressService', function ($scope, $rootScope, $state, dataContext, addressService) {

    $scope.steps = [];
    $scope.steps['personal'] = {title: 'Personal Information', description: 'Please fill in your personal information'};
    $scope.steps['shipping'] = {title: 'Shipping', description: 'Please select you shipping method'};
    $scope.steps['payment'] = {title: 'Payment', description: 'Please select you payment method'};
    $scope.steps['confirm'] = {title: 'Confirm Order', description: 'Please confirm your order'};

    // scope variables
    $scope.addressService = addressService;
    $scope.payment_methods=[];
    $scope.shipping_methods=[];


    $scope.order = {

        default_address:null,

        customer_id: null,
        customer_first_name: null,
        customer_last_name: null,
        customer_phone: null,
        customer_email: null,

        billing_address_first_name: null,
        billing_address_last_name: null,
        billing_address_company: null,
        billing_address_address_1: null,
        billing_address_address_2: null,
        billing_address_city: null,
        billing_address_postal_code: null,
        billing_address_country_id: null,
        billing_address_zone_id: null,

        shipping_address_same_as_billing_address: true,

        shipping_address_first_name: null,
        shipping_address_last_name: null,
        shipping_address_company: null,
        shipping_address_address_1: null,
        shipping_address_address_2: null,
        shipping_address_city: null,
        shipping_address_postal_code: null,
        shipping_address_country_id: null,
        shipping_address_zone_id: null,

        shipping_method: null,
        payment_method: null,
    };

    $scope.step = "personal";
    $scope.gotoStep = function (step) {
        $scope.step = step;
    }

    //get initial options
    dataContext.repository('orders')
        .checkoutOptions()
        .success(function (data) {
            $scope.shipping_methods = data.shipping_methods;
            $scope.payment_methods = data.payment_methods;

            $scope.order.shipping_method = $scope.shipping_methods[0].name;
            $scope.order.payment_method = $scope.payment_methods[0].name;

            if (data.customer != null) {
                $scope.order.customer_id=data.customer.id;
                $scope.order.customer_first_name=data.customer.first_name;
                $scope.order.customer_last_name=data.customer.last_name;
                $scope.order.customer_phone=data.customer.phone;
                $scope.order.customer_email=data.customer.email;

                $scope.addresses=data.customer.addresses;

                $scope.order.default_address= data.customer.default_address;

                if ($scope.order.default_address==null)
                {
                    $scope.order.default_address={
                        first_name:data.customer.first_name,
                        last_name:data.customer.last_name,
                    }
                }
                $scope.fillAddress('billing',$scope.order.default_address);
            }
        });

    $scope.checkout = function () {
        var repo = dataContext.repository('orders');

        //create order
        var order = angular.extend({}, $scope.order);
        delete order.default_address;
        order.line_items = [];
        order.totals = [];

        angular.forEach($scope.app.shoppingCart.items, function (item, key) {
            order.line_items.push({
                product_id: item.product.id,
                name: item.product.name,
                model: item.product.model,
                quantity: item.quantity,
                tax: item.getTax(),
                total: item.getTotal(),
                total_including_tax: item.getTotalIncludingTax()
            });
        });

        var sort_order = 0;
        angular.forEach($scope.app.shoppingCart.totals, function (item, key) {
            order.totals.push({
                code: item.title,
                title: item.title,
                value: item.value,
                sort_order: (++sort_order),
            });
        });

        order.total = order.totals[order.totals.length - 1].value;

        repo.checkoutOrder(null, order)
            .success(function (data, status, headers, config) {
                $rootScope.app.shoppingCart.clear();
                $state.go('checkout-success');
            })
            .error(function (data, status, headers, config) {
                switch (status) {
                    case 400: //Bad request - Validation errors
                        $rootScope.notification.show('checkout', 'error', 'Validation', $rootScope.getValidationErrors(data));
                        break
                    case 401:
                        $rootScope.notification.show('checkout', 'error', 'Authentication failed', ['Email or password do not match'])
                        break
                }
            });
    }

    $scope.defaultAddressChanged = function (type) {
        $scope.fillAddress(type, $scope.order.default_address);
    };


    $scope.getAddress=function (type) {

        prefix = (type == 'billing') ? 'billing_address_' : 'shipping_address_';

        return {
            first_name: $scope.order[prefix + 'first_name'],
            last_name: $scope.order[prefix + 'last_name'],
            company: $scope.order[prefix + 'company'],
            address_1: $scope.order[prefix + 'address_1'],
            address_2: $scope.order[prefix + 'address_2'],
            city: $scope.order[prefix + 'city'],
            postal_code: $scope.order[prefix + 'postal_code'],
            country_id: $scope.order[prefix + 'country_id'],
            zone_id: $scope.order[prefix + 'zone_id']
        }
    }

    $scope.fillAddress=function(type,address)
    {
        if (address==null) return;

        prefix=(type=='billing')?'billing_address_':'shipping_address_';

        $scope.order[prefix + 'first_name']=address.first_name;
        $scope.order[prefix + 'last_name']=address.last_name;
        $scope.order[prefix + 'company']=address.company;
        $scope.order[prefix + 'address_1']=address.address_1;
        $scope.order[prefix + 'address_2']=address.address_2;
        $scope.order[prefix + 'city']=address.city;
        $scope.order[prefix + 'postal_code']=address.postal_code;
        $scope.order[prefix + 'country_id']=address.country_id;
        $scope.order[prefix + 'zone_id']=address.zone_id;

        if (type=='billing' && $scope.order.shipping_address_same_as_billing_address)
            $scope.fillAddress('shipping',address);
    };

    $scope.fillSampleAddress=function() {
        dataContext.repository('addresses')
            .empty()
            .success(function (data) {
                $scope.fillAddress('billing',data);
            })
    }

    $scope.fillSampleCustomer=function() {
        dataContext.repository('customers')
            .empty()
            .success(function (data) {
                $scope.order.customer_first_name = data.first_name;
                $scope.order.customer_last_name = data.last_name;
                $scope.order.customer_phone = data.phone;
                $scope.order.customer_email = data.email;
            })
    }
}]);