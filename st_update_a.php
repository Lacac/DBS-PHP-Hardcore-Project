<?php
session_start();

if (!isset($_SESSION['student']) || !$_SESSION['student']) {
  header('Location: login.php');
}

if (isset($_POST['submit'])) {
    if (hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        $password = $_POST['pass'];
        $confirmPassword = $_POST['cpass'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phonenum'];

        // Validate password
        if (!preg_match("/^\s*[a-zA-Z0-9_]{5,30}\s*$/", $password)) { 
            header('Location: st_update.php?password=error');
            exit();
        }

        // Confirm password
        if ($password != $confirmPassword) {   
            header('Location: st_update.php?confirm=error');
            exit();
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: st_update.php?email=error');
            exit();
        }

        // Validate phone number
        if (!preg_match("/^[0-9]{10}$/", $phoneNumber)) {
            header('Location: st_update.php?phone=error');
            exit();
        }

        require 'permission.php';
            $u = "your_username";
            $p = "your_password";
            $permission = new permission($u, $p);
            $conn = $permission->connect_to_mssql();

        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $tsql = "UPDATE student SET password=?, email=?, phonenum=? WHERE username=?";
        $params = array($password, $email, $phoneNumber, $_SESSION['user']);
        $stmt = sqlsrv_query($conn, $tsql, $params);

        if ($stmt === false) {
            echo "Failed";
            exit();
        } else {
            header('Location: st_update.php?status=success');
            exit();
        }
    } else {
        header('Location: login.php');
        exit();
    }
}
?>