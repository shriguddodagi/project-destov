<?php

function uploadFile($file) {
  $target_dir = "storage/";
  $target_file_path = $target_dir . time() . basename($file["name"]);

  return (move_uploaded_file($file["tmp_name"], $target_file_path)) ? $target_file_path : false;
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
  $message = $POST['message'];
  return "INSERT INTO `inquiries` (name, position, company, email, phone, message, product) VALUES('$name', '$position', '$company', '$email', '$phone', '$message', '$productTitle')";
}

function recordSanitize($POST) {
 	$name = FormSanitizer::sanitizeFormNameNumber($POST['name']);
  $email = FormSanitizer::sanitizeFormEmail($POST['email']);
  $phone = FormSanitizer::sanitizeFormNameNumber($POST['phone']);
  $message = $POST['message'];
  return "INSERT INTO `feedbacks` (name, email, phone, message) VALUES('$name', '$email', '$phone', '$message')";
}
