<?php
session_start();

// isLogin flag
$isLogin = false;
$msg = "sorry, you should login first. <a href=\"login.php\">Login</a> now.";

// if is post back
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
                echo "<p class='lead'>" . $dateOfIssue ." - ". $status . "</p>";
                echo "<hr class=\"my-4\">";
                foreach ($messages as $message) {
                    echo "<p>" . $message->getElementsByTagName("messageContent")->item(0)->nodeValue ."</p>";
                    echo "<hr class=\"my-4\">";
                }
            }

            ?>
        </div>
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