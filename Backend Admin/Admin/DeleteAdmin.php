<?php
include_once("../functions/functions.php");

$err = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST["pswCf"])) {
        $err["pswCf"] = "Please Confirm password";
    }
}

if (isset($_GET['adminID'])) {
    $Admin = Select_Admin_With_ID($_GET['adminID']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/delete.css">
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
        </form><br><br><br>
        <div class="form-delete">
            <h2>Delete Admin</h2>
            <?php echo "Do you want to delete admin <strong>" . $Admin['Name'] . " </strong>?"; ?>
            <br><br>
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                <div class="form-group">
                    <label for="pswCf">Confirm password: </label>
                    <input class="form-control" type="password" id="pswCf" name="pswCf" placeholder="Enter password">
                    <span style="color:red;">
                        <?php echo isset($err['pswCf']) ? $err['pswCf'] : "";
                        ?>
                    </span>
                </div>
                <input type="hidden" name="id" value="<?php echo $_GET['adminID']; ?>">
                <br>
                <div class="button">
                    <div class="row">
                        <input class="btn btn-warning col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="submit" value="Delete">
                        <input class="btn btn-danger col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="cancel" value="Cancel">
                    </div>
                </div>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['pswCf'])) {
                if ($Admin['Password'] == sha1($_POST['pswCf'])) {
                    if ($Admin['Name'] !=  $_SESSION['admin']) {
                        Delete_Admin($_POST['id']);
                        $_SESSION['delete_admin'] = "<div style='color:green;'>Delete Admin Successfully</div>";
                        redirect_to("../Home Admin/StatisticalAdmin.php");
                    } else {
                        Delete_Admin($_POST['id']);
                        unset($_SESSION['admin']);
                        redirect_to('../Login-Sign up/LoginAdmin.php');
                    }
                }
                if ($Admin['Password'] != sha1($_POST['pswCf']) && !empty($_POST['pswCf'])) {
                    echo "<span style='color:red; position:absolute; left:40%;'>Wrong password</span>";
                }
            }

            if (isset($_POST['cancel']) || $Admin['Name'] == null) {
                redirect_to("../Home Admin/StatisticalAdmin.php");
            }

            if (isset($_POST['logout'])) {
                unset($_SESSION['admin']);
                setcookie("username", "", time() - 86400, "/");
                redirect_to('../index.php');
            }

            ?>
        </div>
    </div>


</body>

</html>

<?php
db_disconnect($cn);
?>