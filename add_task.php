<?php
session_start();
include('inc/connections.php');

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
  $id = $_SESSION['id'];
  $username = $_SESSION['username'];

  // Prepare and execute the SQL query
  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Fetch user data
  if($data = mysqli_fetch_array($result)) {
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add task</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    
    <style>
 body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
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
                <h1 class="text-center">add task</h1>
                <form action="add_task_get.php" method="GET">
                    <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <input type="text" name="title" id="title" placeholder="title task" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="description" id="description" placeholder="description task" class="form-control">
                    </div>
    
                    <div class="form-group">
            <input type="date" class="form-control" id="task_date" name="task_date" placeholder="Task Date">
        </div>


                    <div class="form-group">
                        <input type="submit" name="add_task" id="add_task" value="add task" class="btn btn-primary btn-block">
                    </div>
                    <h3 class="text-center">Or</h3>
                    <a href="index.php" class="text-center d-block">back to home</a>
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

<?php
  }
} else {
  header('Location:login.php');
  exit();
}
?>
