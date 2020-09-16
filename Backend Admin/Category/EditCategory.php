<?php
include_once("../functions/functions.php");

if (isset($_POST['category'])) {
    $ArrCategory = Find_Category($_POST['category']);
    $count = mysqli_num_rows($ArrCategory);
    $Category = mysqli_fetch_array($ArrCategory);
}

if (isset($_GET['categoryID'])) {
    $_SESSION['categoryID'] = $_GET['categoryID'];
}
$CategoryID = Find_Category_With_ID($_SESSION['categoryID']);


$err = [];
$dem = 0;

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST["category"])) {
        $err["category"] = "Enter Category Name";
    }

    if ($count == 1 && $Category['CategoryID'] != $_SESSION['categoryID']) {
        $err["category"] = "Category is identical";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/edit.css">
</head>

<body>
    <?php
    if (isset($_SESSION['admin'])) {
        echo "<div id='name-admin'>Admin: " . $_SESSION['admin'] . "</div>" . "<br>";
    }
    ?>

    <div class="container">

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <button id='button-logout' class="btn btn-danger" type="submit" value="Logout" name="logout">
                Logout
                <span class="glyphicon glyphicon-log-out"></span>
            </button>

            <div class="form-category">
                <a class="btn btn-info" href="<?php echo "../Home Admin/Category.php"; ?>">
                    <span class="glyphicon glyphicon-chevron-left"></span> Back to Index</a><br>

                <h2>Edit Category <br> <strong><?php echo $CategoryID['Name'] ?></h2>
                <div class="form-group">
                    <label for="category">Category Name </label>
                    <input class="form-control" id="category" type="text" name="category" value="<?php echo !isset($err['category']) ? $CategoryID['Name'] : "" ?>">
                    <span style='color:red;'>
                        <?php echo isset($err['category']) ? $err['category'] : "";
                        ?>
                    </span>
                </div>
                <div class="form-group" style="text-align: center;">
                    <label for="visible">Visible </label>
                    <input id="visible" type="checkbox" name="visible" <?php echo (isset($CategoryID['Visible']) && $CategoryID['Visible']) ? "Checked" : ""; ?>>
                </div>
                <input type="hidden" name="id" value="<?php echo $_SESSION['categoryID'] ?>">
                <br>
                <div class="button">
                    <div class="row">
                        <input class="btn btn-success col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="submit" value="Update">

                    </div>
                </div>

        </form>
        <?php
        if (isset($_POST['visible'])) {
            $visible = true;
        } else {
            $visible = false;
        }
        if (isset($_POST['category'])) {
            $InfoCategory = [];
            $InfoCategory['name'] = $_POST['category'];
            $InfoCategory['visible'] = $visible;
            $InfoCategory['id'] = $_POST['id'];
        }

        if ($_SERVER["REQUEST_METHOD"] == 'POST' && $err == [] && !isset($_POST['cancel'])) {
            if (($_POST['category'] != $result['Name'] || $result['Visible'] != $visible)) {
                Update_Category($InfoCategory);
                $_SESSION['update_category'] = "<div style='color:green;'>Update successfully</div>";
                redirect_to("../Home Admin/Category.php");
            }
        }

        if (isset($_POST['cancel'])) {
            redirect_to("../Home Admin/Category.php");
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