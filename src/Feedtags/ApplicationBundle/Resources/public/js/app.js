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
            templateUrl: '/bundles/feedtagsapplication/partials/feeds.html',
            controller: 'FeedsController'
        })
        .otherwise({
            templateUrl: '/bundles/feedtagsapplication/partials/error.html'
        });
})
.controller('FeedsController', function() {
    console.log('FeedsController');
});
