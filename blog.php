<?php
include_once('./includes/header.php');

$blogId = $_GET['blog'];
$query = "SELECT * FROM `blogs` WHERE id='$blogId'";
$blog = mysqli_fetch_array(mysqli_query($cn, $query));

if(!count($blog)) {
  header('Location: blogs.php');
}
?>


<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $blog['image'] ?>">
  <div class="parallax-content container">
    <h1 class="carousel-title"><?php echo $blog['title'] ?></h1>
  </div>
</div>


<div class="bg-color-sky-light">
  <div class="content-lg container">
    <div class="row">
      <div class="col-md-12 margin-b-30">
        <p style="color: #000"><?php echo $blog['description'];  ?></p>
      </div>
    </div>
  </div>
</div>

<?php include_once('./includes/scripts.php'); ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php'); ?>