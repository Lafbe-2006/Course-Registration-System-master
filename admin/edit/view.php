<?php 
session_start();
include('../../includes/config.php');

if (isset($_GET['id'])) {
    $Enrollment_No =$_GET['id'];

    // Use prepared statement to select student data
    $stmt = mysqli_prepare($database, "SELECT * FROM Student WHERE Enrollment_No = ?");
    mysqli_stmt_bind_param($stmt, "s", $Enrollment_No);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $query = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$query) {
        header('location: ../registered_students.php');
        exit();
    }
} else {
    header('location: ../registered_students.php');
    exit();
}

if (isset($_POST['submit'])) {
    $First_Name     =$_POST['First_Name'];
    $Last_Name      =$_POST['Last_Name'];
    $Department     =$_POST['Department'];
    $SGPA           =$_POST['SGPA'];
    $CGPA           =$_POST['CGPA'];
    $Category       =$_POST['Category'];
    $Semester       =$_POST['Semester'];
    $Fee_Amount     =$_POST['Fee_Amount'];
    $Journal_Number =$_POST['Journal_Number'];
    $Subject_1      =$_POST['Subject_1'] ?? '';
    $Subject_2      =$_POST['Subject_2'] ?? '';
    $Subject_3      =$_POST['Subject_3'] ?? '';
    $Subject_4      =$_POST['Subject_4'] ?? '';
    $Subject_5      =$_POST['Subject_5'] ?? '';

    // Prepared statement to prevent SQL injection
    $update_sql = "UPDATE `Student` SET 
        `First_Name` = ?, 
        `Last_Name` = ?, 
        `Department` = ?, 
        `Journal_Number` = ?, 
        `Category` = ?, 
        `Semester` = ?,
        `SGPA` = ?,
        `CGPA` = ?,
        `Fee_Amount` = ?,
        `Subject_1` = ?, 
        `Subject_2` = ?, 
        `Subject_3` = ?, 
        `Subject_4` = ?, 
        `Subject_5` = ? 
        WHERE `Enrollment_No` = ?";

    $stmt_update = mysqli_prepare($database,$update_sql);
    mysqli_stmt_bind_param(
        $stmt_update, 
        "sssssiddsssssss", 
        $First_Name, $Last_Name,$Department, $Journal_Number,$Category, 
        $Semester,$SGPA, $CGPA,$Fee_Amount, 
        $Subject_1,$Subject_2, $Subject_3,$Subject_4, $Subject_5,$Enrollment_No
    );

    if (mysqli_stmt_execute($stmt_update)) {$_SESSION['msg'] = "Student Record updated Successfully !!";
        header('location: ../admin_panel.php');
        exit();
    } else {
        $_SESSION['msg'] = "Error : Student Record not updated";
    }
    mysqli_stmt_close($stmt_update);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel // Edit Registration</title>

    <link href="../../others/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="../../others/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link href="../../others/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../../others/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link href="../../others/css/main.css" rel="stylesheet" media="all">

    <script type="text/javascript">
    function confSubmit(form) {
        if (confirm("Are you sure you want to submit the form?")) {
            return true;
        } else {
            return false;
        }
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
                    <h2 class="title">Enrollment No: <?php echo htmlentities($Enrollment_No); ?></h2>
                </div>
                <div class="card-body">
                    <form name="admin" method="post" onSubmit="return confSubmit(this);">
                        
                        <!-- Name Field -->
                        <div class="form-row m-b-55">
                            <div class="name">Name</div>
                            <div class="row row-space">
                                <div class="col-2">
                                    <div class="input-group-desc">
                                        <input class="input--style-5" type="text" name="First_Name" value="<?php echo htmlentities($query['First_Name'] ?? ''); ?>" required>
                                        <label class="label--desc">First name</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group-desc">
                                        <input class="input--style-5" type="text" name="Last_Name" value="<?php echo htmlentities($query['Last_Name'] ?? ''); ?>" required>
                                        <label class="label--desc">Last name</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enrollment Number Field -->
                        <div class="form-row">
                            <div class="name">Enrollment Number</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="Enrollment_Number" value="<?php echo htmlentities($Enrollment_No); ?>" pattern="[a-zA-Z0-9-]+" required>
                                </div>
                            </div>
                        </div>

                        <!-- Department Field -->
                        <div class="form-row">
                            <div class="name">Department</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="Department" value="<?php echo htmlentities($query['Department'] ?? ''); ?>" pattern="[a-zA-Z0-9\s&,-]+" required>      
                                </div>
                            </div>
                        </div>

                        <!-- Semester Field -->
                        <div class="form-row">
                            <div class="name">Semester</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="number" name="Semester" value="<?php echo htmlentities($query['Semester'] ?? ''); ?>" min="1" max="14" required>      
                                </div>
                            </div>
                        </div>

                        <!-- Grades Field -->
                        <div class="form-row m-b-55">
                            <div class="name">Grades</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="number" step="0.01" name="SGPA" value="<?php echo htmlentities($query['SGPA'] ?? ''); ?>" min="0" max="10" required>
                                            <label class="label--desc">SGPA</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="number" step="0.01" name="CGPA" value="<?php echo htmlentities($query['CGPA'] ?? ''); ?>" min="0" max="10" required>
                                            <label class="label--desc">CGPA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Journal Number Field -->
                        <div class="form-row">
                            <div class="name">Journal Number</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="Journal_Number" value="<?php echo htmlentities($query['Journal_Number'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Fee Amount Field -->
                        <div class="form-row">
                            <div class="name">Fee Amount: </div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="number" name="Fee_Amount" value="<?php echo htmlentities($query['Fee_Amount'] ?? ''); ?>" min="1" max="999999" required>
                                </div>
                            </div>
                        </div>

                        <!-- Category Field -->
                        <div class="form-row">
                            <div class="name">Category</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="Category" value="<?php echo htmlentities($query['Category'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Subjects Dropdowns (1 to 5) -->
                        <?php 
                        for ($i = 1; $i <= 5; $i++) {$current_subj = $query["Subject_$i"] ?? '';
                        ?>
                            <div class="form-row">
                                <div class="name">Subject <?php echo $i; ?></div>
                                <div class="value">
                                    <div class="input-group">
                                        <div class="rs-select2 js-select-simple select--no-search">
                                            <select name="Subject_<?php echo $i; ?>" required>
                                                <option value="" disabled <?php echo empty($current_subj) ? 'selected' : ''; ?>>Select Subject</option>
                                                <?php 
                                                $subject_query = mysqli_query($database, "SELECT DISTINCT Course_Code FROM Subjects");
                                                while ($row = mysqli_fetch_array($subject_query)) {$selected = ($row[0] ==$current_subj) ? 'selected' : '';
                                                    echo "<option value='" . htmlentities($row[0]) . "' $selected>" . htmlentities($row[0]) . "</option>";
                                                } 
                                                ?>
                                            </select>
                                            <div class="select-dropdown"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div>
                            <button name="submit" class="btn btn--radius-2 btn--red" type="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../others/vendor/jquery/jquery.min.js"></script>
    <script src="../../others/vendor/select2/select2.min.js"></script>
    <script src="../../others/vendor/datepicker/moment.min.js"></script>
    <script src="../../others/vendor/datepicker/daterangepicker.js"></script>
    <script src="../../others/js/global.js"></script>

</body>
</html>