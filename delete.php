<?php
session_start();
if (!isset($_SESSION['teacher']) || !$_SESSION['teacher']) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php
        if (isset($_POST['delete'])) {
            require 'permission.php';
            $u = "your_username";
            $p = "your_password";
            $permission = new Permission($u, $p);
            $con15 = $permission->connect_to_mssql();
            $id = $_SESSION['id'];
            $sql = "DELETE FROM student WHERE id='$id'";
            $result = sqlsrv_query($con15, $sql);
            if ($result !== false) {
                echo 'Delete successful';
                $con16 = $permission->connect_to_mssql();
                $sql = "DROP TABLE [$arr[1]]";
                if ($con16->query($sql)) {
                    $msg = "This student has been deleted!";
                }
            } else {
                echo 'Delete failed';
            }
        }
    ?>
    <br/>
    <h1 style="color: green;"><?php if (isset($msg)) echo $msg; ?></h1>
    <?php if (isset($msg))  echo '<a href="index.php"><button type="button" class="btn btn-secondary">Come back to home page</button></a>'; ?>
</body>
</html>
