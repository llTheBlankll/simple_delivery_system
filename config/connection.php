<?php
# define("MYSQL_USERNAME", "u937809650_root");
# define("MYSQL_PASSWORD", "Group_07");
# define("MYSQL_HOST", "localhost");
# define("MYSQL_DATABASE", "u937809650_test");

define("MYSQL_USERNAME", "public");
define("MYSQL_PASSWORD", "public");
define("MYSQL_HOST", "localhost");
define("MYSQL_DATABASE", "test");

function getConnection(): mysqli
{
    $con = mysqli_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

    if ($con != true) {
        return $con;
    }

    return $con;
}
