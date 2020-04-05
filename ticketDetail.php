<?php
session_start();

// vars
$username = "";
$userType = "";
$msgUsername = "";
$msgUserType = "";

// isLogin flag
$isLogin = false;
$msg = "sorry, you should login first. <a href=\"login.php\">Login</a> now.";

// if is login in (have session)
if (isset($_SESSION["userType"])) {
    if (isset($_GET["id"])) {

        $isLogin = true;
        $userType = $_SESSION["userType"];


        $xmlDoc = new DOMDocument();
        $xmlDoc->load("supportingTickets.xml");
        $tickets = $xmlDoc->getElementsByTagName("ticket");

    } else {
        $msg = "nah, you need a ticket id to view detail. <a href=\"ticketList.php\">Back</a>";
    }
    $userId = $_SESSION["userId"];
}

// if is post back
if (isset($_POST["submit"])) {
    // get current userid
    echo $_SESSION["username"];
//    echo $userId;
    $message = $_POST["addMessage"];
    // add into xml file
//    <supportMessages>
//        <userID>209221</userID>
//        <messageContent>When I click on submit at my lab page, nothing happens!</messageContent>
//    </supportMessages>
    $tempXml = new DOMDocument();

    $useridnode = $tempXml->createElement("userID");
    $useridnodeText = $tempXml->createTextNode($userId);
    $useridnode->appendChild($useridnodeText);

    $messageContent = $tempXml->createElement("messageContent");
    $messageContentText = $tempXml->createTextNode($message);
    $messageContent->appendChild($messageContentText);

    $smNode = $tempXml->createElement("supportMessages");
    $smNode->appendChild($useridnode);
    $smNode->appendChild($messageContent);

    $currentTicket->appendChild($smNode);



}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tianyi's</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<?php include "include/header.php" ?>
<main>
    <div class="container <?php if (!$isLogin) {
        echo "d-none";
    } ?>">
        <div class="jumbotron">

            <?php
            $ticketUserId = $_GET["id"];

            foreach ($tickets as $ticket) {

                if ($ticket->getElementsByTagName("ID")->item(0)->nodeValue == $ticketUserId) {

                    $ticketUserId = $ticket->getElementsByTagName("userID")->item(0)->nodeValue;
                    $subject = $ticket->getElementsByTagName("subject")->item(0)->nodeValue;
                    $status = $ticket->getAttribute("status");
                    $dateOfIssue = $ticket->getElementsByTagName("dateOfIssue")->item(0)->nodeValue;
                    $id = $ticket->getElementsByTagName("ID")->item(0)->nodeValue;

                    $messages = $ticket->getElementsByTagName("supportMessages");


                } else {
                    continue;
                }
                echo "<h1>" . $subject . "</h1>";
                echo "<p class='lead'>" . $dateOfIssue . " - " . $status . "</p>";
                echo "<hr class=\"my-4\">";
                foreach ($messages as $message) {
                    $messageUserId = $message->getElementsByTagName("userID")->item(0)->nodeValue;
                    // get username & type from $ticketUserId
                    $userXmlDoc = new DOMDocument();
                    $userXmlDoc->load("user.xml");
                    $users = $userXmlDoc->getElementsByTagName("user");
                    foreach ($users as $key => $user) {
                        if ($user->getElementsByTagName("ID")->item(0)->nodeValue == $messageUserId) {
                            // get username & type
                            $msgUsername = $user->getElementsByTagName("username")->item(0)->nodeValue;
                            $msgUserType = $user->getAttribute("type");
                            // that's enough
                            break;
                        }
                    }
                    if ($msgUserType == "client") {
                        // client
                        echo "<p class='text-info'>" . $msgUsername . ":</p>";
                    } else {
                        // admin
                        echo "<p class='text-primary'>" . $msgUsername . ":</p>";
                    }
                    echo "<p>" . $message->getElementsByTagName("messageContent")->item(0)->nodeValue . "</p>";
                    echo "<hr class=\"my-4\">";
                }
            }

            ?>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="addMessage">Feedback</label>
                <textarea name="addMessage" id="addMessage" class="form-control"></textarea>
            </div>
            <input type="submit" name="submit" value="submit" class="btn btn-primary"/>
        </form>
    </div>
    <div class="<?php if ($isLogin) {
        echo "d-none";
    } ?>"><?php
        echo $msg;
        ?>
    </div>
</main>

</body>

</html>