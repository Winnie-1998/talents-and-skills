<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
$mresult = "";
if (isset($_GET['book'])) {
    $talentname = $_GET['book'];

    $aid = $_SESSION['id'];
    $venue = $_POST['talentvenue'];
    $today = date("Y-m-d H:i:s");
    $date = strtotime("+7 day");
    $bookingday = date('M d, Y', $date);

    $query = ("SELECT * FROM talentshowcase  WHERE talentname='$talentname'");
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($con));
    $rowuser = mysqli_fetch_array($result, $resulttype = MYSQLI_BOTH);

    $targetid = $rowuser['useruid'];


    $sql = "INSERT INTO talentbooking(userid,targetid,talentname,date_booked,venue,status) values ('$aid','$targetid','$talentname','$bookingday','Pending')";
    if (mysqli_query($mysqli, $sql)) {
        echo '<script>alert("Booking successfully")</script>';
    } else {
        echo '<script>alert("Error in Booking")</script>' . mysqli_error($mysqli);
        $error = mysqli_error($mysqli);
    }
}




?>
<!doctype html>
<html>

<head>
    <title>Talent And Skills Center</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/carousel.css" rel="stylesheet">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="js/jquery.star-rating-svg.js"></script>
    <link rel="stylesheet" type="text/css" href="css/star-rating-svg.css">

</head>

