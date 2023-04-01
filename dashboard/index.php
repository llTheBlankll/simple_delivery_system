<?php

include_once("../config/connection.php");
include_once("./functions.php");

session_start();
// Check if the user is logged in.
if (session_status() === PHP_SESSION_ACTIVE) {
    if (empty($_SESSION["user_id"]) && empty($_SESSION["username"])) {
        header("Location: /dashboard/logout.php");
    }
} else {
    header("Location: /dashboard/logout.php");
}

$delete_status = 0;

// * Validate if the user does really search something
if (isset($_GET["search"])) {
    if ($_GET["search"] === "") {
        header("Location: /dashboard");
    }
}

// * ADD
if (isset($_POST["product_name"]) && isset($_POST["order_id"]) && isset($_POST["tracking_id"])) {
    $order_id = $_POST["order_id"];
    $product_name = $_POST["product_name"];

    if (findByTrackingIdExists($tracking_id) != false) {
        die(header("Location: /dashboard/index.php?error=Parcel already exists"));
    }

    if (empty($order_id)) {
        die(header("Location: /dashboard/index.php?error=Order ID cannot be empty."));
    } else if (empty($product_name)) {
        die(header("Location: /dashboard/index.php?error=Product Name cannot be empty."));
    }

    $con = getConnection();
    $sql = "INSERT INTO parcel (product_name, order_id) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $product_name, $order_id);

    if ($stmt->execute()) {
        header("Location: /dashboard/index.php?success=Product Name " . $product_name . " successfully added for delivery.");
    }
}

// * DELETE
if (isset($_GET["delete_id"]) && !empty($_GET["delete_id"])) {
    $parcel_id = $_GET["delete_id"];

    if (findByParcelIdExists($parcel_id) == false) {
        die(header("Location: /dashboard/index.php?error=Parcel ID " . $parcel_id . " doesn't exists."));
    }

    $sql = "DELETE FROM parcel WHERE parcel_id = ?";
    $con = getConnection();
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $parcel_id);
    $stmt->execute();

    // Set that you deleted something.
    $delete_status = 1;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard | Parcel System </title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.2.1/dist/css/materialize.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.2.1/dist/js/materialize.min.js"></script>
    <script src="./js/main.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="dashboard-background-image">
    <?php

    if ($delete_status == 1) {
    ?>
        <div class="alert success">
            Parcel was successfully deleted!
        </div>
    <?php
    } else if (isset($_GET["error"]) && !empty($_GET["error"])) {
    ?>
        <div class="alert danger">
            <?php echo htmlspecialchars($_GET["error"], ENT_QUOTES, "UTF-8"); ?>
        </div>
    <?php
    } else if (isset($_GET["success"])) {
    ?>
        <div class="alert success">
            <?php echo htmlspecialchars($_GET["success"], ENT_QUOTES, "UTF-8"); ?>
        </div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col s12 l8 offset-l3" style="margin-top: 16px;">
                <div class="row">
                    <form action="index.php" method="GET" id="search_form">
                        <div class="input-field col s12 m8 offset-m2 l5">
                            <i class="material-icons prefix">search</i>
                            <input type="text" name="search" id="parcel_search_input" class="validate">
                            <label for="parcel_search_input">Search by Parcel Tracking ID</label>
                        </div>
                    </form>
                    <div class="input-field col s12 offset-m3 offset-s2 l7">
                        <button class="btn waves-effect waves-light" type="submit" form="search_form"><i class="material-icons left">search</i>Search</button>
                        <button type="submit" class="btn waves-effect waves-light green" form="add_delivery_form"><i class="material-icons left">add</i>Add Delivery</button>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card grey lighten-5">
                    <div class="card-content">
                        <span class="card-title">Parcel Delivery</span>
                        <form action="" id="add_delivery_form" method="post">
                            <div class="row">
                                <div class="col s12 l4 m6 input-field"><input type="text" name="product_name" id="txt_productName"><label for="product_name">Product Name</label></input>
                                </div>
                                <div class="col s12 l4 m6 input-field"><input type="text" name="order_id" id="txt_orderId"><label for="order_id">Order ID</label></input></div>
                                <div class="col s12 l4 m12 input-field"><input type="text" name="tracking_id" id="txt_trackingId"><label for="tracking_id">Tracking ID</label></input></div>
                            </div>
                        </form>

                        <div class="fixed-action-btn">
                            <a class="btn-floating btn-large red">
                                <i class="large material-icons">mode_edit</i>
                            </a>
                            <ul>
                                <li><a class="btn-floating red" href="/dashboard/logout.php"><i class="material-icons">logout</i></a></li>
                            </ul>
                        </div>

                        <div class="card">
                            <div class="card-content">
                                <span class="card-title center">Not Delivered</span>
                                <table class="table table-striped responsive-table centered">
                                    <thead>
                                        <tr>
                                            <th>
                                                Product Name
                                            </th>
                                            <th>
                                                Order ID
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!isset($_GET["search"])) {
                                            $result = getAllDelivery();

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $row["product_name"] . "</td>";
                                                echo "<td>" . $row["order_id"] . "</td>";
                                                echo "<td><a href='/dashboard/index.php?delete_id=" . $row["parcel_id"] . "' class='action-link'>Delete</a></td>";
                                                echo "<tr/>";
                                            }
                                        } else {
                                            $result = deliveryFindByTrackingId($_GET["search"]);

                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["product_name"] . "</td>";
                                                echo "<td>" . $row["order_id"] . "</td>";
                                                echo "<td>" . $row["tracking_id"] . "</td>";
                                                echo "<td><a href='/dashboard/index.php?delete_id=" . $row["parcel_id"] . "' class='action-link'>Delete</a></td>";
                                                echo "<tr/>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title center">
                                    Delivered
                                </span>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-actions">
                    <!-- ADD PAGINATION -->
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>