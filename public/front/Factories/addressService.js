appModule.factory('addressService',['$rootScope','dataContext', function($rootScope, dataContext) {

    var self = this;

    self.countries = [];
    self.zones = [];

    //get initial options
    dataContext.repository('store')
        .countriesAndZones()
        .success(function (data) {
            self.countries = data.countries;
            self.zones = data.zones;
        });

    self.getObject=function(type,id) {
        var arr = null;
        if (type == 'country')
            arr = self.countries;
        else
            arr = self.zones;

        for (var i = 0; i < arr.length; i++) {
            if (arr[i].id === id) {
                return arr[i];
            }
        }

        return null;
    }

    // format address
    self.formatAddress = function (address) {
        function resolve(item, path) {
            var token = /w+/g;
            var results = path.split(".");
            var temp = item;
            for (var i = 0; i < results.length; i++)
                if (temp) temp = temp[results[i]];

            return (temp) || '{' + path + '}';
        }

        function addline(line) {
            if (line != '')
                return line + '<br\>';
            else
                return '';
        }

        if (address == null)
            return '';
        else {

            address.country=self.getObject('country',address.country_id);
            address.zone=self.getObject('zone',address.zone_id);

            return addline(resolve(address, 'last_name') + ' ' + resolve(address, 'first_name')) +
                addline(resolve(address, 'address_1')) +
                addline(resolve(address, 'address_2')) +
                addline(resolve(address, 'city') + ', ' + resolve(address, 'postal_code')) +
                addline(resolve(address, 'zone.name')) +
                addline(resolve(address, 'country.name'));
        }
    };


    self.flatten=function(address,prefix) {
        address.country = self.getObject('country', address.country_id);
        address.zone = self.getObject('zone', address.zone_id);

        var result = [];
        result[prefix + 'first_name'] = resolve(address, 'first_name');
        result[prefix + 'last_name'] = resolve(address, 'last_name');
        result[prefix + 'company'] = resolve(address, 'company');
        result[prefix + 'address_1'] = resolve(address, 'address_1');
        result[prefix + 'address_2'] = resolve(address, 'address_2');
        result[prefix + 'city'] = resolve(address, 'city');
        result[prefix + 'postal_code'] = resolve(address, 'postal_code');
        result[prefix + 'country_id'] = resolve(address, 'country_id');
        result[prefix + 'zone_id'] = resolve(address, 'zone_id');

        return result
    }

    return self;
}]);