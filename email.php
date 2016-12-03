<?php
 
if(isset($_POST['email'])) {
 
     
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "tylerhamilton@ie.com.au";
 
    $email_subject = "Your email subject line";
 
     
 
     
 
    function died($error) {
 
        // your error code can go here
        $result = array();
 
        $result["message"] = "We are very sorry, but there were error(s) found with the form you submitted. " .
            "These errors appear below.<br /><br />" .
            $error."<br /><br />" .
            "Please go back and fix these errors.<br /><br />";
        
        $result["success"] = false;
        
        echo json_encode($result);
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['name']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['company']) ||
  
        !isset($_POST['iCheck'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
     
 
    $name = $_POST['name']; // required
 
    $email = $_POST['email']; // required
 
    $company = $_POST['company']; // not required
 
    $tickets = $_POST['iCheck']; // required
 
     
 
    $error_message = "";
 
    $email_exp = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
 
  if(!preg_match($email_exp,$email)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name)) {
 
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "Name: ".clean_string($name)."\n";
 
    $email_message .= "Email: ".clean_string($email)."\n";
 
    $email_message .= "Company: ".clean_string($company)."\n";
 
    $email_message .= "Ticket Type: ".clean_string($ticket)."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$email."\r\n".
 
'Reply-To: '.$email."\r\n" .
 
'X-Mailer: PHP/' . phpversion();

mail($email_to, $email_subject, $email_message, $headers);  
 
$result = array();

$result["message"] = "Success";
$result["success"] = true;
    
    echo json_encode($result);
 
} else {
    $result = array();

$result["message"] = "Unrecognised request";
$result["success"] = false;
    
    echo json_encode($result);
}