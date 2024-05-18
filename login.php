<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <style>


.footer-image {
    width: 80px; /* تعيين عرض الصورة */
    height: auto; /* السماح للارتفاع بالتكيف تلقائيًا بناءً على العرض المحدد */
}


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
    .form-container img {
        max-width: 100%;
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
    }
    .form-container h1 {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="form-container">
                    <h1 class="text-center">Login</h1>
                    <p class="text-center">Let's enjoy</p>
                    <?php if(isset($user_error)) { ?>
                        <div class="alert alert-danger"><?php echo $user_error; ?></div>
                    <?php } ?>
                    <form action="login_post.php" method="POST">
                        
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if(isset($_COOKIE['username'])) echo $_COOKIE['username']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php if(isset($_COOKIE['Password'])) echo $_COOKIE['Password']; ?>">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="keep" name="keep" value="1">
                            <label class="form-check-label" for="keep">Keep me signed in</label>
                        </div>
                        <a href="Forget_password.php" class="d-block text-right mb-3">Forget password</a>
                        
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                       
                    </form>
                    <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-container">
                    <img src="img/checklist.png" alt="Image">
                </div>
            </div>
        </div>
    </div>
    <footer class="footer fixed-bottom bg-transparent text-white text-center">
    <div class="container py-1">
        <img src="img\Palestine.jpg" alt="Description of the image" class="img-fluid footer-image">
    </div>
</footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
