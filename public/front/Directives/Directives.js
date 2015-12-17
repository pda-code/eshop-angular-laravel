appModule.directive('notification', function () {
    return {
        restrict: 'E',
        scope: {},
        replace: true,
        controller: function ($scope) {
            $scope.init = function () {
                $scope.show = false;
                $scope.type = null;
                $scope.headerMessage = null;
                $scope.messages = null;
            };

            $scope.$on('notify', function (event, type, headerMessage, messages) {
                $scope.type = type;
                $scope.headerMessage = headerMessage;
                $scope.messages = messages;
                $scope.toggleDisplay();
            });

            $scope.hide = function () {
                $scope.init();
            };

            $scope.toggleDisplay = function toggledisplay() {
                $scope.show = !!($scope.type && $scope.headerMessage && $scope.messages);
            };

            $scope.init();
        },
        template: '<div class="alert alert-{{type}}" ng-show="show">' +
                  '  <button type="button" class="close" ng-click="hide()">&times;</button>' +
				  '  <h4>{{headerMessage}}</h4>' +
				  '  <ul>' +
				  '		<li ng-repeat="msg in messages">{{msg}}</li>' +
				  ' </ul>' +
                  '</div>'
    };
});

appModule.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function () {
                var file = element[0].files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var s = reader.result.split(",");
                    scope.$apply(function () {
                        modelSetter(scope, s[1]);
                    });
                };

                reader.readAsDataURL(file);
            });
        }
    };
}]);