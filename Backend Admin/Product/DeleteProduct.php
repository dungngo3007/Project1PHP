<?php
include_once("../functions/functions.php");

if (!isset($_SESSION['admin'])) {
    redirect_to('../index.php');
}

if (isset($_GET['productID'])) {
    $Product = Select_Product_With_ProductID($_GET['productID']);
    $image = Select_All_Images_with_ProductID($_GET['productID']);
    $count = mysqli_num_rows($image);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
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
        <div class="container">

            <form action="" method="post">
                <button id='button-logout' class="btn btn-danger" type="submit" value="Logout" name="logout">
                    Logout
                    <span class="glyphicon glyphicon-log-out"></span>
                </button>
            </form><br><br>

            <div style="text-align: center;" class="modal-content">
                <br><a style="position:absolute; left:5%;" class="btn btn-info" href="<?php echo "../Home Admin/AllProducts.php"; ?>">
                    <span class="glyphicon glyphicon-chevron-left"></span> Back to Index</a><br>
                <h2>Do you want to delete <?php echo "<strong>" . $Product['Name'] . "</strong>"; ?></h2>

                <div><label> Name: </label><?php echo $Product['Name']; ?></div>
                <div><label>Product Price:</label> <?php echo "$" . number_format($Product['Price'], 0, ",", "."); ?></div>
                <div><label>Product Description: </label><?php echo $Product['Description']; ?></div>
                <div>
                    <label>Image: </label><br>
                    <?php
                    for ($i = 0; $i < $count; $i++) :
                        $row = mysqli_fetch_array($image);
                    ?>
                        <img style="width:150px; height:150px; display:inline-block;" src="<?php echo "../Image/" . $row['ImageUrl']; ?>">

                    <?php endfor; ?>
                </div>
                <br>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['productID'] ?>">
                    <div class="button">
                        <div class="row">
                            <input class="btn btn-danger col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="delete" value="Delete">

                        </div>
                    </div>

                </form>
                <br>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isset($_POST['cancel'])) {
                    Delete_Order_With_ProductID($_POST['id']);
                    Delete_All_Image_of_Product($_POST['id']);
                    Delete_Product($_POST['id']);
                    $_SESSION['Delete_Product'] = "<div style='color:green;'>Delete successfully</div>";
                    redirect_to("../Home Admin/AllProducts.php");
                }

                if (isset($_POST['cancel']) || $Product['Name'] == null) {
                    redirect_to("../Home Admin/AllProducts.php");
                }

                if (isset($_POST['logout'])) {
                    unset($_SESSION['admin']);
                    setcookie("username", "", time() - 86400, "/");
                    redirect_to('../index.php');
                }

                ?>

            </div>
        </div>
    </div>
</body>

</html>

<?php
db_disconnect($cn);
?>