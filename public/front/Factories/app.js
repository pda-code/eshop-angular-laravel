appModule.factory('app',['$rootScope','$state','dataContext','cart','$window', function($rootScope,$state, dataContext,cart,$window) {

    var self = this;

    //Init
    self.language = null;
    self.currency = null;
    self.customer = null;

    self.languages = [];
    self.currencies = [];

    self.configuration = null;

    self.shoppingCart = new cart('shopping');
    self.wishlist = new cart('wishlist');
    self.comparison = new cart('compare');


    if ($window.sessionStorage['layout'])
        self.layout=$window.sessionStorage['layout'];
    else
        self.layout='grid';

    //Copy carts from session storage
    angular.forEach(['shopping','wishlist','compare'],function(name,key){
        switch (name)
        {
            case 'shopping':
                self.shoppingCart.fromJson($window.sessionStorage[name]);
                break;
            case 'wishlist':
                self.wishlist.fromJson($window.sessionStorage[name]);
                break;
            case 'compare':
                self.comparison.fromJson($window.sessionStorage[name]);
                break;
        }
    });

    //Copy carts to session storage
    $rootScope.$on('cleared', function(event, cart) {
        $window.sessionStorage[cart.name]=cart.toJson();
    });

    $rootScope.$on('itemAdded', function(event, cartItem, cart) {
        $window.sessionStorage[cart.name]=cart.toJson();
    });

    $rootScope.$on('itemUpdated', function(event, cartItem, cart) {
        $window.sessionStorage[cart.name]=cart.toJson();
    });

    $rootScope.$on('itemRemoved', function(event, cartItem, cart) {
        $window.sessionStorage[cart.name]=cart.toJson();
    });

    // format number
    self.formatPrice = function (amount) {
        if (!isNaN(amount))
            return Number(amount).toFixed(2) + '€'
        //return amount.toString() + ' euro';
        else
            return '';
    };

    // format date
    self.formatDate = function (date) {
        return date;
        //return $filter('date')(Date.parse(date), 'medium');
    };


    // set customer
    self.setCustomer = function (customer) {
        self.customer = customer;
    }

    // set language
    self.setLanguage = function (language) {
        self.language = language;
        $window.sessionStorage.language_id=self.language.id;
    }

    // set currency
    self.setCurrency = function (currency) {
        self.currency = currency;
        $window.sessionStorage.currency_id=self.currency.id;
    }

    // set currency
    self.setLayout = function (layout) {
        self.layout = layout;
        $window.sessionStorage.layout=layout;
    }

    /*
    // change language
    self.changeLanguage = function (id) {
        var repo = dataContext.repository('store');
        repo.changeLanguage(null, {id: id})
            .success(function (data) {
                self.setLanguage(data);
                //$translate.use(data.code);
            });
    }

    // change currency
    self.changeCurrency = function (id) {
        var repo = dataContext.repository('store');
        repo.changeCurrency(null, {id: id})
            .success(function (data) {
                self.setCurrency(data);
            });
    }
    */

    self.copyCartContents = function (from, to) {
        to.items = from.items;
        to.totals = from.totals;
        to.tax = from.tax;
        to.total = from.total;
        to.total_including_tax = from.total_including_tax;
    }

    // get settings
    self.init = function () {
        var repo = dataContext.repository('store');
        repo.settings()
            .success(function (data) {

                self.setCustomer(data.customer);
                self.setLanguage(data.language);
                self.setCurrency(data.currency);

                //for (var key in self.cartTypes)
                //    self.copyCartContents(data.settings.carts[key],self.carts[key]);

                //self.configuration = data.settings.configuration;
                self.currencies = data.currencies;
                self.languages = data.languages;
                //console.log(self.shoppingCart());
            });
    }


    /*
    // add to cart
    self.addToCartGerneral = function (cart, item, quantity) {
        console.log(item);
        return;
        var repo = dataContext.repository('store');
        return repo.addToCart({cart_type: cart_type, id: id}, {quantity: quantity})
            .success(function (data) {
                self.copyCartContents(data, self.carts[cart_type]);
            });
    }

    // remove from cart
    self.removeFromCartGeneral = function (cart_type, id) {
        console.log(cart_type, id)
        var repo = dataContext.repository('store');
        return repo.removeFromCart({cart_type: cart_type, id: id})
            .success(function (data) {
                self.copyCartContents(data, self.carts[cart_type]);
            });
    }
    */

    // log in
    self.login = function (credentials) {
        var repo = dataContext.repository('customers');
        return repo.login(null, credentials)
            .success(function (data) {
                $window.sessionStorage.auth_token = data.auth_token;

                self.setCustomer(data.customer);
                self.shoppingCart.clear();
                //for (var key in self.cartTypes)
                //    self.copyCartContents(data.carts[key], self.carts[key]);

                $state.go("home");
            })
    };

    // log out
    self.logout = function () {
        var repo = dataContext.repository('customers');
        repo.logout(null, null)
            .success(function (data) {
                delete $window.sessionStorage.auth_token;
                self.setCustomer(null);
                $state.go("home");
            })
    };


    self.isAuthenticated = function () {
        return self.customer != null && $window.sessionStorage.auth_token != null;
    }

    return self;
}]);