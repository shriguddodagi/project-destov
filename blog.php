<?php
include_once('./includes/header.php');
$blogId = $_GET['blog'];
$blog = mysqli_fetch_array(mysqli_query($cn, "SELECT * FROM `blogs` WHERE id='$blogId' LIMIT 1"));

if(!count($blog)) {
  header('Location: blogs.php');
}

$prev = mysqli_fetch_array(mysqli_query($cn, "SELECT id FROM `blogs` WHERE id<$blogId ORDER BY id DESC LIMIT 1"))['id'];
$next = mysqli_fetch_array(mysqli_query($cn, "SELECT id FROM `blogs` WHERE id>$blogId ORDER BY id ASC LIMIT 1"))['id'];

?>


<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $blog['image'] ?>">
  <div class="parallax-content container">
    <h1 class="carousel-title"><?php echo $blog['title'] ?></h1>
  </div>
</div>


<div class="bg-color-sky-light">
  <div class="content-lg container">
    <div class="row margin-b-20">
      <div class="col-md-12 margin-b-30">
        <p style="color: #000"><?php echo $blog['description'];  ?></p>
      </div>
    </div>
    <p><i class='fa fa-lg fa-calendar' style='color: #17bed2;'></i> &nbsp <?php echo date('jS F, Y', strtotime($blog['created_at'])) ?></p>
    <div class="row">
      <div class="col-md-12" style="display: flex; justify-content: center;">
        <a href="blog.php?blog=<?php if(isset($prev)) { echo $prev; } ?>" <?php if(!isset($prev)) { echo "disabled"; } ?> class="btn-info btn text-uppercase margin-r-20">Previous</a>
        <a href="blog.php?blog=<?php if(isset($next)) { echo $next; } ?>" <?php if(!isset($next)) { echo "disabled"; } ?> class="btn-info btn text-uppercase margin-l-20">Next</a>
      </div>
    </div>
  </div>
</div>

<?php include_once('./includes/scripts.php'); ?>
<script src="vendor/jquery.parallax.min.js" type="text/javascript"></script>
<?php include_once('./includes/footer.php'); ?>