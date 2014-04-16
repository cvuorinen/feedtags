angular.module('feedtags.controllers', [])
    .controller('FeedsController',function ($scope, Feed) {
        // Fetch feeds from server
        $scope.feeds = Feed.query();
    }).controller('FeedItemsController', function ($scope, feedItems) {
        $scope.itemListType = 'items-list-compact';

        $scope.feedItems = feedItems;

        $scope.alert = function (msg) {
            alert(msg);
        };
    });
