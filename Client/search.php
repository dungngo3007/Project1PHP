<?php
include_once("../Backend Admin/functions/functions.php");

$ArrCategory = Select_Category_Visible_True();
$countCategory = mysqli_num_rows($ArrCategory);

if (isset($_GET['search'])) {
  $Product_Name = urlencode($_GET['search']);
  $Product_Name = str_replace("+","%",$Product_Name);
  // print_r(($Product_Name));
  // die();
  $ArrSearch = Search_Products($Product_Name);
  $Count_Search = mysqli_num_rows($ArrSearch);
}

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['name_product_search'])) {
  redirect_to("search.php?search=". $_POST['name_product_search']);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gracious Garments</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="page.css">
</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top ">
    <div class="container-fluid">
      <div class="navbar-header">
        <!-- logo -->
        <a class="navbar-brand" href="Homepage.php" style="border: red 1px solid ; font-family: 'Aguafina Script'; font-size: 20px; background-color: red ;color: white;">GRACIOUS
          GARMENTS</a>
        <!-- responsive  -->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

      </div>
      <!-- navbar -->
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class=" nav  navbar-nav">
          <!-- nhiều hơn 5 category visible true -->
          <?php if ($countCategory > 5) : ?>
            <?php
            for ($i = 0; $i < 5; $i++) :

              $Category = mysqli_fetch_array($ArrCategory);
            ?>
              <li class="dropdown">
                <a href="<?php echo "Category.php?CategoryID=" . $Category['CategoryID']; ?>">
                  <button class="dropbtn"><?php echo $Category['Name'] ?></button></a>
              </li>
            <?php endfor ?>

            <li class="dropdown">
              <a href="#">
                <button class="dropbtn">More...</button></a>
              <div class="dropdown-content">
                <?php
                for ($j = 5; $j < $countCategory; $j++) :

                  $Category = mysqli_fetch_array($ArrCategory);
                ?>
                  <a href="<?php echo "Category.php?CategoryID=" . $Category['CategoryID']; ?>"><?php echo $Category['Name'] ?></a>
                <?php endfor; ?>
              </div>

            </li>
          <?php endif; ?>


          <!-- ít hơn 5 category visible true -->
          <?php if ($countCategory <= 5) : ?>
            <?php
            for ($i = 0; $i < $countCategory; $i++) :

              $Category = mysqli_fetch_array($ArrCategory);
            ?>
              <li class="dropdown">
                <a href="<?php echo "Category.php?CategoryID=" . $Category['CategoryID']; ?>">
                  <button class="dropbtn"><?php echo $Category['Name'] ?></button></a>
              </li>
            <?php endfor ?>
          <?php endif; ?>

          <ul class="nav navbar-nav navbar-right" style="margin-left: 20px;">
            <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart
                <?php echo isset($_SESSION['ArrProduct']) ? "(" . count($_SESSION['ArrProduct']) . ")" : "(0)" ?></a></li>

          </ul>
          <!-- search -->
          <form class="navbar-form navbar-right" role="search" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="input-group">
              <input name="name_product_search" type="text" class="form-control" placeholder="Search" style="margin-left: 10px;" style="width: 300px;">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>
            </div>
          </form>

        </ul>
      </div>
    </div>
  </nav>
  <!-- header -->
  <!-- Thẻ Chạy chữ -->
  <marquee behavior="scroll" width="100%" direction="left" style="color: rgb(231, 140, 104);padding-top: 1.5cm;" loop="1">WELCOME TO
    GRACIOUS
    GARMENTS!!! WISHING YOU A HAPPY AND HAPPY DAY</marquee>


  </div>
  <div class="container">

    <?php if (($_GET['search']) != "") { ?>
      <?php for ($i = 0; $i < $Count_Search; $i++) :
        $Search = mysqli_fetch_array($ArrSearch);
        $image = Select_Image_with_ProductID($Search['ProductID']); ?>
        <div class="col-sm-6 col-lg-3 col-xs-12 col-md-4">
          <div>
            <a href="<?php echo "product.php?ProductID=" . $Search['ProductID']; ?>">
              <div class="img-container">
                <img style="cursor:pointer;" class="img-fluid" src="<?php echo "../Backend Admin/Image/" . $image['ImageUrl'] ?>" alt="" style="width: 100%; height: 100%;">
              </div>
              <p style="text-align: center;" class="hovertext"><?php echo $Search['Name'] ?></p>
            </a>
            <p style="text-align: center;">
              <?php echo "$" . number_format($Search['Price'], 0, ",", ".") ?>
            </p>
          </div>
        </div>
      <?php endfor; ?>
    <?php } else {
      echo "There are no products matching the search";
    }

    if ($Count_Search == 0) {
      echo "There are no products matching the search";
    }
    ?>


  </div>
  <div class="page-header">
  </div>
  </div>
  <!-- footer -->
  <div class="site-footer footer-desktop">
    <div class="footer-container">
      <div class="f-column1  col-sm-3" style="margin-left : 20px; padding-left:1cm; ">
        <h3 class="title"> Gracious Garments</h3>
        <div style="color : gray;">
          <p>Business registration number: 123456778, date of issue: June 18, 2020. Place of issue: Hanoi Department of Planning and Investment</p>
          <p>Contact address: Floor 4, 285 Ward Doi Can, Q Ba Dinh, Hanoi</p>
          <p>Phone :+84584137059 <br>Fax: +84584137059 <br>Email:hoa.nb.475@aptechlearning.edu.vn</p>
        </div>
      </div>
      <div class="f-column2 col-sm-2 " style=" padding-left:1cm; ">
        <h3 class="title" style="margin-left : 20px;">Trademark</h3>
        <ul style="list-style-type: none;margin-left : -20px;">
          <li>Introduce</a></li>
          <li>Blog</li>
          <li>Recruitment</li>
          <li>With the community</li>
          <li>Shop system</li>
          <li>Contact</li>
        </ul>
      </div>
      <div class="f-column3 col-sm-2 " style="padding-left:1cm; ">
        <h3 class="title" style="margin-left : 20px;">Support</h3>
        <ul style="margin-left : -20px;list-style-type: none;">
          <li>Set uniform</li>
          <li>FAQs</li>
          <li>Shipping policy</li>
          <li>Instructions for choosing a size</li>
          <li>Payment Guide</li>
          <li>Check the goods</li>
          <li>Regulations exchange</li>
          <li>Look up card points</li>
          <li>Friendly customer policy</li>
          <li>Information security policy</li>
        </ul>
      </div>
      <div class="f-column3 col-sm-3 " style="padding-left:1cm; ">
        <div class="footer-social" style="margin-left : 20px;">
          <h3 class="title">Connect</h3>
          <a class="social-icon facebook-icon sprite interactive interactive-hover-button" target="_blank" href="https://www.facebook.com/hoachan0112/"><img src="https://canifa.com/skin/frontend/canifa/canifa-2019/images/icon/facebook-icon.svg" alt=""></a>
          <a class="social-icon instagram-icon sprite interactive interactive-hover-button" target="_blank" href="https://www.instagram.com/ngobichhoa0112/"><img src="https://canifa.com/skin/frontend/canifa/canifa-2019/images/icon/instagram-icon.svg" alt=""></a>
          <a class="social-icon youtube-icon sprite interactive interactive-hover-button" target="_blank" href="https://www.youtube.com/channel/UCM2M_oJTdzW2DmtDgfA8V6A?view_as=subscriber"><img src="https://canifa.com/skin/frontend/canifa/canifa-2019/images/icon/youtube-icon.svg" alt=""></a>

        </div>
        <div class="footer-logo" style="margin-left : 20px;padding-top : 10px;">
          <div class="img-barcode"><img src="https://canifa.s3.amazonaws.com/media/wysiwyg/QR-canifa_1.jpg" alt=""></div>
          <div class="img-app" style="padding-top : 10px;">
            <a href="" target="_blank"><img src="https://canifa.com/skin/frontend/canifa/canifa-2019/images/icon/img-app1.png" alt=""></a>
            <a href="" target="_blank"><img src="https://canifa.com/skin/frontend/canifa/canifa-2019/images/icon/img-app2.png" alt=""></a>
          </div>
          <div class="img-payment-method" style="padding-top : 10px;">
            <img src="https://canifa.com/skin/frontend/canifa/canifa-2019/images/icon/img-payment-method.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- map -->

  <iframe width="100%" height="300" frameborder="0" style="border:0; padding-top : 1cm;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1861.9610306784825!2d105.8189332!3d21.0358043!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab0d14762d23%3A0xd5e263c36363fa8d!2zMjg1IMSQ4buZaSBD4bqlbg!5e0!3m2!1sen!2s!4v1592621936391!5m2!1sen!2s" allowfullscreen>
  </iframe>


</body>

</html>

<?php
db_disconnect($cn);
?>