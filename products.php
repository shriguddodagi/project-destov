<?php 
include_once('./includes/header.php');
include_once('./includes/productUtil.php');
include_once('./includes/classes/Product.php');

// Pagination
$page_no = 1;
$total_records_per_page = 3;

if(isset($_GET['page_no']) && $_GET['page_no'] != "") {
  $page_no = $_GET['page_no'];
}

$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$total_records = mysqli_fetch_array(mysqli_query($cn, "SELECT COUNT(*) AS total_records FROM `products`"))['total_records'];

$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1; // total pages minus 1

$products = mysqli_query($cn, "SELECT id, title, image, description FROM `products` LIMIT $offset, $total_records_per_page");

if(isset($_GET['category']) && $_GET['category'] != "") {
  $category_id = $_GET['category'];
  $products = mysqli_query($cn, "SELECT id, title, image, description FROM `products` WHERE subcategory_id=$category_id");
}

if(isset($_GET['calender']) && $_GET['calender'] != "") {
  $month_name = $_GET['calender'];
  $query = 
  "SELECT 
      products.id AS `id`,
      products.title AS `title`,
      products.image AS `image`
    FROM products 
    CROSS JOIN calender  
    ON products.id = calender.product_id 
    WHERE calender.$month_name = 'Peak' OR calender.$month_name = 'Lean'";
    
  $products = mysqli_query($cn, $query);
}

if(isset($_GET['term']) && isset($_GET['search'])) {
  $term = $_GET['term'];
  $search = mysqli_query($cn, "SELECT * FROM `products` WHERE title LIKE '$term%'");
  unset($_GET['search']);
}

$categories = mysqli_query($cn, "SELECT * FROM categories");
$months = mysqli_query($cn, "SELECT * FROM months");
?>

  <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/our products.jpg">
    <div class="parallax-content container">
      <h1 class="carousel-title">Products</h1>
    </div>
  </div> 

<style>
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}
</style>

  <div class="content container">
    <div class="row">
      

        <div class="col-md-4 margin-b-10 col-xs-4 text-left">

          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">All Category <span class="caret"></span></button>
            <ul class="dropdown-menu">

              <?php
              
              $cat = "";
              while($category = mysqli_fetch_array($categories)) {

                $subcategories = mysqli_query($cn, "SELECT * FROM subcategories WHERE category_id=" . $category['id']);
                
                echo  "
                  <li class='dropdown-submenu'>
                    <a class='test' tabindex='-1' href='#'>". $category['name'] ." <span class='caret'></span></a>
                    <ul class='dropdown-menu'>";
                     
                  while ($subcategory = mysqli_fetch_array($subcategories)) {
                    echo "<li><a tabindex='-1' href='products.php?category=". $subcategory['id'] ."'>". $subcategory['name'] ."</a></li>";
                  }
                    echo "</ul>
                  </li>";

                // $cat .= "<li class='dropdown-submenu'>
                //   <a tabindex='-1' href='#'>". $category['name'] ." <span class='caret'></span></a>
                //   <ul class='dropdown-menu'>";


                //   while ($subcategory = mysqli_fetch_array($subcategories)) {
                //     $cat .= "<li><a tabindex='-1' href='#' href='products.php?category=". $subcategory['id'] ."'>". $subcategory['name'] ."</a></li>";
                //   }


                //   $cat .= "</ul>
                // </li>";
              }
              // echo $cat;

              ?>
                <li class="dropdown-submenu">
                  <a class="test" tabindex="-1" href="#">Calender <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    
                    <?php
                    while ($month = mysqli_fetch_array($months)) {
                      echo "<li><a href='products.php?calender=". $month['name'] ."'>". $month['name'] ."</a></li>";
                    }
                    ?>
                  </ul>
                </li>

            </ul>
          </div>

        </div>
        <div class="col-md-3 margin-b-10 col-xs-4 text-right">
          <div id="btnContainer">
              <button id="listview" class="btn"><i class="fa fa-bars"></i></button> 
              <button id="gridview" class="btn active"><i class="fa fa-th-large"></i></button>
            </div>
        </div>
      <form action="" method="get">
        <div class="col-md-4 margin-b-10 col-xs-8 text-right">
          <input name="term" 
            id="term" 
            type="text" 
            value="<?php echo isset($_GET['term'])? $_GET['term'] : '' ?>"
            class="form-control" 
            style="height: 35px;"
            placeholder="Search For products..." 
            required 
            pattern="^\w+(\s+\w+)*$" />
        </div>

        <div class="col-md-1 margin-b-10 col-xs-2">
          <button name="search" id="search" type="submit" class="btn btn-info text-uppercase">Search</button>
        </div>
      </form>
    </div>

    <div class="row">
      <?php
      if(isset($search)) {
        while($row = mysqli_fetch_array($search)) {
          echo thumbnail($row['image'], $row['title'], $row['id']);
        }
      }
      ?>
    </div>
  </div>
  
  <?php if(!isset($_GET['term'])) { ?>

  <div class="content-lg container">
    <div class="row margin-b-40">
      <div class="col-sm-6">
        <h2>
          <?php
          if(isset($_GET['term'])) {
            echo "Related to " . $_GET['term'];
          } else if (isset($_GET['calender'])) {
            echo "Products are available in " . $_GET['calender'];
          } else {
            echo "Our Product Range";
          }
          
          ?>
        </h2>
      </div>
    </div>
    <?php if(!isset($_GET['category']) && !isset($_GET['calender'])) { ?>
    
      <div class="row">
        <div class="text-center margin-b-20">
          <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>
      </div>

    <?php } ?>

    <div class="row">
    <?php
      while($row = mysqli_fetch_array($products)) {
        echo thumbnail($row['image'], $row['title'], $row['id']);
      }
    ?>
    </div>
    
  </div>

  <?php } ?>

  <?php if(!isset($_GET['term']) && !isset($_GET['calender']) && !isset($_GET['category'])) { ?>

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

  <?php } ?>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>


<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });

  var cols = $('.column');
  var items = $('.list-item');

  $('#listview').on('click', function() {
    cols.addClass('col-xs-6');
    items.addClass('col-xs-12').removeClass('col-md-4');
    $(this).addClass('active');
    $('#gridview').removeClass('active');
  });
  $('#gridview').on('click', function() {
    cols.removeClass('col-xs-6');
    items.removeClass('col-xs-12').addClass('col-md-4');
    $(this).addClass('active');
    $('#listview').removeClass('active');
  });

});
</script>

<?php include_once('./includes/footer.php') ?>
