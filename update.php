<?php

if(isset($_POST["update"]))
{
    $name = $_POST["username"];
    $email = $_POST["email"];
    $ccname = $_POST["ccname"];
    $cfname = $_POST["cfname"];
    $ach = $_POST["ach"];
    $pwd = $_POST["ccpwd"];

    function OpenCon()
    {
        // $dbhost = "sql6.freesqldatabase.com";
        // $dbuser = "sql6400897";
        // $dbpass = "gcysFbCvd9";
        // $db = "sql6400897";
        // $conn = new mysqli($dbhost, $dbuser, $dbpass,$db);
        // return $conn;
        $conn = pg_connect($_ENV['DATABASE_URL']);
        return $conn;
    }

    function CloseCon($conn)
    {
        pg_close($conn);
        // $conn -> close();
    } 

    $conn = OpenCon();
    if($conn === false){
        die("ERROR: Could not connect." . pg_last_error($conn));
        echo "<br>";
    }
    
    $sql = "UPDATE persons SET email='$email', ccname='$ccname', cfname='$cfname', achievements='$ach', password='$pwd' WHERE username='$name'";
    error_log($sql);
    if(pg_query($conn, $sql) === true){
//         echo $ccname;
//         echo $cfname;
//         echo $pwd;
//         echo $name;
//         echo $email;
//         echo $ach;
        header('Location: index.php');
        exit;
    }
    
    CloseCon($conn);
}
?>
