<?php
include_once("../functions/functions.php");

if (!isset($_SESSION['admin'])) {
    redirect_to('../index.php');
}

if (isset($_GET['CategoryID'])) {
    $_SESSION['idcategory'] = $_GET['CategoryID'];
    $Category_Name = Find_Category_With_ID($_GET['CategoryID']);
}



$err = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (empty($_POST["name"])) {
        $err["name"] = "Enter product name";
    }

    if (empty($_POST["price"])) {
        $err["price"] = "Enter product price";
    }

    if (empty($_POST["description"])) {
        $err["description"] = "Enter product description";
    }

    $ImgType = array('jpg', 'png', 'jpeg', 'gif');

    foreach ($_FILES['image']['name'] as $files) {
        $extenstionfile = pathinfo($files, PATHINFO_EXTENSION);
        if (in_array($extenstionfile, $ImgType) === false) {
            $err["image"] = "Only image format allowed jpg, png, jpeg, gif";
        }
    }

    if (empty($_FILES['image']['name'][0])) {
        $err["image"] = "Select image";
    }

    if (empty($_POST["category"])) {
        $err["category"] = "Select Category";
    }
}
?>

<?php
$product = [];
if (!empty($_POST['category'])) {
    $CategoryID = Select_Category_With_Name($_POST["category"]);
    $product['CategoryID'] = $CategoryID['CategoryID'];
}

if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])) {

    $product['Name'] = $_POST['name'];
    $product['Price'] = $_POST['price'];
    $product['Description'] = $_POST['description'];
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
    <title>Create Product</title>
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

    $ArrCategory = Select_All_Category();
    $count = mysqli_num_rows($ArrCategory);
    ?>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <button id='button-logout' class="btn btn-danger" type="submit" value="Logout" name="logout">
            Logout
            <span class="glyphicon glyphicon-log-out"></span>
        </button><br><br>
        <div class="form-product">
            <a style="position:absolute; left:5%;" class="btn btn-info" href="<?php echo (!isset($_GET['CategoryID'])) ? "../Home Admin/AllProducts.php" : "../Category/ViewCategory.php?categoryID=" . $_SESSION['idcategory']; ?>">
                <span class="glyphicon glyphicon-chevron-left"></span> Back to Index</a><br>
            <h2>Create New Product </h2>
            <div class="form-group">
                <label for="category">Choose a Category: </label>
                <select class="form-control" name="category" id="category" value="<?php echo !empty($err) ? $_POST['category'] : "" ?>">
                    <option></option>
                    <?php for ($i = 0; $i < $count; $i++) :
                        $Category = mysqli_fetch_array($ArrCategory); ?>
                        <option value="<?php echo $Category['Name'] ?>" <?php echo ((!isset($err['category']) && isset($Category_Name['Name']) && $Category_Name['Name'] == $Category['Name'])) ? "selected" : ""
                                                                        ?>><?php echo $Category['Name'] ?></option>
                    <?php endfor; ?>
                </select>
                <span style='color:red;'>
                    <?php echo isset($err['category']) ? $err['category'] : "";
                    ?>
                </span><br>
            </div>
            <div class="form-group">
                <label for="name">Product Name: </label>
                <input class="form-control" id="name" type="text" name="name" value=<?php echo !empty($err) ? $_POST['name'] : "" ?>>
                <span style='color:red;'>
                    <?php echo isset($err['name']) ? $err['name'] : "";
                    ?>
                </span><br>
            </div>
            <div class="form-group">
                <label for="Price">Product Price: </label>
                <input class="form-control" type="number" id="Price" name="price" min="0" value=<?php echo !empty($err) ? $_POST['price'] : "" ?>>
                <span style='color:red;'>
                    <?php echo isset($err['price']) ? $err['price'] : "";
                    ?>
                </span><br>
            </div>
            <div class="form-group">
                <label for="descript">Description: </label>
                <textarea class="form-control" name="description" id="descript"></textarea>
                <span style='color:red;'>
                    <?php echo isset($err['description']) ? $err['description'] : "";
                    ?>
                </span><br>
            </div>
            <div class="form-group">
                <label for="arrImage">Image: </label>
                <input class="form-control" type="file" name="image[]" id="arrImage" multiple>
                <span style='color:red;'>
                    <?php echo isset($err['image']) ? $err['image'] : "";
                    ?>
                </span><br>
            </div>
            <input type="hidden" name="id" value="<?php echo $_SESSION['categoryid']; ?>"><br>
            <div class="button">
                <div class="row">
                    <input class="btn btn-success col-md-10 col-lg-10 col-xs-10 col-sm-10" type="submit" value="Create" name="create">
                </div>
            </div>
    </form>

    <script type="text/javascript">
        <?php if (isset($_POST['description']) && !empty($err)) : ?>
            document.getElementById("descript").value = "<?php echo $_POST['description']; ?>";
        <?php endif; ?>
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == 'POST' && $err == []) {
        Insert_Product($product);
        $ProductIdMax = Find_Product_idmax();
        if ($ProductIdMax['maxid'] == null) {
            Insert_Image(1);
        } else {
            Insert_Image($ProductIdMax['maxid']);
        }
        echo "<div style='color:green;'>Create Product successfully</div>";
    }

    $_SESSION['idcategory'];

    ?>

    </div>
</body>

</html>

<?php
db_disconnect($cn);
?>