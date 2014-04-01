/**
 * Main app for Feedtags
 */
angular.module('feedtagsApp', [
        'ngRoute',
        'feedtags.services',
        'feedtags.controllers'
    ])
    .config(function ($routeProvider) {
        $routeProvider
            .when('/', {
                redirectTo: '/all'
            })
            .when('/all', {
                templateUrl: '/bundles/feedtagsfrontend/partials/feed-items.html',
                controller: 'FeedItemsController',
                resolve: {
                    feedItems: function (FeedItem) {
                        return FeedItem.query();
                    }
                }
            })
            .when('/feeds', {
                templateUrl: '/bundles/feedtagsfrontend/partials/feeds.html',
                controller: 'FeedsController'
            })
            .otherwise({
                templateUrl: '/bundles/feedtagsfrontend/partials/error.html'
            });
    });
