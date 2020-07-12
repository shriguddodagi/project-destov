<?php
include_once('./config.php');

include_once('./includes/classes/Category.php');





$obj = new Category($cn, 2);
// $data = $obj->subcategories();
// var_dump($data);
// for ($i=0; $i < count($data); $i++) { 
//   echo $data[$i] . "<br />";
// }

foreach($obj->subcategories() as $row) {
  print($row['category_id'] . "<br />");
}
