<?php
include_once("../Backend Admin/functions/functions.php");

if (isset($_GET['ProductID'])) {
  $_SESSION['ProductId'] = $_GET['ProductID'];
  $Product = Select_Product_With_ProductID($_SESSION['ProductId']);
  $ArrImage = Select_Image_with_ProductID_Frontend($Product['ProductID']);
  $countImg = mysqli_num_rows($ArrImage);
  $ArrImage2 = Select_Image_with_ProductID_Frontend2($Product['ProductID']);
  $countImg2 = mysqli_num_rows($ArrImage2);
}


$ArrCategory = Select_Category_Visible_True();
$countCategory = mysqli_num_rows($ArrCategory);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['name_product_search'])) {
  redirect_to("search.php?search=" . $_POST['name_product_search']);
}

if (!isset($_SESSION['id_cart'])) {
  $_SESSION['id_cart'] = 1;
}
if (isset($_POST['cart'])) {

  $Product_Name = $Product['Name'];
  $Product_ID = $Product['ProductID'];
  $Product_Price = $Product['Price'];
  if (empty($_POST['quantity'])) {
    $quantity = 1;
  } else {
    $quantity = $_POST['quantity'];
  }

  if (isset($_SESSION['ArrProduct'])) {
    foreach ($_SESSION['ArrProduct'] as $Product) {

      if ($Product['product_name'] == $Product_Name) {
        $quantity = $Product['quantity'];
        $quantity += $_POST['quantity'];
        unset($_SESSION['ArrProduct'][$Product['id']]);
        // break;
      }
    }
  }

  if (!isset($_SESSION['ArrProduct'][$_SESSION['id_cart']])) {
    $_SESSION['ArrProduct'][$_SESSION['id_cart']] = array(
      'id' => $_SESSION['id_cart'],
      'productID' => $Product_ID,
      'product_name' => $Product_Name,
      'quantity' => $quantity,
      'price' => $Product_Price
    );
  }

  $_SESSION['id_cart']++;

  redirect_to("product.php?ProductID=" . $_SESSION['ProductId']);
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
  <style>
    * {
      box-sizing: border-box;
    }

    /* Position the image container (needed to position the left and right arrows) */
    .container {
      position: relative;
    }

    /* Hide the images by default */
    .mySlides {
      display: none;
    }

    /* Add a pointer when hovering over the thumbnail images */
    .cursor {
      cursor: pointer;
    }

    /* Next & previous buttons */
    .prev,
    .next {
      cursor: pointer;
      position: absolute;
      top: 40%;
      width: auto;
      padding: 16px;
      margin-top: -50px;
      color: white;
      font-weight: bold;
      font-size: 20px;
      border-radius: 0 3px 3px 0;
      user-select: none;
      -webkit-user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }

    /* Container for image text */
    .caption-container {
      text-align: center;
      background-color: #222;
      padding: 2px 16px;
      color: white;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    /* Six columns side by side */
    .column {
      float: left;
      width: 16.66%;
    }

    /* Add a transparency effect for thumnbail images */
    .demo {
      opacity: 0.6;
    }

    .active,
    .demo:hover {
      opacity: 1;
    }
  </style>
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
          <!-- <div style="float:left;"> -->
          <ul class="nav navbar-nav navbar-right" style="margin-left: 20px;">
            <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <?php echo isset($_SESSION['ArrProduct']) ? "(" . count($_SESSION['ArrProduct']) . ")" : "(0)" ?></a></li>
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

          <!-- </div> -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- header -->
  <div class="container" style="padding-top:1.5cm;">
    <div class="row">
      <div class="col-md-5 col-sm-5">
        <!-- Full-width images with number text -->
        <?php
        for ($i = 0; $i < $countImg; $i++) :
          $image = mysqli_fetch_array($ArrImage);

        ?>
          <div class="mySlides">
            <img src="<?php echo "../Backend Admin/Image/" . $image['ImageUrl'] ?>" style="width:100%">
          </div>

        <?php
        endfor;
        ?>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <!-- Image text
        <div class="caption-container">
          <p id="caption"></p>
        </div> -->

        <!-- Thumbnail images -->
        <div class="row" style="padding-left:15px;padding-right: 15px;">
          <?php
          for ($j = 0; $j < $countImg2; $j++) :
            $image2 = mysqli_fetch_array($ArrImage2);

          ?>

            <div class="column">
              <img class="demo cursor" src="<?php echo "../Backend Admin/Image/" . $image2['ImageUrl'] ?>" style="width:100%" onclick="currentSlide(<?php echo $j + 1 ?>)" alt="">
            </div>

          <?php
          endfor;
          ?>
        </div>
      </div>
      <div class=" col-md-1 col-sm-1 col-xs-1 col-lg-1"></div>
      <div class=" col-sm-5">
        <h1 class="hovertext"><?php echo  $Product['Name'] ?></h1>
        <p style="font-size: 25px;">Price: <?php echo "$" . number_format($Product['Price'], 0, ",", "."); ?></p>
        <p style="font-size: 25px;">Description:</p>
        <p><?php echo $Product['Description'] ?></p>
        <p class="hovertext" style="font-size: 18px;">Color </p>
        <button type="button" style="background-color:rgb(185, 184, 184); width: 20px; height: 20px; border: none;"></button>
        <button type="button" style="background-color:rgb(243, 63, 63); width: 20px; height: 20px; border: none;"></button>
        <button type="button" style="background-color:rgb(60, 217, 228); width: 20px; height: 20px; border: none;"></button>
        <button type="button" style="background-color:rgb(193, 241, 59); width: 20px; height: 20px; border: none;"></button>
        <button type="button" style="background-color:rgb(102, 63, 243); width: 20px; height: 20px; border: none;"></button>
        <button type="button" style="background-color:rgb(245, 69, 151); width: 20px; height: 20px; border: none;"></button>
        <p></p>
        <p class="hovertext" style="font-size: 18px;">Size</p>

        <button type="button" class="hoverbutton" style=" border: 1px solid black;">XS</button>
        <button type="button" class="hoverbutton" style=" border: 1px solid black;">S</button>
        <button type="button" class="hoverbutton" style=" border: 1px solid black;">M</button>
        <button type="button" class="hoverbutton" style=" border: 1px solid black;">L</button>
        <button type="button" class="hoverbutton" style="border: 1px solid black;">XL</button>
        <p></p>


        <p class="hovertext" style="font-size: 18px;">Quantity</p>
        <form action="" method="post">
          <div>
            <input name="quantity" class="input" max="100" min="1" type="number" value="1">
          </div>

          <!-- giỏ hàng -->
          <div class="action" style="padding-top:20px;"> <a href="giohang.php">
              <button name="cart" type="submit" class="btn btn-default btn-lg shopping">
                <span class="glyphicon glyphicon-shopping-cart"></span> Add your cart
              </button>
            </a>
          </div>
        </form>
      </div>
    </div>


    <?php

    ?>
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
          <li>Introduce</li>
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

  <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      // var captionText = document.getElementById("caption");
      if (n > slides.length) {
        slideIndex = 1
      }
      if (n < 1) {
        slideIndex = slides.length
      }
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
      // captionText.innerHTML = dots[slideIndex - 1].alt;
    }
  </script>
</body>

</html>

<?php
db_disconnect($cn);
?>