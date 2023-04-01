<?php
function getNotDelivered()
{
    $con = getConnection();
    $sql = "SELECT * FROM parcel WHERE parcel_status = 'Not Delivered'";
    $result = mysqli_query($con, $sql);

    $con->close();
    return $result;
}

function getDelivered() {
    $con = getConnection();
    $sql = "SELECT * FROM parcel WHERE parcel_status = 'Delivered'";
    $result = mysqli_query($con, $sql);

    $con->close();
    return $result;
}

function deliveryFindByOrderID($orderId, $is_delivered=false)
{
    $orderId = "%" . $orderId . "%";
    $con = getConnection();
    if ($is_delivered == false) {
        $sql = "SELECT * FROM parcel WHERE order_id LIKE ? AND parcel_status = 'Not Delivered'";
    } else {
        $sql = "SELECT * FROM parcel WHERE order_id LIKE ? AND parcel_status = 'Delivered'";
    }
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    $con->close();

    return $result;
}

function getDeliveryProductNameByParcelId($parcelId)
{
    $con = getConnection();
    $sql = "SELECT * FROM parcel WHERE parcel_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $parcelId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $con->close();
        return $data["product_name"];
    } else {
        $con->close();
        return "No Result";
    }
}

// * CHECK PARCEL ID
function findByParcelIdExists($parcel_id) {
    $con = getConnection();
    $sql = "SELECT * FROM parcel WHERE parcel_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $parcel_id);
    $stmt->execute();

    if ($stmt->get_result()->num_rows >= 1) {
        $con->close();
        return true;
    }

    echo "FALSE";
    echo "<alert>alert(1)</script>";
    $con->close();
    return false;
}

?>