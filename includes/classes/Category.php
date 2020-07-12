<?php

class Subcategory {
  private $id;
  private $cn;
  private $subcategoriesArray = array();


  function __construct($cn, $id) {
    $this->id = $id;
    $this->cn = $cn;

    $query = "SELECT * FROM `subcategories` WHERE category_id='$id'";
    $result = mysqli_query($cn, $query);

    while($row = mysqli_fetch_array($result)) {
      $this->subcategoriesArray[] = $row;
      
    }

  }

  public function subcategories() {
    return $this->subcategoriesArray;
  }

}











?>