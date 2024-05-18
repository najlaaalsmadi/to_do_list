<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            font-weight: bold;
            color: #007bff;
        }
        .form-container p {
            font-size: 18px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input, .form-group select {
            border-radius: 5px;
            padding: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-container img {
            display: block;
            margin: 0 auto;
            margin-top: 20px;
            max-width: 100%;
        }
        .footer-image {
            width: 80px;
            height: auto;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <div class="form-container">
                <h1 class="text-center">Register Page</h1>
                <p class="text-center">It's very easy</p>
                <form action="register_Post.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                    </div>
                    <div class="row">
    <div class="col">
        <select aria-label="Month" name="birthday_month" id="birthday_month" title="Birthday Month" class="form-control" required>
            <option disabled selected>Month</option>
            <option value="1">Jan</option>
            <option value="2">Feb</option>
            <option value="3">Mar</option>
            <option value="4">Apr</option>
            <option value="5">May</option>
            <option value="6">Jun</option>
            <option value="7">Jul</option>
            <option value="8">Aug</option>
            <option value="9">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>
    </div>
    <div class="col">
        <select aria-label="Day" name="birthday_day" id="birthday_day" title="Birthday Day" class="form-control" required>
            <option disabled selected>Day</option>
            <?php for($i = 1; $i <= 31; $i++) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col">
        <select aria-label="Year" name="birthday_year" id="birthday_year" title="Birthday Year" class="form-control" required>
            <option disabled selected>Year</option>
            <?php for($i = date("Y"); $i >= date("Y") - 100; $i--) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<br>
                    <div class="form-group">
                        <select name="gender" title="Choose male or female" class="form-control">
                            <option disabled selected>Choose</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" id="submit" value="Register" class="btn btn-primary btn-block">
                    </div>
                    <h3 class="text-center">Or</h3>
                    <a href="login.php" class="text-center d-block">Login</a>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-container">
                <img src="img/laptop.png" alt="Laptop" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<footer class="footer bg-white">
    <div class="container">
        <img src="img/Palestine.jpg" alt="Palestine Flag" class="img-fluid footer-image">
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
