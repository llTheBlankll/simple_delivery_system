<?php
session_start();
include_once("./../config/connection.php");

// Check if the user is logged in.
if (session_status() === PHP_SESSION_ACTIVE) {
    if (empty($_SESSION["user_id"]) && empty($_SESSION["username"])) {
        header("Location: /dashboard/logout.php");
    }
} else {
    header("Location: /dashboard/logout.php");
}

if (isset($_POST["current_password"]) && isset($_POST["new_password"]) && isset($_POST["retype_password"])) {

    $con = getConnection();
    $update_password = "UPDATE users SET password = ? WHERE BINARY user_id = ?";
    $check_password = "SELECT * FROM users WHERE BINARY user_id = ?";
    
    # * INPUTS
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $retype_password = $_POST["retype_password"];

    if ($new_password != $retype_password) {
        header("Location: /dashboard/change_password.php?error=Password is not the same.");
        return;
    }

    $prepared_statement = $con->prepare($check_password);
    $prepared_statement->bind_param("s", $_SESSION["user_id"]);
    $prepared_statement->execute();
    $result = $prepared_statement->get_result()->fetch_assoc();

    if (password_verify($current_password, $result["password"])) {
        if ($current_password == $new_password) {
            header("Location: /dashboard/change_password.php?error=Your new password cannot be the same as the current password");
            return;
        }

        $prepared_statement->prepare($update_password);
        $prepared_statement->bind_param("ss", password_hash($new_password, PASSWORD_BCRYPT), $_SESSION["user_id"]);
        if ($prepared_statement->execute()) {
            session_destroy();
            header("Location: /index.php?success=Password was changed successfully.");
        }
    } else {
        header("Location: /dashboard/change_password.php?error=Password is incorrect.");
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Change Password </title>
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
    <?php
    if (isset($_GET["error"])) {
        echo "<div class='alert error'>";
        echo htmlspecialchars($_GET["error"]);
        echo "</div>";
    } else if (isset($_GET["success"])) {
        echo "<div class='alert success'>";
        echo htmlspecialchars($_GET["success"]);
        echo "</div>";
    }
    ?>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
            <li><a href="/dashboard/index.php" class="btn-floating red"><i class="material-icons">home</i></a></li>
            <li><a class="btn-floating red" href="/dashboard/logout.php"><i class="material-icons">logout</i></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 l8 m12 offset-l2">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title center">Change Password</span>

                        <div class="row">
                            <div class="col s12 l12">
                                <div class="card">
                                    <form action="" method="post">
                                        <div class="card-content">
                                            <div class="input-group">
                                                <label for="current_password">Current Password:</label>
                                                <input type="password" name="current_password" id="txt_password" placeholder="Current Password" maxlength="64">
                                            </div>
                                            <div class="input-group">
                                                <label for="new_password">New Password:</label>
                                                <input type="password" name="new_password" id="txt_new_password" placeholder="New Password" maxlength="64">
                                            </div>
                                            <div class="input-group">
                                                <label for="retype_password">ReType
                                                    Password</label>
                                                <input type="password" name="retype_password" id="txt_retype_password" placeholder="Type your new password" maxlength="64">
                                            </div>
                                            <div class="input-group center">
                                                <button type="submit" class="btn btn-primary">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php } ?>
</html>