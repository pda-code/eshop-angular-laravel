// DataContext
appModule.factory('cart', ['$rootScope',function ($rootScope) {

    //cartItem contsructor
    function CartItem(product,quantity)
    {
        var self=this;

        self.product=product;
        self.quantity=quantity;
    }

    CartItem.prototype.getTax=function()
    {
       return this.quantity * this.product.tax;
    }

    CartItem.prototype.getTotal=function()
    {
        return this.quantity * this.product.price;
    }

    CartItem.prototype.getTotalIncludingTax=function()
    {
        return this.getTotal() + this.getTax();
    }

    //cart contsructor
    function Cart(name) {

        var self = this;
        self.name=name;
        self.items = [];
        self.totals = [];
        self.enableBroadCast=true;
    }

    Cart.prototype.clear=function() {
        this.items = [];
        this.totals = [];
        if (this.enableBroadCast) $rootScope.$broadcast('cleared', this);
    }

    Cart.prototype.getIndex=function(product) {
        var index = -1;
        angular.forEach(this.items, function (item, key) {
            if (item.product.id === product.id) index = key;
        });

        return index;
    }

    Cart.prototype.addOrUpdate=function(product,quantity) {
        if (product == null)  return null;
        if (!angular.isNumber(quantity)) quantity = 1;
        var index = this.getIndex(product);
        var cartItem=null;
        if (index === -1) {
            cartItem = new CartItem(product, quantity);
            this.items.push(cartItem);
        }
        else {
            cartItem = this.items[index];
            cartItem.quantity += quantity;
        }
        this.updateTotals();
        return cartItem;
    };

    Cart.prototype.add=function(product,quantity) {
        var cartItem=this.addOrUpdate(product,quantity);
        if (cartItem==null) return null;
        if (this.enableBroadCast) $rootScope.$broadcast('itemAdded',cartItem,this);
        return cartItem;
    };

    Cart.prototype.update=function(product,quantity) {
        var cartItem=this.addOrUpdate(product,quantity);
        if (cartItem==null) return null;
        if (this.enableBroadCast) $rootScope.$broadcast('itemAdded',cartItem,this);
        return cartItem;
    };

    Cart.prototype.remove=function(product,quantity) {
        if (product == null)  return null;
        if (!angular.isNumber()) quantity = 1;
        var index = this.getIndex(product);
        if (index === -1) return null;
        var cartItem=this.items[index];
        this.items.splice(index, 1);

        if (cartItem==null) return null;
        if (this.enableBroadCast) $rootScope.$broadcast('itemRemoved',cartItem,this);

        this.updateTotals();
        return cartItem;
    };

    Cart.prototype.getProductIds=function()
    {
        var ids=[];
        angular.forEach(this.items, function (item, key) {
            ids.push(item.product.id);
        });

        return ids;
    }

    Cart.prototype.getTax=function()
    {
        var tax=0.0;
        angular.forEach(this.items, function(item, key) {
            tax += item.getTax();
        });

        return tax;
    }

    Cart.prototype.getTotal=function()
    {
        var total=0.0;
        angular.forEach(this.items, function(item, key) {
            total += item.getTotal();
        });

        return total;
    }

    Cart.prototype.getTaxes=function() {
        var taxes = {};
        angular.forEach(this.items, function (item, key1) {
            angular.forEach(item.product.taxes, function (itemTax, key2) {
                var taxId = itemTax.id.toString();
                if (taxes[taxId] === undefined)
                    taxes[taxId] = {id: itemTax.id, name: itemTax.name, amount: item.quantity * itemTax.amount}
                else
                    taxes[taxId].amount += (item.quantity * itemTax.amount);
            });
        });

        var flatTaxes = [];
        for (var key in taxes)
            flatTaxes.push(taxes[key]);

        return flatTaxes;
    }

    Cart.prototype.getTotals=function() {
        var self = this;
        var totals = [];
        var taxes = self.getTaxes();

        //Sub Total
        totals.push({title: 'Sub Total', value: self.getTotal()});

        //Taxes
        angular.forEach(taxes, function (item, key) {
            totals.push({title: item.name, value: item.amount});
        });

        //Grand Total
        totals.push({title: 'Grand Total', value: self.getTotalIncludingTax()});

        return totals;
    }

    Cart.prototype.updateTotals=function() {
        this.totals=this.getTotals();
    }

    Cart.prototype.getTotalIncludingTax=function()
    {
        return this.getTotal() + this.getTax();
    }

    Cart.prototype.toJson=function()
    {
        return JSON.stringify(this);
    }

    Cart.prototype.fromJson=function(json) {
        if (!json) return;

        var cart = JSON.parse(json);
        this.items = [];
        this.totals = [];

        this.enableBroadCast=false;

        var self=this;
        angular.forEach(cart.items, function (item, key) {
            self.addOrUpdate(item.product,item.quantity);
        });

        this.enableBroadCast=true;
    }

    return Cart;
}]);

