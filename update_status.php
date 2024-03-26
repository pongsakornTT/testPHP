<?php
include 'connect.php';

if(isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    date_default_timezone_set('Asia/Bangkok');
    $jobs_time = date("H:i:s");
    $sql_update = "UPDATE table_report SET jobs_status = '$status', jobs_end_time = '$jobs_time' WHERE id = $id";
    $result_update = mysqli_query($conn, $sql_update);

    if($result_update) {
        header("Location: index.php");
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตสถานะ";
    }
}

mysqli_close($conn);
?>
