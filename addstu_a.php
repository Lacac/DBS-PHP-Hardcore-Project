<?php
session_start();
if(!isset($_SESSION['teacher']) || !$_SESSION['teacher']){
   header('Location: login.php');
}
if(!preg_match("/^\s*[a-zA-Z0-9_]{5,30}\s*$/",$_POST['pass']))
{ 
    header('Location: addstu.php?password=error');
}
else if ($_POST['pass'] != $_POST['cpass']){   
    header('Location: addstu.php?confirm=error');
}
else if (!preg_match("/^\s*[a-z0-9_]{4,30}\s*$/",$_POST['username'])){
    header('Location: addstu.php?username=error');
}
else if(!preg_match("/^[A-Z][a-zA-Z]{1,10}(?: [A-Z][a-z]*){1,10}$/",$_POST['fullname'])){ 
    header('Location: addstu.php?fullname=error');
}
else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    header('Location: addstu.php?email=error');
}
else if(!preg_match("/^[0-9]{10}$/",$_POST['phonenum'])){
    header('Location: addstu.php?phone=error');
}
else{
    // $con5 = new mysqli("localhost","kali","kali","class");
    // if ($con5->connect_error) {
    //     die("Connection failed: " . $con5->connect_error);
    // } 
    require_once 'permission.php';
    $u = "your_username";
    $p = "your_password";
    $permission = new Permission($u, $p);
    $con5 = $permission->connect_to_mssql();
    
    $stmt = sqlsrv_prepare($con5, "SELECT * FROM student WHERE username=?", array(&$_POST['username']));
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    if (sqlsrv_execute($stmt)) {
        if (sqlsrv_fetch($stmt) === true) {
            header('Location: addstu.php?status=failed');
            exit();
        } else {
            $permission1 = new Permission($u, $p);
            $con6 = $permission1->connect_to_mssql();
            $stmt1 = sqlsrv_prepare($con6, 'INSERT INTO student (username,password,fullname,email,phonenum) VALUES (?,?,?,?,?)', array(&$_POST['username'], &$_POST['pass'], &$_POST['fullname'], &$_POST['email'], &$_POST['phonenum']));
            
            $permission2 = new Permission($u, $p);
            $con7 = $permission2->connect_to_mssql();
            $sql = "CREATE TABLE ".$_POST['username']." (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, sender VARCHAR(30) NOT NULL, content VARCHAR(10000) NOT NULL)";
            if (sqlsrv_execute($stmt1) && sqlsrv_query($con7, $sql)) {
                header('Location: addstu.php?status=success');
                exit();
            } else {
                echo "Failed";
            }
        }
    }
    sqlsrv_free_stmt($stmt);   
} 
?>
