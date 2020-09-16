<?php
include_once("../functions/functions.php");

if (isset($_POST['logout']) || !isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
    setcookie("username", "", time() - 86400, "/");
    redirect_to('../index.php');
}

$ArrProducts = Select_All_Products();
$count = mysqli_num_rows($ArrProducts);

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     redirect_to("AllProducts.php?name=" . $_POST['name_product']);
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
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
        </form>
        <br>
        <div class="row">
            <div class="col-md-3 col-lg-3 col-xs-12 col-sm-3">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="IndexAdmin.php">Home Admin</a></li>
                    <li><a href="Category.php">Category</a></li>
                    <li class="active"><a href="AllProducts.php">Products</a></li>
                    <li><a href="CustomerVSOrder.php">Customer and Order</a></li>
                    <li><a href="StatisticalAdmin.php">Admins</a></li>
                </ul>
            </div>
            <br><br>

            <div class="table-responsive">
                <div class="modal-content">
                    <table class="table table-hover"><br>
                        <a class="btn btn-primary" href="<?php echo "../Product/CreateProduct.php"; ?>"><span class="glyphicon glyphicon-plus"></span> Create New Product</a>
                        <!-- <form class="navbar-form navbar-right" role="search" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="input-group">
                                <input style="float: right;" name="name_product" type="text" placeholder="Search">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </form> -->
                        <h2>All Products</h2>
                        <?php
                        if (isset($_SESSION['Edit_Product'])) {
                            echo $_SESSION['Edit_Product'];
                        }

                        if (isset($_SESSION['Delete_Product'])) {
                            echo $_SESSION['Delete_Product'];
                        }
                        ?>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php
                        // if (empty($_POST['name_product'])) :
                        for ($i = 0; $i < $count; $i++) :
                            $Products = mysqli_fetch_array($ArrProducts);
                            $image = Select_Image_with_ProductID($Products['ProductID']);
                        ?>

                            <tr>
                                <td><?php echo $Products['Name'] ?></td>
                                <td><?php echo "$" . number_format($Products['Price'], 0, ",", ".") ?></td>
                                <td><?php echo $Products['Description'] ?></td>
                                <td><img style="width:100px; height:100px" src="<?php echo "../Image/" . $image['ImageUrl']; ?>" alt="image"></td>
                                <td><a class="btn btn-info" href="<?php echo "../Product/EditProduct.php?productID=" . $Products['ProductID']; ?>">Edit</a>
                                <td><a class="btn btn-danger" href="<?php echo "../Product/DeleteProduct.php?productID=" . $Products['ProductID']; ?>">Delete</a></td>


                            </tr>

                        <?php
                        endfor;
                        // endif;
                        unset($_SESSION['Edit_Product']);
                        unset($_SESSION['Delete_Product']);
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