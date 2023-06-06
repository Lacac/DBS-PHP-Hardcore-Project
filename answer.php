<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
</head>
<body>
<?php
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "game",
    "UID" => "kali",
    "PWD" => "kali"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

$sql = "SELECT hints FROM challenge ORDER BY chalID DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY";
$result = sqlsrv_query($conn, $sql);

if ($result !== false) {
    if (sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "hints: " . $row["hints"];
        }
    } else {
        echo "0 results";
    }
} else {
    echo "Error executing query: " . print_r(sqlsrv_errors(), true);
}

sqlsrv_close($conn);
?>
<?php
if (isset($_POST["btn_submit"])) {
    $answer = $_POST["answer"];
    if ($answer == "") {
        echo "Answer is empty!";
    } else {
        $file = "challenge/" . $answer . ".txt";
        if (file_exists($file)) {
            echo "<br>Correct<br>";
            echo file_get_contents($file);
        } else {
            echo "<br>Incorrect";
        }
    }
}
?>
<form method="POST" action="answer.php">
    <table class="table">
        <tr class="table-success">
            <td>Dap an</td>
            <td><input type="text" name="answer" size="30"></td>
        </tr>
        <tr class="table-success">
            <td colspan="2" align="center"> <input name="btn_submit" type="submit" value="Tra loi"></td>
        </tr>
    </table>
</form>
</body>
</html>
