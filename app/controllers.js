var olippControllers = angular.module('olippControllers', []);

olippControllers.controller('OlippNavTreeCtrl', ['$scope', '$routeParams','dataWebServices', 'authWebServices', function($scope, $routeParams, dataWebServices, authWebServices) {
    
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

    authWebServices.IsAdminExists().then(function(results){
      console.log(results);
      $scope.IsAdminExists = results.data.value;
    });

    $scope.Logout = function(){
      $scope.$emit('OlippLogoutEvent');
  }
}]);

olippControllers.controller('OlippFooterCtrl', ['$scope', function($scope) {
  $scope.copyright = "Fauchery SARL";
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

olippControllers.controller('OlippAuthCtrl', ['$scope', 'authWebServices', '$location', function($scope, authWebServices, $location) {

  $scope.SignUpAdmin = function(){
    authWebServices.signUpAdmin($scope.signup.username, $scope.signup.email, $scope.signup.password).
                        success(function(results, status, headers, config) {
                                $scope.$emit('OlippLoginEvent', {
                                  username: $scope.signup.username,
                                  password: $scope.signup.password
                                });                              
                        }).
                        error(function(results, status, headers, config) {
                                console.log(results);
                                $scope.status = false;
                                $scope.errorMessage = results.message; 
                        });
  }

  $scope.Login = function(){
    $scope.$emit('OlippLoginEvent', {
      username: $scope.login.username,
      password: $scope.login.password
    });
  }

  $scope.RecoverAccount = function(){
    authWebServices.recoverAccount($scope.recoverAccount.email).
                        success(function(results, status, headers, config) {
                                $location.path("/login");                              
                        }).
                        error(function(results, status, headers, config) {
                                console.log(results);
                                $scope.status = false;
                                $scope.errorMessage = results.message; 
                        });
  }

}]);
