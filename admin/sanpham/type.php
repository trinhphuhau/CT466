<?php
    require ("../connect.php");
    $gioitinh = $_GET["gender"];
    $sql = $conn->query("SELECT * FROM loai WHERE gioitinh = '".$gioitinh."' OR gioitinh = '0'");
    while ($row_type = $sql->fetch_assoc()) {
    ?>
        <option value="<?php echo $row_type["maloai"] ?>"><?php echo $row_type["tenloai"] ?></option>
    <?php
    }
    $conn->close();
?>