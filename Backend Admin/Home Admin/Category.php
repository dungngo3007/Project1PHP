<?php
include_once("../functions/functions.php");
$ArrCategory = Select_All_Category();
$count = mysqli_num_rows($ArrCategory);

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
    <title>Category</title>
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

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <button id='button-logout' class="btn btn-danger" type="submit" value="Logout" name="logout">
                Logout
                <span class="glyphicon glyphicon-log-out"></span>
            </button>
        </form><br>
        <div class="row">
            <div class="col-md-3 col-lg-3 col-xs-12 col-sm-3">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="IndexAdmin.php">Home Admin</a></li>
                    <li class="active"><a href="Category.php">Category</a></li>
                    <li><a href="AllProducts.php">Products</a></li>
                    <li><a href="CustomerVSOrder.php">Customer and Order</a></li>
                    <li><a href="StatisticalAdmin.php">Admins</a></li>
                </ul>
            </div>

            <br><br>

            <div class="table-responsive">
                <div class="modal-content">
                    <table class="table table-striped table-hover">
                        <br><a class="btn btn-primary" href="../Category/CreateCategory.php"><span class="glyphicon glyphicon-plus"></span> Create New Category</a>
                        <h2>Statistics Category</h2>
                        <?php
                        if (isset($_SESSION['update_category'])) {
                            echo $_SESSION['update_category'];
                        }

                        if (isset($_SESSION['Delete_Category'])) {
                            echo $_SESSION['Delete_Category'];
                        }

                        ?>
                        <tr>
                            <th>Name</th>
                            <th>Visible</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>

                            <?php
                            for ($i = 0; $i < $count; $i++) :
                                $Category = mysqli_fetch_array($ArrCategory);
                            ?>

                                <tr>
                                    <td><?php echo $Category['Name'] ?></td>
                                    <td><?php echo $Category['Visible'] ? "True" : "False" ?></td>
                                    <td><a class="btn btn-info" href="<?php echo "../Category/ViewCategory.php?categoryID=" . $Category['CategoryID']; ?>">View</a>
                                    <td><a class="btn btn-info" href="<?php echo "../Category/EditCategory.php?categoryID=" . $Category['CategoryID']; ?>">Edit</a>
                                    <td><a class="btn btn-danger" href="<?php echo "../Category/DeleteCategory.php?categoryID=" . $Category['CategoryID']; ?>">Delete</a>
                                </tr>

                            <?php
                            endfor;

                            unset($_SESSION['update_category']);
                            unset($_SESSION['Delete_Category']);
                            ?>
                </div>
            </div>
        </div>

    </div>



</body>

</html>

<?php
db_disconnect($cn);
?>