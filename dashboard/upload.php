<?php
include_once("./functions.php");
include_once("../config/connection.php");

session_start();

if (session_status() === PHP_SESSION_ACTIVE) {
    if (empty($_SESSION["user_id"]) && empty($_SESSION["username"])) {
        header("Location: /dashboard/logout.php");
    }
} else {
    header("Location: /dashboard/logout.php");
}

function changeParcelImageProofLocation($file_path, $parcel_id) {
    $con = getConnection();
    $sql = "UPDATE parcel SET image_proof_path = ? WHERE parcel_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $file_path, $parcel_id);
    if ($stmt->execute()) {
        return true;
    }

    return false;
}

if (isset($_FILES["image_file"])) {
    $target_directory = "upload/";
    try {
        $target_file = $target_directory . random_int(100000000, 999999999) . "-" . basename($_FILES["image_file"]["name"]);
    } catch (Exception $e) {
       die ($e);
    }

    // Check image size
    if ($_FILES["image_file"]["size"] > 10000000) {
        echo "File is too large.";
        return "10 MB image is the limit.";
    }

    if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
        if (changeParcelImageProofLocation($target_file, $_GET["parcel_id"])) {
            header("Location: /dashboard/index.php?success=The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.");
        }
    } else {
        header("Location: /dashboard/index.php?error=There was an error uploading your file.");
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Upload Image | Parcel Delivery</title>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.2.1/dist/css/materialize.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
            integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.2.1/dist/js/materialize.min.js"></script>
    <script src="./js/main.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="dashboard-background-image">
<div class="container">
    <div class="row">
        <div class="col s12 l8 offset-l2">
            <div class="card">
                <form action="" id="upload_form" method="post" enctype="multipart/form-data">
                    <div class="card-content">
                        <span class="card-title">Upload Image for <b><?php echo htmlspecialchars(getDeliveryProductNameByParcelId($_GET["parcel_id"])); ?></b></span>

                        <div class="row">
                            <div class="file-field input-field col s12">
                                <div class="btn"><span>Image</span><input type="file" name="image_file" id="file_input"></div>
                                <div class="file-path-wrapper">
                                    <input type="text" class="file-path validate">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-action right-align">
                        <input type="submit" value="Submit" class="btn waves-light waves-effect green" form="upload_form">
                        <a href="/dashboard/index.php" class="btn waves-light waves-effect red">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>