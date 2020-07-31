<?php 
include_once('./includes/admin-header.php'); 
include_once('./includes/util.php');

if (!in_array('slider', $permissions)) {
  header('Location: admin-' . $permissions[0] . '.php');
  exit;
}

if (isset($_POST['submit'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $file = $_FILES['image'];
  $type = $_POST['type'];
  if(validType($file, $type)){
    $filePath = uploadFile($file);
    $query = "INSERT INTO `slides` (title, description, file, type) VALUES ('$title', '$description', '$filePath', '$type')";
    mysqli_query($cn, $query);
    header('Location: admin-slider.php');
  } else {
    unset($_POST['submit']);
    echo "<script>alert('File type and file are not matched')</script>";
  }
}

if (isset($_POST['update'])) {
  $id = $_POST['sliderId'];
  $title = $_POST['titleInEditModal'];
  $description = $_POST['descriptionInEditModal'];
  $file = $_FILES['sliderImageInEditModal'];
  $type = $_POST['type'];

  if($file['error'] > 0) {
    $query = "UPDATE `slides` SET title='$title', description='$description' WHERE id=$id";
    mysqli_query($cn, $query);
    unset($_POST);
    header('Location: admin-slider.php');
  } else {
    if(validType($file, $type)){
      $query = "SELECT `file` FROM `slides` WHERE id=$id";
      unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['file']);
      $filePath = uploadFile($file);
      $query = "UPDATE `slides` SET title='$title', description='$description', file='$filePath', type='$type' WHERE id=$id";
      mysqli_query($cn, $query);
      unset($_POST);
      header('Location: admin-slider.php');
    }
  }
}

if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  $query = "SELECT image FROM `slides` WHERE id=$id";
  unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['image']); 
  $query = "DELETE FROM `slides` WHERE id=$id";
  mysqli_query($cn, $query);
  header('Location: admin-slider.php');
}


  // Pagination
  $page_no = 1;
  $total_records_per_page = 3;

  if(isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
  }

  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $total_records = mysqli_fetch_array(mysqli_query($cn, "SELECT COUNT(*) AS total_records FROM `slides`"))['total_records'];

  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1; // total pages minus 1

  $slides = mysqli_query($cn, "SELECT * FROM `slides` ORDER BY id DESC LIMIT $offset, $total_records_per_page");

?> 
  <main>

    <div class="container">
      <div class="row">
        <div class="col d-flex justify-content-between display-3">
          <h2>Sliders</h2> 
          <button class="btn font-weight-bold btn-outline-primary" data-toggle="modal" data-target="#sliderModal">Add New
            Slide</button>
        </div>
      </div>

      <div class="row">
        <div class="text-center m-2">
          <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>
      </div>

      <div class="row">
        <?php

        while ($row = mysqli_fetch_array($slides)) {          
          $slide = "
            <div class='col-sm-12 col-md-6 col-lg-4 col-xl-3'>
              <div class='card'>";
              
              $slide .= ($row['type'] == "image") ? 
                "<img src='". $row['file'] ."' class='card-img-top file ". $row['type'] ." w-100 h-50' alt='".$row['title']."'>"
                :
                "<video src='". $row['file'] ."' class='card-img-top file ". $row['type'] ." w-100 h-50' alt='".$row['title']."' controls></video>";
                
              
              $slide .= "<div class='card-body'>
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
            echo $slide;
        }
        ?>    
      </div>
      
      <div class="row m-5">
        <div class="col d-flex justify-content-center">
          <div aria-label="Page navigation">
            <ul class="pagination">
              <?php 
              if($page_no > 1){
                echo "<li class='page-item '><a class='page-link' href='?page_no=1'>First Page</a></li>";
              } 
              ?>      
              <li class='page-item <?php if($page_no <= 1){ echo "disabled"; } ?>'>
                <a class='page-link' <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?> aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
                  
              <li class='page-item <?php if($page_no >= $total_no_of_pages){ echo "disabled";} ?>'>
                <a class='page-link' <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?> aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
              
              <?php if($page_no < $total_no_of_pages){
              echo "<li class='page-item'><a class='page-link' class='' href='?page_no=$total_no_of_pages'>Last &raquo;</a></li>";
            } ?>
            </ul>
          </div>
        </div>
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
              <div class="form-check d-flex justify-content-between">
                <div>  
                  <input class="form-check-input" type="radio" name="type" value="image" id="image">
                  <label class="form-check-label" for="image">Image</label>
                </div>
                <div>
                  <input class="form-check-input" type="radio" name="type" value="video" id="video">
                  <label class="form-check-label" for="video">Video</label>
                </div>
              </div>
              
              <div class="mb-3">
                <label for="titleInEditModal" class="form-label">Title</label>
                <input type="text" class="form-control" id="titleInEditModal" name="titleInEditModal" placeholder="Title" pattern="^\w+(\s+\w+)*$"></textarea>
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
                  placeholder="Required Description" pattern="^\w+(\s+\w+)*$"></textarea>
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
                <button class="btn btn-primary float-right" name="update" type="submit">Update</button>
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
              <div class="form-check d-flex justify-content-between">
                <div>  
                  <input class="form-check-input" type="radio" name="type" value="image" id="image" checked>
                  <label class="form-check-label" for="image">Image</label>
                </div>
                <div>
                  <input class="form-check-input" type="radio" name="type" value="video" id="video">
                  <label class="form-check-label" for="video">Video</label>
                </div>
              </div>
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                  pattern="^\w+(\s+\w+)*$"></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid <Title></Title>
                </div>
              </div>

              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description"
                  pattern="^\w+(\s+\w+)*$"></textarea>
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

