<?php
session_start();
if(!isset($_SESSION['auth']) && !$_SESSION['auth'] == true && !isset($_SESSION['email'])) {
  unset($_SESSION['auth'], $_SESSION['email']);
  header('Location: login.php');
}

if(isset($_POST['logout'])) {
  unset($_SESSION['auth'], $_SESSION['email']);
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Destov - Admin</title>
  <link rel="stylesheet" href="./vendor/bootstrap 5/css/bootstrap.min.css">
  <script src="http://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand w-25">
          <img src="./img/500px.png" alt="logo" class="img-fluid w-50 rounded img h-auto">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbar">
        <?php 
          if(strpos($_SERVER['REQUEST_URI'],'admin-home',0)) {
            $home = true;
          }
          if(strpos($_SERVER['REQUEST_URI'],'admin.php',0)) {
            $categories = true;
          }
          if(strpos($_SERVER['REQUEST_URI'],'admin-products',0)) {
            $products = true;
          }
          if(strpos($_SERVER['REQUEST_URI'],'slider',0)) {
            $slider = true;
          }
          if(strpos($_SERVER['REQUEST_URI'],'admin-blog',0)) {
            $blog = true;
          }
          if(strpos($_SERVER['REQUEST_URI'],'inquiries',0)) {
            $inquiries = true;
          }
          if(strpos($_SERVER['REQUEST_URI'],'feedback',0)) {
            $feedback = true;
          }
        ?>    
          <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link <?php if(isset($categories)) {echo "active";} ?>" aria-current="page" href="admin.php">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($home)) {echo "active";} ?>" aria-current="page" href="admin-home.php">Home Page Product</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($products)) {echo "active";} ?>" href="admin-products.php">products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($slider)) {echo "active";} ?>" href="slider.php">Slider</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($blog)) {echo "active";} ?>" href="admin-blog.php">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($inquiries)) {echo "active";} ?>" href="inquiries.php">Inquiries</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if(isset($feedback)) {echo "active";} ?>" href="feedbacks.php">Feedbacks</a>
            </li>
          </ul>
          <span class="navbar-text">
            <form action="" method="post">
              <button class="btn btn-sm btn-info" type="submit" name="logout">Logout</button>
            </form>
          </span>
        </div>

      </div>
    </nav>
  </header> 