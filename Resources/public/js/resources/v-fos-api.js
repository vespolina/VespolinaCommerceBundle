(function() {
    'use strict';

    angular.module('vespolina')
        .factory('vApiRecourse', ['$http', function ($http) {
            function FOSApiResource() {}

            FOSApiResource.prototype.getProduct = function(productId) {
                return $http.get(Routing.generate('v_api_get_product', {productId: productId}))
                    .then(function(response) {
                        return response.data;
                    });
            };

            return new FOSApiResource();
        }]);
}());
