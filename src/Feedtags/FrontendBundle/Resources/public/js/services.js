angular.module('feedtags.services', [
    'ngResource'
]).factory('Feed', function($resource) {
    return $resource('/api/feeds/:feedId', {feedId:'@id'});
});
