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
    }).directive('feedItemList', function () {
        return {
            restrict: 'A',
            scope: {},
            controller: function () {
                this.open = function (feedItem) {
                    // TODO implement auto-closing others if needed
                    //console.log('feedItemList.open', feedItem);
                };

                this.close = function (feedItem) {};
            }
        };
    }).directive('feedItem', function ($sce, $compile) {
        var itemTemplate = '<div class="item-content" ng-bind-html="feedItem.contentHtmlSafe"></div>';

        return {
            restrict: 'A',
            require: '^feedItemList',
            scope: {
                feedItem: '='
            },
            link: function (scope, element, attrs, feedItemListCtrl) {
                var isOpen = false;
                var itemContentElement = null;

                // Set item contect as trusted html content
                // TODO sanitize html on server side with HTMLPurifier
                scope.feedItem.contentHtmlSafe = $sce.trustAsHtml(scope.feedItem.content);

                // Toggle item content on click
                element.click(function () {
                    if (isOpen) {
                        isOpen = false;

                        scope.$apply(function () {
                            itemContentElement.remove();
                        });

                        itemContentElement = null;
                        feedItemListCtrl.close(scope.feedItem);
                    } else { // closed
                        isOpen = true;
                        itemContentElement = $(itemTemplate);

                        scope.$apply(function () {
                            element.append(
                                $compile(itemContentElement)(scope)
                            );
                        });

                        feedItemListCtrl.open(scope.feedItem);
                    }
                });
            }
        };
    });
