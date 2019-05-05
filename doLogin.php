 <?php
 
require 'config.php';
require 'mysql.class.php';

error_log(0, 3, './errors.log');
if (empty($_POST['userNameOrEmailAddress']) || empty($_POST['password'])) {
	header('location:index.html');
}


DB::connect();
$user = DB::$con->real_escape_string($_POST['userNameOrEmailAddress']);
$pwd = DB::$con->real_escape_string($_POST['password']);



$sql_login = "SELECT password FROM users WHERE email='{$user}'";


$insert_status = mysqli_query(DB::$con,$sql_login);
$password = mysqli_fetch_array($insert_status)[0];
DB::close();

if ($pwd === $password) {
	//save to session
	session_start();
	$_SESSION['admin'] = true;
	header('location:admin.php');
} else {
	header('location:index.php');
}

/**end of file**/