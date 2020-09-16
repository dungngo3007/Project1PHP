<?php
include_once("../functions/functions.php");

$err = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST["category"])) {
        $err["category"] = "Enter Category Name";
    }

    if (isset($_POST["category"])) {
        $kq = Find_Category($_POST['category']);
        $result = mysqli_fetch_array($kq);
        if ($result != null) {
            $err["category"] = "Name already exists";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/create.css">
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
                <a style="position:absolute; left:5%;" class="btn btn-info" href="<?php echo "../Home Admin/Category.php"; ?>">
                    <span class="glyphicon glyphicon-chevron-left"></span> Back to Index</a><br>
                <h2>Create New Category</h2><br>
                <div class="form-group">
                    <label for="category">Category Name </label>
                    <input class="form-control" type="text" name="category" id="category">
                    <span style='color:red;'>
                        <?php echo isset($err['category']) ? $err['category'] : "";
                        ?>
                    </span><br>
                </div>

                <div class="form-group">
                    <label for="visible">Visible</label>
                    <input type="checkbox" name="visible" id="visible">
                    <br>
                </div>

                <div class="button">
                    <div class="row">
                        <input class="btn btn-success col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" name="create" value="Create">
                    </div>
                </div>

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
                }

                if (isset($_POST['logout'])) {
                    unset($_SESSION['admin']);
                    setcookie("username", "", time() - 86400, "/");
                    redirect_to('../index.php');
                }
                if (isset($_POST['create']) && $err == []) {
                    Insert_Category($InfoCategory);
                    echo "<div style='color:green;'>Insert successfully</div>";
                }
                ?>
        </form>

    </div>

    </div>

</body>

</html>

<?php
db_disconnect($cn);
?>