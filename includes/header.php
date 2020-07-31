<?php 
include_once('./config.php'); 

if (isset($_POST['subscribe'])) {
  $email = $_POST['email'];
  mysqli_query($cn, "INSERT INTO `subscribers` (email) VALUES ('$email')");
  unset($_POST, $_GET, $_REQUEST);
}

?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
  <meta charset="utf-8" />
  <title>Destov</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="vendor/swiper/css/swiper.min.css" rel="stylesheet" type="text/css" />
  
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/layout.min.css" rel="stylesheet" type="text/css" />

  <link rel="shortcut icon" href="favicon.ico" />
  <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5f2154069194d500128e100f&product=sticky-share-buttons" async="async"></script>
</head>

<body>

<style>
.nav-item-child:hover {
  color: red;
}
</style>
  
  
  <header class="header navbar-fixed-top">
    <div style="background: #f1f1f1; display: flex; justify-content: space-between;">
      <div id="google_translate_element" style="text-align: left" class="xs-translate"></div>
      <div>
        <a href="https://www.facebook.com/destovinternational"><i class="margin-r-10 fa fa-lg fa-facebook"></i></a>
        <a href="https://www.facebook.com/destovinternational"><i class="margin-r-10 fa fa-lg fa-tag fa-twitter"></i></a>
        <a href="https://twitter.com/destovofficial"><i class="margin-r-10 fa fa-lg fa-tag fa-linkedin"></i></a>
        <a href="https://www.facebook.com/destovinternational"><i class="margin-r-10 fa fa-lg fa-tag fa-instagram"></i></a>
      </div>
  </div>
    <nav class="navbar" role="navigation">
      <div class="container">
        <div class="menu-container">
          <button type="button" style="margin-top: 20px" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="toggle-icon"></span>
          </button>
          <!-- style="max-width: 240px; margin-top: -18px; height: auto;"
style="max-width: 240px; margin-top: -18px; height: auto;" -->
        
          <div class="logo">
            <a class="logo-wrap" href="index.php">
              <img class=" logo-img-main" style="max-width: 150px; margin-top: -2px" src="./img/500px.png" alt="Destov Logo">
              <img class=" logo-img-active" style="max-width: 150px; margin-top: -2px" src="./img/500px.png" alt="Destov Logo">
            </a>
          </div>
          <!-- <div id="google_translate_element" class="translate" style="float: right; margin-right: -40px"></div> -->
        
        </div>
        <?php 
            if(strpos($_SERVER['REQUEST_URI'],'index',0)) {
              $home = true;
            }
            if(strpos($_SERVER['REQUEST_URI'],'about',0)) {
              $about = true;
            }
            if(strpos($_SERVER['REQUEST_URI'],'products',0)) {
              $products = true;
            }
            if(strpos($_SERVER['REQUEST_URI'],'contact',0)) {
              $contact = true;
            }
            if(strpos($_SERVER['REQUEST_URI'],'blogs',0)) {
              $blog = true;
            }
          ?>   
        
        <div class="collapse navbar-collapse nav-collapse">
          <div class="menu-container">
            <ul class="navbar-nav navbar-nav-right">
              <!-- <div id="google_translate_element" style="float: right"></div> -->
              <li class="nav-item"><a class="nav-item-child nav-item-hover <?php if(isset($home)) {echo "active";} ?>" href="index.php">Home</a></li>
              <!-- <li class="nav-item"><a class="nav-item-child nav-item-hover" href="pricing.html">Pricing</a></li> -->
              <li class="nav-item"><a class="nav-item-child nav-item-hover <?php if(isset($about)) {echo "active";} ?>" href="about.php">About</a>
              </li>
              <li class="nav-item"><a class="nav-item-child nav-item-hover <?php if(isset($products)) {echo "active";} ?>" href="products.php">Products</a></li>
              <li class="nav-item"><a class="nav-item-child nav-item-hover <?php if(isset($blog)) {echo "active";} ?>" href="blogs.php">Blog</a></li>
              <li class="nav-item"><a class="nav-item-child nav-item-hover <?php if(isset($contact)) {echo "active";} ?>" href="contact.php">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- <div id="google_translate_element" style="text-align: center" class="xs-translate"></div> -->
    </nav>
   
  </header>
  