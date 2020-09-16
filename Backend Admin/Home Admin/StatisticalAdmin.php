<?php
include_once("../functions/functions.php");

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
    <title>Statistics Admin</title>
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
                    <li><a href="AllProducts.php">Products</a></li>
                    <li><a href="CustomerVSOrder.php">Customer and Order</a></li>
                    <li class="active"><a href="StatisticalAdmin.php">Admins</a></li>
                </ul>
            </div>
            <br><br>
            <div class="table-responsive">
                <div class="modal-content">
                    <table class="table table-hover"><br>
                        <a class="btn btn-primary" href="../Login-Sign up/CreateAdmin.php"><span class="glyphicon glyphicon-plus"></span> Create New Admin</a><br>
                        <h2>Statistical Admin</h2>

                        <br>
                        <?php
                        if (isset($_SESSION['delete_admin'])) {
                            echo $_SESSION['delete_admin'];
                        }

                        if (isset($_SESSION['change_psw'])) {
                            echo $_SESSION['change_psw'];
                        }
                        ?>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php
                        $result = Select_All_Admin();
                        $count = mysqli_num_rows($result);

                        for ($i = 0; $i < $count; $i++) :
                            $row = mysqli_fetch_array($result);
                        ?>

                            <tr>
                                <td><?php echo $row['Name'] ?></td>
                                <td><?php echo $row['Email'] ?></td>
                                <td><a class="btn btn-info" href="<?php echo "../Admin/EditAdmin.php?adminID=" . $row['AdminID']; ?>">Change Password</a>
                                <td><a class="btn btn-danger" href="<?php echo "../Admin/DeleteAdmin.php?adminID=" . $row['AdminID']; ?>">Delete</a>
                            </tr>

                        <?php
                        endfor;
                        unset($_SESSION['delete_admin']);
                        unset($_SESSION['change_psw']);



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