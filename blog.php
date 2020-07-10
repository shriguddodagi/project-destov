<?php include_once('./includes/header.php') ?>
<?php
  $query = "SELECT * FROM `blogs` ORDER BY id DESC LIMIT 2";
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
      <!--// end row -->
      <?php
          $cnt = 0;
          
          while($row = mysqli_fetch_array($blogs)) {
          
            if($cnt++ % 2 == 0 ){
              echo "<div class='row margin-b-40'>
                <div class='col-sm-7 sm-margin-b-50'>
                  <div class='margin-b-30'>
                    <h3>". $row['title'] ."</h3>
                  </div>
                  <p>". $row['description'] ."</p>
                </div>
                <div class='col-sm-4 col-sm-offset-1'>
                  <img class='img-responsive' src='". $row['image'] ."' alt='". $row['title'] ."'>
                </div>
              </div>";
            } else {
              echo "<div class='row margin-b-40'>
                <div class='col-sm-4'>
                  <img class='img-responsive' src='". $row['image'] ."' alt='". $row['title'] ."'>
                </div>
                <div class='col-sm-7 col-sm-offset-1 sm-margin-b-50'>
                  <div class='margin-b-30'>
                    <h3>". $row['title'] ."</h3>
                  </div>
                  <p>". $row['description'] ."</p>
                </div>
              </div>";
            }
            
          }
      ?>
     
      
      <!--// end row -->
    </div>



<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>