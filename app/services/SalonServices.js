var salonServices = angular.module('salonServices', ['ngResource']);

salonServices.factory('salonServices', ['$http',
  function($http){
  	
    'use strict';

  	var serviceBase = 'api/';
    var obj = {};

    obj.sendMail = 
    function($contact){
             return $http({
                          method: "POST",
                          url: serviceBase + 'contact-form.php', 
                          data: $.param($contact),
                          headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
                        });
             }

    obj.GetExposants = function(){
      return $http.get(serviceBase + 'Exposant.php');
    }

    obj.GetAnnonceurs = function(){
      return $http.get(serviceBase + 'Annonceur.php');
    }

	  return obj; 
	
  }]);
