// loginController
appModule.controller('loginController', ['$scope', '$rootScope', 'app','dataContext', function ($scope, $rootScope, app, dataContext) {

    $scope.credentials = {
        email: 'pda.clms@gmail.com',
        password: 'admin'
    };

    $scope.customer = {

    };

    /*
    console.log($scope.loginForm);
    $scope.test = function (testCase) {
        switch (testCase) {
            case 1:
                var errors = {
                    'email': ['email'],
                    'password': ['required', 'minlength']
                }
                break;
            case 2:
                var errors = {
                    'email': ['email'],
                    'password': ['minlength']
                }
                break;

            case 3:
                var errors = {};
        }

        validationDecorator.decorate($scope.credentials, errors, $scope.loginForm);
        //console.log($scope.loginForm.email.$error)
    };

    $scope.test2 = function () {
        $scope.loginForm.$setPristine();
        //console.log($scope.loginForm.email.$error)
    };


     $scope.alert = function () {
     //$rootScope.notification.show('login','error', 'Authentication failed', ['Email or password do not match']);
     //$scope.loginAlerts = [{ type: 'danger', msg: '<ul><li>Oh snap! Change a few things up and try submitting again.</li></ul>ul>' }];
     };

    */

    // login
    $scope.login = function () {
        app.login($scope.credentials)
            .error(function (data, status, headers, config) {
                switch (status) {
                    case 400: //Bad request - Validation errors
                        $rootScope.notification.show('login', 'error', 'Validation', $rootScope.getValidationErrors(data));
                        break
                    case 401: //Authentication failed
                        $rootScope.notification.show('login', 'error', 'Authentication failed', ['Email or password do not match']);
                        break
                }
            })
    };



    // register
    $scope.register = function () {
        dataContext.repository('customers')
            .register(null, $scope.customer)
            .success(function (data) {
                var credentials = {email: $scope.customer.email, password: $scope.customer.password};
                app.login(credentials);
            })
            .error(function (data, status, headers, config) {
                switch (status) {
                    case 400: //Bad request - Validation errors
                        $rootScope.notification.show('register', 'error', 'Register failed', $rootScope.getValidationErrors(data));
                        break
                }
            })
    }

    $scope.fillSampleCustomer=function() {
        dataContext.repository('customers')
            .empty()
            .success(function (data) {
                $scope.customer = data;
            })
    }
}]);