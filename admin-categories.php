<?php
include_once('./includes/admin-header.php');
include_once('./includes/classes/Category.php');

$permissions = explode(', ', $_SESSION['permissions']);


if (!in_array('categories', $permissions)) {
  header('Location: admin-' . $permissions[0] . '.php');
  exit;
}

if(isset($_POST['createCategory'])) {
  $name = $_POST['categoryName'];
  $terms = $_POST['categoryTerms'];
  $query = "INSERT INTO `categories` (name, terms) VALUES ('$name', '$terms')";
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-categories.php');
}

if(isset($_POST['updateCategory'])) {
  $name = $_POST['categoryNameInEditModal'];
  $terms = $_POST['categoryTermsInEditModal'];
  $id = $_POST['categoryIdInEditCategoryModal'];
  $query = "UPDATE `categories` SET name='$name', terms='$terms' WHERE id=$id";
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-categories.php');
}

if(isset($_POST['deleteCategory'])) {
  $id = $_POST['id'];
  $query = "DELETE FROM `categories` WHERE id=$id";
  $subcategories = mysqli_query($cn, "SELECT id FROM `subcategories` WHERE category_id=$id");
  while($subcategory = mysqli_fetch_array($subcategories)) {
    mysqli_query($cn, "DELETE FROM `products` WHERE subcategory_id=" . $subcategory['id']);
  }
  mysqli_query($cn, "DELETE FROM `subcategories` WHERE category_id=$id");
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-categories.php');
}

if(isset($_POST['createSubcategory'])) {
  $categoryId = $_POST['categoryIdInCreateSubCategoryModal'];
  $name = $_POST['subCategoryName'];
  $query = "INSERT INTO `subcategories` (name, category_id) VALUES ('$name', '$categoryId')";
  mysqli_query($cn, $query);
  unset($_POST);
  header('Location: admin-categories.php');
}

if(isset($_POST['deleteSubcategory'])) {
  $id = $_POST['subcategoryId'];
  mysqli_query($cn, "DELETE FROM `products` WHERE subcategory_id=$id");
  mysqli_query($cn, "DELETE FROM `subcategories` WHERE id=$id");
  unset($_POST);
  header('Location: admin-categories.php');
}


$query = "SELECT * FROM `categories`";
$categories = mysqli_query($cn, $query);


?>




