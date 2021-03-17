<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['approve'])) {
	$id = $_GET['approve'];
	$adn = "UPDATE talentbooking SET status='Approved' WHERE talentname=?";
	$stmt = $mysqli->prepare($adn);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
	echo "<script>alert('Booking Approved');</script>";
	header("location:approvemybookings.php");
}

if (isset($_GET['deny'])) {
	$id = $_GET['deny'];
	$adn = "UPDATE talentbooking SET status='Denied' WHERE talentname=?";
	$stmt = $mysqli->prepare($adn);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();
	echo "<script>alert('Booking Denied');</script>";
	header("location:approvemybookings.php");
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
	<title>My Bookings</title>
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
	<?php include('includes/header.php'); ?>

	<div class="ts-main-content">
		<?php include('includes/sidebar.php'); ?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">My Bookings</h2>
						<div class="panel panel-default">
							<div class="panel-heading"> Bookings Details</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Sno.</th>
											<th>Full name</th>
											<th>Contact no</th>
											<th>Talent Name</th>
											<th>Venue</th>
											<th> Booking Fees</th>
											<th>Booking Date</th>
											<th>Booking Time</th>
											<th>Status</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Sno.</th>
											<th>Full name</th>
											<th>Contact no</th>
											<th>Talent Name</th>
											<th>Venue</th>
											<th> Booking Fees</th>
											<th>Booking Date</th>
											<th>Booking Time</th>
											<th>Status</th>
										</tr>
									</tfoot>
									<tbody>
										<?php
										$aid = $_SESSION['id'];
										$ret = "select * from talentbooking WHERE targetid='$aid' && status='Approved'";
										$stmt = $mysqli->prepare($ret);
										//$stmt->bind_param('i',$aid);
										$stmt->execute(); //ok
										$res = $stmt->get_result();
										$cnt = 1;
										while ($row = $res->fetch_object()) {
											$aid2 =$row->userid;
											$query = ("SELECT * FROM userregistration  WHERE id='$aid2'");
											$result = mysqli_query($mysqli, $query) or die(mysqli_error($con));
											$rowuser = mysqli_fetch_array($result, $resulttype = MYSQLI_BOTH);

											$fullname = $rowuser['firstName'] . ' ' . $rowuser['lastName'];

											$query1 = ("SELECT * FROM talentshowcase  WHERE useruid='$aid'");
											$result1 = mysqli_query($mysqli, $query1) or die(mysqli_error($con));
											$rowuser1 = mysqli_fetch_array($result1, $resulttype = MYSQLI_BOTH);
										?>
											<tr>

												<td><?php echo $cnt;; ?></td>
												<td><?php echo $fullname ?></td>
												<td><?php echo $rowuser['contactNo']; ?></td>
												<td><?php echo $row->talentname; ?></td>												
												<td><?php echo $row->venue; ?></td>
												<td><?php echo "Ksh. ". $row->booking_fee; ?></td>
												<td><?php echo $row->date_booked; ?></td>
												<td><?php echo $row->time_booked; ?></td>
												<td> <?php echo "Awaiting down-Payment" ?></td>
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

</body>

</html>