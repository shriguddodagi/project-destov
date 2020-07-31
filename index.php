<?php 
include_once('./includes/header.php');
include_once('./includes/util.php');
include_once('./FormSanitizer.php');
include_once('./includes/productUtil.php');


if(isset($_POST['submit'])) {
  mysqli_query($cn, sanitizeInquiryForm($_POST));
  unset($_POST);  
  header('Location: index.php');
}

$query = "SELECT * FROM `slides` ORDER BY id DESC";
$slides = mysqli_query($cn, $query);

$query = "SELECT id, title, description, image FROM `products` WHERE display_on_home='on' ORDER BY position ASC LIMIT 5";
$products = mysqli_query($cn, $query);

$query = "SELECT `name`, `message` FROM `feedbacks` WHERE `status`='1'";
$feedbacks = mysqli_query($cn, $query);
?>

<style>
@-webkit-keyframes zoom {
  from {
    -webkit-transform: scale(1, 1);
  }
  to {
    -webkit-transform: scale(1.5, 1.5);
  }
}

@keyframes zoom {
  from {
    transform: scale(1, 1);
  }
  to {
    transform: scale(1.5, 1.5);
  }
}

/* .carousel-inner .item video {
  -webkit-animation: zoom 20s;
  animation: zoom 20s;
} */
</style>

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
        "<img src='". $row['file'] ."' data-color='red' class='img-responsive' alt='".$row['title']."'>"
        :
        "<video src='". $row['file'] ."' class='img-responsive full-screen' alt='".$row['title']."'></video>";

        $play = ($row['type'] == "video") ? "<h1 class='carousel-title text-center video' src='". $row['file'] ."' style='cursor: pointer' data-toggle='modal' data-target='#video'><i class='fa fa-lg fa-play'></i></h1>" : "";

        $slide .= "<div class='container'>
            <div class='carousel-centered'>
              <div class='margin-b-40'>
                <h1 class='carousel-title'>". $row['title'] ."</h1>
                <p style='color:white; font-size: 20px'>". $row['description'] ."</p>
                </div>
                <a href='product.php'
                class='btn-theme margin-b-20 btn-theme-sm btn-white-brd text-uppercase'>Explore</a>
                $play
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
                <div class="margin-b-10">
                Destov International is based in Mumbai with its wings spread across India. We are Exporters of Fruits and
                Vegetables, taking a prestige to deliver Quality over Quantity. We deal in pomegranates, mangoes, bananas,
                onions, potatoes, garlic, and so on.
                </div>
                <div class="margin-b-10">
                We are strategically located in Mumbai, which facilitates International Trade through its largest port of
                Nhava Sheva. Proximity to different locations like Nashik, Pune, Ratnagiri, Solapur, Nagpur which are part
                of the Maharashtra State, the agricultural hub of India, helps us to procure products with ease.
                </div>
                <div class="">
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
      <img class="img-responsive" src="./img/1920x1080/aboutuscover.png" alt="Content Image">
    </div>
  </div>

  <?php if($feedbacks->num_rows > 0) { ?>
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
  <?php } ?>
  
  <div class="bg-color-sky-light overflow-h">
    <div class="content-lg container">
      <div class="row margin-b-40">
        <div class="col-sm-6">
          <h2>Our Product Range</h2>
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
            <a href='products.php'>
              <img class='full-width img-responsive' style='relative' src='img/1920x1080/EXPLORE US.jpg' alt='Portfolio Image'>
              <h3 class='color-white margin-b-5' style='position: absolute; left: 5px; bottom: 20px; font-size: 60px;'>Show All</h3>
              <p class='color-white margin-b-0' style='position: absolute; left: 5px; bottom: 1px; font-size: 25px;'>Explore Our All Products</p>
            </a>
          </div>
        </div>";

        ?>    
      </div>
    </div>
  </div>

  <?php include_once('./includes/certificates.php'); ?>

  <div class="bg-color-sky-light content container-fluid">
  <div class="row">
    <div class="col-md-12 text-center text-uppercase">
      <h2>we'd love to hear from you</h2>
    </div>
    <div class="col-md-12 text-center">
      Whether it's a silly doubt or a major concern, we are here to answer all your questions.
    </div>
    <div class="col-md-12 text-center margin-b-40">
      Feel free to reach out to us.
    </div>
    <div class="col-md-12 text-center">
      <a href="contact.php" 
        class="btn" 
        style="padding: 10px 20px; background: #000; font-weight: 500; color: #fff; border-radius: 5px;">
        GET IN TOUCH</a>
    </div>
  </div>
</div>


<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center">Inquiry Now</h3>
      </div>
      <div class="modal-body">
      <p class="text-center" style="color: #000">
        I'm intrested in <strong class="product-name">Title</strong>. Kindly send us the details.
      </p>
      <form id="form" action="" method="POST">
        <input type="hidden" id="productTitle" name="productTitle">
        <input name="name" id="name" type="text" class="form-control footer-input margin-b-20" placeholder="Name" required pattern="^\w+(\s+\w+)*$">
        <input name="position" id="position" type="text" class="form-control footer-input margin-b-20" placeholder="Position (optional)" pattern="^\w+(\s+\w+)*$">
        <input name="company" id="company" type="text" class="form-control footer-input margin-b-20" placeholder="Company Name  (optional)" pattern="^\w+(\s+\w+)*$">
        <input name="destinationPort" id="destinationPort" type="text" class="form-control footer-input margin-b-20" placeholder="Nearest Port of Destination (optional)" pattern="^\w+(\s+\w+)*$">
        <input name="email" id="email" type="email" class="form-control footer-input margin-b-20" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
        <input name="phone" id="phone" type="text" class="form-control footer-input margin-b-20" placeholder="Phone" required pattern="[0-9]{6,}">
        <textarea name="message" id="message" class="form-control footer-input margin-b-30" rows="6" placeholder="Message" required pattern="^\w+(\s+\w+)*$"></textarea>
        <button name="submit" id="submit" type="submit" class="btn-theme btn-block btn-theme-sm btn-base-bg text-center text-uppercase">Submit</button>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="video" tabindex="-1" aria-labelledby="video" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <video id="video-slider" style='width:100%' autoplay controls></video>
      </div>
    </div>
  </div>
</div>
  
<?php include_once('./includes/scripts.php') ?>
<script>
  $(document).ready(function () {
    $(document).on('click', '.inquiry-btn', function () {
      let name = $(this).attr('id');
      $('#form').find('#productTitle').val(name);
      $('#modal').find('.product-name').text(name);
    });
    $(document).on('click', '.video', function () {
      $('#video-slider').attr('src', $(this).attr('src'));
    });
    $('#video').on('hidden.bs.modal', function (e) {
      // do something...
      $(this).find('video').attr('src', null);
    })
  });
</script>
<?php include_once('./includes/footer.php') ?>