<?php
session_start();

// Redirect logged-in users to a different page
if (isset($_SESSION['teacher']) || isset($_SESSION['student'])) {
    header('Location: index.php');
    exit();
}

$errorMessages = [];

// Handle form submission
if (isset($_POST['save'])) {
    // Validate and sanitize input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
    $confirmPassword = filter_input(INPUT_POST, 'cpass', FILTER_SANITIZE_STRING);

    // Perform server-side validation
    if (!validateUsername($username)) {
        $errorMessages[] = "Username must have lowercase characters (a-z) or numbers (0-9) or underscores(_), no special characters and length from 5 to 30!";
    }

    if (!validatePassword($password)) {
        $errorMessages[] = "Password must have characters (a-z) or numbers (0-9) or underscores(_), length under 30!";
    }

    if ($password !== $confirmPassword) {
        $errorMessages[] = "Wrong confirmed password";
    }
}

// Function to validate username
function validateUsername($username)
{
    // Implement your validation logic here
    // Return true if the username is valid, otherwise false
    // Example validation logic:
    return preg_match('/^[a-z0-9_]{5,30}$/i', $username);
}

// Function to validate password
function validatePassword($password)
{
    // Implement your validation logic here
    // Return true if the password is valid, otherwise false
    // Example validation logic:
    return preg_match('/^[a-z0-9_]{1,30}$/i', $password);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assests/css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="signup-form">
        <form action="signup_a.php" method="post" enctype="multipart/form-data">
            <h2>Sign up as a teacher, create your class!</h2>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required="required">
            </div>  
            <?php foreach ($errorMessages as $error): ?>
                <p style="color: red"><?php echo $error; ?></p>
            <?php endforeach; ?>  
            <div class="form-group">
                <input type="password" class="form-control" name="pass" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="cpass" placeholder="Confirm Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" name="save" class="btn btn-info btn-lg btn-block">Add now</button>
            </div>
        </form>
        <p style="color: green">
     <?php 
     $comeback = '';
     if(isset($_GET['status']) && $_GET['status']=="success") { 
       $comeback = '<a href="index.php"><button type="button" class="btn btn-secondary">Come back to home page</button></a>'; 
       echo "Adding successfully!"; 
     } 
     ?>
     </p>
    <?php echo $comeback; ?>
    </div>
</body>
</html>