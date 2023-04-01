<?php
require_once './config/connection.php';

$order_id = $_GET['order_id'];
error_log('Received order_id: ' . $order_id);

if (isset($order_id)) {
    $conn = getConnection();

    if (!$conn) {
        error_log('Database connection failed.');
        die();
    }

    $sql = "SELECT * FROM parcel WHERE order_id = '$order_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        error_log('Query execution failed.');
        die();
    }

    $row = mysqli_fetch_array($result);

    if ($row) {
        echo '{"exists":true}';
    } else {
        echo '{"exists":false}';
    }

    mysqli_close($conn);
} else {
    error_log('Order ID not provided.');
    echo '{"exists":false}';
}
?>
