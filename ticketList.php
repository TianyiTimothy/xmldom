<?php
session_start();

// isLogin flag
$isLogin = false;

// if is post back
if (isset($_SESSION["userType"])) {

    $isLogin = true;

    $xmlDoc = new DOMDocument();
    $xmlDoc->load("supportingTickets.xml");
    $tickets = $xmlDoc->getElementsByTagName("ticket");

    $userType = $_SESSION["userType"];
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
        <table class="table table-dark mt-5">
            <thead>
            <tr>
                <th scope="col">Subject</th>
                <th scope="col">Status</th>
                <th scope="col">DateOfIssue</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($userType == "client") {
                // get user id
                $userId = $_SESSION["userId"];

                // show client tickets
                foreach ($tickets as $ticket) {
                    $ticketUserId = $ticket->getElementsByTagName("userID")->item(0)->nodeValue;
                    if ($userId == $ticketUserId) {
                        $subject = $ticket->getElementsByTagName("subject")->item(0)->nodeValue;
                        $status = $ticket->getAttribute("status");
                        $dateOfIssue = $ticket->getElementsByTagName("dateOfIssue")->item(0)->nodeValue;
                        $id = $ticket->getElementsByTagName("ID")->item(0)->nodeValue;
                        if ($status == "resolved") {
                            $statusClass = "bg-success";
                        } else {
                            $statusClass = "bg-warning";
                        }
                        echo "<tr class='" . $statusClass . "'>";
                        echo "<th><a href='ticketDetail.php?id=" . $id . "'>" . $subject . "</a></th>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>" . $dateOfIssue . "</td>";
                        echo "</tr>";
                    }
                }

            } else if ($userType == "admin") {
                // show all tickets
                foreach ($tickets as $ticket) {
                    $subject = $ticket->getElementsByTagName("subject")->item(0)->nodeValue;
                    $status = $ticket->getAttribute("status");
                    $dateOfIssue = $ticket->getElementsByTagName("dateOfIssue")->item(0)->nodeValue;
                    $id = $ticket->getElementsByTagName("ID")->item(0)->nodeValue;
                    if ($status == "resolved") {
                        $statusClass = "bg-success";
                    } else {
                        $statusClass = "bg-warning";
                    }
                    echo "<tr class='" . $statusClass . "'>";
                    echo "<th><a href='ticketDetail.php?id=" . $id . "'>" . $subject . "</a></th>";
                    echo "<td>" . $status . "</td>";
                    echo "<td>" . $dateOfIssue . "</td>";
                    echo "</tr>";
                }

            } else {
                echo "userType ERROR";
                $isLogin = false;
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="<?php if ($isLogin) {
        echo "d-none";
    } ?>">sorry, you should login first. <a href="login.php">Login</a> now.
    </div>
</main>

</body>

</html>