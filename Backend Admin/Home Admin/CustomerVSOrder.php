<?php
include_once("../functions/functions.php");
$ArrCustomer = Select_All_Customer();
$count = mysqli_num_rows($ArrCustomer);

if (isset($_POST['logout']) || !isset($_SESSION['admin'])) {
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
    <title>Customer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/homeadmin.css">
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
        </form><br>
        <div class="row">
            <div class="col-md-3 col-lg-3 col-xs-12 col-sm-3">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="IndexAdmin.php">Home Admin</a></li>
                    <li><a href="Category.php">Category</a></li>
                    <li><a href="AllProducts.php">Products</a></li>
                    <li class="active"><a href="CustomerVSOrder.php">Customer and Order</a></li>
                    <li><a href="StatisticalAdmin.php">Admins</a></li>
                </ul>
            </div>
            <br><br>
            <div class="table-responsive">
                <div class="modal-content">
                    <table class="table table-striped table-hover">
                        <h2>All Customers</h2>

                        <?php
                        if (isset($_SESSION['Delete_Customer'])) {
                            echo $_SESSION['Delete_Customer'];
                        }
                        ?>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Items</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php
                        for ($i = 0; $i < $count; $i++) :
                            $Customer = mysqli_fetch_array($ArrCustomer);
                            $Number_Items = Count_Items_With_CustomerID($Customer['CustomerID']);
                        ?>
                            <tr>
                                <td><?php echo $Customer['Name'] ?></td>
                                <td><?php echo $Customer['Contact'] ?></td>
                                <td><?php echo $Customer['Address'] ?></td>
                                <td><?php echo $Customer['Email'] ?></td>
                                <td><?php echo $Number_Items['items'] ?></td>
                                <td><a class="btn btn-info" href="<?php echo "../Customer-Order/ViewOrder.php?customerID=" . $Customer['CustomerID'] ?>">View</td>
                                <td><a class="btn btn-danger" href="<?php echo "../Customer-Order/DeleteCustomer.php?customerID=" . $Customer['CustomerID'] ?>">Delete</td>

                            </tr>

                        <?php
                        endfor;

                        unset($_SESSION['Delete_Customer']);
                        ?>
                    </table>
                </div>
            </div>
        </div>
</body>

</html>

<?php
db_disconnect($cn);
?>