<?php
$target_dir = "baitap/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$pdfFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$errors = [];

// Check if file already exists
if (file_exists($target_file)) {
  $errors[] = "Sorry, the file already exists.";
  $uploadOk = 0;
}

// Check file size (limit it to a reasonable size)
$maxFileSize = 10 * 1024 * 1024; // 10MB
if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
  $errors[] = "Sorry, the file is too large. Please upload a file up to 10MB in size.";
  $uploadOk = 0;
}

// Allow only PDF files
if ($pdfFileType != "pdf") {
  $errors[] = "Sorry, only PDF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $errors[] = "Sorry, the file was not uploaded.";
} else {
  // Create a folder with the file name
  $folderName = pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_FILENAME);
  $folderPath = $target_dir . $folderName;

  if (!file_exists($folderPath)) {
    // Create the folder
    mkdir($folderPath, 0777, true);
  }

  // Move the uploaded file to the folder
  $destination = $folderPath . "/" . basename($_FILES["fileToUpload"]["name"]);
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $destination)) {
    $message = "File " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded successfully.";
  } else {
    $errors[] = "Sorry, there was an error uploading your file.";
  }
}

// Display errors and success message (if any)
if (!empty($errors)) {
  foreach ($errors as $error) {
    echo $error . "<br>";
  }
} else {
  echo $message;
}
?>
