<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('inc/connections.php');

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // Prepare and execute the SQL query (using prepared statements for security)
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch user data
    if ($data = mysqli_fetch_array($result)) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom Styles */
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
       
    </style>
</head>
<body>
    <div class="container">
        <div class="row">

            <div class="col-md-6 offset-md-4 row justify-content-center align-items-center vh-100">
                <div class="profile">
                    <div class="photo text-center">
                        <?php
                        // Checking if profile picture exists
                        if (!empty($data['profile_picture'])) {
                            // Escape the profile picture filename to prevent potential security issues
                            echo "<img src='img/" . $data['profile_picture'] . "' alt='Profile Picture' class='img-fluid rounded-circle'>";
                        } else {
                            echo "<p class='text-danger'>Profile picture not found</p>";
                        }
                        ?>
                    </div>

                    <form action="upload_image.php" method="POST" enctype="multipart/form-data">
                                       <input type="file" name="file" id="file">
                                    
                                       <input type="submit" name="upload" value="upload" class="btn btn-primary btn-inline">
                    </form>
                          <?php if(isset($error)) { echo $error;}?>
                          <div class="info mt-3">
                               <table class="table table-striped">
                            <tbody>
                            
                            
                              
                                <tr>
                                    <th scope="row">Username</th>
                                    <td><?php echo $data['username']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><?php echo $data['email']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Gender</th>
                                    <td><?php echo $data['gender']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Birthday</th>
                                    <td><?php echo $data['birthday']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Logout websit</th>
                                    <td> <a href="logout.php" class="btn btn-danger">Logout website</a></td>
                                </tr>
                                <tr>
                                    <th scope="row">back home page</th>
                                    <td><div class="back"><a href="index.php" class="btn btn-primary">back home page </a></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    }
} else {
    header('Location:login.php');
    exit();
}
?>
