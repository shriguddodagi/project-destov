<?php
include_once('./includes/admin-header.php');
include_once('./config.php');
include_once('./includes/util.php');
include_once('./includes/classes/Category.php');
include_once('./includes/classes/Product.php');
include_once('./includes/classes/PackingDetail.php');

if(isset($_POST['submit'])) {
  $subcategoryId = $_POST['subcategoryIdIncreateProductModal'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $varieties = $_POST['varieties'];
  $color = $_POST['color'];
  $size = $_POST['size'];
  $weight = $_POST['weight'];
  $tss = $_POST['tss'];
  $calender = implode(',', $_POST['calender']);
  // die($calender);
  $containercapacity = $_POST['containercapacity'];
  $incoterms = $_POST['incoterms'];
  $paymenterms = $_POST['paymenterms'];
  $certifications = $_POST['certifications'];
  $image = $_FILES['image'];

  $productId = $_POST['productIdInCreateProductModal'];
  if(isset($productId) && $productId == "") {
    // Insert
    if(validType($image)){
      $imagePath = uploadFile($image);
      $query = "INSERT INTO `products` (
        subcategory_id, title, description, varieties, color, size, weight, tss, calender, containercapacity, incoterms, paymenterms, certifications, image) VALUES (
          '$subcategoryId', '$title', '$description', '$varieties', '$color', '$size', '$weight', '$tss', '$calender', '$containercapacity', '$incoterms', '$paymenterms', '$certifications', '$imagePath');";
        $data = mysqli_query($cn, $query);
      unset($_POST);
      header('Location: admin-products.php');
    } else {
      echo "<script>alert('Wrong Image Type')</script>";
    }
  } else {
    // die('update');
    if($image['error'] > 0) {
      $query = "UPDATE `products` 
      SET 
      title='$title', 
      description='$description', 
      varieties='$varieties',
      color='$color',
      size='$size',
      weight='$weight',
      tss='$tss',
      calender='$calender',
      containercapacity='$containercapacity',
      incoterms='$incoterms',
      paymenterms='$paymenterms',
      certifications='$certifications'
        WHERE id='$productId'";
      mysqli_query($cn, $query);
      mysqli_error($cn);
      unset($_POST);
      header('Location: admin-products.php');
    } else {
      if(validType($image)){
        $query = "SELECT image FROM `products` WHERE id=$productId";
        unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['image']);
        $imagePath = uploadFile($image);
        $query = "UPDATE `products` 
          SET 
          title='$title', 
          description='$description', 
          varieties='$varieties',
          color='$color',
          size='$size',
          weight='$weight',
          tss='$tss',
          calender='$calender',
          containercapacity='$containercapacity',
          incoterms='$incoterms',
          paymenterms='$paymenterms',
          certifications='$certifications',
          image='$imagePath' 
            WHERE id=$productId";
        mysqli_query($cn, $query);
        unset($_POST);
        header('Location: admin-products.php');
      }
    }
  }
  

}

if(isset($_POST['deleteProduct'])) {
  $id = $_POST['productId'];
  $query = "SELECT image FROM `products` WHERE id=$id";
  unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['image']); 
  $query = "DELETE FROM `products` WHERE id=$id";
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-products.php');
}

if(isset($_POST['createPackingSpecification'])) {
  $productId = $_POST['productIdInPackingModal'];
  $county = $_POST['country'];
  $packagingSpecs = $_POST['packagingSpecs'];
  $netWT = $_POST['netWT'];
  $grossWT = $_POST['grossWT'];
  $boxes = $_POST['boxes'];
  $containerType = $_POST['containerType'];
  $containerLoadability = $_POST['containerLoadability'];
  $other = $_POST['other'];

  $query = "INSERT INTO `packing_specifications` 
    (country, specs, net_wt, gross_wt, boxes, container_type, container_loadability, other_details, product_id) VALUES
    ('$county', '$packagingSpecs', '$netWT', '$grossWT', '$boxes', '$containerType', '$containerLoadability', '$other', '$productId')";

  mysqli_query($cn, $query);
  unlink($_POST);
  header('Location: admin-products.php');
}

