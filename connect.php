<?php
$conn = mysqli_connect('localhost', 'root', '', 'phptest');

if (!$conn) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}
?>