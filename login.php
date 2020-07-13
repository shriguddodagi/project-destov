<?php
include_once('./config.php');

if(isset($_POST['login'])) {
  $email = $_POST['adminEmail'];
  $password = $_POST['adminPassword'];
  $data = mysqli_fetch_array(mysqli_query($cn, "SELECT * FROM `admin` WHERE `email`='$email' AND `password`='$password' LIMIT 1"));
  
  if(count($data) > 0) {
    session_start();
    $_SESSION['auth'] = true;
    $_SESSION['email'] = $email;
    unset($_POST);
    header('Location: admin.php');
  } else {
    echo "<script>alert('Invalid Email and Password');</script>";
    unset($_POST);
    header('Location: login.php');
  }
  
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop</title>
  <link rel="stylesheet" href="./vendor/bootstrap 5/css/bootstrap.min.css">
  <script src="./vendor/jquery.min.js"></script>
</head>

<body>

  <div class="modal fade" id="loginModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content p-0 m-0">
        <div class="modal-header bg-info text-white m-3 rounded text-center">
          <h5 class="modal-title text-capitalization" id="exampleModalLabel">ADMIN LOGIN</h5>
        </div>
        <div class="modal-body">
          <form action="" method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
              <label for="adminEmail" class="form-label">Your Email</label>
              <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="adminEmail" class="form-control" id="adminEmail" required>
              <div class="invalid-feedback">
                Email is Invalid
              </div>
            </div>
            <div class="col-12">
              <label for="adminPassword" class="form-label">Your password</label>
              <input type="password" pattern=".{5,}" title="Eight or more characters" name="adminPassword" class="form-control" id="adminPassword" required>
              <div class="invalid-feedback">
                Password is Required
              </div>
            </div>
            <div class="col-12 text-center">
              <button class="btn btn-block btn-primary" name="login" type="submit">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="./vendor/bootstrap 5/js/bootstrap.min.js"></script>
  <script>

    $(document).ready(function () {
      var modal = $('#loginModal');
      modal.modal('show');
    });
  </script>
  <script>
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')

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
</body>

</html>