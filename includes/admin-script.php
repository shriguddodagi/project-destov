<script src="./vendor/jquery.min.js"></script>
<link rel="stylesheet" href="./vendor/jquery-ui/jquery-ui.min.css">

<script src="./vendor/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="./vendor/bootstrap 5/js/bootstrap.min.js"></script>
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

<div class="modal fade" id="changePassword" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordLabel">Change Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="javascript:void(0)" method="POST" id="updateusername" class="row g-3">
          <div class="col-md-12">
            <h4>Change Username</h4>
          </div>
          <div class="col-md-12" id="updateusernameresponse"></div>
          <div class="col-md-12">
            <input type="text" class="form-control" name="newUsername" id="newUsername" value="<?php echo $_SESSION['username']; ?>" placeholder="Username" required>
          </div>
          <div class="col-md-12">
            <input type="password" class="form-control" name="password" id="existpassword" placeholder="Password" required>
          </div>
          <div class="col-md-12">
            <input type="checkbox" class="form-check-input" id="showpassword">
            <label class="form-check-label" for="showpassword">Show Password</label>
          </div>
          <div class="col-md-12 text-center">
            <button type="submit" name="updateUsername" class="btn btn-primary">Update Username</button>
          </div>
        </form>

        <div class="dropdown-divider"></div>

        <form action="javascript:void(0)" id="changepassword" method="POST" class="row g-3 needs-validation" novalidate>
          <div class="col-md-12">
            <h4>Change Password</h4>
          </div>
          <div class="col-md-12" id="changepasswordresponse"></div>
          <div class="col-md-12">
            <input type="password" class="form-control" placeholder="Old Password" name="oldPassword" id="oldPassword" required>
          </div>
          <div class="col-md-12">
            <input type="password" class="form-control" placeholder="New Password" name="newPassword" id="newPassword" required>
          </div>
          <div class="col-md-12 d-flex justify-content-between">
            <div>
              <input type="checkbox" class="form-check-input" id="showNewPassword">
              <label class="form-check-label" for="showNewPassword">Show Password</label>
            </div>
            <div class="btn btn-sm btn-light" id="generateNewPassword">Auto Generate Password</div>
          </div>
          <div class="col-md-12 text-center">
            <button type="submit" name="changePassword" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $(document).on("change", "#showNewPassword", function () {
      const type = $("#newPassword").attr('type');
      $("#newPassword").attr('type', (type == "password") ? "text" : "password");
      $("#oldPassword").attr('type', (type == "password") ? "text" : "password");
    });
    $(document).on("change", "#showpassword", function () {
      const type = $("#existpassword").attr('type');
      $("#existpassword").attr('type', (type == "password") ? "text" : "password");
    });
    $(document).on("click", "#generateNewPassword", function () {
      var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", length = 8;
      var password = "";
      for (let i = 0; i < length; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
      }
      $('#newPassword').val(password);
    });


    // ajax

    $(document).on("submit", "#updateusername", function () {
      const username = $(this).find('#newUsername').val();
      const password = $(this).find('#existpassword').val();
      const alertBox = $(this).find("#updateusernameresponse");
      console.log(alertBox);
      $.ajax({
        url: 'updateDetails.php',
        type: 'post',
        data: {username, password},
        success: function (response) {
          alert(response).prependTo(alertBox);
        }
      });

    });

    $(document).on("submit", "#changepassword", function () {
      const oldPassword = $(this).find('#oldPassword').val();
      const newPassword = $(this).find('#newPassword').val();
      const alertBox = $(this).find("#changepasswordresponse");
      
      $.ajax({
        url: 'updateDetails.php',
        type: 'post',
        data: {oldPassword, newPassword},
        success: function (response) {
          alert(response).prependTo(alertBox);
          $('#oldPassword').val("");
          $('#newPassword').val("");
        }
      });

    });

    function alert(response) {
      const span = $('<span></span>').html('&times').attr('aria-hidden', "true");
      const btn = $('<button></button>').addClass('close').attr("data-dismiss", "alert").attr("aria-label", "close").html(span);
      return $('<div></div>').text(response).addClass('alert alert-info alert-dismissible fade show').attr('role', "alert").append(btn);
    }
  });
</script>