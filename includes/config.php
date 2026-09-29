
<?php
$database = mysqli_connect("localhost","root","","course_registration_system");
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
