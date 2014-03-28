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
            templateUrl: '/bundles/feedtagsapplication/html/feeds.html',
            controller: 'FeedsController'
        })
        .otherwise({
            templateUrl: '/bundles/feedtagsapplication/html/error.html'
        });
})
.controller('FeedsController', function() {
    console.log('FeedsController');
});
