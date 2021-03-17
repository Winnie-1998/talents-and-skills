<?php if ($_SESSION['id']) { ?><div class="brand clearfix">
		<a href="#" class="logo" style="font-size:16px;">Talent And Skills Center</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<li><a href="talentlist.php">Browse Talents</a></li>
			<!--<li><a href="skillslist.php">Browse Skills</a></li>-->
			<li class="ts-account">
				<?php
				$aid = $_SESSION['id'];
				$query = ("SELECT * FROM userregistration  WHERE id='$aid'");
			     $result = mysqli_query($mysqli, $query) or die(mysqli_error($con));
			     $rowuser = mysqli_fetch_array($result, $resulttype = MYSQLI_BOTH);

			     $fullname = $rowuser['firstName'] ;

				?><a href="#"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> <?php echo $fullname ?> <i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="my-profile.php">My Account</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

			</li>
		</ul>
	</div>

<?php
} else { ?>
	<div class="brand clearfix">
		<a href="#" class="logo" style="font-size:16px;">Talent And Skills Center</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>

	</div>
<?php } ?>