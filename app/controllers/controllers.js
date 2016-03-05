var olippControllers = angular.module('olippControllers', []);

olippControllers.controller('OlippContactCtrl', ['$scope', 'blockUI', 'blockUIConfig', 'ngNotify', 'salonServices',
  function($scope, blockUI, blockUIConfig, ngNotify, salonServices) {

  $scope.resetForm = function() {
    $scope.contact.lastname = undefined; 
    $scope.contact.firstname = undefined;
    $scope.contact.email = undefined;
    $scope.contact.company = undefined;
    $scope.contact.telephone = undefined;
    $scope.contact.subject = undefined;
    $scope.contact.message = undefined; 
  }

  $scope.Send = function(){

    ngNotify.config(
    {
      position: 'bottom',
      duration: 3000,
      sticky: false,
      button: true,
      html: false
    });

    ngNotify.addType('noticeSalonSuccess', 'notice-salon-success');

    if($scope.contact.company == undefined) $scope.contact.company = "";
    if($scope.contact.telephone == undefined) $scope.contact.telephone = ""; 

    // Block the user interface
    blockUIConfig.message = 'Envoi du mail en cours...';
    blockUI.start();

    salonServices.sendMail($scope.contact)
                        .success(function(data){
                            console.log(data);
                            if (data.success) { //success comes from the return json object
                              // Unblock the user interface
                              blockUI.stop(); 
                              $scope.resetForm();
                              ngNotify.set(data.message, 'noticeSalonSuccess');
                            } else {
                              // Unblock the user interface
                              blockUI.stop(); 
                              ngNotify.set(data.message, 'error');
                            }
                        });
    };

}]);

