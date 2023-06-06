<?php
session_start();
if (!isset($_SESSION['teacher']) || !$_SESSION['teacher']) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
            color: #d96459;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }
        th {
            background-color: #d96459;
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
<br/>
<hr>
<br/><h2>Details of clicked student</h2>
</br>
<table>
    <tr>
        <th>Fullname</th>
        <th>Email</th>
        <th>Phone number</th>
    </tr>
    <?php
    require 'permission.php';
    $u = "your_username";
    $p = "your_password";
    $permission = new permission($u, $p);
    $conn = $permission->connect_to_mssql();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = isset($_POST['td_data']) ? $_POST['td_data'] : '';

        $sql = "SELECT fullname, email, phonenum FROM student WHERE id = ?";
        $params = array(&$data);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt !== false) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr><td>".$row["fullname"]."</td><td>".$row["email"]."</td><td>".$row["phonenum"]."</td></tr>";
            }
        } else {
            $msg = "Error retrieving student details.";
        }
    }
    ?>
</table>
<br/>
<button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='sendmess.php'">Chat with this student</button>
<?php if (isset($_SESSION['teacher']) && $_SESSION['teacher']) echo '<a href="tec_update.php"><button type="button" class="btn btn-primary btn-lg">Update information</button></a>';?>
<?php if (isset($_SESSION['teacher']) && $_SESSION['teacher']) echo '<br/><br/><form action="delete.php" method="post"><button type="submit" name="delete" class="btn btn-primary btn-lg">Delete this student</button></form>';?>
</body>
</html>
