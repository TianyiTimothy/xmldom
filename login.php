<!DOCTYPE html>
<html lang="en">

<?php
// validation function
include "include/validation.php";

$username = $password = "";
$isLogin = false;


// if is post back
if (isset($_POST["submit"])) {

    // get inputs
    $username = $_POST["username"];
    $password = $_POST["password"];

    $isLogin = validation($username, $password);

    if (!$isLogin) {
        // if here, invalid
        $msg = "invalid username or password.";
    }
//    echo $username;
}
?>

<head>
    <title>Tianyi's</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<?php include "include/header.php"; ?>


<main>
    <div class="container">
        <div class="row <?php if ($isLogin) {
            echo "d-none";
        } ?>">
            <div class="col-lg-5 mx-auto">
                <div class="card my-5">
                    <div class="card-body">

                        <form class="form-signin" action="" method="post">
                            <div class="form-label-group">
                                <input name="username" type="text" id="inputUsername" class="form-control"
                                       value="<?php echo $username; ?>"
                                       placeholder="Username"
                                       required autofocus>
                                <label for="inputUsername">Username</label>
                            </div>

                            <div class="form-label-group">
                                <input name="password" type="password" id="inputPassword" class="form-control"
                                       value="<?php echo $password; ?>"
                                       placeholder="Password" required>
                                <label for="inputPassword">Password</label>
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" checked>
                                <label class="custom-control-label" for="customCheck1">Remember password</label>
                            </div>

                            <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block text-uppercase">
                                Sign in
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

</html>