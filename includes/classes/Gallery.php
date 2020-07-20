<?php

class Gallery {
  private $id;
  private $cn;
  private $imagesArray = array();

  function __construct($cn, $id) {
    $this->id = $id;
    $this->cn = $cn;

    $query = "SELECT * FROM `images` WHERE productId='$id'";
    $result = mysqli_query($cn, $query);

    while($row = mysqli_fetch_array($result)) {
      $this->imagesArray[] = $row;
    }
  }

  public function images() {

    return $this->imagesArray;
  }
}

?>