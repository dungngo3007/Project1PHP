<?php
include_once("../functions/functions.php");

$PassW = Select_Admin_With_ID($_GET['adminID']);

$err = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    if (strlen($_POST["pswNew"]) != 8) {
        $err["pswNew"] = "Password needs at least 8 characters";
    }

    if (strlen($_POST["pswCf"]) != 8) {
        $err["pswCf"] = "Password needs at least 8 characters";
    }

    if ($_POST['psw'] == $_POST['pswNew']) {
        $err['pswNew'] = "The new password is the same the current password";
    }

    if (sha1($_POST['psw']) != $PassW['Password']) {
        $err["psw"] = "Password wrong";
    }

    if (empty($_POST["psw"])) {
        $err["psw"] = "Enter Current password";
    }

    if (empty($_POST["pswNew"])) {
        $err["pswNew"] = "Enter New password";
    }

    if (empty($_POST["pswCf"])) {
        $err["pswCf"] = "Confirm password";
    }

    if ($_POST['pswNew'] != $_POST['pswCf']) {
        $err['pswCf'] = "The passwords do not match";
    }
}


?>

<?php

if (isset($_POST['cancel']) || $PassW['Password'] == null) {
    redirect_to("../Home Admin/StatisticalAdmin.php");
}

if (isset($_POST['logout'])) {
    unset($_SESSION['admin']);
    setcookie("username", "", time() - 86400, "/");
    redirect_to('../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/edit.css">
</head>

<body>
    <?php
    if (isset($_SESSION['admin'])) {
        echo "<div id='name-admin'>Admin: " . $_SESSION['admin'] . "</div>" . "<br>";
    }
    ?>
    <div class="container">
        <form action="" method="post">
            <button id='button-logout' class="btn btn-danger" type="submit" value="Logout" name="logout">
                Logout
                <span class="glyphicon glyphicon-log-out"></span>
            </button>
        </form><br>
        <div class="form-category">

            <h2>Chang password Admin <br> <strong> <?php echo $PassW['Name'] ?> </strong></h2>
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                <div class="form-group">
                    <label for="psw"> Current password: </label>
                    <input class="form-control" type="password" name="psw" id="psw">
                    <span style='color:red;'>
                        <?php echo isset($err['psw']) ? $err['psw'] : "" ?>
                    </span><br>
                </div>
                <div class="form-group">
                    <label for="pswNew"> New password: </label>
                    <input class="form-control" type="password" name="pswNew" id="pswNew">
                    <span style='color:red;'>
                        <?php echo isset($err['pswNew']) ? $err['pswNew'] : "" ?>
                    </span><br>
                </div>
                <div class="form-group">
                    <label for="pswCf">Confirm new password: </label>
                    <input class="form-control" type="password" name="pswCf" id="pswCf">
                    <span style='color:red;'>
                        <?php echo isset($err['pswCf']) ? $err['pswCf'] : "" ?>
                    </span><br>
                </div>
                <input type="hidden" name="id" value='<?php echo $_GET['adminID'] ?>'>

                <div class="button">
                    <div class="row">
                        <input class="btn btn-success col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="change" value="Change">
                        <input class="btn btn-danger col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="cancel" value="Cancel">

                    </div>
                </div>

            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == 'POST' && $err == []) {
                Change_Password($_POST["id"]);
                $_SESSION['change_psw'] = "<div style='color:green;'>Change Password successfully</div>";
                redirect_to('../Home Admin/StatisticalAdmin.php');
            }


            ?>

        </div>
    </div>
</body>

</html>


<?php
db_disconnect($cn);
?>