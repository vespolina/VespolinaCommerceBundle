var vespolinaApi = {
    'get_products': Routing.generate('v_api_get_products')
};

var get_products = Routing.generate('v_api_get_products');


function ProductPageCtrl($scope, $http, $timeout, ngTableParams) {

    $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,          // count per page
        sorting: {
            name: 'asc'     // initial sorting
        }
    }, {
        total: 0,           // length of data
        getData: function($defer, params) {
            $http({method: 'GET', url: vespolinaApi.get_products, params: params.url()}).success(function(json) {
                $timeout(function() {
                    // update table params
                    params.total(json.total);
                    // set new data
                    $defer.resolve(json.data);
                }, 500);
            });
        }
    });
}