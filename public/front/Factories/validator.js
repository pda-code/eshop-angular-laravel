appModule.factory('validationDecorator',['$rootScope','dataContext','$window', function($rootScope, dataContext, $window) {

    var self = this;

    self.decorate=function(model, data, form)
    {
        for (var propertyName in model) {
            var field = form[propertyName];
            //field.$error={};
            //field.$dirty=false;
            //field.$valid=true;
            //field.$pristine=true;

            if (data[propertyName] != undefined) {
                var brokenRules = data[propertyName];
                for (var key in brokenRules) {
                    field.$setDirty();
                    field.$setValidity(brokenRules[key], false);
                }
            }
            else
            {
                field.$setPristine();
                field.$setValidity(brokenRules[key], true);
            }

            console.log(propertyName,field.$error)
        }
    }

    return self;
}]);