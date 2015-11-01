'use strict';

/* dataWebServices */

olippServices.factory('dataWebServices', ['$http',
  function($http){
  	
  	var serviceBase = 'api/'
    var obj = {};

    obj.navigation = function(){
      return $http.get(serviceBase + 'navigation');
    }

    obj.contact = function(){
      return $http.get(serviceBase + 'contact');
    }
    
    obj.exposant = function(){
      return $http.get(serviceBase + 'exposant');      
    }

    obj.movies = function($id){     
      return $http({
                    method: "post",
                    url: serviceBase + "movies",
                    data: {
                        'id': $id
                    }
                });
    }

	return obj; 
	
  }]);
