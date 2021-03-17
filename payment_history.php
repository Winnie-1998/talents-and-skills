<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
$error = "";

$user_id = $_SESSION['id'];

if (isset($_GET['rate'])) {
  $stars = $_GET['rate'];
  $talent_id = $_GET['talentId'];
  $talent_showcase_id = $_GET['showcase_id'];
  $user_id = $_SESSION['id'];


  $query = "delete from talent_ratings where user_id='$user_id' and talent_id='$talent_id'";
  mysqli_query($mysqli, $query);

  $query = "insert into talent_ratings values ('$user_id','$talent_id','$talent_showcase_id','$stars')";
  mysqli_query($mysqli, $query);


  header("location:payment_history.php");

}

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

     <title>Payment History</title>
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
     <link rel="stylesheet" href="css/bootstrap-social.css">
     <link rel="stylesheet" href="css/bootstrap-select.css">
     <link rel="stylesheet" href="css/fileinput.min.css">
     <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
     <link rel="stylesheet" href="css/style.css">

     <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
     <script src="js/jquery.star-rating-svg.js"></script>
     <link rel="stylesheet" type="text/css" href="css/star-rating-svg.css">



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
                             <h2 class="page-title">View Your Payment History</h2>

                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="panel panel-primary">

                                         <div class="panel-body">
                                             <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                 <thead>
                                                     <tr>
                                                         <th>Talent Name</th>
                                                         <th>Venue</th>
                                                         <th>Date Booked</th>
                                                         <th>Amount Paid</th>
                                                         <th>Date Paid</th>
                                                         <th>Rate Talent</th>
                                                     </tr>
                                                 </thead>
                                                 <tfoot>
                                                     <tr>
                                                       <th>Talent Name</th>
                                                       <th>Venue</th>
                                                       <th>Date Booked</th>
                                                       <th>Amount Paid</th>
                                                       <th>Date Paid</th>
                                                       <th>Rate Talent</th>
                                                     </tr>
                                                 </tfoot>
                                                 <tbody>
                                                   <?php
                                                    $query = "select * from payment_history where user_id=$user_id";
                                                    $talents = mysqli_query($mysqli,$query);

                                                    $count = 1;
                                                    while ($row = mysqli_fetch_array($talents)) {
                                                      $talent_id = $row['talent_id'];
                                                      $query = "select * from talentbooking where id='$talent_id'";

                                                      $result= mysqli_fetch_array(mysqli_query($mysqli, $query));

                                                      $talent_name = $result['talentname'];
                                                      $telent_venue = $result['venue'];
                                                      $date_booked = $result['date_booked'];

                                                      $query = "select id from talentshowcase where talentname=(select talentname from talentbooking where id = '$talent_id')";
                                                      $talent_showcase_id = mysqli_fetch_array(mysqli_query($mysqli,$query))['id'];

                                                      $fee = $row['amount'];
                                                      $date_paid = $row['date_time'];

                                                      $rate_class_name = ".rate".$count;

                                                      echo "<tr><td>$talent_name</td><td>$telent_venue</td><td>$date_booked</td><td>$fee</td><td>$date_paid</td>";
                                                      $query = "select stars from talent_ratings where user_id = '$user_id' and talent_id = '$talent_id'";
                                                      if (mysqli_num_rows(mysqli_query($mysqli,$query)) != 0) {
                                                        $stars = mysqli_fetch_array(mysqli_query($mysqli,$query))['stars'];
                                                      }else {
                                                        $stars = 0;
                                                      }

                                                    ?>

                                                      <td>
                                                        <div class="my-rating"></div>
                                                        <script type="text/javascript">
                                                        $(".my-rating").starRating({
                                                           initialRating: <?php echo "$stars";?>,
                                                           strokeColor: '#894A00',
                                                           useFullStars: true,
                                                           strokeWidth: 10,
                                                           starSize: 25,
                                                           callback: function(currentRating, $el){
                                                              alert('You have rated ' + currentRating + ' stars');
                                                              window.location.href = "?rate="+currentRating+"&talentId="+<?php echo $talent_id;?>+"&showcase_id="+<?php echo "$talent_showcase_id";?>;

                                                            }
                                                           });
                                                        </script>
                                                      </td>

                                                    </tr>

                                                  <?php
                                                    $count++;
                                                  }
                                                  ?>
                                                 </tbody>

                                               </table>
                                             </div>
                                           </div>
                                         </div>
