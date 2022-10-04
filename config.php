<?php

require 'vendor/autoload.php';


// init configuration
$clientID = '973876093855-5g44c1u8ksusa6uhdrch4ouvo864j4t5.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/google-login/welcome.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");


$servername = "localhost";
$uname = "root";
$password = "";
$db = "google_login";

$cn = mysqli_connect($servername, $uname, $password,$db);
?>