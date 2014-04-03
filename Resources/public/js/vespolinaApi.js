var vespolinaApi = {
    getOrder: function(orderId) {
        return Routing.generate('v_api_get_order', {orderId: orderId});
    },
    getProducts: function() {
        return Routing.generate('v_api_get_products');
    }
};