<main>
  <div class="container">
    <div class="row p-2">
      <div class="col d-flex justify-content-between">
        <h2>Categories</h2>
        <button class="btn font-weight-bold btn-outline-primary" data-toggle="modal" data-target="#createCategoryModal">New Category</button>
      </div>
    </div>
    
    <div class="row">
      

      
      <?php
      
      while($row = mysqli_fetch_array($categories)) {
        $subCatObj = new Subcategory($cn, $row['id']);
        $card = "<div class='col-6'>
          <div class='card m-2 w-100'>
            <div class='card-body text-center selector-for-some-widget'>
              <div class='d-flex justify-content-between'>
                <h5 class='card-title'>". $row['name'] ."</h5>
                
                <button class='btn btn-primary create-sub-category-button' id='". $row['id'] ."' data-toggle='modal'
                  data-target='#createSubCategoryModal'>Add Sub Category</button>
              </div>
              <div class='text-left p-2'>". substr(strip_tags($row['terms']), 0, 19) ."</div>
              <div class='text-left terms d-none p-2'>". $row['terms'] ."</div>
              <div class='d-flex mt-3 justify-content-between'>
                <button id='".  $row['id'] ."' class='btn btn-warning edit-category-button'>Edit</button>
                  <form action='' method='POST'>
                    <input type='hidden' name='id' value='". $row['id'] ."'>
                    <button type='submit' name='deleteCategory' class='btn btn-danger delete-category-button'>Delete</button>
                  </form>
              </div>
            </div>
            <div class='card-footer'>
              <ul>";
              
              foreach($subCatObj->subcategories() as $row) {
              
                $card .= "<li class='d-flex my-1 justify-content-between'>
                  <div>". $row['name'] ."</div>
                  <form action='' method='POST'>
                    <input type='hidden' name='subcategoryId' value='".$row['id']."'>
                    <button type='submit' name='deleteSubcategory' class='btn btn-outline-danger'>Delete</button>
                  </form>
                </li>";
              }

              $card .="</ul>

            </div>
          </div>
        </div>";
        echo $card;
      }

      ?>
    </div>

    <?php
        if($categories->num_rows == 0) {
          echo "<div class='row'>
            <div class='col text-center'>
              <div class='display-3'>
                Nothing Found!
              </div>
            </div>
          </div>";
        }
      ?>

    <!-- Category -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="createCategoryModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createCategoryModalLabel">Create New Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <div class="col-md-12">
                <label for="categoryName" class="form-label">Name</label>
                <input type="text" name="categoryName" id="categoryName" class="form-control" pattern="^\w+(\s+\w+)*$"
                  required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Category Name is invalid.
                </div>
              </div>
              <div class="col-md-12">
                <label for="categoryTerms" class="form-label">Terms & Conditions</label>
                <textarea name="categoryTerms" id="categoryTerms" class="form-control" pattern="^\w+(\s+\w+)*$"
                  required></textarea>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid input.
                </div>
              </div>
              <button type="submit" name="createCategory" class="btn btn-primary">Create Category</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="editCategoryModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="editCategoryModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editCategoryModalLabel">Edit Category <span class="text-primary"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <div class="col-md-12">
                <input type="hidden" name="categoryIdInEditCategoryModal" id="categoryIdInEditCategoryModal">
                <label for="categoryNameInEditModal" class="form-label">Category Name</label>
                <input type="text" name="categoryNameInEditModal" id="categoryNameInEditModal" class="form-control" pattern="^\w+(\s+\w+)*$"
                  required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Category Name is invalid.
                </div>
              </div>
              <div class="col-md-12">
                <label for="categoryTermsInEditModal" class="form-label">Terms & Conditions</label>
                <!-- <textarea name="categoryTermsInEditModal" id="categoryTermsInEditModal" class="form-control" pattern="^\w+(\s+\w+)*$"
                  required></textarea> -->
                <div id="des"></div>
              </div>
              <button type="submit" name="updateCategory" class="btn btn-primary">Update Category</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!--Create subcategory -->
    <div class="modal fade" id="createSubCategoryModal" tabindex="-1" aria-labelledby="createSubCategoryModalLabel"
      data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createSubCategoryModalLabel">Create New Sub Category into <span
                class="text-primary"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <input type="hidden" name="categoryIdInCreateSubCategoryModal" id="categoryIdInCreateSubCategoryModal">
              <div class="col-md-12">
                <label for="subcategoryName" class="form-label text-primary h6">Sub Category Name</label>
                <input type="text" name="subCategoryName" id="subCategoryName" class="form-control"
                  pattern="^\w+(\s+\w+)*$" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Sub Category Name is invalid.
                </div>
              </div>
              <div class="col-md-12 text-center">
                <button type="submit" name="createSubcategory" class="btn btn-primary">Create New Sub Category</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include_once('./includes/admin-script.php'); ?>
<script>
  $(document).ready(function () {
    // Edit Category
    $(document).on('click', '.edit-category-button', function () {
      $('#categoryIdInEditCategoryModal').val($(this).attr('id'));
      const title = $(this).parent().siblings('div').find('h5.card-title').text();
      $('#editCategoryModalLabel').find('.text-primary').text(title);
      $('#categoryNameInEditModal').val(title);
      const content = $(this).parent().siblings('div.terms').html();
      $('#des').html(
      `<textarea class="form-control" id="categoryTermsInEditModal" name="categoryTermsInEditModal">${content}</textarea>`
      );
      CKEDITOR.replace('categoryTermsInEditModal');
      $('#categoryTermsInEditModal').text();
      $('#editCategoryModal').modal('show');
    });

    // SubCategory
    $(document).on('click', '.create-sub-category-button', function () {
      $('#categoryIdInCreateSubCategoryModal').val($(this).attr('id'));
      $('#createSubCategoryModalLabel').find('.text-primary').text($(this).siblings('.card-title').text());
    });
  });
  
  CKEDITOR.replace('categoryTerms');
</script>
<?php include_once('./includes/admin-footer.php'); ?>