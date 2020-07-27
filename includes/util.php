<?php

function uploadFile($file) {
  $target_dir = "storage/";
  $target_file_path = $target_dir . time() . basename($file["name"]);

  return (move_uploaded_file($file["tmp_name"], $target_file_path)) ? $target_file_path : false;
}

function movefile($temp_name, $basename) {
  $target_dir = "storage/";
  $target_file_path = $target_dir . time() . $basename;

  return (move_uploaded_file($temp_name, $target_file_path)) ? $target_file_path : false;
}

function checkFileType($extension, $type = "image") {
  if($type == "video") {
    return ($extension != "mp4") ? false : true;
  } elseif($type == "image") {
    return ($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif") ? false : true;
  }
}

function validType($file, $type = "image") {
  $fileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
  if($type == "video") {
    return ($fileType != "mp4") ? false : true;
  } elseif($type == "image") {
    return ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") ? false : true;
  }
}

function sanitizeInquiryForm($POST) {
 	$name = FormSanitizer::sanitizeFormNameNumber($POST['name']);
 	$position = FormSanitizer::sanitizeFormNameNumber($POST['position']);
 	$company = FormSanitizer::sanitizeFormNameNumber($POST['company']);
  $email = FormSanitizer::sanitizeFormEmail($POST['email']);
  $phone = FormSanitizer::sanitizeFormNameNumber($POST['phone']);
  $productTitle = FormSanitizer::sanitizeFormNameNumber($POST['productTitle']);
  $destinationPort = FormSanitizer::sanitizeFormNameNumber($POST['destinationPort']);
  $message = $POST['message'];
  return "INSERT INTO `inquiries` (name, position, company, email, phone, message, product, destination_port) VALUES('$name', '$position', '$company', '$email', '$phone', '$message', '$productTitle', '$destinationPort')";
}

function recordSanitize($POST) {
 	$name = FormSanitizer::sanitizeFormNameNumber($POST['name']);
  $email = FormSanitizer::sanitizeFormEmail($POST['email']);
  $phone = FormSanitizer::sanitizeFormNameNumber($POST['phone']);
  $message = $POST['message'];
  return "INSERT INTO `feedbacks` (name, email, phone, message) VALUES('$name', '$email', '$phone', '$message')";
}
