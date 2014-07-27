angular.module('vespolina').directive('vProductOptions', ['productProvider', function(productProvider) {
        return {
            restrict: 'AE',
            link: function (scope, element) {
                scope.selectElements = {};
                angular.forEach(scope.product.option_groups, function(optionGroup, key) {
                    element.append('<label for=' + optionGroup.type + '" class="control-label">' + optionGroup.type + '</label>');
                    scope.selectElements[optionGroup.type] = null;
                    var selectElement = buildSelect(optionGroup);
                    selectElement.on('change', function() {
                        scope.$apply(function() {
                            var type = selectElement.attr('name');
                            var index = selectElement.val();
                            scope.selectElements[type] = index;

                            var recalculate = [];
                            angular.forEach(scope.selectElements, function(index, type) {
                                if ((typeof index === 'object')) {
                                    this.push(type);
                                }
                            }, recalculate);
                            if (recalculate.length === 0) {
                                // check for a matching variation
                                var variation = productProvider.getMatchingVariation(scope.selectElements);
                                if (variation) {
                                    scope.activeProduct = variation;
                                } else {
                                    // flash message
                                }
                            }
                        });
                    });
                    element.append(selectElement);
                    scope.selectElements[optionGroup.type] = selectElement;
                });
                function buildSelect(optionGroup) {
                    var selectElement = angular.element('<select name="' + optionGroup.type + '"></select>');
                    selectElement.append('<option selected></option>');
                    angular.forEach(optionGroup.options, function(option, key) {
                        selectElement.append('<option ' + option.index + '>' + option.display + '</option>');
                    });

                    return selectElement;
                };
            },
            templateUrl: function(elem, attrs) {
                return attrs.templateUrl || '/vespolina/product/product-options.html';
            }
        };
    }]);
