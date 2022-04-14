<?php
    require ("connect.php");
    $search = $_GET['search'];
    if ($search == "") {
        $result = $conn->query("SELECT * FROM sanpham LIMIT 4");
    } else {
        $result = $conn->query("SELECT * FROM sanpham WHERE ten LIKE '%".$search."%' LIMIT 4");
    }
    if($result->num_rows > 0) {
        while($row_search = $result->fetch_assoc()) { ?>
        <li class="slide-product">
            <a href="../product.php?id=<?php echo $row_search["idsp"] ?>">
                <img src="<?php echo $row_search["hinhanh"] ?>" alt="<?php echo $row_search["ten"] ?>" class="slide-product-img">
            </a>
            <div class="slide-product-info">
                <a href="../product.php?id=<?php echo $row_search["idsp"] ?>">
                    <div class="slide-product-name"><?php echo $row_search["ten"] ?></div>
                </a>
                <div class="slide-product-price"><?php echo number_format($row_search["giaban"],0,",",".") ?>₫</div>
            </div>
        </li>
<?php
        }
    }
    else {
        echo "Không tìm thấy kết quả phù hợp";
    }
    $conn->close();
?>