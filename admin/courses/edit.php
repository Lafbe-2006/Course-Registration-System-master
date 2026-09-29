<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME','course_registration_system');
$database = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

if(isset($_GET['del'])) {
    $code = mysqli_real_escape_string($database, $_GET['id']);
    mysqli_query($database, "DELETE FROM subjects WHERE Course_Code = '$code'");
    $_SESSION['delmsg'] = "Course deleted !!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses List</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background image with blur effect */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Replace with your image file name */
            background: url('Dorfic2.jpg') no-repeat center center;
            background-size: cover;
            filter: blur(8px); /* Adjust pixel amount to increase/decrease blur */
            transform: scale(1.05); /* Prevents white edges caused by blur */
            z-index: -1;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            background: rgba(18, 24, 38, 0.82);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.1);
        }

        .header-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        h2 {
            color: #ffffff;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .add-btn {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
        }

        .add-btn:hover {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.6);
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            background: rgba(255, 255, 255, 0.03);
        }

        th {
            background: rgba(255, 255, 255, 0.08);
            color: #38bdf8;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        td {
            padding: 14px 16px;
            color: #e2e8f0;
            font-size: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .action-link {
            text-decoration: none;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .action-edit {
            color: #38bdf8;
        }

        .action-edit:hover {
            background: rgba(56, 189, 248, 0.15);
        }

        .action-delete {
            color: #f87171;
        }

        .action-delete:hover {
            background: rgba(248, 113, 113, 0.15);
        }

        .separator {
            color: rgba(255, 255, 255, 0.3);
            margin: 0 4px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header-area">
            <h2>Courses List</h2>
            <a href="../courses/add_course.php" class="add-btn">+ Add New Course</a>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Department</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Course Credits</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $data = mysqli_query($database, "SELECT * FROM subjects");
                    $count = 0;
                    if ($data && mysqli_num_rows($data) > 0) {
                        while($row = mysqli_fetch_array($data)) {
                            $count++;
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo htmlentities($row['Department']); ?></td>
                                <td><?php echo htmlentities($row['Course_Code']); ?></td>
                                <td><?php echo htmlentities($row['Course_Title']); ?></td>
                                <td><?php echo htmlentities($row['Course_Credit']); ?></td>
                                <td>
                                    <a href="edit-course.php?id=<?php echo urlencode($row['Course_Code']); ?>" class="action-link action-edit">Edit</a>
                                    <span class="separator">|</span>
                                    <a href="?id=<?php echo urlencode($row['Course_Code']); ?>&del=delete" class="action-link action-delete" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                </td>
                            </tr>
                            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align: center; color: #94a3b8;'>No courses found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>