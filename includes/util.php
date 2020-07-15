<?php

function uploadFile($file) {
  $target_dir = "storage/";
  $target_file_path = $target_dir . time() . basename($file["name"]);

  return (move_uploaded_file($file["tmp_name"], $target_file_path)) ? $target_file_path : false;
}

function validType($file, $type) {
  $fileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
  if($type == "video") {
    return ($fileType != "mp4") ? false : true;
  } elseif($type == "image") {
    return ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") ? false : true;
  }
}

function recordSanitize($POST) {
 	$name = FormSanitizer::sanitizeFormNameNumber($POST['name']);
  $email = FormSanitizer::sanitizeFormEmail($POST['email']);
  $phone = FormSanitizer::sanitizeFormNameNumber($POST['phone']);
  $message = $POST['message'];
  $check = $_POST['check'];
  return "INSERT INTO `inquiries` (name, email, phone, message, check_mode) VALUES('$name', '$email', '$phone', '$message', '$check')";
}
