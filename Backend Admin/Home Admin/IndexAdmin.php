<?php
include_once("../functions/functions.php");

$Category = Select_All_Category();
$CountCategory = mysqli_num_rows($Category);

$Admin = Select_All_Admin();
$CountAdmin = mysqli_num_rows($Admin);

$Products = Select_All_Products();
$CountProducts = mysqli_num_rows($Products);

$Customer = Select_All_Customer();
$CountCustomer = mysqli_num_rows($Customer);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/indexadmin.css">
</head>

<body>


    <div class="container-fluid">
        <?php
        if (isset($_SESSION['admin'])) {
            echo "<div id='name-admin'>Admin: " . $_SESSION['admin'] . "</div>" . "<br>";
        }
        ?>
        <form action="" method="post">
            <button id='button-logout' class="btn btn-danger" type="submit" value="Logout" name="logout">
                Logout
                <span class="glyphicon glyphicon-log-out"></span>
            </button>
        </form>
        <br>
    </div>

    <div class="container modal-content">
        <h2>Manager</h2><br><br>

        <div class="row">
            <div class="col-md-3 col-xs-5 col-sm-3">
                <div class="manager">
                    <h4 class="title">Category Manager</h4>
                    <p class="number"><?php echo $CountCategory . " Category" ?></p><br><br>
                    <a href="Category.php" class="btn btn-info">View Details</a>
                </div>
            </div>
            <div class="col-md-3 col-xs-5 col-sm-3">
                <div class="manager">
                    <h4 class="title">Product Manager</h4>
                    <p class="number"><?php echo $CountProducts . " Product" ?></p><br><br>
                    <a href="AllProducts.php" class="btn btn-info">View Details</a>
                </div>
            </div>
            <div class="col-md-3 col-xs-5 col-sm-3">
                <div class="manager">
                    <h4 class="title">Customer Manager</h4>
                    <p class="number"><?php echo $CountCustomer . " Customer" ?></p><br><br>
                    <a href="CustomerVSOrder.php" class="btn btn-info">View Details</a>
                </div>
            </div>
            <div class="col-md-3 col-xs-5 col-sm-3">
                <div class="manager">
                    <h4 class="title">Admin Manager</h4>
                    <p class="number"><?php echo $CountAdmin . " Admin" ?></p><br><br>
                    <a href="StatisticalAdmin.php" class="btn btn-info">View Details</a>
                </div>
            </div>
        </div><br><br><br><br>
    </div>
</body>
<?php

if (isset($_POST['logout']) || !isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
    setcookie("username", "", time() - 86400, "/");
    redirect_to('../index.php');
}
?>

</html>

<?php
db_disconnect($cn);
?>