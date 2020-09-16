<?php

session_start();

function connect()
{
    $servername = "localhost";
    $username = "root";
    $dbname = "gracious_garments";
    $password = "";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    return $conn;
}

function db_disconnect($connection)
{
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

$cn = connect();


function Create_Admin($admin)
{
    global $cn;
    $query = "INSERT INTO admin ";
    $query .= "(Name, Email, Password) ";
    $query .= "VALUES (";
    $query .= "'" . $admin['name'] . "',";
    $query .= "'" . $admin['email'] . "',";
    $query .= "'" . $admin['psw'] . "'";
    $query .= ")";
    mysqli_query($cn, $query);
    // return confirm_result()
}

function Select_Email_Admin($email)
{
    global $cn;
    $query = "SELECT Email FROM admin where Email = '$email'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_assoc($kq);

    return $result;
}

function Select_Name_Admin($name)
{
    global $cn;
    $query = "SELECT * FROM admin where Name = '$name'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_assoc($kq);

    return $result;
}

function Select_All_Admin()
{
    global $cn;
    $query = "SELECT * FROM admin";
    $result = mysqli_query($cn, $query);
    return $result;
}

function Select_Admin_With_ID($id)
{
    global $cn;
    $query = "SELECT * FROM admin where AdminID = $id";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_assoc($kq);

    return $result;
}

function Delete_Admin($id)
{
    global $cn;
    $query = "DELETE FROM admin where AdminID = $id";
    mysqli_query($cn, $query);
}

function Change_Password($id)
{
    global $cn;
    $password = sha1($_POST['pswCf']);
    $query = "UPDATE admin SET Password = '$password' where AdminID = $id";
    mysqli_query($cn, $query);
}

function Insert_Category($InfoCategory)
{
    global $cn;
    $query = "INSERT INTO category ";
    $query .= "(Name, Visible) ";
    $query .= "VALUES (";
    $query .= "'" . $InfoCategory['name'] . "',";
    $query .= "'" . $InfoCategory['visible'] . "'";
    $query .= ")";
    mysqli_query($cn, $query);
}

function Find_Category($name)
{
    global $cn;
    $query = "SELECT * FROM category WHERE Name = '$name'";
    $result = mysqli_query($cn, $query);

    return $result;
}

function Find_Category_New($name)
{
    global $cn;
    $query = "SELECT * FROM category WHERE Name = '$name'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);

    return $result;
}

function Find_Category_With_ID($id)
{
    global $cn;
    $query = "SELECT * FROM category WHERE CategoryID = '$id'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);

    return $result;
}

function Select_All_Category()
{
    global $cn;
    $query = "SELECT * FROM category";
    $result = mysqli_query($cn, $query);

    return $result;
}

function Update_Category($InfoCategory)
{
    global $cn;
    $query = "UPDATE category SET ";
    $query .= "Name = ";
    $query .= "'" . $InfoCategory['name'] . "',";
    $query .= "Visible = ";
    $query .= "'" . $InfoCategory['visible'] . "'";
    $query .= " WHERE CategoryID = ";
    $query .= "'" . $InfoCategory['id'] . "'";
    mysqli_query($cn, $query);
}

function Insert_Product($Product)
{
    global $cn;
    $query = "INSERT INTO products ";
    $query .= "(CategoryID, Name, Price, Description) ";
    $query .= "VALUES (";
    $query .= "'" . $Product['CategoryID'] . "',";
    $query .= "'" . $Product['Name'] . "',";
    $query .= "'" . $Product['Price'] . "',";
    $query .= "'" . $Product['Description'] . "'";
    $query .= ")";
    mysqli_query($cn, $query);
}

function Find_Product_idmax()
{
    global $cn;

    $query = "SELECT max(ProductID) as maxid from products";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);
    return $result;
}

function Select_Category_With_Name($name)
{
    global $cn;
    $query = "SELECT * FROM Category WHERE Name = '$name'";

    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);

    return $result;
}

function Insert_Image($ProductID)
{
    global $cn;
    $target_dir    = "../Image/";
    $countImg = count($_FILES['image']['name']);

    for($i=0;$i<$countImg;$i++){
        $FileName = $_FILES['image']['name'][$i];
        $Dirfile = $target_dir . $FileName;
        move_uploaded_file($_FILES['image']['tmp_name'][$i], $Dirfile);
        $query = "INSERT INTO image (ProductID,ImageUrl) VALUES ('$ProductID','$FileName')";
        mysqli_query($cn, $query);
    }

}

function Select_Product_with_CategoryID($CategoryID)
{
    global $cn;
    $query = "SELECT * FROM Products WHERE CategoryID = '$CategoryID'";
    $result = mysqli_query($cn, $query);

    return $result;
}

function Select_Image_with_ProductID($ProductID)
{
    global $cn;
    $query = "SELECT * FROM image where ProductID = '$ProductID' LIMIT 1";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);

    return $result;
}

function Select_Image_with_ProductID_Frontend($ProductID)
{
    global $cn;
    $query = "SELECT * FROM image where ProductID = '$ProductID'";
    $result = mysqli_query($cn, $query);

    return $result;
}

function Select_Image_with_ProductID_Frontend2($ProductID)
{
    global $cn;
    $query = "SELECT * FROM image where ProductID = '$ProductID'";
    $result = mysqli_query($cn, $query);

    return $result;
}

function Select_All_Products()
{
    global $cn;
    $query = "SELECT * FROM products";

    $result = mysqli_query($cn, $query);
    return $result;
}

