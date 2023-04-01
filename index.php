<?php
// * Don't show Warnings.
error_reporting(E_ALL ^ E_WARNING);

include_once("./config/connection.php");
session_start();

// * Check if the user is logged in.
if (session_status() === PHP_SESSION_NONE) {
	session_start();
} else if (session_status() === PHP_SESSION_ACTIVE && $_SESSION["user_id"] != "") {
	header("Location: /dashboard/index.php");
}

if (isset($_POST["username"])) {

	$con = getConnection();

	$username = $_POST["username"];
	$password = $_POST["password"];

	// Validating if the form is not empty.
	if (empty($username)) {
		die(header("Location: /index.php?error=Username cannot be empty."));
	}

	if (empty($password)) {
		die(header("Location; /index.php?error=Password cannot be empty."));
	}

	// Statements
	$preparedStatement = $con->prepare("SELECT * FROM users WHERE BINARY username = ?");
	$preparedStatement->bind_param("s", $username);
	$preparedStatement->execute();
	$row = $preparedStatement->get_result()->fetch_assoc();

	// Verify if the password is correct.
	if (password_verify($password, $row["password"])) {
		$_SESSION["user_id"] = $row["user_id"];
		$_SESSION["username"] = $row["username"];
		$_SESSION["name"] = $row["name"];
		header("Location: /dashboard");
	} else {
		header("Location: /index.php?error=Username or Password is Incorrect!");
	}

	// Close the connection from the database.
	$con->close();
	
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title> Parcel Delivery </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="#" method="POST">
					<span class="login100-form-title">
						Administrator Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid username is required: myusername">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					<?php
					if (isset($_GET["error"])) {
						echo '
					
					<div class="text-center p-t-10">
						<div class="alert alert-danger">
							' . htmlspecialchars($_GET["error"]) . '</div></div>';
					} ?>
				</form>
			</div>
		</div>
	</div>
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

<?php } ?>