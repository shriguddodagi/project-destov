<?php
function forCol6 ($image, $title, $description, $id) {
  return " 
    <div class='masonry-grid-item col-xs-6 col-sm-6 col-md-4'>
  
      <div class='work wow fadeInUp' data-wow-duration='.3' data-wow-delay='.2s'>
        <div class='work-overlay'>
          <img class='full-width img-responsive' src='". $image ."' alt='". $title ."'>
        </div>
        <div class='work-content'>
          <h3 class='color-white margin-b-5'>". $title ."</h3>
          <p class='color-white margin-b-0'>". $description ."</p>
        </div>
        <a class='content-wrapper-link'
          href='product.php?product=". $id ."'></a>
      </div>
      
    </div>";
};

function forCol12 ($image, $title, $description, $id) {
  return " 
  <div class='masonry-grid-item col-xs-12 col-sm-6 col-md-8'>

    <div class='work wow fadeInUp' data-wow-duration='.3' data-wow-delay='.1s'>
      <div class='work-overlay'>
        <img class='full-width img-responsive' src='". $image ."' alt='". $title ."'>
      </div>
      <div class='work-content'>
        <h3 class='color-white margin-b-5'>". $title ."</h3>
        <p class='color-white margin-b-0'>". $description ."</p>
      </div>
      <a class='content-wrapper-link'
      href='product.php?product=". $id ."'></a>
    </div>

  </div>";
};

function thumbnail ($image, $title, $description, $id) {
  return "<div class='col-sm-4 sm-margin-b-50 margin-b-30'>
    <div class='margin-b-20'>
      <div class='wow zoomIn' data-wow-duration='.3' data-wow-delay='.1s'>
        <img class='img-responsive' src='". $image ."' alt='". $title ."'>
      </div>
    </div>
    <h3><a href='product.php?product=". $id ."'>". $title ."</a></h3>
    <p class='h5'>". $description ."</p>
    <a class='link' href='product.php?product=". $id ."'>Read More</a>
  </div>";
}