<body>
    <!-- NAVBAR -->
    <div class="navbar-wrapper">
        <div class="container">

            <nav class="navbar navbar-inverse navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">Talent Finder</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="talentlist.php">Browse Talents</a></li>
                            <!--<li><a href="skillslist.php">Browse Skills</a></li>-->
                            <li><a href="auditions.php">Auditions</a></li>
                            <li><a href="dashboard.php">Dashboard</a></li>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <?php if (isset($_SESSION['id'])) : ?>
                                <li><a href="logout.php">Logout</a></li>
                            <?php else : ?>
                                <li><a href="registration.php">Signup</a></li>
                                <li><a href="loginroute.php">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!--Corsule -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="first-slide" src="img/1.jpg" alt="First slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 style="color:#53b7f4">Talent Showcase</h1>
                        <p style="color:#24141e">The Showcase is a safe, educational, family-oriented way to gain knowledge about the talent industry and connect with many Industry Professionals that are all under one roof at the same time, giving you undivided attention while you showcase your talents in front of them.</p>
                        <p><?php if (isset($_SESSION['id'])) { ?>
                                <li></li>
                            <?php } else { ?>
                                <li><a href="loginroute.php">Login</a></li>
                            <?php } ?></p>

                    </div>
                </div>
            </div>
            <div class="item">
                <img class="second-slide" src="img/2.jpg" alt="Second slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 style="color:#53b7f4">Auditions</h1>
                        <p style="color:#24141e">Auditions are held throughout the United States and Internationally for ages 4 and up that are interested in Modeling, Acting, Singing and Dancing. The Audition locations and dates are posted on our website, Facebook and Instagram. </p>
                        <p><?php if (isset($_SESSION['id'])) { ?>
                                <li></li>
                            <?php } else { ?>
                                <li><a href="loginroute.php">Login</a></li>
                            <?php } ?></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="third-slide" src="img/3.jpg" alt="Third slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 style="color:#53b7f4">Search Thousands of Talented Users</h1>
                        <p style="color:#24141e">Build and Post Your Resume and Access Thousands of Pages of Talents Info and Advice</p>
                        <p><a class="btn btn-lg btn-primary" href="talentlist.php" role="button">Browse Talents</a></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- START THE FEATURETTES -->

    <div class="container">
        <div class="row">
            <?php
            include('includes/config.php');

            $ret = "select * from talentshowcase";
            $stmt = $mysqli->prepare($ret);
            //$stmt->bind_param('i',$aid);
            $stmt->execute(); //ok
            $res = $stmt->get_result();
            $cnt = 1;
            while ($row = $res->fetch_object()) {

                $query = ("SELECT * FROM userregistration  WHERE id='$row->useruid;'");
                $result = mysqli_query($mysqli, $query) or die(mysqli_error($con));
                $rowuser = mysqli_fetch_array($result, $resulttype = MYSQLI_BOTH);
                $images = $row->image;
                $image_arr = explode(",", $images);


                $query = "SELECT avg(stars) 'stars' FROM talent_ratings WHERE talent_showcase_id='$row->id'";
                $stars = mysqli_fetch_array(mysqli_query($mysqli,$query))['stars'];


                if ($stars == "") {
                  $stars = 0 ;
                }

            ?>
                <div class="col-lg-4">
                    <div class="card" style="width: 28rem;">
                        <img class="card-img-top" src="uploads/<?php echo $image_arr[0]; ?>" style="width:100px;height:100px;" alt="Card image cap">

                        <div class="card-body">
                          <div class="my-rating"></div>
                          <script type="text/javascript">
                          $(".my-rating").starRating({
                             initialRating: <?php echo "$stars";?>,
                             readOnly: true,
                             useFullStars: true,
                             strokeWidth: 10,
                             starSize: 25
                             });
                          </script>



                            <h5 class="card-title"><?php echo $row->talentname; ?></h5>
                            <p class="card-text"><?php echo $row->description; ?>.</p>
                            <p class="card-text"><?php echo $row->city; ?>.</p>
                            <p class="card-text"><?php echo $rowuser['contactNo'];  ?>.</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_<?php echo $row->id; ?>">Book</button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href='my-location.php?location=<?php echo $row->city; ?>'">Show Location</button>

                            <br> <?php echo $mresult ?>
                            <div class="modal fade" id="exampleModal_<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Booking Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" class="mt" method="post">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Venue</label>
                                                    <input type="text" name="venue" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp" placeholder="Enter venue">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Date</label>
                                                    <input type="date" name="date" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Time</label>
                                                    <input type="time" name="times" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Booking fee</label>
                                                    <input type="text" name="fee" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Target talent</label>
                                                    <input type="text" name="target" value="<?php echo $row->talentname; ?>" readonly class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp" placeholder="Enter venue">
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php
            } ?>
            <?php
            if (isset($_POST['submit'])) {

                $talentname = $_POST['target'];
                $talentvenue = $_POST['venue'];
                $mdate = $_POST['date'];
                $mtime = $_POST['times'];
                $mfee = $_POST['fee'];
                $aid = $_SESSION['id'];

                $query = ("SELECT * FROM talentshowcase  WHERE talentname='$talentname'");
                $result = mysqli_query($mysqli, $query) or die(mysqli_error($con));
                $rowuser = mysqli_fetch_array($result, $resulttype = MYSQLI_BOTH);

                $targetid = $rowuser['useruid'];
                $sql = "INSERT INTO talentbooking(userid,targetid,talentname,date_booked,venue,time_booked,booking_fee,status) values ('$aid','$targetid','$talentname','$mdate','$talentvenue','$mtime','$mfee','Pending')";
                if (mysqli_query($mysqli, $sql)) {
                    echo '<script>alert("Booking successfully")</script>'; ?>
                    <script type="text/javascript">
                        location.href = 'hiredtalents.php';
                    </script>
            <?php } else {
                    echo '<script>alert("Error in Booking")</script>' . mysqli_error($mysqli);
                }
            }
            ?>
        </div>
    </div>
    <hr class="featurette-divider">





    <!-- /END THE FEATURETTES -->
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

        <!-- Three columns of text below the carousel -->
        <!--<div class="jumbotron">
            <h1 class="text-center">Team</h1>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="img/user4.jpg" alt="Generic placeholder image" width="140" height="140">
                <h2>test dev 3</h2>
            </div>
            <div class="col-lg-4">
                <img class="img-circle" src="img/user2.jpg" alt="Generic placeholder image" width="140" height="140">
                <h2>test dev 2</h2>
            </div>
            <div class="col-lg-4">
                <img class="img-circle" src="img/user1.jpg" alt="Generic placeholder image" width="140" height="140">
                <h2>test dev 1</h2>
            </div>
        </div>

        <hr class="featurette-divider">-->

        <!-- FOOTER -->
        <footer>
            <p class="pull-right"><a href="#">Back to top</a></p>
            <p>&copy; 2015 JobsFinder &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
            window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')
        </script>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>

</body>

</html>
