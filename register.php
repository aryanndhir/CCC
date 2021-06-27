<?php
if(isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $ccname = $_POST["ccname"];
    $cfname = $_POST["cfname"];
    $email = $_POST["email"];
}

function OpenCon()
 {
	$conn = pg_connect($_ENV['DATABASE_URL']);
 	return $conn;
 }
 
function CloseCon($conn)
 {
    pg_close($conn);
    // $conn -> pg_close();
 }
 $conn = OpenCon();
 if($conn === false){
    die("ERROR: Could not connect.<br>" . $conn->pg_last_error);
}

$sql = "CREATE TABLE IF NOT EXISTS persons(
    username VARCHAR(30) NOT NULL PRIMARY KEY,
    password VARCHAR(30) NOT NULL,
    ccname VARCHAR(30) NOT NULL,
    cfname VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE,
    achievements VARCHAR(100)
)";

pg_query($conn, $sql);

$sql3 = "SELECT * FROM persons WHERE email='$email'";
$result = pg_query($conn, $sql3);

$sql4 = "SELECT * FROM persons WHERE username='$username'";
$result2 = pg_query($conn, $sql4);

if ($result->num_rows> 0) {
    echo "Registration already exists for the given Email address.<br><button onclick='history.go(-1);'>Back</button>";
} else if ($result2->num_rows> 0){
    echo "Registration already exists for the given username.<br><button onclick='history.go(-1);'>Back</button>";
} else {
    $sql2="INSERT INTO persons (username, password, ccname, cfname, email) VALUES ('$username', '$password', '$ccname', '$cfname', '$email')";
    
    if(pg_query($conn, $sql2) === true){
        header('Location: register.html');
        exit;
    }
}

CloseCon($conn);
?>
