<?php
// Include the database connection file
require_once 'inc/connections.php';

if(isset($_POST['Send_Code_new'])){
    // Receive email and new password from the form
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['Confirm_Password'];

    // Perform validation
    if ($newPassword !== $confirmPassword) {
        echo "<div class='alert alert-danger' role='alert'>Passwords do not match. Please try again.</div>";
    } else {
        // Receive email from the form
        $email = $_SESSION['email']; // Assume this session has been created when sending the password reset code

        // Hash the new password (for security)
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepare the update statement
        $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);

            // Execute the update statement
            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully, redirect to login page
                header("Location: login.php");
                exit(); // Stop further execution
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error updating password: " . mysqli_stmt_error($stmt) . "</div>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error preparing statement: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>
