<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tianyi's</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<?php include "include/header.php"; ?>
<?php

$xmlDoc = new DOMDocument();
$xmlDoc->load("user.xml");

$users = $xmlDoc->getElementsByTagName("user");
//echo $users->item(0)->getElementsByTagName("username")->item(0)->nodeValue;

foreach($users as $user){
    $username = $user->getElementsByTagName("username")->item(0)->nodeValue;
    print "username:" . $username;
    echo "<br />";

    $password = $user->getElementsByTagName("password")->item(0)->nodeValue;
    print "password:" . $password;
    echo "<br />";
}



?>

</body>

</html>