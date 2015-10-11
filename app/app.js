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
      otherwise({
        redirectTo: '/dashboard',
      });
  }])
  .run(function($rootScope, $location){
    
  });
