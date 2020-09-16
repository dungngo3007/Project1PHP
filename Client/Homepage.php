<?php
include_once("../Backend Admin/functions/functions.php");

$ArrProductNew = Select_Product_New();
$countProductsNew = mysqli_num_rows($ArrProductNew);

$ArrCategory = Select_Category_Visible_True();
$countCategory = mysqli_num_rows($ArrCategory);

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['name_product_search'])) {
  redirect_to("search.php?search=". $_POST['name_product_search']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GRACIOUS GARMENTS</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="page.css">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial;
    }

    .header {
      text-align: center;
      padding: 32px;
    }

    .row {
      display: -ms-flexbox;
      /* IE10 */
      display: flex;
      -ms-flex-wrap: wrap;
      /* IE10 */
      flex-wrap: wrap;
      padding: 0 4px;
    }

    /* Create four equal columns that sits next to each other */
    .column {
      -ms-flex: 25%;
      /* IE10 */
      flex: 25%;
      max-width: 25%;
      padding: 0 4px;
    }

    .column img {
      margin-top: 8px;
      vertical-align: middle;
      width: 100%;
    }

    .new {
      position: relative;
      border-bottom: 3px solid #e3e3e3;
      margin-bottom: 30px;
    }

    .new .up-btn {
      position: absolute;
      width: 62px;
      height: 62px;
      left: calc(50% - 31px);
      top: calc(50% - 31px);
      text-align: center;
      color: #71767b;
      font-size: 16px;
      display: block;
      padding-top: 16px;
      border-radius: 50%;
      border: 3px solid #e3e3e3;
      background: #fff;
    }

    /* Responsive layout - makes a two column-layout instead of four columns */
    @media screen and (max-width: 800px) {
      .column {
        -ms-flex: 50%;
        flex: 50%;
        max-width: 50%;
      }
    }

    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
      .column {
        -ms-flex: 100%;
        flex: 100%;
        max-width: 100%;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
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
        <ul class="nav navbar-nav">
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

          <!-- <li class="dropdown"> -->
          <ul class="nav navbar-nav navbar-right" style="margin-left: 20px;">
            <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart
                <?php echo isset($_SESSION['ArrProduct']) ? "(" . count($_SESSION['ArrProduct']) . ")" : "(0)" ?></a></li>
          </ul>
          <!-- </li> -->
          <!-- search -->
          <!-- <li class="dropdown"> -->
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
          <!-- </li> -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- header -->

  <!-- Thẻ Chạy chữ -->
  <marquee behavior="scroll" width="100%" direction="left" style="color: rgb(231, 140, 104); padding-top:1.5cm" loop="-1">WELCOME TO GRACIOUS
    GARMENTS!!! WISHING YOU A HAPPY AND HAPPY DAY</marquee>
  <!-- image slide -->
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">

      <div class="item active">
        <a href="<?php echo "product.php?ProductID=111" ?>">
          <img src="../Backend Admin/Sale/Sale1.jpg" alt="Sale" style="width:100%; height : 600px; object-fit: cover;">
        </a>
      </div>


      <div class="item">
        <a href="<?php echo "product.php?ProductID=101" ?>">
          <img src="../Backend Admin/Sale/Sale2.jpg" alt="Sự kiện khuyến mãi" style="width:100%; height : 600px;  object-fit: cover; ">
        </a>
      </div>

      <div class="item">
        <a href="<?php echo "product.php?ProductID=92" ?>">
          <img src="../Backend Admin/Sale/Sale3.jpg" alt="Chương trình ưu đãi " style="width:100%; height : 600px; object-fit: cover; ">
        </a>
      </div>
    </div>

    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <br><br><br>
  <div class="container">
    <div class="new">
      <div class="up-btn" id="new">New</div>
    </div>

  </div>
  <div class="container">

    <?php
    for ($i = 0; $i < $countProductsNew; $i++) :

      $ProductNew = mysqli_fetch_array($ArrProductNew);
      $image = Select_Image_with_ProductID($ProductNew['ProductID']);
      if($image != null):

    ?>

      <div class="col-sm-6 col-lg-3 col-xs-12 col-md-4">
        <!-- <div> -->
        <a href="<?php echo "product.php?ProductID=" . $ProductNew['ProductID']; ?>">
          <div class="img-container">
            <img style="cursor:pointer;" class="img-fluid" src="<?php echo "../Backend Admin/Image/" . $image['ImageUrl']; ?>" alt="" style="width: 300px; height: 400px;">

          </div>
          <p class="hovertext" style="text-align: center;"><?php echo $ProductNew['Name'] ?></p>
        </a>
        <p style="text-align: center;">
          <?php echo "$" . number_format($ProductNew['Price'], 0, ",", "."); ?>
        </p>
        <!-- </div> -->
      </div>

      <?php endif; endfor; ?>

  </div>
  <br>


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

  <?php
  if (isset($_SESSION['order'])) {
    echo '<script type="text/javascript">alert("' . $_SESSION['order'] . '")</script>';
  }

  unset($_SESSION['order']);

  ?>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php
db_disconnect($cn);
?>