<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
$error = "";
if (isset($_POST['submit'])) {
    if ($_FILES['image']['name'] != null) {
        // File upload path
        $targetDir = "uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);


        $file = addslashes(file_get_contents($_FILES['image']['name']));
        $talentname = $_POST['tname'];
        $mdate = $_POST['stayf'];
        $mabout = $_POST['descri'];
        $mcity = $_POST['city'];
        $sql = "INSERT INTO talentshowcase(talentname,date,description,city,image) values ('$talentname','$mdate','$mabout','$mcity','$targetFilePath')";
        if (mysqli_query($mysqli, $sql)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
            echo '<script>alert("File Inserted successfully")</script>';
        } else {
            echo '<script>alert("Error in insertion")</script>' . mysqli_error($mysqli);
            $error = mysqli_error($mysqli);
        }
    } else {
        echo '<script>alert("Please Select Image");</script>';
    }
}

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "delete from talentshowcase where id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Talent Deleted');</script>";
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

    <title>DashBoard</title>
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
                            <h2 class="page-title">View All My Talents</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">

                                        <div class="panel-body">
                                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>talentname</th>
                                                        <th>id Number</th>
                                                        <th>firstName</th>
                                                        <th>lastName</th>
                                                        <th>contactNo</th>
                                                        <th>date</th>
                                                        <th>description</th>
                                                        <th>city</th>
                                                        <th>image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>talentname</th>
                                                        <th>id Number</th>
                                                        <th>firstName</th>
                                                        <th>lastName</th>
                                                        <th>contactNo</th>
                                                        <th>date</th>
                                                        <th>description</th>
                                                        <th>city</th>
                                                        <th>image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $aid = $_SESSION['id'];
                                                    $ret = "select * from talentshowcase WHERE useruid='$aid'";
                                                    $stmt = $mysqli->prepare($ret);
                                                    //$stmt->bind_param('i',$aid);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    $cnt = 1;
                                                    while ($row = $res->fetch_object()) {

                                                        $query = ("SELECT * FROM userregistration  WHERE id='$aid'");
                                                        $result = mysqli_query($mysqli, $query) or die(mysqli_error($con));
                                                        $rowuser = mysqli_fetch_array($result, $resulttype = MYSQLI_BOTH);

                                                        $images = $row->image;
                                                        $image_arr = explode(",", $images)
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $cnt;; ?></td>
                                                            <td><?php echo $row->talentname; ?></td>
                                                            <td><?php echo $rowuser['regNo']; ?></td>
                                                            <td><?php echo $rowuser['firstName']; ?></td>
                                                            <td><?php echo $rowuser['lastName']; ?></td>
                                                            <td><?php echo $rowuser['contactNo']; ?></td>
                                                            <td><?php echo $row->date; ?></td>
                                                            <td><?php echo $row->description; ?></td>
                                                            <td><?php echo $row->city; ?></td>
                                                            <td><img src="uploads/<?php echo $image_arr[0] ?>" width="100px" /> <br>
                                                                <img src="uploads/<?php echo $image_arr[1] ?>" width="100px" />
                                                            </td>
                                                            <td> <a href="managetshowcase.php?del=<?php echo $row->id; ?>" class="btn btn-danger">Delete <i class="fa fa-close"> </i></a></td>
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