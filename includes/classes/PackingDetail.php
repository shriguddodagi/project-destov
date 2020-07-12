<?php
class PackingDetail {
  private $packingDetailArray = array();

  function __construct($cn, $id) {
    $query = "SELECT * FROM `packing_specifications` WHERE product_id='$id'";
    $result = mysqli_query($cn, $query);

    while($row = mysqli_fetch_array($result)) {
      $this->packingDetailArray[] = $row;
    }
  }

  public function packingDetails() {
    return $this->packingDetailArray;
  }
}