<?php
include_once("../functions/functions.php");

if (!isset($_SESSION['admin'])) {
    redirect_to('../index.php');
}

if (isset($_GET['productID'])) {
    $_SESSION['ProductID'] = $_GET['productID'];
}

$Product = Select_Product_Info_With_ProductID($_GET['productID']);
$ArrImage = Select_All_Images_with_ProductID($_GET['productID']);
$countImg = mysqli_num_rows($ArrImage);

$ArrCategory = Select_All_Category();
$countCategory = mysqli_num_rows($ArrCategory);


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

    if (empty($_POST["category"])) {
        $err["category"] = "Select Category";
    }

    $ImgType = array('jpg', 'png', 'jpeg', 'gif');

    foreach ($_FILES['image']['name'] as $files) {
        $extenstionfile = pathinfo($files, PATHINFO_EXTENSION);
        if (in_array($extenstionfile, $ImgType) === false && $files != "") {
            $err["image"] = "Only image format allowed jpg, png, jpeg, gif";
        }
    }
}



if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])) {
    $NewCategory = Find_Category_New($_POST["category"]);
    $Product = [];
    $Product['categoryid'] = $NewCategory['CategoryID'];
    $Product['name'] = str_replace("'", "''", (string) $_POST['name']);
    $Product['price'] = $_POST['price'];
    $Product['description'] = $_POST['description'];
    $Product['id'] = $_GET['productID'];
}



if ($_SERVER["REQUEST_METHOD"] == 'POST' && $err == []) {
    Update_Product($Product);
    if (!empty($_FILES['image']['name'][0])) {
        Insert_Image($Product['id']);
    }
    $AllImg = array();
    $ImgKeep = array();
    for ($i = 0; $i < $countImg; $i++) {
        $AllImg[] = $_POST['AllImg'][$i];
        $ImgKeep[] = $_POST['DeleteImg'][$i];
    }
    $ImgDel = array_diff($AllImg, $ImgKeep);
    foreach ($ImgDel as $value) {
        Delete_Image_with_ImageID($value);
    }
    $_SESSION['Edit_Product'] = "<div style='color:green;'>Update successfully</div>";
    redirect_to("../Home Admin/AllProducts.php");
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../CSS/edit.css">
    <style>
        #anh {
            width: 170px;
            height: 170px;
            display: inline-block;
            margin: 10px;
        }

        input[type=checkbox] {
            display: none;
        }

        input[type=checkbox]+label {
            opacity: 0.2;
            background-color: white;
            cursor: pointer;
        }

        input[type=checkbox]:checked+label {
            opacity: 1;
            cursor: pointer;
        }
    </style>
</head>

<body>


    <?php
    if (isset($_SESSION['admin'])) {
        echo "<div id='name-admin'>Admin: " . $_SESSION['admin'] . "</div>" . "<br>";
    }




    ?>

    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <button id='button-logout' class="btn btn-danger" type="submit" value="Logout" name="logout">
                Logout
                <span class="glyphicon glyphicon-log-out"></span>
            </button>
        </form>
    </div>
    <div class="form-product"><br>
        &nbsp;&nbsp;&nbsp;&nbsp;<a id="back_product" class="btn btn-info" href="<?php echo "../Home Admin/AllProducts.php"; ?>">
            <span class="glyphicon glyphicon-chevron-left"></span> Back to Index</a><br>
        <h2>Edit Product <?php echo isset($Product['Name']) ? "<strong>" . $Product['Name'] . "</strong>" : ""; ?></h2>

        <form action="<?php echo "EditProduct.php?productID=" . $_SESSION['ProductID']; ?>" method="post" enctype="multipart/form-data">
            <label for="category">Choose a Category: </label>
            <select class="form-control" name="category" id="category">
                <option></option>
                <?php for ($i = 0; $i < $countCategory; $i++) :
                    $Category = mysqli_fetch_array($ArrCategory); ?>
                    <option value="<?php echo $Category['Name'] ?>" <?php if (isset($Product['categoryName']) && $Product['categoryName'] == $Category['Name'] && !isset($err["category"])) {
                                                                        echo "selected";
                                                                    } ?>><?php echo $Category['Name'] ?></option>
                <?php endfor; ?>
            </select>
            <span style='color:red;'>
                <?php echo isset($err['category']) ? $err['category'] : ""; ?>
            </span><br>
            <div class='form-group'>
                <label for="name">Product Name: </label>
                <input class="form-control" type="text" name="name" id="name" value="<?php echo !isset($err['name']) && isset($Product['Name']) ? $Product['Name'] : "" ?>">
                <span style='color:red;'>
                    <?php echo isset($err['name']) ? $err['name'] : "";
                    ?>
                </span><br>
            </div>
            <div class='form-group'>
                <label for="Price">Product Price: </label>
                <input class="form-control" type="number" name="price" min="1" value=<?php echo !isset($err['price']) && isset($Product['Price']) ? $Product['Price'] : ""; ?>>
                <span style='color:red;'>
                    <?php echo isset($err['price']) ? $err['price'] : "";
                    ?>
                </span><br>
            </div>
            <div class='form-group'>
                <label for="description">Description: </label>
                <textarea rows="5" class="form-control" name="description" id="descript"><?php echo (!isset($err['description']) && isset($Product['Description'])) ? $Product['Description'] : ""; ?></textarea>
                <span style='color:red;'>
                    <?php echo isset($err['description']) ? $err['description'] : "";
                    ?>
                </span><br>
            </div>
            <div>
                <?php
                for ($i = 0; $i < $countImg; $i++) :
                    $Image = mysqli_fetch_array($ArrImage);
                ?>
                    <input type="hidden" value="<?php echo $Image['ImageID']; ?>" name="AllImg[]">
                    <input type="checkbox" id="<?php echo $i ?>" name="DeleteImg[]" value="<?php echo $Image['ImageID']; ?>" checked value="Yes">
                    <label for="<?php echo $i ?>">
                        <img id="anh" src="<?php echo "../Image/" . $Image['ImageUrl']; ?>">
                    </label>
                <?php endfor; ?>
            </div><br>
            <div class="form-group">
                <label for="arrImage">Add a descriptive photo: </label>
                <input class="form-control" type="file" name="image[]" multiple>
                <span style='color:red;'>
                    <?php echo isset($err['image']) ? $err['image'] : "";
                    ?>
                </span><br>
            </div>
            <input class="btn btn-success col-md-12 col-lg-12 col-xs-12 col-sm-12" type="submit" value="Update" name="update">
        </form>
</body>

</html>

<?php
db_disconnect($cn);
?>