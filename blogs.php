<?php include_once('./includes/header.php');


  // Pagination
  $page_no = 1;
  $total_records_per_page = 3;

  if(isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
  }

  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $total_records = mysqli_fetch_array(mysqli_query($cn, "SELECT COUNT(*) AS total_records FROM `blogs`"))['total_records'];

  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1; // total pages minus 1

  $blogs = mysqli_query($cn, "SELECT * FROM `blogs` LIMIT $offset, $total_records_per_page");

?>
  <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/blog.jpg">
    <div class="parallax-content container">
      <h1 class="carousel-title">Blogs</h1>
    </div>
  </div>

  
  
    <div class="content-lg container">
      <div class="row">
        <div class="text-center margin-b-20">
          <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>
      </div>
      <div class="masonry-grid row" style="position: relative; height: 1106.08px;">
        <div class="masonry-grid-sizer col-xs-6 col-sm-6 col-md-1"></div>
        <?php
        $cnt = 0;
        
        while($row = mysqli_fetch_array($blogs)) {
          
            echo "<div style='padding: 10px; box-sizing: border-box;' class='masonry-grid-item col-xs-12 col-sm-6 col-md-4' style='position: absolute; left: 50%; top: 0px;'>
              <div class='margin-b-10'>
                <img class='full-width img-responsive wow fadeInUp animated' src='".  $row['image'] ."' alt='".  $row['title'] ."' data-wow-duration='.3' data-wow-delay='.3s' style='visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;'>
              </div>
              <h2>".  $row['title'] ."</h2>
              <p><i class='fa fa-lg fa-calendar' style='color: #17bed2;'></i> &nbsp". date('jS F, Y', strtotime($row['created_at'])) ."</p>
              <a class='link' href='blog.php?blog=". $row['id'] ."'>Read More</a>
            </div>";
          
        }
        ?>
        
      
      </div>

      <div class="text-center">
        <ul class="pagination">
          <?php 
          if($page_no > 1){
            echo "<li><a href='?page_no=1'>First Page</a></li>";
          } 
          ?>      
          <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
            <a 
              <?php 
              if($page_no > 1){
                echo "href='?page_no=$previous_page'";
              } 
              ?>>
              Previous
            </a>
          </li>
              
          <li <?php if($page_no >= $total_no_of_pages){
            echo "class='disabled'";
          } ?>>
          <a <?php if($page_no < $total_no_of_pages) {
            echo "href='?page_no=$next_page'";
          } ?>>Next</a>
          </li>
          
          <?php if($page_no < $total_no_of_pages){
          echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
        } ?>
        </ul>
      </div>
    </div>
    
    



<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>