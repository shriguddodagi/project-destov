<?php 
include_once('./includes/header.php');
include_once('./includes/util.php');
include_once('./FormSanitizer.php');

if(isset($_POST['submit'])) {
  mysqli_query($cn, recordSanitize($_POST));
  $_SESSION['feedbackDone'] = true;
  unset($_REQUEST, $_POST, $_GET);  
  header('Location: contact.php');
}

?>
  <div class="parallax-window" data-parallax="scroll" data-image-src="img/1920x1080/contactus.jpg">
    <div class="parallax-content container">
      <h1 class="carousel-title">Contact Us</h1>
    </div>
  </div>

   <!-- Contact List -->
   <div class="section-seperator">
    <div class="content-lg container">
      <div class="row">
       
        <div class="col-sm-4 sm-margin-b-50"></div>

        <div class="col-sm-4 text-center sm-margin-b-50">
          <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".3s">
            <h3>Mumbai</h3>
            <p>
              Shop No.04, Olive Excel <br>
              Seawoods, Sector-42<br>
              New Mumbai - 400 706
            </p>
            <ul class="list-unstyled contact-list">
              <li><i class="margin-r-10 color-base fa fa-lg fa-tag fa-phone"></i> +91 8082087255</li>
              <li><i class="margin-r-10 color-base fa fa-lg fa-tag fa-envelope"></i> info@destov.com</li>
            </ul>
          </div>
        </div>

        <div class="col-sm-4 sm-margin-b-50"></div>
      </div>
    </div>
  </div>
  <!-- End Contact List -->

  <div id="map" class="map height-400">
    <iframe style="border:0; width: 100%; height: 350px;" 
      src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" 
      frameborder="0" allowfullscreen></iframe>
  </div>

<?php include_once('./includes/feedback-form.php') ?>


<?php include_once('./includes/scripts.php') ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php') ?>