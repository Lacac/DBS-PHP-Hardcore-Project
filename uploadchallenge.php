<?php
include '../challenge.php';

$serverName = "localhost";
$connectionOptions = array(
    "Database" => "game",
    "Uid" => "kali",
    "PWD" => "kali"
);

// This is the directory where images will be saved
$target_dir = "challenge/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// This gets all the other information from the form
$hints = $_POST["hints"];
$challenge = $_FILES["fileToUpload"]["name"];

// Connect to MSSQL
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    echo "Unable to connect to MSSQL: " . print_r(sqlsrv_errors(), true);
    exit;
}

// Writes the information to the database
$sql = "INSERT INTO challenge (challenge, hints) VALUES (?, ?)";
$params = array($challenge, $hints);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    echo "Error inserting data into the database: " . print_r(sqlsrv_errors(), true);
    exit;
}

// Writes the photo to the server
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // Tells you if it's all okay
    echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded, and your information has been added to the directory";
} else {
    // Gives an error if it's not
    echo "Sorry, there was a problem uploading your file.";
}

// Clean up resources
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>