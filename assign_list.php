<?php
session_start();
if (!isset($_SESSION['teacher']) && !isset($_SESSION['student'])) {
    // Redirect them to the login page
    header("Location: login.php");
    exit(); // Terminate script execution after redirection
}

$fileList = glob('baitap/*');
foreach ($fileList as $filename) {
    if (is_dir($filename)) {
        // $target = basename("$filename", ".pdf") . PHP_EOL;
        // $mypath = "./baitap/$target";
        $mypath = "./$filename";
        mkdir($mypath, 0777, true);
        echo $mypath . '<a href="' . $filename . '"> Download </a>' . '<a href=submit.php> Nop bai </a>' . '<a href=view_submitted.php> Bai da nop </a>', '<br>';
    }
}
?>
