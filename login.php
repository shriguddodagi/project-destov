<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop</title>
  <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
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
          <form action="admin.html" method="POST" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
              <label for="adminEmail" class="form-label">Your Email</label>
              <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="adminEmail" class="form-control" id="adminEmail" required>
              <div class="invalid-feedback">
                Email is Invalid
              </div>
            </div>
            <div class="col-12">
              <label for="adminPassword" class="form-label">Your password</label>
              <input type="password" pattern=".{8,}" title="Eight or more characters" name="adminPassword" class="form-control" id="adminPassword" required>
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
  <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
  <script>

    $(document).ready(function () {
      var modal = $('#loginModal');
      modal.modal('show');
    });
  </script>
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
</body>

</html>