<?php
session_start();
if (!isset($_SESSION['student']) || !$_SESSION['student']) {
    // Redirect them to the login page
    header("Location: login.php");
    exit; // Terminate the script after redirection
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Invalid CSRF token, handle the error (e.g., show an error message or log the event)
        die("Invalid CSRF token");
    }

    // Validate and process the uploaded file
    if (isset($_FILES['fileToUpload'])) {
        $file = $_FILES['fileToUpload'];

        // Check for errors during file upload
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Perform additional validation, such as file type and size checks

            // Move the uploaded file to a desired location
            $destination = "path/to/save/uploads/" . $file['name'];
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                // File upload successful, perform further actions or show a success message
                echo "File uploaded successfully!";
            } else {
                // Error handling for file upload failure
                echo "File upload failed.";
            }
        } else {
            // Error handling for file upload errors
            echo "An error occurred during file upload.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <form action="uploadanswer.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleFormControlFile1">Choose a file to upload:</label>
            <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" required>
            <br/>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Upload File" name="submit">
        </div>
    </form>
</body>
</html>