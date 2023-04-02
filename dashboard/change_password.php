<?php
include_once("./../config/connection.php");

if (isset($_POST[""])) {

}
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
    <div class="alert success">
        
    </div>
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

</html>