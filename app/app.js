'use strict';

/* App Module */

var olippApp = angular.module('olippApp', [
  'ngRoute',
  'olippDirectives',
  'olippControllers',
  'olippServices'
]);

var olippServices = angular.module('olippServices', ['ngResource']);

olippApp.config(['$routeProvider',
  function($routeProvider) {    

    $routeProvider.
      when('/dashboard', {
        templateUrl: 'partials/Dashboard.html',
        controller: 'OlippDashboardCtrl'
      }).
      when('/service/:id', {
        templateUrl: 'partials/Service.html',
        controller: 'OlippServiceCtrl'
      }).
      when('/contact/:id', {
        templateUrl: 'partials/Contact.html',
        controller: 'OlippContactCtrl'
      }).
      when('/article/:id', {
        templateUrl: 'partials/Article.html',
        controller: 'OlippArticleCtrl'
      }).
      when('/login', {
        title: 'Login',
        templateUrl: 'partials/Login.html',
        controller: 'OlippAuthCtrl'
      }).
      when('/signup', {
        title: 'SignUp',
        templateUrl: 'partials/SignUp.html',
        controller: 'OlippAuthCtrl'
      }).
      when('/recover', {
        title: 'Recover Account',
        templateUrl: 'partials/RecoverAccount.html',
        controller: 'OlippAuthCtrl'
      }).
      otherwise({
        redirectTo: '/dashboard',
      });
  }])
  .run(function($rootScope, $location, authWebServices){
        
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            console.log("routeChangeStart");
            $rootScope.authenticated = false;
            $rootScope.status = true;
            authWebServices.session()
                        .success(function (results, status, headers, config) {
                          console.log(results);
                                  if (results.guid) {
                                      $rootScope.authenticated = true;
                                      $rootScope.guid = results.guid;
                                      $rootScope.username = results.username;
                                      $rootScope.email = results.email;
                                  } 
                        }).
                        error(function(results, status, headers, config) {
                                console.log('error: ' + results);
                        });
        });

        $rootScope.$on("OlippLoginEvent", function (event, data) {
            console.log("on -> OlippLoginEvent");
            $rootScope.authenticated = false;
            $rootScope.status = true;
            authWebServices.login(data['username'], data['password']).
                        success(function(results, status, headers, config) {
                                console.log(results);
                                $rootScope.status = true;
                                $rootScope.successMessage = results.message;  

                                $rootScope.authenticated = true;
                                $rootScope.guid = results.guid;
                                $rootScope.username = results.username;
                                $rootScope.email = results.email; 
                                $location.path("/dashboard");                              
                        }).
                        error(function(results, status, headers, config) {
                                console.log(results);
                                $rootScope.status = false;
                                $rootScope.errorMessage = results.message; 
                        });
        });

        $rootScope.$on("OlippLogoutEvent", function (event, data) {
            console.log("on -> OlippLogoutEvent");

            authWebServices.logout().
                        success(function(results, status, headers, config) {
                                console.log(results);
                                $rootScope.authenticated = false;
                                $rootScope.guid = results.guid;
                                $rootScope.username = results.username;
                                $rootScope.email = results.email;
                                $location.path("/dashboard");                               
                        }).
                        error(function(results, status, headers, config) {
                                console.log('error: ' + results);
                        });             
        });

  });