if(isset($_POST['deletePackingDetail'])) {
  $packingId = $_POST['packingId'];
  $query = "DELETE FROM `packing_specifications` WHERE id=$packingId";
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-products.php');
}


$query = "SELECT * FROM `categories`";
$categories = mysqli_query($cn, $query);
$query = "SELECT * FROM `months`";
$months = mysqli_query($cn, $query);
?>
<script>

</script>
  <main>

    <div class="container">
      <div class="display-1">
        Products
      </div>

      <div class="accordion" id="accordionProducts">


        <?php

        $container = "";

        while($category = mysqli_fetch_array($categories)) {
          $subCatObj = new Subcategory($cn, $category['id']);
        

          $container .=
          "<div class='card border rounded my-3'>
            <div class='card-header' id='heading-'". $category['id'] ." >
              <h2 class='mb-0'>
                <button class='btn text-uppercase font-weight-bold text-primary btn-block text-left' type='button' data-toggle='collapse' data-target='#collapse". $category['id'] ."' aria-expanded='true' aria-controls='collapse". $category['id'] ."'>
                  ". $category['name'] ."
                </button>
              </h2>
            </div>";



            $container .= "<div id='collapse". $category['id'] ."' class='collapse show' aria-labelledby='heading-'". $category['id'] ."  data-parent='#accordionProducts'>
              <div class='card-body'>";
                

              foreach($subCatObj->subcategories() as $subcategory) {
                $productsObj = new Product($cn, $subcategory['id']);
                $subcategoryBlock = "";
                
                $subcategoryBlock .= "<div id='collapseOne' class='collapse show' aria-labelledby='headingOne' data-parent='#accordionSubcategory'>
                  <div class='card-body'>
                    <button class='btn text-center mx-3 btn-sm btn-success' type='button' data-toggle='collapse' data-target='#sub". $subcategory['id'] ."' aria-expanded='false' aria-controls='sub". $subcategory['id'] ."'>
                      ". $subcategory['name'] ."
                    </button>
                    <button class='btn btn-sm btn-outline-secondary create-product float-right' id='". $subcategory['id'] ."'	
                      data-toggle='modal' data-target='#createProductModal'>Add Product</button>	
                    

                    <div class='collapse' id='sub". $subcategory['id'] ."'>
                      <div class='card my-2 card-body'>";

                      foreach($productsObj->products() as $row) {
                        $packingDetailsObj = new PackingDetail($cn, $row['id']);  
                        $productBlock = "";
                        $productBlock .= "<div class='row border rounded p-1 m-1 border-info'>
                          <div class='card mb-3 border-0'>
                            <div class='row g-0'>
                              <div class='col-md-4'>
                                <img src='". $row['image'] ."' class='w-100 img rounded img-fluid h-auto' alt='...'>
                                <div class='d-flex justify-content-between'>
                                  <button class='btn btn-sm m-1 packing-specification btn-outline-primary' data-toggle='modal' data-target='#packingModal' id='". $row['id'] ."'>New Packing Specification</button>
                                  <button class='btn btn-sm m-1 btn-outline-warning edit-product' id='". $row['id'] ."'>Edit</button>
                                  <form action='' method='POST'>
                                    <input type='hidden' name='productId' value='". $row['id'] ."'>
                                    <button class='btn btn-sm m-1 btn-outline-danger' type='submit' name='deleteProduct'>Delete</button>
                                  </form>
                                </div>
                              </div>

                              <div class='col-md-8 details'>
                                <div class='card-body'>
                                  <h5 class='card-title'>". $row['title'] ."</h5>
                                  <p class='card-text description'>". $row['description'] ."</p>
                                  <p class='card-text'>Varieties : <small class='text-muted varieties'>". $row['varieties'] ."</small></p>
                                  <p class='card-text'>Color : <small class='text-muted color'>". $row['color'] ."</small></p>
                                  <p class='card-text'>Size : <small class='text-muted size'>". $row['size'] ."</small></p>
                                  <p class='card-text'>Weight : <small class='text-muted weight'>". $row['weight'] ."</small></p>
                                  <p class='card-text'>TSS : <small class='text-muted tss'>". $row['tss'] ."</small></p>
                                  <p class='card-text'>Calender : <small class='text-muted calender'>". $row['calender'] ."</small></p>
                                  <p class='card-text'>Container Capacity : <small class='text-muted containercapacity'>". $row['containercapacity'] ."</small></p>
                                  <p class='card-text'>INCOTERMS : <small class='text-muted incoterms'>". $row['incoterms'] ."</small></p>
                                  <p class='card-text'>Payment Terms : <small class='text-muted paymenterms'>". $row['paymenterms'] ."</small></p>
                                  <p class='card-text'>Certifications : <small class='text-muted certifications'>". $row['certifications'] ."</small></p>    
                                </div>
                              </div>
                              
                              <div class='col-md-12'>
                                <div class='row g-0'>
                                  <div class='table-responsive'>
                                    <table class='table'>
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
                                          <th scope='col'>Delete</th>
                                        </tr>
                                      </thead>
                                      <tbody>";

                                      foreach($packingDetailsObj->packingDetails() as $row) {

                                        $productBlock .= "<tr>
                                          <th scope='row'>". $row['country'] ."</th>
                                          <td>". $row['specs'] ."</td>
                                          <td>". $row['net_wt'] ."</td>
                                          <td>". $row['gross_wt'] ."</td>
                                          <td>". $row['boxes'] ."</td>
                                          <td>". $row['container_type'] ."</td>
                                          <td>". $row['container_loadability'] ."</td>
                                          <td>". $row['other_details'] ."</td>
                                          <td>
                                            <form method='POST' action=''>
                                              <input type='hidden' name='packingId' id='packingId' value='". $row['id'] ."' >
                                              <button class='btn btn-sm m-1 btn-outline-danger' type='submit' name='deletePackingDetail'>Delete</button>
                                            </form>
                                          </td>
                                        </tr>";

                                      }

                                      $productBlock .= "</tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>


                            </div>
                          </div>
                        </div>";

                        $subcategoryBlock .= $productBlock;
                      }
                      
                      $subcategoryBlock .= 
                      "</div>
                    </div>
                  </div>
                </div>";

                $container .= $subcategoryBlock;

              }

            $container .= "</div>";


            $container .=
            "</div>
          </div>";



        }

        echo $container;
        ?>

      </div>
    </div>

    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
      data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createProductModalLabel">Create New Product into <span
                class="text-primary"></span> Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
              <input type="hidden" name="subcategoryIdIncreateProductModal" id="subcategoryIdIncreateProductModal">
              <input type="hidden" name="productIdInCreateProductModal" id="productIdInCreateProductModal">
              <div class="form-file col-md-12 p-3" style="box-sizing: border-box;">
                <input type="file" class="form-file-input" name="image" id="image"
                  onchange="return fileValidation()">
                <label class="form-file-label" for="image">
                  <span class="form-file-text">Product Image</span>
                  <span class="form-file-button">Browse</span>
                </label>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid File
                </div>
                <div id="imagePreview" class="text-center d-block m-3"></div>
              </div>
              
              <div class="col-md-12">
                <label for="title" class="form-label text-primary h6">Title</label>
                <input type="text" class="form-control" id="title" name="title" pattern="^\w+(\s+\w+)*$"
                  placeholder="Title" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-12">
                <label for="description" class="form-label text-primary h6">Description</label>
                <textarea class="form-control" id="description" name="description" pattern="^\w+(\s+\w+)*$"
                  placeholder="description" required></textarea>

                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Data is invalid.
                </div>
              </div>

              <div class="col-md-12 border-bottom border-primary">
                <label class="form-label text-primary h6">Product Specification</label>
              </div>
              <div class="col-md-4">
                <label for="varieties" class="form-label text-small h6">Varieties</label>
                <input type="text" name="varieties" id="varieties" class="form-control" placeholder="Varieties" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-4">
                <label for="color" class="form-label h6">Color</label>
                <input type="text" name="color" id="color" class="form-control" placeholder="Color" pattern="^\w+(\s+\w+)*$" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-4">
                <label for="size" class="form-label h6">Size</label>
                <input type="text" name="size" id="size" class="form-control" placeholder="Size" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-4">
                <label for="weight" class="form-label h6">Weight</label>
                <input type="text" name="weight" id="weight" class="form-control" placeholder="Weight" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-4">
                <label for="tss" class="form-label h6">Total Soluble Solids (T.S.S.)</label>
                <input type="text" name="tss" id="tss" class="form-control" placeholder="Total Soluble Solids (T.S.S.)" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>

              <div class="col-md-12 border-bottom border-primary">
                <label class="form-label text-primary h6">Season Calendar</label>
              </div>

              <?php

              while($row = mysqli_fetch_array($months)) {
                echo "<div class='col-md-2'>
                    <div class='form-check mb-3'>
                      <input type='checkbox' class='form-check-input' id='". $row['id'] ."' value='". $row['id'] ."' name='calender[]'>
                      <label class='form-check-label'>". $row['name'] ."</label>
                    </div>
                  </div>";
              }
              ?>


              <div class="col-md-6">
                <label for="containercapacity" class="form-label text-primary h6">Container Preferred Capacity</label>
                <input type="text" name="containercapacity" id="containercapacity" class="form-control" placeholder="Container Preferred Capacity" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Field Name is invalid.
                </div>
              </div>
              <div class="col-md-6">
                <label for="incoterms" class="form-label text-primary h6">INCOTERMS</label>
                <input type="text" name="incoterms" id="incoterms" class="form-control" placeholder="INCOTERMS" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>

              <div class="col-md-6">
                <label for="paymenterms" class="form-label text-primary h6">Payment Terms</label>
                <div id="paymentermsDes">
                  <textarea name="paymenterms" id="paymenterms" class="form-control" placeholder="Payment Terms" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required></textarea>
                </div>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="certifications" class="form-label text-primary h6">Certifications</label>
                <div id="certificationsDes">
                  <textarea name="certifications" id="certifications" class="form-control" placeholder="Certifications" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+" required></textarea>
                </div>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>




              <div class="col-md-12 text-center">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="packingModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="packingModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="packingModalLabel">New Packing Specification</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <input type="hidden" name="productIdInPackingModal" id="productIdInPackingModal">
              <div class="col-md-6">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="Country"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="packagingSpecs" class="form-label">Packaging Specs</label>
                <input type="text" class="form-control" id="packagingSpecs" name="packagingSpecs" placeholder="Packaging Specs"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="netWT" class="form-label">Net Wt Per Box / Bag</label>
                <input type="text" class="form-control" id="netWT" name="netWT" placeholder="Net Wt Per Box / Bag"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="grossWT" class="form-label">Gross Wt Per Box / Bag</label>
                <input type="text" class="form-control" id="grossWT" name="grossWT" placeholder="Gross Wt Per Box / Bag"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="boxes" class="form-label">No. of Boxes / Bags</label>
                <input type="text" class="form-control" id="boxes" name="boxes" placeholder="No. of Boxes / Bags"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="containerType" class="form-label">Container Type</label>
                <input type="text" class="form-control" id="containerType" name="containerType" placeholder="Container Type"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="containerLoadability" class="form-label">Container Loadability</label>
                <input type="text" class="form-control" id="containerLoadability" name="containerLoadability" placeholder="Container Loadability"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>
              <div class="col-md-6">
                <label for="other" class="form-label">Other Details</label>
                <input type="text" class="form-control" id="other" name="other" placeholder="Other Details"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Input.
                </div>
              </div>

              <div class="col-md-12">
                <button class="btn btn-primary float-right" name="createPackingSpecification" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </main>

