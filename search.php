<?php
require_once("config.php"); 

if(isset($_POST['term']) && isset($_POST['productId'])) {
  $term = $_POST['term'];
  $search = mysqli_query($cn, "SELECT id, title, description, image FROM `products` WHERE title LIKE '$term%'");
  $result = "";
  while($row = mysqli_fetch_array($search)) {
    $result .= "<div class='row p-2' style='box-sizing: border-box'>
        <div class='col-3'>
          <img class='img img-fluid w-100 h-auto' src='". $row['image'] ."' alt='". $row['title'] ."'>
        </div>
        <div class='col-6'>
          <div class='h5'>". $row['title'] ."</div>
          <p>". $row['description'] ."</p>
        </div>
        <div class='col-3'>
          <form action='' method='post'>
            <input type='hidden' name='oldProductId' value='". $_POST['productId'] ."'>
            <input type='hidden' name='newProductId' value='". $row['id'] ."'>
            <button class='btn rounded-pill btn-primary' name='change' type='submit'>Choose</button>
          </form>
        </div>
      </div>";
  }
  if($result == "") {
    $result .= "<div class='row p-3'>
      <div class='h3'>
        No match found!
      </div>
    </div>";
  }
  echo $result;
}

?>