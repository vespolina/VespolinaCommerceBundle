var adminApp = angular.module('adminApp', ['ngRoute'])
    .directive('navMenu', function($location) {
    return function(scope, element, attrs) {
        var links = element.find('a'),
            onClass = attrs.navMenu || 'active',
            routePattern,
            link,
            url,
            currentLink,
            urlMap = {},
            i;

        if (!$location.$$html5) {
            routePattern = /^#[^/]*/;
        }

        for (i = 0; i < links.length; i++) {
            link = angular.element(links[i]);
            url = link.attr('href');

            if ($location.$$html5) {
                urlMap[url] = link;
            } else {
                urlMap[url.replace(routePattern, '')] = link;
            }
        }

        scope.$on('$routeChangeStart', function() {
            var pathLink = urlMap[$location.path()];

            if (pathLink) {
                if (currentLink) {
                    currentLink.removeClass(onClass);
                }
                currentLink = pathLink;
                currentLink.addClass(onClass);
            }
        });
    };
});

// configure our routes
adminApp.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '/bundles/vespolinacommerce/partials/dashboard.html'
        })
        .when('/products', {
            templateUrl: '/bundles/vespolinacommerce/partials/products.html'
        })
        .otherwise({
            redirectTo: '/'
        })
        ;
});

function AdminPageController($scope) {

}
