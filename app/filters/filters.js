var olippFilters = angular.module('olippFilters', []);

olippFilters.filter('trusted', ['$sce', function ($sce) {
    return function(url) {
        return $sce.trustAsResourceUrl(url);
    };
}]);