<?php include_once('./includes/admin-script.php'); ?>
<script>
  $(document).ready(function () {

    // Edit Slider
    $(document).on('click', '.edit-slider-btn', function () {
      $('#sliderIdInEditModal').val($(this).attr('id'));
      $('#titleInEditModal').val($(this).siblings('.card-title').text());
      $('#descriptionInEditModal').val($(this).siblings('.card-text').text());
      file = $(this).parent().siblings('.file');
      
      let tag;
      if (file.hasClass('image')) {
        $('#editSliderModal').find('#image.form-check-input').prop("checked", true);
        tag = document.createElement('img');
      } else {
        $('#editSliderModal').find('#video.form-check-input').prop("checked", true);
        tag = document.createElement('video');
        tag.controls = true;
      }
      tag.src = file.attr('src');
      tag.classList = 'img img-fluid';
      $('#imagePreviewInEditModal').html(tag);
    });

  });

  function fileValidation() {
    var fileInput = document.getElementById('sliderImage');
    var radio = $('#sliderModal').find('.form-check-input');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
    if (!allowedExtensions.exec(filePath)) {
      alert('File must jpeg, .jpg, .png, .gif, mp4 only.');
      fileInput.value = '';
      return false;
    } else {
      //Image preview
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById('imagePreview').innerHTML = (!radio[1].checked) ?  
            '<img src="' + e.target.result + '" class="img img-fluid" style="max-width: 300px; margin-top:35px; max-height:auto"/>'
            :
            '<video controls src="' + e.target.result + '" class="img img-fluid" style="max-width: 300px; margin-top:35px; max-height:auto"></video>';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }
  function fileValidationInEditModal() {
    var fileInput = document.getElementById('sliderImageInEditModal');
    var radio = $('#editSliderModal').find('.form-check-input');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4)$/i;
    if (!allowedExtensions.exec(filePath)) {
      alert('File must jpeg, .jpg, .png, .gif, mp4 only.');
      fileInput.value = '';
      return false;
    } else {
      //Image preview
      if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById('imagePreviewInEditModal').innerHTML = (!radio[1].checked) ?  
            '<img src="' + e.target.result + '" class="img img-fluid" style="max-width: 300px; margin-top:35px; max-height:auto"/>'
            :
            '<video controls src="' + e.target.result + '" class="img img-fluid" style="max-width: 300px; margin-top:35px; max-height:auto"></video>';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }
</script>

<?php include_once('./includes/admin-script.php'); ?>
<?php include_once('./includes/admin-footer.php'); ?>