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
    <title>Add Note</title>
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
                <h1 class="text-center">Add Note</h1>
                <form action="add_note_get.php" method="GET" onsubmit="return validateForm()">
                    <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="task_id" value="<?php echo $_GET['task_id']; ?>">

                    <div class="form-group">
                        <input type="text" name="title" id="title" placeholder="Note" class="form-control" required>
                    </div>
                   
                   
                    <div class="row">
                        <div class="col">
                            <select aria-label="Month" name="task_month" id="task_month" title="Task Month" class="form-control" required>
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
                            <select aria-label="Day" name="task_day" id="task_day" title="Task Day" class="form-control" required>
                               <option disabled selected>DAY</option>
                                <?php for($i = 1; $i <= 31; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <select aria-label="Year" name="task_year" id="task_year" title="Task Year" class="form-control" required>
                                  <option disabled selected>Year</option>
                                  <?php for($i = date("Y"); $i <= date("Y") + 10; $i++) { ?>
                                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                  <?php } ?>
                            </select>
                            <br>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add_note" id="add_note" value="Add Note" class="btn btn-primary btn-block">
                    </div>
                    <h3 class="text-center">Or</h3>
                    <a href="Add_Note.php" class="text-center d-block">Back Note</a>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function validateForm() {
        var title = document.getElementById("title").value;
        var task_month = document.getElementById("task_month").value;
        var task_day = document.getElementById("task_day").value;
        var task_year = document.getElementById("task_year").value;

        if (title == "" || task_month == "" || task_day == "" || task_year == "") {
            alert("All fields must be filled out");
            return false;
        }
        return true;
    }
</script>
</body>
</html>



<?php
  }
} else {
  header('Location:login.php');
  exit();
}
?>
