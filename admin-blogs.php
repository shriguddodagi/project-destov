<?php include_once('./includes/admin-header.php');
include_once('./includes/util.php');

if (!in_array('blogs', $permissions)) {
  header('Location: admin-' . $permissions[0] . '.php');
  exit;
}

if (isset($_POST['submit'])) {

  $title = $_POST['title'];
  $description = $_POST['description'];
  $image = $_FILES['image'];

  if(validType($image, 'image')){
    $imagePath = uploadFile($image);
    $query = "INSERT INTO `blogs` (title, description, image) VALUES ('$title', '$description', '$imagePath')";
    mysqli_query($cn, $query);
    header('Location: admin-blogs.php');
  }
}

if (isset($_POST['update'])) {
  $id = $_POST['blogId'];
  $title = $_POST['titleInEditModal'];
  $description = $_POST['descriptionInEditModal'];
  $image = $_FILES['blogImageInEditModal'];

  if($image['error'] > 0) {
    $query = "UPDATE `blogs` SET title='$title', description='$description' WHERE id=$id";
    mysqli_query($cn, $query);
    header('Location: admin-blogs.php');
  } else {
    if(validType($image, 'image')){
      $query = "SELECT image FROM `blogs` WHERE id=$id";
      unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['image']);
      $imagePath = uploadFile($image);
      $query = "UPDATE `blogs` SET title='$title', description='$description', image='$imagePath' WHERE id=$id";
      mysqli_query($cn, $query);
    }
  }
}

if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  $query = "SELECT image FROM `blogs` WHERE id=$id";
  unlink(mysqli_fetch_array((mysqli_query($cn, $query)))['image']); 
  $query = "DELETE FROM `blogs` WHERE id=$id";
  mysqli_query($cn, $query);
  header('Location: admin-blogs.php');
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

  $total_records = mysqli_fetch_array(mysqli_query($cn, "SELECT COUNT(*) AS total_records FROM `blogs`"))['total_records'];

  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1; // total pages minus 1

  $blogs = mysqli_query($cn, "SELECT * FROM `blogs` ORDER BY id DESC LIMIT $offset, $total_records_per_page");

?> 
  <main>

    <div class="container mt-3">
      <div class="row p-2">
        <div class="col d-flex justify-content-between">
          <h2>Blogs</h2>
          <button class="btn font-weight-bold btn-outline-primary" data-toggle="modal" data-target="#blogModal">Create Blog</button>
        </div>
      </div>

      <div class="row">
        <div class="text-center m-2">
          <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>
      </div>

      <div class="row g-2">
        <?php

        while ($row = mysqli_fetch_array($blogs)) {
          echo "
            <div class='col-sm-12 col-md-6 col-lg-4 col-xl-3'>
              <div class='card'>
                <img src='". $row['image'] ."' class='card-img-top w-100 h-50' alt='".$row['title']."'>
                <div class='card-body'>
                  <h5 class='card-title'>". $row['title'] ."</h5>
                  <p class='card-text'>". substr(strip_tags($row['description']), 0, 19) ."...</p>
                  <div class='card-text d-none'>". $row['description'] ."...</div>
                  <button id='". $row['id'] ."' class='btn float-left edit-blog-btn btn-warning' data-toggle='modal' data-target='#editblogModal'>Edit</button>

                  <form action='' method='POST'>
                      <input type='hidden' name='id' value='". $row['id'] ."'>
                      <button name='delete' type='submit' class='btn float-right delete-blog-btn btn-danger'>Delete</button>
                  </form>
                </div>
              </div>
            </div>";
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

    <div class="modal fade" id="editblogModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="editblogModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editblogModalLabel">Edit Blog Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
              <input type="hidden" name="blogId" id="blogIdInEditModal">
              <div class="mb-3">
                <label for="titleInEditModal" class="form-label">Title</label>
                <input type="text" class="form-control" id="titleInEditModal" name="titleInEditModal" placeholder="Title">
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Title
                </div>
              </div>

              <div class="mb-3">
                <label for="descriptionInEditModal" class="form-label">Description</label>
                <div id="des"></div>
              </div>


              <div class="form-file mb-3">
                <input type="file" class="form-file-input" name="blogImageInEditModal" id="blogImageInEditModal"
                  onchange="return fileValidationInEditModal()">
                <label class="form-file-label" for="blogImageInEditModal">
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
    <div class="modal fade" id="blogModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="blogModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="blogModalLabel">Add New blog</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
              <div class="mb-3">
                <label for="description" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                >
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
                ></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Description
                </div>
              </div>


              <div class="form-file mb-3">
                <input type="file" class="form-file-input" name="image" id="blogImage" onchange="return fileValidation()">
                <label class="form-file-label" for="blogImage">
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


<?php include_once('./includes/admin-script.php'); ?>

<script>
  $(document).ready(function () {
    const des = CKEDITOR.replace('descriptionInEditModal');
    // Edit blog
    $(document).on('click', '.edit-blog-btn', function () {
      $('#blogIdInEditModal').val($(this).attr('id'));
      $('#titleInEditModal').val($(this).siblings('.card-title').text());
      const content = $(this).siblings('div.card-text').html();
      $('#des').html(
      `<textarea class="form-control" id="descriptionInEditModal" name="descriptionInEditModal">${content}</textarea>`
      );
      CKEDITOR.replace('descriptionInEditModal');    
      const img = document.createElement('img');
      img.src = $(this).parent().siblings('img').attr('src');
      img.classList = 'img img-fluid';
      $('#imagePreviewInEditModal').html(img);
    });

  });
</script>

<script>
  function fileValidation() {
    var fileInput = document.getElementById('blogImage');
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
    var fileInput = document.getElementById('blogImageInEditModal');
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
          document.getElementById('imagePreviewInEditModal').innerHTML = '<img src="' + e.target.result + '" class="img img-fluid" style="max-width: 300px; margin-top:35px; max-height:auto"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }
  
  CKEDITOR.replace('description');
</script>

<?php include_once('./includes/admin-footer.php'); ?>