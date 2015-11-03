'use strict';

/* dataWebServices */

olippServices.factory('dataWebServices', ['$http',
  function($http){
  	
  	var serviceBase = 'api/'
    var obj = {};

    obj.navigation = function(){
      return $http.get(serviceBase + 'navigation');
    }

    obj.dashboard = function(){
      return $http.get(serviceBase + 'dashboard');
    }

    obj.config = function(){
      return $http.get(serviceBase + 'config');
    }
    
    obj.contact = function($id){     
      return $http({
                    method: "post",
                    url: serviceBase + "contact",
                    data: {
                        'id': $id
                    }
                });
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

    obj.sendMail = function($lastname, $firstname, $email, $company, $telephone, $message){
      return $http({
                    method: "post",
                    url: serviceBase + 'sendMail', 
                    data: {
                      'lastname': $lastname, 
                      'firstname': $firstname, 
                      'email': $email,
                      'company': $company,
                      'telephone': $telephone,
                      'message': $message
                    }
                  });
    }
	return obj; 
	
  }]);
