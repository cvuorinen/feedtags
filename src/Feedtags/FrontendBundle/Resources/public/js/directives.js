angular.module('feedtags.directives', [])
    .directive('feedIcon', function () {
        var feedIconUrl = 'https://www.google.com/s2/favicons?alt=feed&domain=';

        return {
            restrict: 'EA',
            replace: true,
            template: '<span class="feed-icon"><img src="' + feedIconUrl + '{{ feed.url }}" alt="" /></span>',
            scope: {
                feed: '='
            }
        };
    });
