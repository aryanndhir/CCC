<?php

if(isset($_POST["login"]))
{
    $username = $_POST["username1"];
    $password = $_POST["password1"];
}
function OpenCon()
 {
	$conn = pg_connect(string $_ENV['DATABASE_URL']);
 	return $conn;
 }
 
 function CloseCon($conn)
 {
 	$conn -> close();
 }
 $conn = OpenCon();
 if($conn === false){
    die("ERROR: Could not connect.<br>" . $conn->connect_error);
}

$sql= "SELECT * FROM persons WHERE username='$username' AND password='$password'";
$result = $conn->pg_query($sql);

if($result->num_rows>0){
	$cookie_name = "username"; 
	$cookie_value = $username;
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	CloseCon($conn);
	header('Location: home.php');
}else{
    $error = "Your Login Name or Password is invalid";
    echo "$error";
    CloseCon($conn);
}

?>
