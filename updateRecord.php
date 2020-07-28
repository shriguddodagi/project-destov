<?php
require_once "./config.php";

$imageIdsArray = $_POST['imageIds'];

$count = 1;
foreach ($imageIdsArray as $id) {
    if (mysqli_query($cn, "UPDATE `products` SET display_on_home='on', position='$count' WHERE id=$id")) {
        $response = 'Images Order is Updated';
    } else {
        $response = 'Error Occuer in Changing the Image Order';
    }
    $count++;
}
echo $response;
exit;
