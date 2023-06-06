<?php
include "assign_list.php";
// $target_dir = "baitap/";
// $target = "answer"; // Specify the target folder name
// $target_dir .= $target . "/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $target_dir = "baitap/$target/";
$target_file = $mypath . "/" . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

$pdfFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the target directory exists, create it if necessary
if (!is_dir($mypath)) {
    mkdir($mypath, 0755, true);
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size (100MB limit in this example)
$maxFileSize = 100 * 1024 * 1024; // 100MB
if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
    echo "Sorry, your file is too large. Maximum file size is 100MB.";
    $uploadOk = 0;
}

// Allow only PDF file format
if ($pdfFileType != "pdf") {
    echo "Sorry, only PDF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // Try to upload the file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded successfully.";
        echo "<br>";
        echo basename($_FILES["fileToUpload"]["name"]);
        echo "<br>";
        echo $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>