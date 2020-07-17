<?php 
include_once('./includes/header.php');
include_once('./includes/util.php');
include_once('./FormSanitizer.php');
include_once('./includes/productUtil.php');

$query = "SELECT * FROM `slides` ORDER BY id DESC";
$slides = mysqli_query($cn, $query);

$query = "SELECT id, title, description, image FROM `products` WHERE display_on_home='on' ORDER BY position ASC LIMIT 8";
$products = mysqli_query($cn, $query);

$query = "SELECT `name`, `message` FROM `feedbacks`";
$feedbacks = mysqli_query($cn, $query);

?>

  <div id="carousel-example-generic" class="carousel slide margin-b-40" data-ride="carousel">
    <div class="container">
      <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <?php
        $cnt = 0;
        while($cnt++ < $slides->num_rows-1) {
          echo "<li data-target='#carousel-example-generic' data-slide-to='$cnt'></li>";
        }        
        ?>
      </ol>
    </div>
    <div class="carousel-inner" role="listbox">
      <?php 
      while ($row = mysqli_fetch_array($slides)) {
      
        $slide = "<div class='item'>";

        $slide .= ($row['type'] == "image") ? 
        "<img src='". $row['file'] ."' class='img-responsive' alt='".$row['title']."'>"
        :
        "<video src='". $row['file'] ."' class='img-responsive' alt='".$row['title']."' autoplay controls></video>";

        $slide .= "<div class='container'>
            <div class='carousel-centered'>
              <div class='margin-b-40'>
                <h1 class='carousel-title'>". $row['title'] ."</h1>
                <p style='color:white; font-size: 20px'>". $row['description'] ."</p>
              </div>
              <a href='product.php'
                class='btn-theme btn-theme-sm btn-white-brd text-uppercase'>Explore</a>
            </div>
          </div>
        </div>";
        echo $slide;
      }
      ?>
    </div>
  </div>

  <div class="promo-section bg-color-sky-light overflow-h">
    <div class="container">
      <div class="clearfix">
        <div class="ver-center">
          <div class="ver-center-aligned">
            <div class="promo-section-col">
              <h2>About US</h2>
              <blockquote class="blockquote">
                <div class="margin-b-20">
                Destov International is based in Mumbai with its wings spread across India. We are Exporters of Fruits and
                Vegetables, taking a prestige to deliver Quality over Quantity. We deal in pomegranates, mangoes, bananas,
                onions, potatoes, garlic, and so on.
                </div>
                <!-- <div class="margin-b-20">
                We are strategically located in Mumbai, which facilitates International Trade through its largest port of
                Nhava Sheva. Proximity to different locations like Nashik, Pune, Ratnagiri, Solapur, Nagpur which are part
                of the Maharashtra State, the agricultural hub of India, helps us to procure products with ease.
                </div> -->
                <div class="margin-b-20">
                  <a href="about.php"
                  class="btn-theme btn-theme-sm btn-black-brd text-uppercase">Know More</a>
                </div>
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="promo-section-img-right">
      <img class="img-responsive" src="./img/1920x1080/01.jpg" alt="Content Image">
    </div>
  </div>

  <div class="content-lg container">
    <div class="row">
      <div class="col-sm-9">
        <h2>Customer Reviews</h2>

        <div class="swiper-slider swiper-testimonials swiper-container-horizontal">
          
          <div class="swiper-wrapper" style="transform: translate3d(-1372px, 0px, 0px); transition-duration: 0ms;"><div class="swiper-slide swiper-slide-duplicate" data-swiper-slide-index="1" style="width: 686px;">
            <blockquote class="blockquote">
              <div class="margin-b-20"></div>
              <div class="margin-b-20"></div>
              <p><span class="fweight-700 color-link"></span></p>
            </blockquote>
          </div>

        <?php
        while ($row = mysqli_fetch_array($feedbacks)) {
          echo "<div class='swiper-slide swiper-slide-prev' data-swiper-slide-index='0' style='width: 686px;'>
            <blockquote class='blockquote'>
              <div class='margin-b-20'>
                ". $row['message'] ."
              </div>
              <p><span class='fweight-700 color-link'>". $row['name'] ."</span></p>
            </blockquote>
          </div>";
        }

          
         

        ?>

          <div class="swiper-slide swiper-slide-duplicate swiper-slide-next" data-swiper-slide-index="2" style="width: 686px;">
            <blockquote class="blockquote">
              <div class="margin-b-20"></div>
              <div class="margin-b-20"></div>
              <p><span class="fweight-700 color-link"></span></p>
            </blockquote>
          </div>
        </div>
      
        <div class="swiper-testimonials-pagination"></div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="bg-color-sky-light overflow-h">
    <div class="content-lg container">
      <div class="row margin-b-40">
        <div class="col-sm-6">
          <h2>Products</h2>
        </div>
      </div>
      

      <div class="masonry-grid">
        <div class="masonry-grid-sizer col-xs-6 col-sm-6 col-md-1"></div>
     
        <?php

        $cnt = 0;

        while($row = mysqli_fetch_array($products)) {

          if($cnt === 0) {
            echo forCol6($row['image'], $row['title'], $row['description'], $row['id']);
          } elseif ($cnt === 1) {
            echo forCol12($row['image'], $row['title'], $row['description'], $row['id']);
          } elseif ($cnt === 2) {
            echo forCol6($row['image'], $row['title'], $row['description'], $row['id']);
          } elseif ($cnt === 3) {
            echo forCol12($row['image'], $row['title'], $row['description'], $row['id']);
          } elseif ($cnt === 4) {
            echo forCol6($row['image'], $row['title'], $row['description'], $row['id']);
          } elseif ($cnt === 5) {
            echo forCol6($row['image'], $row['title'], $row['description'], $row['id']);
          } elseif ($cnt === 6) {
            echo forCol6($row['image'], $row['title'], $row['description'], $row['id']);
          } elseif ($cnt === 7) {
            echo forCol6($row['image'], $row['title'], $row['description'], $row['id']);
          }
          $cnt++;
        }
        echo "<div class='masonry-grid-item col-xs-6 col-sm-6 col-md-4'>             
          <div class='work wow fadeInUp' data-wow-duration='.3' data-wow-delay='.4s'>
            <div class='work-overlay'>
              <img class='full-width img-responsive' src='img/970x647/01.jpg' alt='Portfolio Image'>
            </div>
            <div class='work-content'>
              <h3 class='color-white margin-b-5'>Show All</h3>
              <p class='color-white margin-b-0'>Explore Our All Products</p>
            </div>
            <a class='content-wrapper-link'
              href='products.php'></a>
          </div>
        </div>";

        ?>
       
      
      
      
      
      </div>
    </div>
  </div>

  <div data-auto-height="true">
    <div class="content-lg container">
      <h2 class="text-center text-uppercase">We are proud members of</h2>
      <div class="row row-space-1 margin-b-10">
        <div style="padding: 30px 60px; box-sizing: border-box" class="col-md-3">
          <div class="wow text-center fadeInLeft" data-wow-duration=".3" data-wow-delay=".3s">
              <img class="img-responsive" style="width: 100%; height: auto;" src="./img/certificates/03.png" alt="">
          </div>
        </div>
        <div style="padding: 30px 60px; box-sizing: border-box" class="col-md-3">
          <div class="wow text-center fadeInLeft" data-wow-duration=".3" data-wow-delay=".2s">
              <img class="img-responsive" style="width: 100%; height: auto;" src="./img/certificates/01.png" alt="">
          </div>
        </div>
        <div style="padding: 30px 60px; box-sizing: border-box" class="col-md-3">
          <div class="wow text-center fadeInLeft" data-wow-duration=".3" data-wow-delay=".1s">
              <img class="img-responsive" style="width: 100%; height: auto;" src="./img/certificates/06.png" alt="">
          </div>
        </div>
        <div style="padding: 30px 60px; box-sizing: border-box" class="col-md-3">
          <div class="wow text-center fadeInLeft" data-wow-duration=".3" data-wow-delay=".3s">
              <img class="img-responsive" style="width: 100%; height: auto;" src="./img/certificates/05.png" alt="">
          </div>
        </div>
      </div>
      <div class="row row-space-1 margin-b-10">
        <div class="col-md-6">
          <h2 class="text-center text-uppercase" style="padding: 10px">Our associations</h2>
          <div class="row row-space-1 margin-b-2">
            <div class="col-md-6" style="padding: 30px 60px; box-sizing: border-box">
              <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".2s">
                <img class="img-responsive" src="./img/certificates/07.png" alt="">
              </div>
            </div>
            <div class="col-md-6" style="padding: 30px 60px; box-sizing: border-box">
              <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".2s">
                <img class="img-responsive" src="./img/certificates/04.png" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <h2 class="text-center text-uppercase" style="padding: 10px">Our banking partner</h2>
          <div class="row row-space-1 margin-b-2">
            <div class="col-md-12" style="padding: 30px 60px; box-sizing: border-box">
              <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".1s">
                <img class="img-responsive" src="./img/certificates/02.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-color-sky-light content container-fluid">
  <div class="row">
  <div class="col-md-12 text-center">
    <a href="contact.php" class="btn" style="padding: 15px; background: #000; font-weight: 500; color: #fff; border-radius: 5px;">GET IN TOUCH</a>
  </div>
  </div>
  </div>


  
<?php include_once('./includes/scripts.php') ?>
<?php include_once('./includes/footer.php') ?>