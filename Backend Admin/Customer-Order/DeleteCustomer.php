<?php
include_once("../functions/functions.php");

if (isset($_GET['customerID'])) {
    $Customer = Find_Customer_With_CustomerID($_GET['customerID']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
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
        </form><br>
        <div class="form-delete">
            <h2>Do you want to delete the customer <?php echo "<strong>" . $Customer['Name'] . "</strong>" ?> and all products ordered by this customer???</h2>

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['customerID'] ?>">

                <div class="button">
                    <div class="row">
                        <input class="btn btn-warning col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="delete" value="Delete">
                        <input class="btn btn-danger col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="cancel" value="Cancel">
                    </div>
                </div>

            </form>
        </div>
    </div>

    <?php
    if ((isset($_POST['cancel']) || !isset($Customer['Name'])) && !isset($_POST['delete'])) {
        redirect_to("../Home Admin/CustomerVSOrder.php");
    }


    if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['delete'])) {
        Delete_Order_With_CustomerID($_POST['id']);
        Delete_Customer_with_CustomerID($_POST['id']);
        $_SESSION['Delete_Customer'] = "<div style='color:green;'>Delete Successfully</div>";
        redirect_to("../Home Admin/CustomerVSOrder.php");
    }

    if (isset($_POST['logout'])) {
        unset($_SESSION['admin']);
        setcookie("username", "", time() - 86400, "/");
        redirect_to('../index.php');
    }

    ?>
</body>

</html>

<?php
db_disconnect($cn);
?>