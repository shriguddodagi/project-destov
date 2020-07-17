<?php 
include_once('./includes/header.php');
include_once('./includes/productUtil.php');
include_once('./includes/classes/Product.php');

$query = "SELECT id, title, description, image FROM `products` ORDER BY id DESC";
$products = mysqli_query($cn, $query);

if(isset($_GET['term']) && isset($_GET['search'])) {
  $term = $_GET['term'];
  $search = mysqli_query($cn, "SELECT * FROM `products` WHERE title LIKE '$term%'");
  unset($_GET['search']);
}

$subcategories = mysqli_query($cn, "SELECT * FROM subcategories");

?>

  <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/01.jpg">
    <div class="parallax-content container">
      <h1 class="carousel-title">Products</h1>
    </div>
  </div>

  <div class="content-lg container">
    <div class="row margin-b-10 text-center">
      <form action="" method="get">
        <div class="col-md-10">
          <input name="term" 
            id="term" 
            type="text" 
            value="<?php echo isset($_GET['term'])? $_GET['term'] : '' ?>"
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
      if(isset($search)) {
        while($row = mysqli_fetch_array($search)) {
          echo thumbnail($row['image'], $row['title'], $row['description'], $row['id']);
        }
      }
      ?>
    </div>
  </div>
  <style>
  .accordion [aria-expanded="true"],
  .accordion .collapse.in {
    color: #000000;
    background: #fafafa;
  }
</style>
  <div class="content-lg container">
    <div class="row margin-b-40">
      <div class="col-sm-6">
        <h2>Our Exceptional Products</h2>
      </div>
    </div>
    
    <div class="accordion">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      
      <?php
        while($row = mysqli_fetch_array($subcategories)) {

          $productsObj = new Product($cn, $row['id']);

          $panel = "<div class='panel panel-default'>
            <div class='panel-heading' role='tab' id='". $row['id'] ."'>
              <h4 class='panel-title'>
                <a class='panel-title-child collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#". $row['name'] . "-" . $row['id'] ."' aria-expanded='false' aria-controls='". $row['name'] . "-" . $row['id'] ."'>
                ". $row['name'] ."
                </a>
              </h4>
            </div>
            <div id='". $row['name'] . "-" . $row['id'] ."' class='panel-collapse collapse' role='tabpanel' aria-labelledby='". $row['id'] ."' aria-expanded='false' style='height: 0px;'>
              <div class='panel-body'> 
              
                <div class='row margin-b-50'>";
              
                  foreach($productsObj->products() as $row) {
                    $panel .= thumbnail($row['image'], $row['title'], $row['description'], $row['id']);
                  }
              
              $panel .= "</div>

              </div>
            </div>
          </div>";

          echo $panel;
        }
        ?>

      
      </div>
    </div>

    
  </div>

 




<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>