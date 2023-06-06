<?php
session_start();
if (!isset($_SESSION['user']) || !$_SESSION['student']) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
            color: #00bd48;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }
        th {
            background-color: #00bd48;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        hr {
            border: 10px solid green;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Message</h2>
    <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Sender</th>
            <th>Content</th>
        </tr>
        <?php
        $serverName = "localhost";
        $connectionOptions = array(
            "Database" => "game",
            "Uid" => "your_username",
            "PWD" => "your_password"
        );

        // Establishes the connection
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $sql = "SELECT * FROM ".$_SESSION['user'];
        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $stmt = sqlsrv_query($conn, $sql, $params, $options);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_num_rows($stmt) > 0) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr><td>".$row["id"]."</td><td>".$row["sender"]."</td><td>".$row["content"]."</td></tr>";
            }
        } else {
            $msg = "Your chat box is empty now!";
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        ?>
        <p style="color: red"><?php echo $msg; ?></p>
    </table>
</body>
</html>