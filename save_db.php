<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    $jobs_type = mysqli_real_escape_string($conn, $_POST['jobs_type']);
    $jobs_name = mysqli_real_escape_string($conn, $_POST['jobs_name']);
    date_default_timezone_set('Asia/Bangkok');
    $jobs_time = date("H:i:s");
    $sql = "INSERT INTO table_report (jobs_type, jobs_name, jods_start_time, jobs_status, jods_save) VALUES ('$jobs_type', '$jobs_name', '$jobs_time', 'ดำเนินการ', NOW())";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
?>