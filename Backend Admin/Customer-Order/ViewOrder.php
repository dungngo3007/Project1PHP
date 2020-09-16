<?php
include_once("../functions/functions.php");

if (isset($_GET['customerID'])) {
    $ArrOrder = Select_Order_Join_Products($_GET['customerID']);
    $count = mysqli_num_rows($ArrOrder);

    $Customer = Find_Customer_With_CustomerID($_GET['customerID']);
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
    <title>View Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/view.css">
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
        <div class="table-responsive">
            <div class="modal-content">
                <table class="table table-hover">
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="<?php echo "../Home Admin/CustomerVSOrder.php"; ?>">
                        <span class="glyphicon glyphicon-chevron-left"></span> Back to Index</a>
                    <h2>All items ordered by customer <?php echo "<strong>" . $Customer['Name'] . "</strong>" ?></h2>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                    <?php
                    $total =0;
                    for ($i = 0; $i < $count; $i++) :
                        $Order = mysqli_fetch_array($ArrOrder);
                    ?>

                        <tr>
                            <td><?php echo $Order['Name'] ?></td>
                            <td><?php echo $Order['Quantity'] ?></td>
                            <td><?php echo "$".number_format($Order['Price'], 0, ",", ".") ?></td>
                            <td><?php echo "$".number_format($Order['total'], 0, ",", ".") ?></td>
                        </tr>

                    <?php $total += $Order['total'];  endfor; ?>

                    <tr>
                        <td colspan="3" style="text-align: center;"><b>Total:</b></td>
                        <td><?php echo "<strong>$" . number_format($total, 0, ",", ".") . "</strong>"; ?></td>
                    </tr>
            </div>
        </div>
</body>

</html>

<?php
db_disconnect($cn);
?>