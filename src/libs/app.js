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
      // Initialiser la date actuelle
      $rootScope.date = new Date();         

  }]);
