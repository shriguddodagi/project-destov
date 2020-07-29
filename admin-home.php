<?php include_once('./includes/admin-header.php');

if (!in_array('home', $permissions)) {
  header('Location: admin-' . $permissions[0] . '.php');
  exit;
}

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

if(isset($_POST['removeProduct'])) {
  $id = $_POST['deleteProductId'];
  $query = "UPDATE `products` SET display_on_home='off', position='0' WHERE id=$id";
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-home.php');  
}

$query = "SELECT * FROM `products` WHERE display_on_home='on' ORDER BY position ASC";
$products = mysqli_query($cn, $query);
?> 
  <main>

   <div class="container border p-3 rounded">
     <div class="row">
       <div class="col">
         <h2>Images Order</h2>
       </div>
     </div>
     <div class="row">
       <div class="col">
        <div class="alert alert-info alert-dismissible d-none fade show" role="alert">
          <div id="txtresponse"></div>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
       </div>
     </div>
     <div class="row g-2" id="image-list" style="list-style: none;">   
        <?php
        if ($products->num_rows > 0) {
          while($row = mysqli_fetch_array($products)) {
            echo '<div class="col image-item" id="image_' . $row['id'] . '" >
              <img class="img rounded img-fluid" src="' . $row['image'] . '" alt="' . $row['title'] . '">
            </div>';
          }
        }
        ?>
     </div>
     <div class="row mt-2">
       <div class="col text-center">
        <button class="btn-submit btn btn-primary" name="submit" id='submit'>Submit</button>
       </div>
     </div>
   </div>

   <div class="container my-5 border rounded">
      <div class="row p-2">
        <div class="col d-flex justify-content-between">
          <h2>Change Product</h2> 
          <button id="0" class="btn font-weight-bold change btn-outline-info" data-toggle="modal" data-target="#modal">New</button>
        </div>
      </div>
      <div class="row g-3">  
        <?php
        mysqli_data_seek($products, 0);
        while($row = mysqli_fetch_array($products)) { 
          echo "<div class='col'>
            <div class='card'>
              <img src='". $row['image'] ."' class='card-img-top w-100 h-50' alt='title'>
              <div class='card-body'>
                <h5 class='card-title'>". $row['title'] ."</h5>
              </div>
              <div class='card-footer d-flex justify-content-between'>
                <button id='". $row['id'] ."' class='btn font-weight-bold change btn-warning' data-toggle='modal' data-target='#modal'>Change</button> 
                <form action='' method='post'>
                  <input type='hidden' value='". $row['id'] ."' name='deleteProductId'>
                  <button type='submit' name='removeProduct' class='btn font-weight-bold btn-danger'>Delete</button>
                </form>
              </div>
            </div>
          </div>";
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

    $("#image-list").sortable({
          update: function(event, ui) { 
            dropIndex = ui.item.index();
        }
    });
    $('#submit').click(function (e) {
        var imageIdsArray = [];
        $('#image-list .image-item').each(function (index) {
          var id = $(this).attr('id');
          var split_id = id.split("_");
          imageIdsArray.push(split_id[1]);
        });
        $.ajax({
            url: 'updateRecord.php',
            type: 'post',
            data: {imageIds: imageIdsArray},
            success: function (response) {
                $(".alert").removeClass('d-none').addClass('d-block'); 
                $("#txtresponse").text(response);
            }
        });
    });
  });

</script>
<?php include_once('./includes/admin-footer.php'); ?>