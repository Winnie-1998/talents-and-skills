<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
$error = "";


if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "delete from talentbooking where talentname=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Talent Deleted');</script>";
}

if (isset($_GET['pay'])) {
    $talent_id = $_GET['pay'];
    $talent_showcase_id = $_GET['showcase_id'];
    $mobile_number = $_GET['number'];

    $user_id = $_SESSION['id'];

    $query = "select booking_fee from talentbooking where id='$talent_id'";

    try {
      $result = mysqli_query($mysqli, $query);
      $fee = mysqli_fetch_array($result)['booking_fee'];
    } catch (Exception $e) {
      $fee = 400;
    }
    // echo "<script>confirm('Do you want to pay Ksh.$fee for this talent?');</script>";
    $query = "select * from payment_history where user_id='$user_id' and talent_id='$talent_id'";
    if (mysqli_num_rows(mysqli_query($mysqli,$query)) >0) {
      echo '<script>alert("Failed\nYou already made this payment!!!");</script>';
    }else{
      //header('location:payment_history.php');

      // Initialize the variables
      $consumer_key = 'XUoqTzugqww0ew1wuLGGgpkwaN6BERW2';
      $consumer_secret = 'fhnmOKzU2dYl6vk4';
      $BusinessShortCode = '174379';
      $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
      $TransactionType = 'CustomerPayBillOnline';
      $tokenUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
      $phone = $mobile_number;

      $lipaOnlineUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
      $amount = $fee;
      $CallBackURL = 'https://2f50f430.ngrok.io/callback.php?key=Your$trongPssWard';
      $timestamp = date("Ymdhis");
      $password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $timestamp);

      // Generate the auth token
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $tokenUrl);
      $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $curl_response = curl_exec($curl);

      $token = json_decode($curl_response)->access_token;

      // Initiate the STK Push
      $curl2 = curl_init();
      curl_setopt($curl2, CURLOPT_URL, $lipaOnlineUrl);
      curl_setopt($curl2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));


      $curl2_post_data = [
          'BusinessShortCode' => $BusinessShortCode,
          'Password' => $password,
          'Timestamp' => $timestamp,
          'TransactionType' => $TransactionType,
          'Amount' => $amount,
          'PartyA' => $phone,
          'PartyB' => $BusinessShortCode,
          'PhoneNumber' => $phone,
          'CallBackURL' => $CallBackURL,
          'AccountReference' => 'Talents And Skills Showcase',
          'TransactionDesc' => 'Test',
      ];

      $data2_string = json_encode($curl2_post_data);

      curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl2, CURLOPT_POST, true);
      curl_setopt($curl2, CURLOPT_POSTFIELDS, $data2_string);
      curl_setopt($curl2, CURLOPT_HEADER, false);
      curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, 0);
      $curl2_response = json_decode(curl_exec($curl2));

      // echo json_encode($curl2_response, JSON_PRETTY_PRINT);

      $query = "insert into payment_history (user_id, talent_id, talent_showcase_id, amount) values('$user_id','$talent_id','$talent_showcase_id','$fee')";
      mysqli_query($mysqli, $query);
      echo "<script>alert('Please enter your M-Pesa pin...');</script>";

  }
  echo "<script>window.location.href='payment_history.php';</script>";

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

    <title>Hired Talents</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript">
      function rateTalent(talentId) {
        var stars = document.getElementById("rate"+talentId).value;
        //var talent_id = document.getElementById("rate"+).getAttribute("talent_id");
        window.location.href = "?rate="+stars+"&talent="+talentId;
      }
    </script>


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
                            <h2 class="page-title">View All Hired Talents</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">

                                        <div class="panel-body">
                                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>talentname</th>
                                                        <th>Full name</th>
                                                        <th>venue</th>
                                                        <th>date</th>
                                                        <th>Time</th>
                                                        <th>city</th>
                                                        <th>image</th>
                                                        <th>status</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>talentname</th>
                                                        <th>Full name</th>
                                                        <th>venue</th>
                                                        <th>date</th>
                                                        <th>Time</th>
                                                        <th>city</th>
                                                        <th>image</th>
                                                        <th>status</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $aid = $_SESSION['id'];
                                                    $ret = "select * from talentbooking WHERE userid='$aid'";
                                                    $stmt = $mysqli->prepare($ret);
                                                    //$stmt->bind_param('i',$aid);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    $cnt = 1;
                                                    while ($row = $res->fetch_object()) {
                                                        $aid2 =$row->targetid;
                                                        $query = ("SELECT * FROM userregistration  WHERE id='$aid2'");
                                                        $result = mysqli_query($mysqli, $query) or die(mysqli_error($con));
                                                        $rowuser = mysqli_fetch_array($result, $resulttype = MYSQLI_BOTH);

                                                        $stringtest = ("SELECT * FROM talentshowcase  WHERE talentname='$row->talentname'");
                                                        $result1 = mysqli_query($mysqli, $stringtest) or die(mysqli_error($mysqli));
                                                        $rowuser1 = mysqli_fetch_array($result1, $resulttype = MYSQLI_BOTH);

                                                        $talent_showcase_id = $rowuser1['id'];
                                                        $fname = $rowuser['firstName'] ." ". $rowuser['lastName'];
                                                        $images=$rowuser1['image'];
                                                        $image_arr=explode(",",$images)
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $cnt;; ?></td>
                                                            <td><?php echo $row->talentname; ?></td>
                                                            <td><?php echo $fname; ?></td>
                                                            <td><?php echo $row->venue; ?></td>
                                                            <td><?php echo $row->date_booked; ?></td>
                                                            <td><?php echo $row->time_booked; ?></td>
                                                            <td><?php echo $rowuser1['city']; ?></td>
                                                            <td><img src="uploads/<?php echo $image_arr[0]  ?>" width="100px" /></td>

                                                            <?php if ($row->status == "Pending") { ?>
                                                                <td><?php /*echo $row->status;*/ echo "Pending"  ?></td>
                                                            <?php } else if ($row->status == "Denied") { ?>
                                                                <td><?php /*echo $row->status;*/ echo "Denied"  ?></td>
                                                            <?php  } else {
                                                            ?>
                                                                <td><button class="btn btn-success" onclick="
                                                                  var number = prompt('Enter number You want to pay with');
                                                                  if(!number.startsWith('254')) alert('Enter number in 2547... format');
                                                                  else{
                                                                    window.location.href='hiredtalents.php?pay=<?php echo $row->id; ?>&showcase_id=<?php echo $talent_showcase_id; ?>&number='+number;
                                                                  }

                                                                  ">Proceed to Payment</button></td>
                                                            <?php } ?>
                                                            <!-- <td> <a href="hiredtalents.php?del=<?php //echo $row->talentname;
                                                                                                    ?>" class="btn btn-danger">Delete  <i class="fa fa-close">  </i></a></td> -->





                                                        </tr>
                                                    <?php
                                                        $cnt = $cnt + 1;
                                                    } ?>


                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>







                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

    <script type="text/javascript">
        function selected_image() {
            var image_name = $('#image').val();
            if (image_name == '') {
                alert("please select Image");
                return false;
            } else {
                var extension = $('#image').val();
                var p = extension.lastIndexOf(".");
                extension = extension.slice(p + 1, extension.length).toLowerCase();
                var ext = ["gif", "png", "jpeg", "jpg"];
                if (!ext.includes(extension)) {
                    alert('unapropriate file selection Please select image file.');
                    $('#image').val('');
                    return false;
                }
            }
        }
    </script>

    <script>
        window.onload = function() {

            // Line chart from swirlData for dashReport
            var ctx = document.getElementById("dashReport").getContext("2d");
            window.myLine = new Chart(ctx).Line(swirlData, {
                responsive: true,
                scaleShowVerticalLines: false,
                scaleBeginAtZero: true,
                multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
            });

            // Pie Chart from doughutData
            var doctx = document.getElementById("chart-area3").getContext("2d");
            window.myDoughnut = new Chart(doctx).Pie(doughnutData, {
                responsive: true
            });

            // Dougnut Chart from doughnutData
            var doctx = document.getElementById("chart-area4").getContext("2d");
            window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {
                responsive: true
            });

        }
    </script>

</body>




<style>
    .foot {
        text-align: center;
        border: 1px solid black;
    }
</style>

</html>
