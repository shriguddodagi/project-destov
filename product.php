<?php
include_once('./includes/header.php');
include_once('./FormSanitizer.php');
include_once('./includes/classes/PackingDetail.php');
include_once('./includes/classes/Gallery.php');
include_once('./includes/util.php');
include_once('./includes/productUtil.php');

if(isset($_POST['submit'])) {
  mysqli_query($cn, sanitizeInquiryForm($_POST));
  unset($_POST);  
  header('Location: product.php?product=' . $_GET['product']);
}

$productId = $_GET['product'];

$query = "SELECT * FROM `months`";
$months = mysqli_query($cn, $query);
$query = "SELECT * FROM `products` WHERE id='$productId'";
$product = mysqli_fetch_array(mysqli_query($cn, $query));

$related_products = mysqli_query($cn, "SELECT * FROM `products` WHERE subcategory_id=" . $product['subcategory_id'] . " LIMIT 3");

if(!count($product)) {
  header('Location: products.php');
}

$subcategoryId = $product['subcategory_id'];
$categoryId = mysqli_fetch_array(mysqli_query($cn, "SELECT category_id FROM `subcategories` WHERE id='$subcategoryId'"))['category_id'];
$terms = mysqli_fetch_array(mysqli_query($cn, "SELECT terms FROM `categories` WHERE id='$categoryId'"))['terms'];

$packingDetailsObj = new PackingDetail($cn, $productId);
$gallery = new Gallery($cn, $productId);
$calender = mysqli_query($cn, "SELECT * FROM calender WHERE product_id=$productId");
?>

<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $product['image'] ?>">
  <div class="parallax-content container">
    <h1 class="carousel-title"><?php echo $product['title'] ?></h1>
  </div>
</div>

<div class="bg-color-sky-light">
  <div class="content-lg container">
    <div class="row margin-b-10">
      <div class="col-md-12">
        <button data-toggle='modal' data-target='#modal' class="btn-theme btn-theme-sm btn-white-bg text-uppercase">Make An Inquiry</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <h2>Description</h2>
          <p><?php echo $product['description'] ?></p>
        </div>
    </div>
  </div>
</div>

<?php if(count($gallery->imagesArray) > 0) { ?>

<div class="bg-color-light">
  <div class="content-lg container">
    <div class="row">
      <div class="col-md-12">
        <h2>Show Case</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <?php
          foreach($gallery->images() as $file) {

            echo ($file['type'] == "image") ? 
            "<div class='col-md-4 margin-b-30'>
              <img src='". $file['file'] ."' class='full-width img-responsive'>
            </div>"
              :
            "<div class='col-md-4 margin-b-30'>
              <video src='". $file['file'] ."' class='full-width img-responsive' controls></video>
            </div>";
            
          }
          ?>
        </div>  
      </div>
    </div>
  </div>
</div>

<?php } ?>

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

<div class="bg-color-light">
  <div class="content-lg container">
      <div class="row">
          <div class="col-md-5 col-sm-5 md-margin-b-60">
              <div class="margin-t-50 margin-b-20">
                  <h2>Season Calender</h2>
                  <div class="row margin-b-10">

                    <?php
                   
                    $cnt = 0;
                    while($month = mysqli_fetch_array($calender)) {
                      
                      while ($row = mysqli_fetch_array($months)) {
                        
                        if($month[$row['name']] == "Peak") {
                          echo "<div class='col-md-3 margin-b-5 margin-r-5 margin-l-5 text-center calender calender-on'>". $row['name'] ."</div>";
                        } else if ($month[$row['name']] == "Lean") {
                          echo "<div class='col-md-3 margin-b-5 margin-r-5 margin-l-5 text-center calender calender-off'>". $row['name'] ."</div>";
                        } else if ($month[$row['name']] == "N/A") {
                          echo "<div class='col-md-3 margin-b-5 margin-r-5 margin-l-5 text-center calender'>". $row['name'] ."</div>";
                        }

                      }
                    }

                    ?>
                  </div>
                  <div class="row">
                    <div class="col-md-5">
                      <ul style="list-style: none;">
                        <li class="text-center color-white margin-b-5" style="background-color: #17bed2; border-radius: 5px; border: 1px solid #000; font-weight: 600;">Peak Season</li>
                        <li class="text-center color-white margin-b-5" style="background-color: #515769; border-radius: 5px; border: 1px solid #000; font-weight: 600;">Lean Season</li>
                        <li class="text-center color-black margin-b-5" style="background-color: #FFFFFF; border-radius: 5px; border: 1px solid #000; font-weight: 600;">Not Avaliable</li>
                      </ul>
                    </div>
                  </div>
              </div>
              <button data-toggle='modal' data-target='#modal' class="btn-theme btn-theme-sm btn-white-bg text-uppercase">Make An Inquiry</button>
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
                            <div style="color: #a0a0a0;" class="panel-body"><?php echo $product['paymenterms'] ?></div>
                        </div>
                    </div>    
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="panel-title-child collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Certifications</a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                            <div style="color: #a0a0a0;" class="panel-body"><?php echo $product['certifications'] ?></div>
                        </div>
                    </div>           
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="panel-title-child collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                INCOTERMS
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                            <div style="color: #a0a0a0;" class="panel-body"><?php echo $product['incoterms'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
         
          </div>
    </div>  
  </div>
</div>

<div class="bg-color-sky-light">
  <div class="content-lg container">
    <div class="row margin-b-10">
      <div class="col-sm-6">
        <h2>Packing Specifications</h2>
      </div>
    </div>
    <div class="table-responsive margin-b-50">    
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
    <div class="row margin-b-10">
      <div class="col-md-12">
        <h3>Container Preferred Capacity</h3>
      </div>
      <div class="col-md-12">
        <p class="margin-b-5"><?php echo $product['containercapacity'] ?></p> 
      </div>
    </div>
  </div>
</div>

<div class="bg-color-light">
  <div class="content-lg container">
    <div class="col-md-12">
      <h2>Terms & Conditions</h2>
    </div>
    <div class="col-md-12">
      <p><?php echo $terms ?></p>
    </div>
  </div>
</div>

<?php if($related_products->num_rows > 0) { ?>

<div class="bg-color-sky-light">
  <div class="content-lg container">
    <div class="row margin-b-40">
      <div class="col-md-12">
        <h2>Related Product</h2>
      </div>
    </div>
    <div class="row">
      <?php
      while($row = mysqli_fetch_array($related_products)) {
        echo thumbnail($row['image'], $row['title'], $row['description'], $row['id']);
      }
      ?>
    </div>
  </div>
</div>

<?php } ?>

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-center">Inquiry Now</h3>
      </div>
      <div class="modal-body">
      <p class="text-center" style="color: #000">
        I'm intrested in <strong><?php echo $product['title']; ?></strong>. Kindly send us the details.
      </p>
      <form action="" method="POST">
        <input type="hidden" name="productTitle" value="<?php echo $product['title']; ?>">
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

<?php include_once('./includes/scripts.php'); ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php'); ?>