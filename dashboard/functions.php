<?php
function getAllDelivery()
{
    $con = getConnection();
    $sql = "SELECT * FROM parcel";
    $result = mysqli_query($con, $sql);

    $con->close();
    return $result;
}

function deliveryFindByOrderID($orderId)
{
    $orderId = "%" . $orderId . "%";
    $con = getConnection();
    $sql = "SELECT * FROM parcel WHERE order_id LIKE ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    $con->close();

    return $result;
}

function deliveryFindByTrackingId($trackingId)
{
    $orderId = "%" . $trackingId . "%";
    $con = getConnection();
    $sql = "SELECT * FROM parcel WHERE tracking_id LIKE ?";
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

// * CHECK TRACKING ID
function findByTrackingIdExists($tracking_id) {
    $con = getConnection();
    $sql = "SELECT * FROM parcel WHERE tracking_id = ? LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $tracking_id);
    $stmt->execute();

    if ($stmt->num_rows() > 0) {
        $con->close();
        return true;
    }

    $con->close();
    return false;
}

?>