<?php
session_start();
if (!isset($_SESSION['teacher']) || !$_SESSION['teacher']) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        header('Location: tec_update.php');
        exit;
    }

    if (!preg_match("/^\s*[a-zA-Z0-9_]{5,30}\s*$/", $_POST['pass'])) {
        header('Location: tec_update.php?password=error');
        exit;
    } elseif ($_POST['pass'] != $_POST['cpass']) {
        header('Location: tec_update.php?confirm=error');
        exit;
    } elseif (!preg_match("/^\s*[a-z0-9_]{5,30}\s*$/", $_POST['username'])) {
        header('Location: tec_update.php?username=error');
        exit;
    } elseif (!preg_match("/^[A-Z][a-zA-Z]{1,10}(?: [A-Z][a-z]*){1,10}$/", $_POST['fullname'])) {
        header('Location: tec_update.php?fullname=error');
        exit;
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('Location: tec_update.php?email=error');
        exit;
    } elseif (!preg_match("/^[0-9]{10}$/", $_POST['phonenum'])) {
        header('Location: tec_update.php?phone=error');
        exit;
    }

    $serverName = "localhost";
    $connectionOptions = array(
        "Database" => "class",
        "UID" => "kali",
        "PWD" => "kali"
    );
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $sql = 'UPDATE student SET username=?, password=?, fullname=?, email=?, phonenum=? WHERE id=?';
    $params = array($_POST['username'], $_POST['pass'], $_POST['fullname'], $_POST['email'], $_POST['phonenum'], $_SESSION['id']);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo 'Failed';
        exit;
    }

    $rowsAffected = sqlsrv_rows_affected($stmt);
    if ($rowsAffected > 0) {
        $oldTableName = $_SESSION['username'];
        $newTableName = $_POST['username'];
        $sqlRename = "EXEC sp_rename '$oldTableName', '$newTableName'";
        $stmtRename = sqlsrv_query($conn, $sqlRename);
        if ($stmtRename === false) {
            echo 'Failed';
            exit;
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_free_stmt($stmtRename);
        sqlsrv_close($conn);

        header('Location: tec_update.php?status=success');
        exit;
    } else {
        echo 'Failed';
        exit;
    }
}
?>