function Select_Product_With_ProductID($ProductID)
{
    global $cn;

    $query = "SELECT * FROM products where ProductID = '$ProductID'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);

    return $result;
}

function Select_Product_Info_With_ProductID($ProductID)
{
    global $cn;

    $query = "SELECT products.*,category.Name as categoryName FROM products
         join category on products.CategoryID = category.CategoryID where ProductID = '$ProductID'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);

    return $result;
}

function Select_All_Images_with_ProductID($ProductID)
{
    global $cn;

    $query = "SELECT * FROM image where ProductID = '$ProductID'";
    $result = mysqli_query($cn, $query);

    return $result;
}

function Delete_Category($CategoryID)
{
    global $cn;

    $query = "DELETE FROM category where CategoryID = '$CategoryID'";
    mysqli_query($cn, $query);
}

function Delete_Products_With_CategoryID($CategoryID)
{
    global $cn;

    $query = "DELETE FROM products where CategoryID = '$CategoryID'";
    mysqli_query($cn, $query);
}

function Delete_Product($ProductID)
{
    global $cn;
    $query = "DELETE from products where ProductID = '$ProductID'";
    mysqli_query($cn, $query);
}

function Delete_All_Image_of_Product($ProductID)
{
    global $cn;
    $query = "DELETE from image where ProductID = '$ProductID'";
    mysqli_query($cn, $query);
}

function Delete_Image_with_ImageID($ImageID)
{
    global $cn;
    $query = "DELETE from image where ImageID = '$ImageID'";

    mysqli_query($cn, $query);
}

function Delete_Image_with_empty()
{
    global $cn;
    $query = "DELETE from image where ImageUrl = ''";

    mysqli_query($cn, $query);
}

function Update_Product($Product)
{
    global $cn;
    $query = "UPDATE products SET ";
    $query .= "CategoryID = ";
    $query .= "'" . $Product['categoryid'] . "',";
    $query .= "Name = ";
    $query .= "'" . $Product['name'] . "',";
    $query .= "Price = ";
    $query .= "'" . $Product['price'] . "',";
    $query .= "Description = ";
    $query .= "'" . $Product['description'] . "'";
    $query .= " WHERE ProductID = ";
    $query .= "'" . $Product['id'] . "'";
    mysqli_query($cn, $query);
}

function Select_Category_Visible_True()
{
    global $cn;
    $query = "SELECT * FROM category WHERE Visible = 1";
    $result = mysqli_query($cn, $query);
    return $result;
}


function Search_Products($Product_Name)
{
    global $cn;
    $query = "SELECT * FROM products WHERE Name like '%$Product_Name%'";
    $result = mysqli_query($cn, $query);
    return $result;
}

function Insert_Order($Order)
{
    global $cn;
    $query = "INSERT INTO `order` ";
    $query .= "(CustomerID, ProductID, Quantity, Price) ";
    $query .= "VALUES (";
    $query .= "'" . $Order['customerID'] . "',";
    $query .= "'" . $Order['productID'] . "',";
    $query .= "'" . $Order['quantity'] . "',";
    $query .= "'" . $Order['price'] . "'";
    $query .= ")";
    mysqli_query($cn, $query);
}

function Insert_Customer($Customer)
{
    global $cn;
    $query = "INSERT INTO customer ";
    $query .= "(Name,Contact, Address, Email) ";
    $query .= "VALUES (";
    $query .= "'" . $Customer['name'] . "',";
    $query .= "'" . $Customer['contact'] . "',";
    $query .= "'" . $Customer['address'] . "',";
    $query .= "'" . $Customer['email'] . "'";
    $query .= ")";
    mysqli_query($cn, $query);
}

function Find_maxID_Customer()
{
    global $cn;
    $query = "SELECT max(CustomerID) as maxid from customer";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);
    return $result;
}

function Select_All_Customer()
{
    global $cn;
    $query = "SELECT * FROM customer";
    $result = mysqli_query($cn, $query);
    return $result;
}

function Find_Customer_With_CustomerID($customerID)
{
    global $cn;
    $query = "SELECT * FROM customer WHERE CustomerID = '$customerID'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);
    return $result;
}

function Delete_Customer_with_CustomerID($customerID)
{
    global $cn;
    $query = "DELETE FROM customer WHERE CustomerID='$customerID'";
    mysqli_query($cn, $query);
}

function Count_Items_With_CustomerID($customerID)
{
    global $cn;
    $query = "SELECT COUNT(ProductID) as items from `order` where CustomerId = '$customerID'";
    $kq = mysqli_query($cn, $query);
    $result = mysqli_fetch_array($kq);
    return $result;
}

function Delete_Order_With_CustomerID($customerID)
{
    global $cn;
    $query = "DELETE FROM `order` where CustomerID = '$customerID'";
    mysqli_query($cn, $query);
}

function Delete_Order_With_ProductID($productID)
{
    global $cn;
    $query = "DELETE FROM `order` where ProductID = '$productID'";
    mysqli_query($cn, $query);
}

function Select_Order_Join_Products($customerID)
{
    global $cn;
    $query = "SELECT products.Name, products.Price, `order`.Quantity,`order`.Price as total
        FROM `order` join products on products.ProductID = `order`.ProductID  WHERE `order`.CustomerID = '$customerID'";
    $result = mysqli_query($cn, $query);
    return $result;
}

function Select_Product_New()
{
    global $cn;
    $query = "SELECT * FROM products WHERE CategoryID IN (SELECT CategoryID FROM category WHERE Visible=1) ORDER BY 1 DESC LIMIT 0,12";
    $result = mysqli_query($cn, $query);
    return $result;
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}
