<?php
include_once("../functions/functions.php");

// if (isset($_GET['categoryID'])) {
//     $_SESSION['categoryid'] = $_GET['categoryID'];
// }

$result = Find_Category_With_ID($_GET['categoryID']);
$products = Select_Product_with_CategoryID($_GET['categoryID']);
$count = mysqli_num_rows($products);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Category</title>
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


        <div class="table-responsive">
            <div class="modal-content">
                <table class="table table-hover">
                    <h2>All Products Of <?php echo "<strong>" . $result['Name'] . "</strong>"; ?></h2>

                    &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="<?php echo "../Home Admin/Category.php"; ?>">
                        <span class="glyphicon glyphicon-chevron-left"></span> Back Index Category</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="<?php echo "../Product/CreateProduct.php?CategoryID=" . $_GET['categoryID']; ?>">
                        <span class="glyphicon glyphicon-plus"></span> Create New Product</a><br>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $count; $i++) :
                        $row = mysqli_fetch_array($products);
                        $image = Select_Image_with_ProductID($row['ProductID']);
                    ?>

                        <tr>
                            <td><?php echo $row['Name'] ?></td>
                            <td><?php echo "$" . number_format($row['Price'], 0, ",", ".") ?></td>
                            <td><?php echo $row['Description'] ?></td>
                            <td><img style="width:100px; height:100px" src="<?php echo "../Image/" . $image['ImageUrl']; ?>" alt="image"></td>
                        </tr>

                    <?php
                    endfor;
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