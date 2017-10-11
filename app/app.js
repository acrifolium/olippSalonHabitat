'use strict';

/* App Module */

var olippApp = angular.module('olippApp', [
  'ngRoute',
   'blockUI',
   'ngNotify',
   'pascalprecht.translate',
   'olippDirectives',
   'olippFilters',
   'olippControllers',
   'salonServices'
]);

 olippApp.config(['$routeProvider', 'blockUIConfig', '$translateProvider', '$locationProvider',
   function($routeProvider, blockUIConfig, $translateProvider, $locationProvider) {

    $locationProvider.hashPrefix('');

    $routeProvider.
      when('/dashboard', {
        templateUrl: 'Dashboard.html'
      }).
      when('/exposant', {
        templateUrl: 'Exposant.html',
         controller: 'OlippExposantCtrl'
      }).
      when('/annonceur', {
        templateUrl: 'Annonceur.html',
         controller: 'OlippAnnonceurCtrl'
      }).
      when('/contact', {
         templateUrl: 'Contact.html',
         controller: 'OlippContactCtrl'
      }).
      when('/movie', {
        templateUrl: 'Movie.html'
      }).      
      otherwise({
        redirectTo: '/dashboard'
      });

      // Change the default overlay message
      blockUIConfig.message = 'Loading';

      //Angular translate
      $translateProvider.useUrlLoader('App_Data/Languages/fr.json');
      $translateProvider.preferredLanguage('fr');
      //$translateProvider.fallbackLanguage('fr');

      // Enable escaping of HTML
      $translateProvider.useSanitizeValueStrategy('escapeParameters');

  }])
   .run(['$rootScope', '$location', '$translate',
    function($rootScope, $location, $translate){
    
      // Manage Dashboard Movies
      $rootScope.DashMovies = [];
      $translate('DASHBOARD.MOVIES.ONE').then(function (translation) {
        $rootScope.DashMovies.push(translation);
      });
      $translate('DASHBOARD.MOVIES.TWO').then(function (translation) {
        $rootScope.DashMovies.push(translation);
      });
      $translate('DASHBOARD.MOVIES.THREE').then(function (translation) {
        $rootScope.DashMovies.push(translation);
      });

      // Manage Movies page
      $rootScope.Movies = [];
      $translate('MOVIES.ONE').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.TWO').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.THREE').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.FOUR').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.FIVE').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.SIX').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.SEVEN').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.HEIGHT').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.NINE').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.TEN').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.ELEVEN').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.TWELVE').then(function (translation) {
        $rootScope.Movies.push(translation);
      });
      $translate('MOVIES.THIRTEEN').then(function (translation) {
        $rootScope.Movies.push(translation);
      });

      $rootScope.date = new Date();         

  }]);
