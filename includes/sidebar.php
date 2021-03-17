<nav class="ts-sidebar">
	<ul class="ts-sidebar-menu">

		<li class="ts-label">Main</li>
		<?PHP if (isset($_SESSION['id'])) { ?>
			<li><a href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>
			<li><a href="my-profile.php"><i class="fa fa-user"></i> My Profile</a></li>
			<li><a href="my-location.php"><i class="fa fa-user"></i> My Location</a></li>
			<li><a href="change-password.php"><i class="fa fa-files-o"></i>Change Password</a></li>
			<li><a href="talentshowcase.php"><i class="fa fa-file-o"></i>New Talent Showcase</a></li>
			<li><a href="managetshowcase.php"><i class="fa fa-file-o"></i>Manage Talent Showcase</a></li>
			<li><a href="approvemybookings.php"><i class="fa fa-file-o"></i>Approve My Bookings</a></li>
			<li><a href="mybookings.php"><i class="fa fa-file-o"></i>My Bookings</a></li>
			<li><a href="managebookings.php"><i class="fa fa-file-o"></i>Manage my Bookings</a></li>
			<li><a href="hiredtalents.php"><i class="fa fa-file-o"></i>Hired Talents</a></li>
			<li><a href="payment_history.php"><i class="fa fa-file-o"></i>Payments History</a></li>
			<li><a href="access-log.php"><i class="fa fa-file-o"></i>Access log</a></li>
		<?php } else { ?>

			<li><a href="registration.php"><i class="fa fa-files-o"></i> User Registration</a></li>
			<li><a href="login.php"><i class="fa fa-users"></i> User Login</a></li>
			<li><a href="admin"><i class="fa fa-user"></i> Admin Login</a></li>
		<?php } ?>

	</ul>
</nav>
