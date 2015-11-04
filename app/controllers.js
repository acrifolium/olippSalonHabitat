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

olippControllers.controller('OlippCarouselSalonCtrl', ['$scope', function($scope) {
  
}]);

olippControllers.controller('OlippFooterCtrl', ['$scope','dataWebServices', function($scope, dataWebServices) {
  $scope.date = new Date();
}]);


olippControllers.controller('OlippDashboardCtrl', ['$scope', 'dataWebServices', function($scope, dataWebServices) {
  dataWebServices.dashboard().then(function(results){
    console.log(results);
    $scope.dashboard = results.data;
  });
}]);

olippControllers.controller('OlippServiceCtrl', ['$scope','$routeParams', 'dataWebServices', function($scope, $routeParams, dataWebServices) {
  $scope.Id = $routeParams.id;

  dataWebServices.exposant().then(function(results){
      console.log(results);
      $scope.exposants = results.data;
    });

  dataWebServices.exposantForm($scope.Id).then(function(results){
      console.log(results);
      $scope.exposantForm = results.data;
    });
}]);

olippControllers.controller('OlippContactCtrl', ['$scope','$routeParams', 'dataWebServices', function($scope, $routeParams, dataWebServices) {
  $scope.Id = $routeParams.id;

  dataWebServices.contact($scope.Id).
                        success(function(results, status, headers, config) {
                          console.log(results);
                          $scope.contact = results;
                        }).
                        error(function(results, status, headers, config) {
                          console.log(results);
                        });

  $scope.status = 0;

  $scope.Send = function(){

  if($scope.company == undefined) $scope.company = "";
  if($scope.telephone == undefined) $scope.telephone = ""; 
  if($scope.message == undefined) $scope.message = "";

  dataWebServices.sendMail($scope.contact.lastname, 
                           $scope.contact.firstname, 
                           $scope.contact.email,
                           $scope.contact.company,
                           $scope.contact.telephone,
                           $scope.contact.message).
                        success(function(results, status, headers, config) {
                                console.log("success");
                                console.log(results.data);
                                $scope.status = 1; 
                                $scope.successMessage = results.message;    
                                $scope.contact.lastname = ""; 
                                $scope.contact.firstname = "";
                                $scope.contact.email = "";
                                $scope.contact.company = "";
                                $scope.contact.telephone = "";
                                $scope.contact.message = "";                      
                        }).
                        error(function(results, status, headers, config) {
                                console.log("error");
                                console.log(results.data);
                                $scope.status = 2;
                                $scope.errorMessage = results.data.message; 
                        });
                      };

}]);

olippControllers.controller('OlippArticleCtrl', ['$scope','$routeParams', function($scope, $routeParams) {
  $scope.ArticleTitle = "Article AngularJS Page";
  $scope.Id = $routeParams.id;
}]);

olippControllers.controller('OlippMovieCtrl', ['$scope','$routeParams','dataWebServices', function($scope, $routeParams, dataWebServices) {
  $scope.MovieTitle = "Movie AngularJS Page";
  $scope.Id = $routeParams.id;

  dataWebServices.movies($scope.Id).
                        success(function(results, status, headers, config) {
                          console.log(results);
                          $scope.movies = results;
                        }).
                        error(function(results, status, headers, config) {
                          console.log(results);
                        });
}]);

