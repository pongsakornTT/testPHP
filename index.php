<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <title>Document</title>
</head>
<body>

    <h1>เพิ่มข้อมูล</h1>
    <form action="save_db.php" method="POST">
        <div>
            <label for="jobs_type">jobs_type</label>
            <input type="text" name="jobs_type" id="jobs_type">
        </div>
        <br>
        <div>
            <label for="jobs_name">jobs_name</label>
            <input type="text" name="jobs_name" id="jobs_name">
        </div>
        <div>
            <button name="submit" id="submit">ADD</button>
        </div>
    </form>

    <h1>สถานะ</h1>
    <form action="index.php" method="POST">
    <label for="month">เลือกเดือน:</label>
    <select name="month" id="month">
        <option value="1">มกราคม</option>
        <option value="2">กุมภาพันธ์</option>
        <option value="3">มีนาคม</option>
        <option value="4">เมษายน</option>
        <option value="5">พฤษภาคม</option>
        <option value="6">มิถุนายน</option>
        <option value="7">กรกฎาคม</option>
        <option value="8">สิงหาคม</option>
        <option value="9">กันยายน</option>
        <option value="10">ตุลาคม</option>
        <option value="11">พฤศจิกายน</option>
        <option value="12">ธันวาคม</option>
    </select>
    <button type="submit" name="search1">ค้นหา</button>
</form>

<?php
include 'connect.php';

if(isset($_POST['search1']) && isset($_POST['month'])) {
    $selected_month = $_POST['month'];
    $sql = "SELECT YEAR(jods_save) AS year, jobs_status, COUNT(*) AS total
            FROM table_report
            WHERE MONTH(jods_save) = $selected_month
            GROUP BY YEAR(jods_save), jobs_status
            ORDER BY YEAR(jods_save) DESC, jobs_status";
    $result = mysqli_query($conn, $sql);

    echo '<table border="1">
        <thead>
            <tr>
                <th>ปี</th>
                <th>สถานะ</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['year'] . '</td>';
        echo '<td>' . $row['jobs_status'] . '</td>';
        echo '<td>' . $row['total'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo "<p>กรุณาเลือกเดือนก่อนที่จะค้นหา</p>";
}
?>

    <h1>ค้นหา</h1>
    <form action="index.php" method="POST">
        <input type="date" id="datepicker" name="datepicker">
        <button type="submit" name="search">ค้นหา</button>
    </form>
    <?php
            if (isset($_POST['search'])) {
            $datepicker = mysqli_real_escape_string($conn, $_POST['datepicker']);

                $sql_report = "SELECT COUNT(*) AS total_jobs,
                               SUM(CASE WHEN jobs_status = 'เสร็จสิ้น' THEN 1 ELSE 0 END) AS completed_jobs,
                               SUM(CASE WHEN jobs_status = 'ยังไม่เสร็จสิ้น' THEN 1 ELSE 0 END) AS pending_jobs
                        FROM table_report
                        WHERE jods_save = '$datepicker'";
                $result_report = mysqli_query($conn, $sql_report);
            

                if(mysqli_num_rows($result_report) > 0) {
                    $row = mysqli_fetch_assoc($result_report);
                    $total_jobs = $row['total_jobs'];
                    $completed_jobs = $row['completed_jobs'];
                    $pending_jobs = $row['pending_jobs'];
                
        
                    echo "<h2>รายงานสรุปผลการปฎิบัติงานประจำวัน ณ วันที่ $datepicker</h2>";
                    echo "<table border='1'>
                            <thead>
                                <tr>
                                    <th>ประเภทงาน</th>
                                    <th>จำนวนงาน</th>
                                </tr>
                            </thead>
                            <tbody>";
                    
                    echo "<tr>
                            <td>จำนวนงานทั้งหมด</td>
                            <td>$total_jobs</td>
                          </tr>";
                    
                    echo "<tr>
                            <td>งานที่เสร็จสิ้น</td>
                            <td>$completed_jobs</td>
                          </tr>";
                    
                    echo "<tr>
                            <td>งานที่ยังไม่เสร็จสิ้น</td>
                            <td>$pending_jobs</td>
                          </tr>";
                
                    echo "</tbody></table>";
                } else {
                    echo "<p>ไม่พบข้อมูลการปฎิบัติงานในวันที่ $datepicker</p>";
                }
                ?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">ประเภทงาน</th>
                <th scope="col">ชื่องานที่ดำเนินการ</th>
                <th scope="col">เวลาที่เริ่มดำเนินการ</th>
                <th scope="col">เวลาที่เสร็จสิ้น</th>
                <th scope="col">สถานะ</th>
                <th scope="col">วันเวลาที่บันทึกข้อมูล</th>
                <th scope="col">วันเวลาที่ปรับปรุงข้อมูลล่าสุด</th>
            </tr>
        </thead>
        <tbody id="list">
        <?php
            $sql = "SELECT * FROM table_report WHERE jods_save = '$datepicker'";
            $query = mysqli_query($conn, $sql);
            $row_number = 1;
            while ($row = mysqli_fetch_assoc($query)) {
                echo '<tr>';
                echo "<td>{$row_number}</td>";
                echo "<td>{$row['jobs_type']}</td>";
                echo "<td>{$row['jobs_name']}</td>";
                echo "<td>{$row['jods_start_time']}</td>";
                echo "<td>{$row['jobs_end_time']}</td>";
                echo "<td>{$row['jobs_status']}</td>";
                echo "<td>{$row['jods_save']}</td>";
                echo "<td>{$row['jobs_update']}</td>";

                if ($row['jobs_status'] == "ดำเนินการ") {
                    echo "<td><a href='update_status.php?id={$row['id']}&status=เสร็จสิ้น'>เสร็จสิ้น</a></td>";
                    echo "<td><a href='update_status.php?id={$row['id']}&status=ยกเลิก'>ยกเลิก</a></td>";
                } elseif ($row['jobs_status'] == "เสร็จสิ้น") {
                    echo "<td>เสร็จสิ้น</td>";
                    echo "<td></td>";
                } elseif ($row['jobs_status'] == "ยกเลิก") {
                    echo "<td>ยกเลิก</td>";
                    echo "<td></td>";
                }
                echo "<td><a href='edit.php?id={$row['id']}' onclick=\"return confirm('คุณต้องการแก้ไขข้อมูลนี้ใช่หรือไม่?');\">แก้ไข</a></td>";
                echo "<td><a href='delete.php?id={$row['id']}' onclick=\"return confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่?');\">ลบ</a></td>";
                echo '</tr>';
                $row_number++;
            }
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>

<script src="jquery-3.6.0.min.js"></script>
<script src="jquery-ui.min.js"></script>
<script>
$( function() {
  $( "#datepicker" ).datepicker({
    dateFormat: "yy-mm-dd" 
  });
  console.log($("#datepicker").val());
} );
</script>
</body>
</html>