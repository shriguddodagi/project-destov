<?php include_once('./includes/admin-header.php') ?>

<?php 
include_once('./config.php');
include_once('./includes/util.php');
if (isset($_POST['submit'])) {

  $title = $_POST['title'];
  $description = $_POST['description'];
  $image = $_FILES['image'];

  if(validType($image)){
    $imagePath = uploadImage($image);
    $query = "INSERT INTO `slides` (title, description, image) VALUES ('$title', '$description', '$imagePath')";
    mysqli_query($cn, $query);
    header('Location: slider.php');
  }
}

if (isset($_POST['update'])) {
  $id = $_POST['sliderId'];
  $title = $_POST['titleInEditModal'];
  $description = $_POST['descriptionInEditModal'];
  $image = $_FILES['sliderImageInEditModal'];

  if($image['error'] > 0) {
    $query = "UPDATE `slides` SET title='$title', description='$description' WHERE id=$id";
    mysqli_query($cn, $query);
    header('Location: slider.php');
  } else {
    if(validType($image)){
      $query = "SELECT image FROM `slides` WHERE id=$id";
      unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['image']);
      $imagePath = uploadImage($image);
      $query = "UPDATE `slides` SET title='$title', description='$description', image='$imagePath' WHERE id=$id";
      mysqli_query($cn, $query);
    }
  }
}

if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  $query = "SELECT image FROM `slides` WHERE id=$id";
  unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['image']); 
  $query = "DELETE FROM `slides` WHERE id=$id";
  mysqli_query($cn, $query);
  header('Location: slider.php');
}


$query = "SELECT * FROM `slides` ORDER BY id DESC";
// $query = "SELECT * FROM `slides` ORDER BY id DESC LIMIT 2";
$result = mysqli_query($cn, $query);
?> 
  <main>

    <div class="container-fluid mt-3">
      <div class="row p-2">
        <div class="col d-flex justify-content-between display-3">
          <span>Sliders</span> 
          <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#sliderModal">Add New
            Slide</button>
        </div>
      </div>
      <div class="row">
        <?php

        while ($row = mysqli_fetch_array($result)) {          
          echo "
            <div class='col-sm-12 col-md-6 col-lg-4 col-xl-3'>
              <div class='card'>
                <img src='". $row['image'] ."' class='card-img-top w-100 h-50' alt='".$row['title']."'>
                <div class='card-body'>
                  <h5 class='card-title'>". $row['title'] ."</h5>
                  <p class='card-text'>". $row['description'] ."</p>
                  <button id='". $row['id'] ."' class='btn float-left edit-slider-btn btn-warning' data-toggle='modal' data-target='#editSliderModal'>Edit</button>

                  <form action='' method='POST'>
                      <input type='hidden' name='id' value='". $row['id'] ."'>
                      <button id='first one' name='delete' type='submit' class='btn float-right delete-slider-btn btn-danger'>Delete</button>
                  </form>
                </div>
              </div>
            </div>";
        }
        ?>    
      </div>
    </div>

    <div class="modal fade" id="editSliderModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="editSliderModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editSliderModalLabel">Edit Slider Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
              <input type="hidden" name="sliderId" id="sliderIdInEditModal">
              <div class="mb-3">
                <label for="titleInEditModal" class="form-label">Title</label>
                <input type="text" class="form-control" id="titleInEditModal" name="titleInEditModal" placeholder="Title" pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid <Title></Title>
                </div>
              </div>

              <div class="mb-3">
                <label for="descriptionInEditModal" class="form-label">Description</label>
                <textarea class="form-control" id="descriptionInEditModal" name="descriptionInEditModal"
                  placeholder="Required Description" pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Description
                </div>
              </div>


              <div class="form-file mb-3">
                <input type="file" class="form-file-input" name="sliderImageInEditModal" id="sliderImageInEditModal"
                  onchange="return fileValidationInEditModal()">
                <label class="form-file-label" for="sliderImageInEditModal">
                  <span class="form-file-text">Choose file...</span>
                  <span class="form-file-button">Browse</span>
                </label>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid File
                </div>
                <div id="imagePreviewInEditModal" class="text-center d-block m-3"></div>
              </div>

              <div class="mb-3">
                <button class="btn btn-primary float-right" name="update" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="sliderModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="sliderModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="sliderModalLabel">Add New Slider</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid <Title></Title>
                </div>
              </div>

              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Required Description"
                  pattern="^\w+(\s+\w+)*$" required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Description
                </div>
              </div>


              <div class="form-file mb-3">
                <input type="file" class="form-file-input" name="image" id="sliderImage" onchange="return fileValidation()" required>
                <label class="form-file-label" for="sliderImage">
                  <span class="form-file-text">Choose file...</span>
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

              <div class="mb-3">
                <button class="btn btn-primary float-right" name="submit" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </main>

</body>

<script src="./vendor/jquery.min.js"></script>
<script src="./vendor/bootstrap 5/js/bootstrap.min.js"></script>
<script>
  (function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>

<script>
  $(document).ready(function () {

    // Edit Slider
    $(document).on('click', '.edit-slider-btn', function () {
      $('#sliderIdInEditModal').val($(this).attr('id'));
      console.log($(this).attr('id'));
      $('#titleInEditModal').val($(this).siblings('.card-title').text());
      $('#descriptionInEditModal').val($(this).siblings('.card-text').text());
      const img = document.createElement('img');
      img.src = $(this).parent().siblings('img').attr('src');
      img.classList = 'img img-fluid';
      $('#imagePreviewInEditModal').html(img);
    });

  });
</script>

<script>
  function fileValidation() {
    var fileInput = document.getElementById('sliderImage');
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
  function fileValidationInEditModal() {
    var fileInput = document.getElementById('sliderImageInEditModal');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(filePath)) {
      alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
      fileInput.value = '';
      return false;
    } else {
      //Image preview
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById('imagePreviewInEditModal').innerHTML = '<img src="' + e.target.result + '" class="img img-fluid" style="max-width: 300px; margin-top:35px; max-height:auto"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }
</script>

</html>