<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$error = "";

if (isset($_POST['submit'])) {
    

    // File upload configuration 
    $targetDir =  "uploads/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    $fileNames = array_filter($_FILES['files']['name']);
    if (!empty($fileNames)) {
        foreach ($_FILES['files']['name'] as $key => $val) {
            // File upload path 
            $fileName = basename($_FILES['files']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server 
                if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                    // Image db insert sql 
                    $insertValuesSQL .= $fileName.",";
                } else {
                    $errorUpload .= $_FILES['files']['name'][$key] . ' | ';
                }
            } else {
                $errorUploadType .= $_FILES['files']['name'][$key] . ' | ';
            }
        }

        if (!empty($insertValuesSQL)) {
            
            $talentname = $_POST['tname'];
            $mdate = $_POST['stayf'];
            $mabout = $_POST['descri'];
            $mcity = $_POST['city'];
            $aid = $_SESSION['id'];
            $now =date("Y-m-d H:i:s");
            // Insert image file name into database 
            $insert = "INSERT INTO talentshowcase (`useruid`,`talentname`,`description`,`city`,`image`,`date`) VALUES ('$aid','$talentname','$mabout','$mcity','$insertValuesSQL','$now')";
            if (mysqli_query($mysqli, $insert)) {
                $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . trim($errorUpload, ' | ') : '';
                $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . trim($errorUploadType, ' | ') : '';
                $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;
                $statusMsg = "Files are uploaded successfully." . $errorMsg;
                echo "<script>alert('Talent Added');</script>" ;
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.".mysqli_error($mysqli);
            }
        }
    } else {
        $statusMsg = 'Please select a file to upload.';
    }

    // Display status message 
    echo $statusMsg;
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

    <title>Talent Showcase</title>
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
                            <h2 class="page-title">Talent Showcase</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Fill all Info</div>
                                        <div class="panel-body">
                                            <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">


                                                <div class="form-group">
                                                    <h5><?php echo $error ?></h5>
                                                    <label class="col-sm-2 control-label">Talent Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="tname" id="seater" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Years of Experience</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="stayf" id="stayf" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Talent Description : </label>
                                                    <div class="col-sm-8">
                                                        <textarea rows="5" name="descri" id="address" class="form-control" required="required"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Address: </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="city" id="city" class="form-control" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Upload Image Using Your Talent : </label>
                                                    <div class="col-sm-8">
                                                        <input type="file" name="files[]" multiple accept="image/*" required id="image">
                                                    </div>
                                                </div>


                                                <div class="col-sm-6 col-sm-offset-4">
                                                    <button class="btn btn-default" type="submit">Cancel</button>
                                                    <input type="submit" name="submit" Value="Add Talent" class="btn btn-primary onclick=" selected_image();">
                                                </div>
                                            </form>

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