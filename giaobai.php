<?php
session_start();
if (!isset($_SESSION['teacher']) || !$_SESSION['teacher']) {
    header("Location: login.php");
    exit; // Add exit to stop further execution
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <form action="up_assign.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlFile1">Chọn bài tập để giao:</label>
            <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
        </div>
        <br/>
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>
