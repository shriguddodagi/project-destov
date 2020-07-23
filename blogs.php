<?php include_once('./includes/header.php') ?>
<?php
  $query = "SELECT * FROM `blogs` ORDER BY id DESC";
  $blogs = mysqli_query($cn, $query);
?>
  <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/05.jpg">
    <div class="parallax-content container">
      <h1 class="carousel-title">Blogs</h1>
    </div>
  </div>

    <div class="content-lg container">
      <div class="row margin-b-20">
        <div class="col-sm-6">
          <h1>Blogs</h1>
        </div>
      </div>
    </div>
     
      
     
    <div class="content-lg container">
      <div class="masonry-grid row" style="position: relative; height: 1106.08px;">
        <div class="masonry-grid-sizer col-xs-6 col-sm-6 col-md-1"></div>
        <?php
        $cnt = 0;
        
        while($row = mysqli_fetch_array($blogs)) {
          if($cnt++ % 2 == 0 ){
            echo "<div style='padding: 10px; box-sizing: border-box;' class='masonry-grid-item col-xs-12 col-sm-6 col-md-4 sm-margin-b-30' style='position: absolute; left: 0%; top: 0px;'>
              <div class='margin-b-10'>
                <h2>". $row['title'] ."</h2>
                <p><i class='fa fa-lg fa-calendar' style='color: #17bed2;'></i> &nbsp". date('jS F, Y', strtotime($row['created_at'])) ."</p>
                <a class='link' href='blog.php?blog=". $row['id'] ."'>Read More</a>
              </div>
              <img class='full-width img-responsive wow fadeInUp animated' src='". $row['image'] ."' alt='". $row['title'] ."' data-wow-duration='.3' data-wow-delay='.2s' style='visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;'>
            </div>";
          } else {
            echo "<div style='padding: 10px; box-sizing: border-box;' class='masonry-grid-item col-xs-12 col-sm-6 col-md-4' style='position: absolute; left: 50%; top: 0px;'>
              <div class='margin-b-10'>
                <img class='full-width img-responsive wow fadeInUp animated' src='".  $row['image'] ."' alt='".  $row['title'] ."' data-wow-duration='.3' data-wow-delay='.3s' style='visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;'>
              </div>
              <h2>".  $row['title'] ."</h2>
              <p><i class='fa fa-lg fa-calendar' style='color: #17bed2;'></i> &nbsp". date('jS F, Y', strtotime($row['created_at'])) ."</p>
              <a class='link' href='blog.php?blog=". $row['id'] ."'>Read More</a>
            </div>";
          } 
        }
        ?>
        
      
      </div>
    </div>
    
    



<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>