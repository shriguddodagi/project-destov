<?php 
include_once('./includes/header.php');
include_once('./includes/productUtil.php');

$query = "SELECT id, title, description, image FROM `products` ORDER BY id DESC";
$products = mysqli_query($cn, $query);

if(isset($_GET['term'])) {
  $term = $_GET['term'];
  $search = mysqli_query($cn, "SELECT * FROM `products` WHERE title LIKE '$term%'");
}

?>

  <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/01.jpg">
    <div class="parallax-content container">
      <h1 class="carousel-title">Products</h1>
    </div>
  </div>

  <div class="content-lg container text-center">
    <div class="row margin-b-10">
      <form action="" method="get">
        <div class="col-md-10">
          <input name="term" 
            id="term" 
            type="text" 
            class="form-control margin-b-10" 
            placeholder="Start Typing..." 
            required 
            pattern="^\w+(\s+\w+)*$">
        </div>
        <div class="col-md-2">
          <button name="search" id="search" type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Search</button>
        </div>
      </form>
    </div>
    <div class="row">
      <?php
      while($row = mysqli_fetch_array($search)) {
        echo thumbnail($row['image'], $row['title'], $row['description'], $row['id']);
      }
      ?>
    </div>
  </div>

  <div class="content-lg container">
    <div class="row margin-b-40">
      <div class="col-sm-6">
        <h2>Our Exceptional Products</h2>
      </div>
    </div>
    

    <div class="row margin-b-50">
      <?php

      while($row = mysqli_fetch_array($products)) {
        echo thumbnail($row['image'], $row['title'], $row['description'], $row['id']);
      }
      
      ?>
    </div>
  </div>

<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>