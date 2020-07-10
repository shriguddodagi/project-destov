<?php 
  $cn = mysqli_connect("localhost", "root", "", "destov") or die("Connection Failed");
  mysqli_select_db($cn, 'destov');
  mysqli_query($cn, 'CREATE DATABASE IF NOT EXISTS destov;');
  mysqli_query($cn, "CREATE TABLE IF NOT EXISTS `admin` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL)
    ");
  mysqli_query($cn, "CREATE TABLE IF NOT EXISTS `inquiries` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      `company` varchar(100) NOT NULL,
      `email` varchar(50) NOT NULL,
      `phone` varchar(10) NOT NULL,
      `message` varchar(1000) NOT NULL,
      `status` boolean NULL DEFAULT 0,
      `created_at` date NOT NULL DEFAULT current_timestamp()
    )
  ");
  mysqli_query($cn, "CREATE TABLE `sliders` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `description` varchar(1000) NOT NULL,
    `image` varchar(100) NOT NULL,
    )
  ");
  
?>