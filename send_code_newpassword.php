<?php
// Make sure the mail function is enabled in php.ini
ini_set("SMTP","smtp.example.com");
ini_set("smtp_port","25");

// Make sure to replace your email here
$to_email = "recipient@example.com";

if(isset($_POST['Forget_password'])){
    // Receive email from the form
    $email = $_POST['email'];

    // Generate a random code to reset the password
    $reset_code = mt_rand(100000, 999999);

    // Construct the message
    $subject = "Password Reset Request";
    $message = "To reset your password, please enter the following code: $reset_code";
    $headers = "From: sender@example.com";

    // Send the email
    if(mail($to_email, $subject, $message, $headers)){
        echo "<p class='text-success'>A password reset code has been sent to your email.</p>";
    } else{
        echo "<p class='text-danger'>An error occurred while attempting to send the email. Please try again.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .navbar {
        background-color: #28a745 !important;
    }
    .navbar-brand {
        font-weight: bold;
    }
    .profile {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .muted {
        color: #6c757d;
    }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <div class="form-container">
                <h1 class="text-center">Forget Password</h1>
                <form action="send_conf_password.php" method="POST">
                    <div class="form-group">
                       
                        <input type="password" name="new_password" id="new_password" placeholder="new password" class="form-control" required>
                    </div>
                    <div class="form-group">
                       
                        <input type="password" name="Confirm_Password" id="Confirm_Password" placeholder="Confirm Password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="Send_Code_new" value="change password" class="btn btn-primary btn-block">
                    </div>
                    <h3 class="text-center">Or</h3>
                    <a href="login.php" class="text-center d-block">Back to Login</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




