/**
 * Main app for Feedtags
 */
angular.module('feedtagsApp', [
    'ngRoute'
])
.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            redirectTo: '/feeds'
        })
        .when('/feeds', {
            templateUrl: '/bundles/feedtagsfrontend/partials/feeds.html',
            controller: 'FeedsController'
        })
        .otherwise({
            templateUrl: '/bundles/feedtagsfrontend/partials/error.html'
        });
})
.controller('FeedsController', function() {
    console.log('FeedsController');
});