</body>
<?php include_once('./includes/admin-script.php'); ?>
<script>
  function fileValidation() {
    var fileInput = document.getElementById('image');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(filePath)) {
      alert('Please upload file having extensions .jpeg, .jpg, .png, .gif only.');
      fileInput.value = '';
      return false;
    } else {
      //Image preview
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" class="img img-fluid" style="max-width: 300px; margin-top:35px; max-height:auto"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }

  $(document).ready(function () {

    var myModalEl = document.getElementById('createProductModal')
    myModalEl.addEventListener('hide.bs.modal', function (e) {
      $(this).find('input').val('');
      $(this).find('input[type=checkbox]').prop("checked", false);
      $(this).find('textarea').val("");  
      $(this).find('img').attr("src", '');  
    })

    $(document).on('click', '.edit-product', function() {
      $('#productIdInCreateProductModal').val($(this).attr('id'));
  
      const img = document.createElement('img');
      img.src = $(this).parent().siblings('img').attr('src');
      img.classList = 'img img-fluid';
      $('#imagePreview').html(img);

      var details = $(this).parent().parent().siblings('div.details').find('.card-body');

      var title = details.find('.card-title').text();
      var description = details.find('.card-text.description').text();
      var Varieties = details.find('.card-text').find('small.varieties').text();
      var Color = details.find('.card-text').find('small.color').text();
      var Size = details.find('.card-text').find('small.size').text();
      var Weight = details.find('.card-text').find('small.weight').text();
      var TSS = details.find('.card-text').find('small.tss').text();
      var Calender = details.find('.card-text').find('small.calender').text();
      var calender = Calender.split(',');
      var ContainerCapacity = details.find('.card-text').find('small.containercapacity').text();
      var INCOTERMS = details.find('.card-text').find('small.incoterms').text();
      var PaymentTerms = details.find('.card-text').find('small.paymenterms').html();
      var Certifications = details.find('.card-text').find('small.certifications').html();


      $("#title").val(title);
      $("#description").val(description);
      $("#varieties").val(Varieties);
      $("#color").val(Color);
      $("#size").val(Size);
      $("#weight").val(Weight);
      $("#tss").val(TSS);
      $("#containercapacity").val(ContainerCapacity);
      $("#incoterms").val(INCOTERMS);

      var boxes = document.querySelectorAll("input[type=checkbox]"); 
      console.log(calender);
      for (let i = 0; i < boxes.length; i++) {
        if(calender.indexOf(boxes[i].id) >= 0){
          boxes[i].checked = true;
        }        
      }

      // $("#paymentermsDes").empty();
      // $("#certificationsDes").empty();
      

      // $('#paymentermsDes').html(
      // `<textarea class="form-control" id="paymenterms" name="paymenterms">${PaymentTerms}</textarea>`
      // );
      // $('#certificationsDes').html(
      // `<textarea class="form-control" id="certificationsDes" name="certificationsDes">${Certifications}</textarea>`
      // );
      // CKEDITOR.replace('paymenterms');
      // CKEDITOR.replace('certificationsDes');

      $("#paymenterms").val(PaymentTerms);
      $("#certifications").val(Certifications);


      

      $('#createProductModal').modal('show');

    });

    // SubCategory
    $(document).on('click', '.create-product', function () {
      $('#subcategoryIdIncreateProductModal').val($(this).attr('id'));
      $('#createProductModalLabel').find('.text-primary').text($(this).siblings('span').text());
    });
    // Packing
    $(document).on('click', '.packing-specification', function () {
      $('#productIdInPackingModal').val($(this).attr('id'));
      $('#createProductModalLabel').find('.text-primary').text($(this).siblings('span').text());
    });


  });
  
  // CKEDITOR.replace('paymenterms');
  // CKEDITOR.replace('certifications');
</script>

</html>
