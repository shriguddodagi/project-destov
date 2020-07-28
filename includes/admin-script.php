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
