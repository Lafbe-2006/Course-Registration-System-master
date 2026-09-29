<?php 
session_start();

// FIXED: Changed relative path to go two levels up to find includes/config.php
include('../../includes/config.php');

if (isset($_POST['submit'])) {
    $Department    = $_POST['Department'];
    $Course_Code   = $_POST['Course_Code'];
    $Course_Title  = $_POST['Course_Title'];
    $Course_Credit = $_POST['Course_Credit'];

    // FIXED: Prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($database, "INSERT INTO Subjects (Department, Course_Code, Course_Title, Course_Credit) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssi", $Department, $Course_Code, $Course_Title, $Course_Credit);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Added Subjects !!";
        header('location: ../admin_panel.php');
        exit();
    } else {
        $_SESSION['msg'] = "Error : Subjects couldn't be Updated.";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel // Add Course</title>

    <!-- FIXED: Added ../.. to CSS paths -->
    <link href="../../others/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="../../others/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link href="../../others/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../../others/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link href="../../others/css/main.css" rel="stylesheet" media="all">

    <script type="text/javascript">
    function confSubmit(form) {
        return confirm("Are you sure you want to Add the Course?");
    }
    </script>

    <style>
        .page-wrapper {
            background: url("https://images.shiksha.com/mediadata/images/1510913480phpWe7tYs.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>

    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Add Course</h2>
                    <div class="title">
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo htmlentities($_SESSION['msg']);
                            unset($_SESSION['msg']);
                        }
                        ?>
                    </div>
                </div> <!-- FIXED: Added missing closing div tag here -->

                <div class="card-body">
                    <form name="admin" method="post" onSubmit="return confSubmit(this);">
                        <div class="form-row m-b-55">
                            <div class="name">Course Details</div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-desc">
                                        <input class="input--style-5" type="text" name="Course_Title" required>
                                        <label class="label--desc">Course Name</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-desc">
                                        <input class="input--style-5" type="text" name="Course_Code" required>
                                        <label class="label--desc">Course Code</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="name">Course Credits</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="number" min="1" max="7" name="Course_Credit" required>
                                </div>
                            </div>
                        </div>  

                        <div class="form-row">
                            <div class="name">Department</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="Department" required>
                                </div>
                            </div>
                        </div>  

                        <div>
                            <button name="submit" class="btn btn--radius-2 btn--red" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>

    <!-- FIXED: Added ../.. to JS paths -->
    <script src="../../others/vendor/jquery/jquery.min.js"></script>
    <script src="../../others/vendor/select2/select2.min.js"></script>
    <script src="../../others/vendor/datepicker/moment.min.js"></script>
    <script src="../../others/vendor/datepicker/daterangepicker.js"></script>
    <script src="../../others/js/global.js"></script>

</body>
</html>