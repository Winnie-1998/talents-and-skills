<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
$error = "";

$user_id = $_SESSION['id'];
$location = $_GET['location'];
?>
 <!doctype html>
 <html lang="en" class="no-js">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
     <meta name="description" content="">
     <meta name="author" content="">
     <meta name="theme-color" content="#3e454c">

     <title>My Location</title>
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
     <link rel="stylesheet" href="css/bootstrap-social.css">
     <link rel="stylesheet" href="css/bootstrap-select.css">
     <link rel="stylesheet" href="css/fileinput.min.css">
     <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
     <link rel="stylesheet" href="css/style.css">


 </head>

 <body>
     <?php include("includes/header.php"); ?>

     <div class="ts-main-content">
         <?php include("includes/sidebar.php"); ?>
         <div class="content-wrapper">
             <div class="container-fluid">

                 <div class="row">
                     <div class="col-md-12">

                         <div class="container-fluid">
                             <h2 class="page-title">View Talents Location In : <?php echo $location; ?></h2>

                             <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127642.59193203965!2d36.834508799999995!3d-1.2746751999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d42c1ed121%3A0xe29eb9dee3e08817!2sNairobi%20CBD!5e0!3m2!1sen!2ske!4v1609678933697!5m2!1sen!2ske" width="800" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
                                <!-- <iframe src="http://maps.google.com/maps?q=<?php echo $location; ?>" width="800" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->



                <?php echo '<iframe width="100%" height="600" frameborder="0" src="https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' . str_replace(",", "", str_replace(" ", "+", $location)) . '&z=14&output=embed"></iframe>';?>
