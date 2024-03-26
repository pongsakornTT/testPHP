<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>
<body>
    <?php
    include 'connect.php';
    $id = $_GET["id"];
        $sql = "SELECT * FROM table_report WHERE id = '$id'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
    ?>
     <h2>Edit Data</h2>
    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <div>
            <label for="jobs_type">ประเภทงาน</label>
            <input type="text" id="jobs_type" name="jobs_type">
        </div>
        <div>
            <label for="jobs_name">ชื่องานที่ดำเนินการ</label>
            <input type="text" id="jobs_name" name="jobs_name">
        </div>
        <div>
            <label for="jobs_status">สถานะ</label>
            <input type="text" id="jobs_status" name="jobs_status">
        </div>
        <div>
            <button type="submit" name="edit">Save Changes</button>
        </div>
    </form>
<?php
    if (isset($_POST['edit'])) {
        $id = $_GET["id"];
        $jobs_type = $_POST['jobs_type'];
        $jobs_name = $_POST['jobs_name'];
        $jobs_status = $_POST['jobs_status'];

    

        $sql_update = "UPDATE table_report SET 
                        jobs_type = '$jobs_type',
                        jobs_name = '$jobs_name',
                        jobs_status = '$jobs_status',
                        jobs_update = NOW()
                        WHERE id = $id";
    

        $result_update = mysqli_query($conn, $sql_update);
    

        if ($result_update) {
            header("Location: index.php");
            echo "อัปเดตข้อมูลสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($conn);
        }
    }
    
    mysqli_close($conn);
    ?>

</body>
</html>