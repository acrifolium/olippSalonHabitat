'use strict';

/* authWebServices */

olippServices.factory('authWebServices', ['$http',
  function($http){
  	
  	var serviceBase = 'api/'
    var obj = {};

    obj.IsAdminExists = function(){
      return $http.get(serviceBase + 'IsAdminExists');
    }

    obj.session = function(){
      return $http.get(serviceBase + 'session');
    }

    obj.signUpAdmin = function($username, $email, $password){
      return $http({
                    method: "post",
                    url: serviceBase + 'signUpAdmin', 
                    data: {
                      'username': $username, 
                      'email': $email, 
                      'password': $password
                    }
                  });
    }

    obj.login = function($username, $password){     
      return $http({
                    method: "post",
                    url: serviceBase + "login",
                    data: {
                        'username': $username,
                        'password': $password
                    }
                });
    }

    obj.logout = function(){
      return $http.get(serviceBase + 'logout');
    }

    obj.recoverAccount = function($email){     
      return $http({
                    method: "post",
                    url: serviceBase + "recoverAccount",
                    data: {
                        'email': $email
                    }
                });
    }

	return obj; 
	
  }]);
