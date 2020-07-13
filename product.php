<?php
include_once('./includes/header.php');
include_once('./includes/classes/PackingDetail.php');

$productId = $_GET['product'];

$query = "SELECT * FROM `months`";
$months = mysqli_query($cn, $query);
$query = "SELECT * FROM `products` WHERE id='$productId'";
$product = mysqli_fetch_array(mysqli_query($cn, $query));

if(!count($product)) {
  header('Location: products.php');
}

$subcategoryId = $product['subcategory_id'];
$categoryId = mysqli_fetch_array(mysqli_query($cn, "SELECT category_id FROM `subcategories` WHERE id='$subcategoryId'"))['category_id'];
$terms = mysqli_fetch_array(mysqli_query($cn, "SELECT terms FROM `categories` WHERE id='$categoryId'"))['terms'];

$packingDetailsObj = new PackingDetail($cn, $productId);
?>

<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $product['image'] ?>">
  <div class="parallax-content container">
    <h1 class="carousel-title"><?php echo $product['title'] ?></h1>
    <p><?php echo $product['description'] ?></p>
  </div>
</div>

<div class="bg-color-sky-light" data-auto-height="true">
    <div class="content-lg container">
    <div class="row margin-b-40">
      <div class="col-sm-6">
          <h2>Product Specifications</h2>
      </div>
    </div>
        <div class="row row-space-1 margin-b-2">
            <div class="col-sm-4 sm-margin-b-2">
                <div class="wow fadeInLeft animated" data-wow-duration=".3" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">
                    <div class="service" data-height="height" style="height: 171px;">
                        <h3>Varieties</h3>
                        <p class="margin-b-5"><?php echo $product['varieties'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="wow fadeInLeft animated" data-wow-duration=".3" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInLeft;">
                    <div class="service" data-height="height" style="height: 171px;">
                        <h3>Colour</h3>
                        <p class="margin-b-5"><?php echo $product['color'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="wow fadeInLeft animated" data-wow-duration=".3" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">
                    <div class="service" data-height="height" style="height: 171px;">
                        <h3>Weights</h3>
                        <p class="margin-b-5"><?php echo $product['weight'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-space-1 margin-b-2">
            <div class="col-sm-4 sm-margin-b-2">
                <div class="wow fadeInLeft animated" data-wow-duration=".3" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">
                    <div class="service" data-height="height" style="height: 171px;">
                        <h3>Sizes</h3>
                        <p class="margin-b-5"><?php echo $product['size'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
              <div class="wow fadeInLeft animated" data-wow-duration=".3" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">
                  <div class="service" data-height="height" style="height: 171px;">
                      <h3>Container Preferred Capacity</h3>
                      <p class="margin-b-5"><?php echo $product['containercapacity'] ?></p> 
                  </div>
              </div>
          </div>
          <div class="col-sm-4">
              <div class="wow fadeInLeft animated" data-wow-duration=".3" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">
                  <div class="service" data-height="height" style="height: 171px;">
                      <h3>INCOTERMS</h3>
                      <p class="margin-b-5"><?php echo $product['incoterms'] ?></p> 
                  </div>
              </div>
          </div>
        </div>

        <div class="row row-space-1">
          <div class="col-sm-4 sm-margin-b-2">
              <div class="wow fadeInLeft animated" data-wow-duration=".3" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                  <div class="service" data-height="height" style="height: 171px;">
                      <h3>Total Soluble Solids (T.S.S.)</h3>
                      <p class="margin-b-5"><?php echo $product['tss'] ?></p>
                  </div>
              </div>
          </div>
         
        </div>
    </div>
</div>

<div class="bg-color-sky-light">
  <div class="content-lg container">
      <div class="row">
          <div class="col-md-5 col-sm-5 md-margin-b-60">
              <div class="margin-t-50 margin-b-30">
                  <h2>Calender</h2>
                  <div class="row">

                    <?php
                    $calender = $product['calender'];
                    while($row = mysqli_fetch_array($months)) {
                      if(strpos($calender, $row['id']) === false)
                        echo "<div class='col-md-3 margin-b-5 margin-r-5 margin-l-5 text-center calender calender-off'>". $row['name'] ."</div>";
                      else 
                        echo "<div class='col-md-3 margin-b-5 margin-r-5 margin-l-5 text-center calender calender-on'>". $row['name'] ."</div>";
                    }
                    ?>
                    
                  </div>
              </div>
              <a href="contact.php" class="btn-theme btn-theme-sm btn-white-bg text-uppercase">Contact US</a>
          </div>
          <div class="col-md-5 col-sm-7 col-md-offset-2">
         
              <div class="accordion">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingOne">
                              <h4 class="panel-title">
                                  <a class="panel-title-child" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Payment Terms
                                  </a>
                              </h4>
                          </div>
                          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
                              <div class="panel-body"><?php echo $product['paymenterms'] ?></div>
                          </div>
                      </div>    
                      <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingTwo">
                              <h4 class="panel-title">
                                  <a class="panel-title-child collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Certifications</a>
                              </h4>
                          </div>
                          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                              <div class="panel-body"><?php echo $product['certifications'] ?></div>
                          </div>
                      </div>
                      <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingThree">
                              <h4 class="panel-title">
                                  <a class="panel-title-child collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Terms & Conditions
                                  </a>
                              </h4>
                          </div>
                          <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                              <div class="panel-body"><?php echo $terms ?></div>
                          </div>
                      </div>
                  </div>
              </div>
         
          </div>
    </div>  
  </div>
</div>

<div class="content container">
  <div class="row margin-b-10">
    <div class="col-sm-6">
      <h2>Packing Specifications</h2>
    </div>
  </div>
  <div class="table-responsive">    
    <table class="table">
      <thead>
        <tr>
        <th scope='col'>Country</th>
        <th scope='col'>Packing Specs</th>
        <th scope='col'>Net Wt Per Box/Beg</th>
        <th scope='col'>Gross Wt Per Box/Beg</th>
        <th scope='col'>No. of Boxes</th>
        <th scope='col'>Container Type</th>
        <th scope='col'>Container Loadability</th>
        <th scope='col'>Other Details</th>
        </tr>
      </thead>
      <tbody>

      <?php

      foreach($packingDetailsObj->packingDetails() as $row) {

       echo "<tr>
          <th scope='row'>". $row['country'] ."</th>
          <td>". $row['specs'] ."</td>
          <td>". $row['net_wt'] ."</td>
          <td>". $row['gross_wt'] ."</td>
          <td>". $row['boxes'] ."</td>
          <td>". $row['container_type'] ."</td>
          <td>". $row['container_loadability'] ."</td>
          <td>". $row['other_details'] ."</td>
        </tr>";

      }
      
      ?>

        
      </tbody>
    </table>
  </div>

</div>







<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>