angular.module('vespolina')
    .controller('ActiveProductController', ['$scope', function($scope) {
        $scope.activeProduct = $scope.product;
    }])
    .directive('vProduct', function() {
        return {
            restrict: 'AE',
            scope: {
                product: '=vProduct'
            },
            templateUrl: function(element, attrs) {
                return attrs.templateUrl || '/vespolina/product/product.html';
            },
            controller: 'ActiveProductController'
        };
});
