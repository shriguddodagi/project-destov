<?php 
include_once('./includes/header.php');

$query = "SELECT id, title, description, image FROM `products` ORDER BY id DESC";
$products = mysqli_query($cn, $query);

?>

  <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/01.jpg">
    <div class="parallax-content container">
      <h1 class="carousel-title">Products</h1>
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

        echo "<div class='col-sm-4 sm-margin-b-50'>
          <div class='margin-b-20'>
            <div class='wow zoomIn' data-wow-duration='.3' data-wow-delay='.1s'>
              <img class='img-responsive' src='". $row['image'] ."' alt='". $row['title'] ."'>
            </div>
          </div>
          <h4><a
              href='product.php?product=". $row['id'] ."'>". $row['title'] ."</a></h4>
          <p>". $row['description'] ."</p>
          <a class='link'
            href='product.php?product=". $row['id'] ."'>Read
            More</a>
        </div>";
      
      }
      
      ?>
    </div>
  </div>

<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>