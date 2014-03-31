angular.module('feedtags.controllers', []).controller('FeedsController', function($scope, Feed) {
    console.log('FeedsController');
    $scope.feeds = Feed.query();
});