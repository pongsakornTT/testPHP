<?php
include 'connect.php';

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM table_report WHERE id = '$id'";
    if(mysqli_query($conn, $sql)) {
        echo "ลบข้อมูลเรียบร้อยแล้ว";
        header("Location: index.php");
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . mysqli_error($conn);
    }
} else {
    echo "ไม่มีการระบุ ID";
}
?>