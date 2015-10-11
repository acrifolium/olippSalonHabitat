'use strict';

/* dataWebServices */

olippServices.factory('dataWebServices', ['$http',
  function($http){
  	
  	var serviceBase = 'api/'
    var obj = {};

    obj.navigation = function(){
      return $http.get(serviceBase + 'navigation');
    }

	return obj; 
	
  }]);
