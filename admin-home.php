<?php include_once('./includes/admin-header.php') ?>

<?php 
include_once('./config.php');
if (isset($_POST['change'])) {
  $oldId = $_POST['oldProductId'];
  $newId = $_POST['newProductId'];
  
  if($oldId == 0) {
    $counter = mysqli_fetch_array(mysqli_query($cn, "SELECT COUNT(*) AS total FROM `products` WHERE display_on_home='on'"))['total'] + 1;
    $query = "UPDATE `products` SET display_on_home='on', position='$counter' WHERE id=$newId";
    mysqli_query($cn, $query);  
    unset($_POST);
    return header('Location: admin-home.php'); 
  }

  $counter = mysqli_fetch_array(mysqli_query($cn, "SELECT position FROM `products` WHERE id='$oldId'"))['position'];
  $query = "UPDATE `products` SET display_on_home='off', position='null' WHERE id=$oldId";
  mysqli_query($cn, $query);
  $query = "UPDATE `products` SET display_on_home='on', position='$counter' WHERE id=$newId";
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-home.php');  
}

// if(isset($_POST['removeProduct'])) {
//   $id = $_POST['deleteProductId'];
//   $query = "UPDATE `products` SET display_on_home='off', position='0' WHERE id=$id";
//   mysqli_query($cn, $query);
//   unset($_POST);
//   header('Location: admin-home.php');  
// }

$query = "SELECT * FROM `products` WHERE display_on_home='on' ORDER BY position ASC";
$products = mysqli_query($cn, $query);
// $positionCounter = mysqli_fetch_array(mysqli_query($cn, "SELECT MAX(position) AS maxi FROM `products` WHERE display_on_home='on'"))['maxi'];
?> 
  <main>

    <div class="container-fluid mt-3">
      <div class="row p-2">
        <div class="col display-3">
          
        </div>
      </div>
      <div class="row p-2">
        <div class="col d-flex justify-content-between display-3">
          <span>Home Page Product</span> 
          <button id="0" class="btn font-weight-bold change btn-outline-info" data-toggle="modal" data-target="#modal">New</button>
        </div>
      </div>
      <div class="row g-3">  
        <?php
        while($row = mysqli_fetch_array($products)) {
          
            echo "<div class='col-sm-12 col-md-6 col-lg-4 col-xl-3'>
              <div class='card'>
                <img src='". $row['image'] ."' class='card-img-top w-100 h-50' alt='title'>
                <div class='card-body'>
                  <h5 class='card-title'>". $row['title'] ."</h5>
                  <p class='card-text'>". $row['description'] ."</p>
                </div>
                <div class='card-footer d-flex justify-content-between'>
                  <div class='h3'>#". $row['position'] ."</div>
                  <button id='". $row['id'] ."' class='btn mx-4 font-weight-bold change btn-info' data-toggle='modal' data-target='#modal'>Change</button>
                  
                  
                </div>
              </div>
            </div>";
                  
                //   <form action='' method='post'>
                //   <input type='hidden' value='". $row['id'] ."' name='deleteProductId'>
                //   <button type='submit' name='removeProduct' class='btn mx-4 font-weight-bold btn-dark'>Delete</button>
                // </form>
            // echo "<div class='col-sm-12 col-md-6 col-lg-4 col-xl-3'>
            //       <div class='card'>
            //         <div class='card-body'>
            //           <h5 class='card-title'>There is just desert</h5>
            //         </div>
            //         <div class='card-footer d-flex justify-content-between'>
            //           <div class='h3'>#". $i ."</div>
            //           <button id='' class='btn mx-4 font-weight-bold change btn-info' data-toggle='modal' data-target='#modal'>Change</button>
            //         </div>
            //       </div>
            //     </div>";
        }
        ?>
      </div>
    </div>

    <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Change Product Sequence</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
              <input type="hidden" name="productId" id="productId">
              <div class="mb-3">
                <input type="text" class="form-control" id="term" name="term" placeholder="Search For Product(Title)">
              </div>
              <div id="result" class="container-fluid"></div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </main>

</body>
<?php include_once('./includes/admin-script.php'); ?>
<script>
  $(document).ready(function () {

    // Edit blog
    $(document).on('click', '.change', function () {
      $('#productId').val($(this).attr('id'));
    });

    $(document).on("keyup", "#term", function(){
      // console.log($(this).val());
      
      $.ajax({
        url: "search.php", 
        data: { 
          term: $(this).val().trim(),
          productId: $('#modal').find('#productId').val()
        },
        method: 'POST',
        success: function(data) {
          $('#result').html(data);
        }
      });
    });

  });
</script>

</html>