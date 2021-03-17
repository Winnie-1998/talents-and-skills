<?php
session_start(); ?>
<!doctype html>
<html>

<head>
  <title>Talent And Skills Center</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/bootstrap.css">
  <link href="css/carousel.css" rel="stylesheet">
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
              <li><a href="loginroute.php">Auditions</a></li>
              <li><a href="dashboard.php">Dashboard</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
              <?php if (isset($_SESSION['id'])) { ?>
                <li><a href="logout.php">Logout</a></li>
              <?php } else { ?>
                <li><a href="registration.php">Signup</a></li>
                <li><a href="loginroute.php">Login</a></li>
              <?php } ?>
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
            <p style="color:#24141e">The Showcase is a safe, educational, family-oriented way to upload your talents so that anyone visting the page can have a look at. If it is an event organizer, he/she will book you to offer your services in their event.</p>
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
            <p style="color:#24141e">Auditions are held throughout the Kenya for people from the age of four (4) and above who are interested in modeling, acting, singing, dancing, carpentry and so much more..... </p>
            <p><?php if (isset($_SESSION['id'])) { ?>

              <?php } else { ?>
                <li><a href="loginroute.php" class="btn btn-lg btn-primary">Login</a></li>
              <?php } ?></a></p>
          </div>
        </div>
      </div>
      <div class="item">
        <img class="third-slide" src="img/3.jpg" alt="Third slide">
        <div class="container">
          <div class="carousel-caption">
            <h1 style="color:#53b7f4">Search Thousands of Talented Users</h1>
            <p style="color:#24141e">Easily locate the talents or skills in the town you plan to host your next event with a click of a batton</p>
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

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading">Talented or skilled in anything? <span class="text-muted">At Talent Center we value your talent.</span></h2>
      <p class="lead">Showcase your talent here and let people see what you can offer. Potential event organizers will find you and utilze your talent. And just like that, you earn from your talent.</p>
    </div>
    <div class="col-md-5">
      <img class="featurette-image img-responsive center-block" src="img/image1.jpg" alt="Generic placeholder image">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 col-md-push-5">
      <h2 class="featurette-heading">We need yor talent or skill. <span class="text-muted">Post your talent or skill here..</span></h2>
      <p class="lead">We visit here to hunt for your talent and skill. Keep posting your talents and or skill. We go round the country scouting for talents and skills to grace our events in the various cities and towns in Kenya.</p>
    </div>
    <div class="col-md-5 col-md-pull-7">
      <img class="featurette-image img-responsive center-block" src="img/t9.jpg" alt="Generic placeholder image">
    </div>
  </div>

  <!--<hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
      <p class="lead">You Got Your Dream Motivation And role Model</p>
    </div>
    <div class="col-md-5">
      <img class="featurette-image img-responsive center-block" src="img/4.jpg" alt="Generic placeholder image">
    </div>
  </div>

  <hr class="featurette-divider">-->

  <!-- /END THE FEATURETTES -->
  <!-- Marketing messaging and featurettes
    ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <!--<div class="container marketing">-->

    <!-- Three columns of text below the carousel 
    <div class="jumbotron">
      <h1 class="text-center">Team</h1>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <img class="img-circle" src="img/user4.jpg" alt="Generic placeholder image" width="140" height="140">
        <h2>test dev 3</h2>
      </div><
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
      <p>&copy; 2020 JobsFinder &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
      window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')
    </script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>