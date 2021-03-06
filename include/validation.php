<?php

/*
 * param1: username
 * param2: password
 *
 * return: {isLogin = isLogin, isAdmin=isAdmin}
 */
function validation($username, $password)
{
    // get uname&pwd from XML
    $xmlDoc = new DOMDocument();
    $xmlDoc->load("user.xml");

    $users = $xmlDoc->getElementsByTagName("user");

    $isLogin = false;


    foreach ($users as $user) {
        $xmlUsername = $user->getElementsByTagName("username")->item(0)->nodeValue;
        if ($xmlUsername === $username) {
            $xmlPassword = $user->getElementsByTagName("password")->item(0)->nodeValue;
            if ($xmlPassword === $password) {
                // is login, hide form
                $isLogin = true;
                // get user id
                $userId = $user->getElementsByTagName("ID")->item(0)->nodeValue;

                // isAdmin?
                $isAdmin = $user->getAttribute("type") == "admin";
            }
        }
    }
    if ($isLogin) {
        return array(
            "isLogin" => $isLogin,
            "isAdmin" => $isAdmin,
            "userId" => $userId,
        );
    } else {
        return array(
            "isLogin" => $isLogin,
        );
    }
}