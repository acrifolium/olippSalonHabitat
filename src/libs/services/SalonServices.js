var salonServices = angular.module('salonServices', ['ngResource']);

salonServices.factory('salonServices', ['$http', '$q',
  function($http, $q){
      
    'use strict';

    var obj = {};

    obj.GetExposants = function(){
        var deferred = $q.defer();
        
        $http.get('api/data/EXPOSANTS.csv', { transformResponse: null })
            .then(function(response) {
                var csvData = response.data;
                var exposants = csvParser.parseExposants(csvData);
                
                var result = {
                    data: {
                        success: true,
                        message: 'Exposants loaded',
                        exposants: exposants
                    }
                };
                
                deferred.resolve(result);
            }, function(error) {
                deferred.reject(error);
            });
            
        return deferred.promise;
    };

    obj.GetAnnonceurs = function(){
        var deferred = $q.defer();
        
        $http.get('api/data/ANNONCEURS.csv', { transformResponse: null })
            .then(function(response) {
                var csvData = response.data;
                var annonceurs = csvParser.parseAnnonceurs(csvData);
                
                var result = {
                    data: {
                        success: true,
                        message: 'Annonceurs loaded',
                        annonceurs: annonceurs
                    }
                };
                
                deferred.resolve(result);
            }, function(error) {
                deferred.reject(error);
            });
            
        return deferred.promise;
    };

    return obj; 
  }]);

