<option value="">District</option>
<?php
    require ("connect.php");
    if (isset($_GET['matp'])) {
        $matp = $_GET['matp'];
        $sql = $conn->query("SELECT * FROM quanhuyen WHERE matp = '$matp' ORDER BY name");
        while ($row = $sql->fetch_assoc()) {
            echo '<option value="'.$row['maqh'].'">'.$row['name'].'</option>';
        }
    }
    $conn->close();
?>