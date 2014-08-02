(function() {
    'use strict';

    angular.module('vespolina')
        .provider('productProvider', [function() {
            var self = this;
            this.product = null;

            this.$get = function() {
                return {
                    getMatchingVariation: function(options) {
                        var variations = angular.copy(self.product.variations);
                        var variation;
                        for (variation in variations) {
                            if (!variations.hasOwnProperty(variation)) {
                                continue;
                            }
                            var optionGroups = variations[variation]['optionGroups'];
                            var i = optionGroups.length;
                            while (i--) {
                                var type = optionGroups[i]['type'];
                                var index = options[type];
                                if (optionGroups[i]['options'][0]['index'] == index) {
                                    continue;
                                }
                                delete variations[variation];
                                break;
                            }
                        }

                        for (variation in variations) {
                            if (!variations.hasOwnProperty(variation)) {
                                continue;
                            }

                            return variations[variation];
                        }

                        return false;
                    },
                    setProduct: function(product) {
                        self.product = product;
                    }
                }
            }
        }]);
}());
