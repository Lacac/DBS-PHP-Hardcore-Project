<?php
if (!preg_match("/^\s*[a-zA-Z0-9_]{5,30}\s*$/", $_POST['pass'])) {
    header('Location: signup.php?password=error');
    exit;
} elseif ($_POST['pass'] != $_POST['cpass']) {
    header('Location: signup.php?confirm=error');
    exit;
} elseif (!preg_match("/^\s*[a-z0-9_]{5,30}\s*$/", $_POST['username'])) {
    header('Location: signup.php?username=error');
    exit;
} else {
    $serverName = "DESKTOP-NCJ03T3\MSSQLSERVER02";
    $database = "php_hardcore_project";
    $uid = "";
    $pass = "";

    $connectionOptions = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $pass
    ];

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $tsql = "SELECT * FROM teacher WHERE username = ?";
    $params = array($_POST['username']);
    $stmt = sqlsrv_query($conn, $tsql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_fetch($stmt) === true) {
        header('Location: signup.php?status=failed');
        exit;
    } else {
        sqlsrv_free_stmt($stmt);

        $tsql = "INSERT INTO teacher (username, password) VALUES (?, ?)";
        $params = array($_POST['username'], $_POST['pass']);
        $stmt = sqlsrv_query($conn, $tsql, $params);
        if ($stmt === false) {
            header('Location: signup.php?status=failed');
            exit;
        } else {
            header('Location: signup.php?status=success');
            exit;
        }
    }

    sqlsrv_close($conn);
}
?>
