<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
            ul{
                list-style: none;
            }

            li{
                display: inline;
            }
    </style>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome!</h2>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="#">#</a></li>
    </ul>

    <?php

require 'config.php';

session_start();

if(isset($_SESSION['user_token'])){
    header("Location:welcome.php");
}else{
    echo "<h1>Login With Google </h1>";
    echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}

?>

</body>
</html>