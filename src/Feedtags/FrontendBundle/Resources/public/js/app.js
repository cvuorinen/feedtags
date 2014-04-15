/**
 * Main app for Feedtags
 */
angular.module('feedtagsApp', [
        'ngRoute',
        'feedtags.services',
        'feedtags.directives',
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
            .when('/feeds/:id', {
                templateUrl: '/bundles/feedtagsfrontend/partials/feed-items.html',
                controller: 'FeedItemsController',
                resolve: {
                    feedItems: function ($route, FeedItem) {
                        return FeedItem.query({feedId: $route.current.params.id});
                    }
                }
            })
            .otherwise({
                templateUrl: '/bundles/feedtagsfrontend/partials/error.html'
            });
    });
