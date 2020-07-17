<?php

class Product {
  private $id;
  private $cn;
  private $productsArray = array();


  function __construct($cn, $id) {
    $this->id = $id;
    $this->cn = $cn;

    $query = "SELECT * FROM `products` WHERE subcategory_id='$id'";
    $result = mysqli_query($cn, $query);

    while($row = mysqli_fetch_array($result)) {
      $this->productsArray[] = $row;
    }

  }

  public function products() {
    return $this->productsArray;
  }

}
