<?php
session_start();
if (!isset($_SESSION['teacher']) || !$_SESSION['teacher']) {
    // Redirect them to the login page
    header("Location: login.php");
    exit; // Terminate the script after redirection
}

include 'assign_list.php';

$fileList = glob("$mypath/*");

if (count($fileList) > 0) {
    foreach ($fileList as $filename) {
        if (is_file($filename)) {
            $target = basename("$filename", ".pdf");
            $target1 = basename("$filename");
            $downloadLink = '/baitap/' . $target . '/' . $target1;
            $safeFileName = htmlspecialchars($target); // Sanitize the file name

            echo $safeFileName . ' <a href="' . $downloadLink . '">Download</a><br>';
        }
    }
} else {
    echo 'No files found.';
}
?>