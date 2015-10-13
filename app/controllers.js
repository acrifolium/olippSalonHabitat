var olippControllers = angular.module('olippControllers', []);

olippControllers.controller('OlippNavTreeCtrl', ['$scope', '$routeParams','dataWebServices', function($scope, $routeParams, dataWebServices) {
    
    dataWebServices.navigation().then(function(results){
      console.log(results);
      $scope.tree = results.data;

      $scope.dashboard = [];
      $scope.menuItems = [];

      for (var i = 0; i < $scope.tree.length; i++) {
        if($scope.tree[i].type == 'dashboard') {
          $scope.dashboard = $scope.tree[i];
        }
        else if($scope.tree[i].type != 'dashboard') {
          $scope.menuItems.push($scope.tree[i]);
        }
      }    
    });
}]);

olippControllers.controller('OlippCarouselCtrl', ['$scope', function($scope) {
  
}]);

olippControllers.controller('OlippFooterCtrl', ['$scope','dataWebServices', function($scope, dataWebServices) {
  dataWebServices.contact().then(function(results){
    console.log(results);
    $scope.contact = results.data;
    $scope.date = new Date();
  });
}]);


olippControllers.controller('OlippDashboardCtrl', ['$scope', function($scope) {
  $scope.DashboardTitle = "Dashboard AngularJS Page";
}]);

olippControllers.controller('OlippServiceCtrl', ['$scope','$routeParams', function($scope, $routeParams) {
  $scope.ServiceTitle = "Service AngularJS Page";
  $scope.Id = $routeParams.id;
}]);

olippControllers.controller('OlippContactCtrl', ['$scope','$routeParams', function($scope, $routeParams) {
  $scope.ContactTitle = "Contact AngularJS Page";
  $scope.Id = $routeParams.id;
}]);

olippControllers.controller('OlippArticleCtrl', ['$scope','$routeParams', function($scope, $routeParams) {
  $scope.ArticleTitle = "Article AngularJS Page";
  $scope.Id = $routeParams.id;
}]);
