<option value="">Xã phường/Thị trấn</option>
<?php
    require ("connect.php");
    if (isset($_GET['maqh'])) {
        $maqh = $_GET['maqh'];
        $sql = $conn->query("SELECT * FROM xaphuongthitran WHERE maqh = '$maqh' ORDER BY name ASC");
        while ($row = $sql->fetch_assoc()) {
            echo '<option value="'.$row['xaid'].'">'.$row['name'].'</option>';
        }
    }
    $conn->close();
?>