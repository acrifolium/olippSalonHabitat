var olippControllers = angular.module('olippControllers', []);

olippControllers.controller('OlippContactCtrl', ['$scope', 'ngNotify', '$window', '$translate',
  function($scope, ngNotify, $window, $translate) {

    $scope.contact = {};

    ngNotify.config({
      position: 'bottom',
      duration: 3000,
      sticky: false,
      button: true,
      html: false
    });
    
    // Fonction pour copier l'email dans le presse-papiers
    $scope.copyEmailToClipboard = function() {
      $translate(['CONTACT_FORM.TITLE', 'CONTACT_FORM.EMAIL.COPY_SUCCESS']).then(function(translations) {
        // Créer un élément temporaire
        var tempInput = document.createElement("input");
        tempInput.value = translations['CONTACT_FORM.TITLE'];
        document.body.appendChild(tempInput);
        
        // Sélectionner et copier le texte
        tempInput.select();
        document.execCommand("copy");
        
        // Supprimer l'élément temporaire
        document.body.removeChild(tempInput);
        
        // Afficher une notification traduite
        ngNotify.set(translations['CONTACT_FORM.EMAIL.COPY_SUCCESS'], 'noticeSalonSuccess');
      });
    };

    $scope.resetForm = function() {
      $scope.contact = {};
      $scope.contactForm.$setPristine();
      $scope.contactForm.$setUntouched();
    };

    $scope.Send = function(isValid) {
      if (!isValid) {
        $translate('CONTACT_FORM.ERRORS.INCOMPLETE_FORM').then(function(translation) {
          ngNotify.set(translation, 'error');
        });
        return;
      }

      // Get translations for email body
      $translate([
        'CONTACT_FORM.EMAIL.BODY_LASTNAME', 
        'CONTACT_FORM.EMAIL.BODY_FIRSTNAME',
        'CONTACT_FORM.EMAIL.BODY_EMAIL',
        'CONTACT_FORM.EMAIL.BODY_COMPANY',
        'CONTACT_FORM.EMAIL.BODY_TELEPHONE',
        'CONTACT_FORM.EMAIL.BODY_MESSAGE',
        'CONTACT_FORM.EMAIL.NOT_SPECIFIED',
        'CONTACT_FORM.EMAIL.SUCCESS_MESSAGE'
      ]).then(function(translations) {
        // Format the email body with the form details
        var body = translations['CONTACT_FORM.EMAIL.BODY_LASTNAME'] + ": " + $scope.contact.lastname + "\n" +
                  translations['CONTACT_FORM.EMAIL.BODY_FIRSTNAME'] + ": " + $scope.contact.firstname + "\n" +
                  translations['CONTACT_FORM.EMAIL.BODY_EMAIL'] + ": " + $scope.contact.email + "\n" +
                  translations['CONTACT_FORM.EMAIL.BODY_COMPANY'] + ": " + ($scope.contact.company || translations['CONTACT_FORM.EMAIL.NOT_SPECIFIED']) + "\n" +
                  translations['CONTACT_FORM.EMAIL.BODY_TELEPHONE'] + ": " + ($scope.contact.telephone || translations['CONTACT_FORM.EMAIL.NOT_SPECIFIED']) + "\n\n" +
                  translations['CONTACT_FORM.EMAIL.BODY_MESSAGE'] + ": \n" + $scope.contact.message;

        // Create the mailto link with all parameters
        var mailtoLink = "mailto:salonhabitatstrambert@gmail.com" +
                        "?subject=" + encodeURIComponent($scope.contact.subject) +
                        "&body=" + encodeURIComponent(body);

        // Open the default mail client with the prepared email
        $window.location.href = mailtoLink;

        // Show success message
        ngNotify.set(translations['CONTACT_FORM.EMAIL.SUCCESS_MESSAGE'], 'noticeSalonSuccess');
        
        // Reset form
        $scope.resetForm();
      });
    };
}]);

olippControllers.controller('OlippExposantCtrl', ['$scope', 'blockUI', 'blockUIConfig', 'ngNotify', 'salonServices', '$translate',
  function($scope, blockUI, blockUIConfig, ngNotify, salonServices, $translate) {

    $scope.exposants = [];

    ngNotify.config(
    {
      position: 'bottom',
      duration: 3000,
      sticky: false,
      button: true,
      html: false
    });

    ngNotify.addType('noticeSalonSuccess', 'notice-salon-success');

    $translate('BLOCKUI.LOADING_EXPOSANTS').then(function(translation) {
      blockUIConfig.message = translation;
      blockUI.start();
    });

    salonServices.GetExposants()
                  .then(function(result){
                    if (result.data.success) { //success comes from the return json object
                      // Unblock the user interface
                      blockUI.stop(); 
                      $scope.exposants = result.data.exposants;
                    } else {
                      // Unblock the user interface
                      blockUI.stop(); 
                      ngNotify.set(result.data.message, 'error');
                    }
                  });
}]);

olippControllers.controller('OlippAnnonceurCtrl', ['$scope', 'blockUI', 'blockUIConfig', 'ngNotify', 'salonServices', '$translate',
  function($scope, blockUI, blockUIConfig, ngNotify, salonServices, $translate) {

    $scope.annonceurs = [];

    ngNotify.config(
    {
      position: 'bottom',
      duration: 3000,
      sticky: false,
      button: true,
      html: false
    });

    ngNotify.addType('noticeSalonSuccess', 'notice-salon-success');

    $translate('BLOCKUI.LOADING_ANNONCEURS').then(function(translation) {
      blockUIConfig.message = translation;
      blockUI.start();
    });

    salonServices.GetAnnonceurs()
                  .then(function(result){
                    if (result.data.success) { //success comes from the return json object
                      // Unblock the user interface
                      blockUI.stop(); 
                      $scope.annonceurs = result.data.annonceurs;
                    } else {
                      // Unblock the user interface
                      blockUI.stop(); 
                      ngNotify.set(result.data.message, 'error');
                    }
                  });
}]);

olippControllers.controller('OlippDashboardCtrl', ['$scope', '$sce', function($scope, $sce) {
    
    // Données existantes
    $scope.date = new Date();
    
    // Note: Les anciennes références YouTube ont été supprimées et remplacées par une vidéo locale
    
    // Pour le carousel avec miniatures
    $scope.currentSlide = 0;
    
    // Fonction pour définir la slide active
    $scope.setCurrentSlide = function(index) {
        $scope.currentSlide = index;
    };
    
    // Écouter les événements du carousel de Bootstrap
    angular.element(document).ready(function() {
        // S'assurer que le carousel est correctement initialisé
        var carousel = $('#myCarouselSalon');
        
        // Écouter l'événement slid.bs.carousel qui est déclenché après la transition
        carousel.on('slid.bs.carousel', function(event) {
            // Mettre à jour l'index de la slide active
            $scope.currentSlide = $(event.relatedTarget).index();
            $scope.$apply();
            
            // Faire défiler les miniatures pour centrer la miniature active
            var container = document.querySelector('.thumbnails-container');
            var activeThumb = document.querySelector('.thumbnail-item.active');
            
            if (container && activeThumb) {
                container.scrollTo({
                    left: activeThumb.offsetLeft - container.clientWidth / 2 + activeThumb.clientWidth / 2,
                    behavior: 'smooth'
                });
            }
        });
    });
}]);