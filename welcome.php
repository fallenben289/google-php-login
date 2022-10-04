<?php


require 'config.php';

/*if(!isset($_SESSION['user_token'])){
 header("Location:index.php");
}*/


// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
  
    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    
    //TO Insert the information into mysql
    $userinfo = [
        'email' => $google_account_info['email'],
        'first_name' => $google_account_info['givenName'],
        'last_name' => $google_account_info['familyName'],
        'gender' => $google_account_info['gender'],
        'full_name' => $google_account_info['name'],
        'picture' => $google_account_info['picture'],
        'verifiedEmail' => $google_account_info['verifiedEmail'],
        'token' => $google_account_info['id'],
    ];


    //Check if user exist
        $sql =  "SELECT * FROM  user WHERE email = '{$userinfo['email']}'";
        $result = mysqli_query($cn, $sql);
        if(mysqli_num_rows($result) > 0){
                $userinfo = mysqli_fetch_assoc($result);
                $token = $userinfo['token'];
        }else {
            $sql = "INSERT INTO user(email, first_name, last_name, gender, full_name, picture, verifiedEmail, token) 
            VALUES (   
            '{$userinfo['email']}',
            '{$userinfo['first_name']}',
            '{$userinfo['last_name']}',
            '{$userinfo['gender']}',
            '{$userinfo['full_name']}',
            '{$userinfo['picture']}',
            '{$userinfo['verifiedEmail']}',
            '{$userinfo['token']}')";
            $result = mysqli_query($cn, $sql);
            if($result){
                echo "Created!";
                $token = $userinfo['token'];
            }else {
                echo "Not Created";
                die();
            }
            
        } 

        //Save the user into session
        $_SESSION['user_token']= $token;
    

  
    // now you can use this profile info to create account in your website and make user logged in.
 }else{

if (!isset($_SESSION['user_token'])) {
    header("Location:index.php");
    die();
}
    //Check if user exist
    $sql =  "SELECT * FROM  user WHERE token = '{$_SESSION['user_token']}'";
    $result = mysqli_query($cn, $sql);
if (mysqli_num_rows($result) > 0) {
    $userinfo = mysqli_fetch_assoc($result);
} 

  }
 
 
 
 /* else {
    echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
  }*/

  ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
</head>
<body>
    <h1>H</h1>
    <img src="<?= $userinfo['picture']?>" alt="" width="150px" height="150px" >
    <ul>

        <li>Full Name: <?= $userinfo['full_name']?></li>
        <li>Email: <?= $userinfo['email']?></li>
        <li>Gender: <?= $userinfo['gender']?></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>