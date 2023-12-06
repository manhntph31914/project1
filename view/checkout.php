<link rel="stylesheet" href="view/css/donhang.css">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin giỏ hàng</title>
    
</head>
<body>

    <?php
    // Tính toán tổng tiền
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalPrice += $item['quantity'] * $item['price'];
    }

    // Chuẩn bị mảng thông tin sản phẩm
    $productInfo = [];
    foreach ($_SESSION['cart'] as $item) {
        $productName = $item['name'];
        $productPrice = $item['price'];
        $productQuantity = $item['quantity'];
        $productTotal = $item['quantity'] * $item['price'];

        // Thêm thông tin vào mảng
        $productInfo[] = [
            'name' => $productName,
            'price' => $productPrice,
            'quantity' => $productQuantity,
            'total' => $productTotal
        ];
    }
    ?>

    <!-- Hiển thị thông tin sản phẩm trong HTML -->
    <h2>Thông tin đơn hàng của bạn</h2>
    <table>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Giá sản phẩm</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <th>trạng thái đơn hàng</th>
        </tr>
        <?php foreach ($productInfo as $product): ?>
            <tr>
                <td><?= $product['name']; ?></td>
                <td><?= number_format($product['price'], 0, ",", "."); ?> ₫</td>
                <td><?= $product['quantity']; ?></td>
                <td><?= number_format($product['total'], 0, ",", "."); ?> ₫</td>
                <td>
                    <select name="" id="">
                        <option value="1">Đang chờ duyệt</option>
                        <option value="2">Đã xác nhận </option>
                        <option value="3">Đang vận chuyển</option>
                        <option value="3">Hoàn thành	</option>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Hiển thị tổng tiền -->
    <h3 style="color:red">Tổng tiền: <?= number_format($totalPrice, 0, ",", "."); ?> ₫</h3>

</body>
</html>
