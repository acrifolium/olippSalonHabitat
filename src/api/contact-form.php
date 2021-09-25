<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'phpmailer/PHPMailerAutoload.php';

if (isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {

    //check if any of the inputs are empty
    if (empty($_POST['lastname']) || empty($_POST['firstname']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        $data = array('success' => false, 'message' => 'Merci de remplir le formulaire complètement.');
        echo json_encode($data);
        exit;
    }

    //create an instance of PHPMailer
    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->Host = 'mail.salonhabitatsaintrambert.com';
    $mail->Port = 25;
    $mail->SMTPAuth   = true;
    $mail->Username = 'contact@salonhabitatsaintrambert.com';
    $mail->Password = 'tm2k18';

    // Expediteur
    $mail->From = $_POST['email'];
    $mail->FromName = $_POST['firstname'] + " " + $_POST['lastname'];
    // Destinataire
    $mail->AddAddress('CONTACT@SALONHABITATSAINTRAMBERT.COM');
    // Modifier l'encodage du mail
    $mail->CharSet = "utf-8";
    // Modifier l'adresse de réponse
    $mail->AddReplyTo($_POST['email'], $mail->FromName); 

    $mail->Subject = $_POST['subject'];
    
    $mail->isHTML(true);

    $mail->AddEmbeddedImage('../img/header/Banniere-header.png','Salon_logo', 'Banniere-header.png');



    $head = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
    $head .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
    $head .= "<head>";
    $head .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
    $head .= "<title>Salon tout pour l'habitat</title>";
    $head .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>";
    $head .= "</head>";

    $header = "<div style=\"height: 100px;\">";
    $header .= "<img src=\"cid:Salon_logo\" alt=\"Logo\"/>";
    $header .= "</div>";
    $header .= "<body>";

    $footer = "<div style=\"color: white; height: 60px; background-color: #1E3E14; margin-top: 20px; padding: 5px 5px 5px 5px; text-align: center;\">";
    $footer .= "Comité Salon Tout Pout l'Habitat - Menuiserie COMBE - ZI du Cappa 26140 Saint Rambert d'Albon - Mail: contact@salonhabitatsaintrambert.com";
    $footer .= " - Françoise SANFILIPPO - Mobile: 06 89 41 14 90";
    $footer .= "</div>";
    $footer .= "</body>";
    $footer .= "</html>";

    $mail->Body = $head;
    $mail->Body .= $header;
    $mail->Body .= "<h1>SITE INTERNET SALON TOUT POUR L'HABITAT</h1>";
    $mail->Body .= "<div style=\"padding: 40px 30px 40px 30px; background-color: #8cc63e;\">";
    $mail->Body .= "<table align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: white; font-size: 14px\">";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= "<b>Nom:</b>";
    $mail->Body .= "</td>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= $_POST['lastname'];
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= "<b>Prénom</b>";
    $mail->Body .= "</td>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= $_POST['firstname'];
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= "<b>Email:</b>";
    $mail->Body .= "</td>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= $_POST['email'];
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= "<b>Société:</b>";
    $mail->Body .= "</td>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= $_POST['company'];
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= "<b>Téléphone:</b>";
    $mail->Body .= "</td>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= $_POST['telephone'];
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= "<b>Objet:</b>";
    $mail->Body .= "</td>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= $_POST['subject'];
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td style=\"padding: 2px 0 2px 2px;\">";
    $mail->Body .= "<b>Message:</b>";
    $mail->Body .= "</td>";
    $mail->Body .= "<td style=\"padding: 20px 0 30px 2px;\">";
    $mail->Body .= $_POST['message'];
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "</table>";
    $mail->Body .= "</div>";
    $mail->Body .= $footer;
    

    if (isset($_POST['ref'])) {
        $mail->Body .= "\r\n\r\nRef: " . $_POST['ref'];
    }

    // Envoi du mail à l'imprimerie
    if(!$mail->send()) {
        $data = array('success' => false, 'message' => 'Le message ne peut être envoyé. Erreur Mail: ' . $mail->ErrorInfo);
        echo json_encode($data);
        exit;
    }

    // Envoi du mail de confirmation à l'internaute
    // Expediteur
    $mail->From = "contact@salonhabitatsaintrambert.com";
    $mail->FromName = "Salon Tout Pour l'Habitat";
    // Destinataire
    $mail->ClearAllRecipients(); // clear all
    $mail->AddAddress($_POST['email']);
    // Modifier l'encodage du mail
    $mail->CharSet = "utf-8";
    // Modifier l'adresse de réponse
    $mail->AddReplyTo("contact@salonhabitatsaintrambert.com", $mail->FromName); 

    $mail->Subject = "Récapitulatif de votre demande";

    $mail->Body = $head;
    $mail->Body .= $header;
    $mail->Body .= "<div style=\"padding: 40px 30px 40px 30px;\">";
    $mail->Body .= "<table border=\"0\" style=\"font-size: 15px;\">";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= "Bonjour " . $_POST['firstname'] . " " . $_POST['lastname'] . ",";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= " ";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";  
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= "Votre email a bien été envoyé. Il sera traité dans les plus bref délais. Vous trouverez ci-dessous un Récapitulatif de votre demande:";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>"; 
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= " ";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= "<i>". $_POST['message'] ."</i>";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>"; 
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= " ";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";     
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= "Bien à vous,";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= " ";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "<tr>";
    $mail->Body .= "<td>";
    $mail->Body .= "L'équipe du salon";
    $mail->Body .= "</td>";
    $mail->Body .= "</tr>";
    $mail->Body .= "</table>";
    $mail->Body .= "</div>";
    $mail->Body .= $footer;

    // Envoi du mail à l'internaute
    if(!$mail->send()) {
        $data = array('success' => false, 'message' => 'Le message ne peut être envoyé. Erreur Mail: ' . $mail->ErrorInfo);
        echo json_encode($data);
        exit;
    }

    $data = array('success' => true, 'message' => 'Merci! Nous avons envoyé votre message.');
    echo json_encode($data);

} else {

    $data = array('success' => false, 'message' => 'Merci de remplir le formulaire complètement.');
    echo json_encode($data);

}