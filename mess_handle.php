<?php
session_start();

if (!isset($_SESSION['teacher']) || !isset($_SESSION['student'])) {
    header('Location: list.php');
} else {
    $serverName = "localhost";
    $connectionOptions = array(
        "Database" => "class",
        "Uid" => "kali",
        "PWD" => "kali"
    );

    // Establish MSSQL connection
    $conn8 = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn8 === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $conn9 = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn9 === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $id = $_SESSION['id'];
    $x = 0;
    $arr = array();

    $query = "SELECT * FROM student WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn8, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        foreach ($row as $r) {
            $arr[$x] = $r;
            $x++;
        }
    }

    sqlsrv_free_stmt($stmt);

    $sender = $_SESSION['user'];
    $content = $_POST['message'];

    $table = $arr[1];

    $query = "INSERT INTO $table (sender, content) VALUES (?, ?)";
    $params = array($sender, $content);
    $stmt = sqlsrv_query($conn9, $query, $params);

    if ($stmt === false) {
        header('Location: sendmess.php?status=failed');
        die(print_r(sqlsrv_errors(), true));
    } else {
        header('Location: sendmess.php?status=success');
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn8);
    sqlsrv_close($conn9);
}
?>