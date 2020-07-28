<?php include_once('./includes/admin-header.php');
include_once('./config.php');

if(isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  mysqli_query($cn, "INSERT INTO `users` (`username`, `password`) VALUE ('$username', '$password')");
  unset($_POST);
  header('Location: users.php');
}

if(isset($_POST['change'])) {
  $permissions = implode(', ', $_POST['permissions']);
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `users` SET `permissions`='$permissions' WHERE id=$id");
  unset($_POST);
  header('Location: users.php');
}

if(isset($_POST['delete'])) {
  $id = $_POST['userId'];
  mysqli_query($cn, "DELETE FROM `users` WHERE id=$id");
  unset($_POST);
  header('Location: users.php');
}

$users = mysqli_query($cn, "SELECT * FROM `users` WHERE id!=1");

?>

  <div class="container">
    <div class="row">
      <div class="col d-flex justify-content-between">
        <h2>User Permissions</h2>
        <button data-toggle="modal" data-target="#createUser" class="btn btn-outline-info">Create New User</button>
      </div>
    </div>

    <div class="row">

    <?php

    while($user = mysqli_fetch_array($users)) {
      echo "<div class='card col-4 m-2'>
        <div class='card-body'>
          <h5 class='card-title'>". $user['username'] ."</h5>
          <h6 class='card-subtitle mb-2 text-muted'>". $user['permissions'] ."</h6>
          <button id='". $user['id'] ."' class='btn btn-sm btn-block my-2 btn-warning edit' data-toggle='modal' data-target='#editUser' class='btn btn-outline-info'>Change Permission</button>
          <form method='POST' action=''>  
            <input type='hidden' value='". $user['id'] ."' name='userId' />
            <button type='submit' name='delete' class='btn btn-sm btn-block my-2 btn-danger'>Delete User</button>
          </form>
        </div>
      </div>";
    }

    ?>
      
    </div>


    <div class="modal fade" id="createUser" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createUserLabel">Create New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <div class="col-md-12">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Username
                </div>
              </div>
              <div class="col-md-12">
                <label for="username" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Invalid Password
                </div>
              </div>
              <div class="col-md-12 d-flex justify-content-between">
                <div>
                  <input type="checkbox" class="form-check-input" id="showPassword">
                  <label class="form-check-label" for="showPassword">Show Password</label>
                </div>
                <div class="btn btn-sm btn-light" id="generatePassword">Auto Generate Password</div>
              </div>
              <div class="col-md-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editUser" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editUserLabel">Change User Permissions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <input type="hidden" name="id" id="userId">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="homepage" id="homepage">
                <label class="form-check-label" for="homepage">
                  Home Page Products
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="categories" id="categories">
                <label class="form-check-label" for="categories">
                  Categories
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="products" id="products">
                <label class="form-check-label" for="products">
                  Products
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="slider" id="slider">
                <label class="form-check-label" for="slider">
                  Slider
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="blogs" id="blogs">
                <label class="form-check-label" for="blogs">
                  Blogs
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="inquiries" id="inquiries">
                <label class="form-check-label" for="inquiries">
                  Inquiries
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="feedbacks" id="feedbacks">
                <label class="form-check-label" for="feedbacks">
                  Feedbacks
                </label>
              </div>
              
              <div class="col-md-12">
                <button type="submit" name="change" class="btn btn-primary float-right">Change</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>

</body>
</html>

<?php include_once('./includes/admin-script.php'); ?>

<script>

$(document).ready(function () {

  $(document).on("change", "#showPassword", function () {
    const type = $("#password").attr('type');
    $("#password").attr('type', (type == "password") ? "text" : "password");
  });
  $(document).on("click", "#generatePassword", function () {
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", length = 8;
    var password = "";
    for (let i = 0; i < length; i++) {
      password += charset.charAt(Math.floor(Math.random() * charset.length));
    }
    $('#password').val(password);
  });
  $(document).on("click", ".edit", function () {
    $('#userId').val($(this).attr('id'));
    const permissions = $(this).siblings('h6.text-muted').text().split(', ');
    
    $("#editUser").find("input[type=checkbox]").each(function (index) {
      const val = $(this).val()

      const check = (permissions.findIndex(function(str) {
        return (str == val) ? true: false;
      })) >= 0 ? true : false;
    
      $(this).prop("checked", check);
    });
  });

});

</script>