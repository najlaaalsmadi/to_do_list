<?php
session_start();
include('inc/connections.php');

if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $md5_pass = md5($password);

    // تحقق من تاريخ الميلاد
    if(isset($_POST['birthday_month'], $_POST['birthday_day'], $_POST['birthday_year'])) {
        $birthday_month = (int)$_POST['birthday_month'];
        $birthday_day = (int)$_POST['birthday_day'];
        $birthday_year = (int)$_POST['birthday_year'];
        $birthday = $birthday_year . '-' . $birthday_month . '-' . $birthday_day;
    }

    if(isset($_POST['gender'])) {
        $gender = $_POST['gender'];
        if(!in_array($gender, ['Male', 'Female'])) {
            $gender_error = "<p class='error'>Please choose a valid gender.</p>";
            $err_s = true;
        }
    }

    if(empty($username)) {
        $user_error = "<p class='error'>Please enter a username.</p>";
        $err_s = true;
    } elseif(strlen($username) < 6) {
        $user_error = "<p class='error'>Your username needs to have a minimum of 6 characters.</p>";
        $err_s = true;
    }

    if(empty($email)) {
        $email_error = "<p class='error'>Please enter an email.</p>";
        $err_s = true;
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "<p class='error'>Please enter a valid email.</p>";
        $err_s = true;
    }

    if(empty($birthday)) {
        $birthday_error = "<p class='error'>Please enter your birthday.</p>";
        $err_s = true;
    }

    if(empty($password)) {
        $pass_error = "<p class='error'>Please enter a password.</p>";
        $err_s = true;
    } elseif(strlen($password) < 6) {
        $pass_error = "<p class='error'>Your password needs to have a minimum of 6 characters.</p>";
        $err_s = true;
    }

    if(!$err_s) {
        $check_user = "SELECT * FROM `users` WHERE username='$username'";
        $check_result = mysqli_query($conn, $check_user);
        
        if (!$check_result) {
            // Query execution failed
            $user_error = '<p class="error">Error: ' . mysqli_error($conn) . '</p>';
        } else {
            // Query executed successfully
            $num_rows = mysqli_num_rows($check_result);
            if ($num_rows != 0) {
                $user_error = '<p class="error">Sorry, username already exists. Please choose another one.</p>';
                $err_s = true;
            }
        }

        if(!$err_s) {
            if($gender=='Female'){
                $picture='female.jpeg';
            }elseif($gender=='Male'){
                $picture='male.jpeg';
            }

            $sql = "INSERT INTO users (username, email, password, gender, birthday, md5_pass,profile_picture)
                    VALUES ('$username', '$email', '$password', '$gender', '$birthday', '$md5_pass', '$picture')";
            if(mysqli_query($conn, $sql)) {
                header("Location: login.php");
                exit();
            } else {
                $user_error = '<p class="error">Error: ' . mysqli_error($conn) . '</p>';
            }
        }
    }
}

include('register.php');
?>
