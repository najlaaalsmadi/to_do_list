<?php
session_start();
include('inc/connections.php');

// Initialize notifications variable
$notifications = '';
$numNotifications = 0;

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
    // Get current date
    $currentDate = date('Y-m-d');

    // SQL query to fetch tasks that are due today for the current user
    $sql = "SELECT * FROM task WHERE createdon = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $currentDate, $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if there are tasks due today
        $numNotifications = mysqli_num_rows($result); // Get the number of notifications

        if ($numNotifications > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Append notifications to the variable
                $notifications .= "Reminder: Task '" . $row['task_name'] . "' is due today (" . $row['createdon'] . ")<br>";
            }
        } else {
            // If no tasks due today, set a message
            $notifications = "No tasks due today.";
        }

        mysqli_stmt_close($stmt);
    } else {
        // If error in preparing SQL statement
        $notifications = "Error in preparing SQL statement: " . mysqli_error($conn);
    }
  }

}

?>




<?php

include('inc/connections.php');

// Check if the session variables are set
if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // Prepare and execute the SQL query to fetch tasks for the current user
    $stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ? AND task_name = 'Personal Affairs'");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are any tasks
    if(mysqli_num_rows($result) > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Personal Affairs Tasks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .container {
        padding-top: 10px;
    }
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
        padding-top: 40px;
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
    /* Improved table style */
    .table th,
    .table td {
        vertical-align: middle;
    }
    .table th {
        background-color: #007bff;
        color: #fff;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 123, 255, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.2);
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="index.php">To Do List</a>
    <a class="navbar-brand" href="notifications.php">Notifications(<?php echo $numNotifications; ?>)</a>
    <a class="navbar-brand" href="all_task.php">All Task</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-light navbar-brand" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px;">
          Categories Task
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="Work.php">Work</a></li>
          <li><a class="dropdown-item" href="Study.php">Study</a></li>
          <li><a class="dropdown-item " href="Personal_Affairs.php">Personal Affairs</a></li>
        </ul>
      </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Welcome, <?php echo $username; ?>!</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="user_information.php">User Information</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item " href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
  <div class="profile">
    <h2 class="text-center mt-5">Personal Affairs Tasks</h2>
    <div class="row mt-3">
      <div class="col-md-8 offset-md-2">
        <?php
        // Display tasks
        ?>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Task Name</th>
                <th scope="col">Task Date</th>
                <th scope="col">Task Description</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>';
                  echo '<td>' . $row['task_name'] . '</td>';
                  echo '<td>' . $row['createdon'] . '</td>';
                  echo '<td>' . $row['description'] . '</td>';
                  if($row['priority'] == 0) {
                    echo "<td>
                    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"location.href='Add_Note.php?task_id=" . $row['task_id'] . "'\">All Note</button>

                    <button type=\"button\" class=\"btn btn-primary\" onclick=\"location.href='mark_completed.php?task_id=" . $row['task_id'] . "'\">Complete</button> | 
                    <button type=\"button\" class=\"btn btn-success\" onclick=\"location.href='edit_task.php?task_id=" . $row['task_id'] . "'\">Edit</button> | 
                    <button type=\"button\" class=\"btn btn-danger\" onclick=\"location.href='delete_task.php?task_id=" . $row['task_id'] . "'\">Delete</button>
                     </td>";
           
                } else {
                    echo "<td>
                    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"location.href='Add_Note.php?task_id=" . $row['task_id'] . "'\">All Note</button>

                          <button type=\"button\" class=\"btn btn-warning\" onclick=\"location.href='mark_incomplete.php?task_id=" . $row['task_id'] . "'\">Retrieve</button>              | 
                          <button type=\"button\" class=\"btn btn-danger\" onclick=\"location.href='delete_task.php?task_id=" . $row['task_id'] . "'\">Delete</button>
                          </td>";
                }
                  echo '</tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
        <?php
        // Free result set
        mysqli_free_result($result);
        ?>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    } else {
        // If there are no tasks, display a message
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Personal Affairs Tasks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .container {
        padding-top: 60px;
    }
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
        padding-top: 40px;
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
    /* Improved table style */
    .table th,
    .table td {
        vertical-align: middle;
    }
    .table th {
        background-color: #007bff;
        color: #fff;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 123, 255, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.2);
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="index.php">To Do List</a>
    <a class="navbar-brand" href="notifications.php">Notifications</a>
    <a class="navbar-brand" href="all_task.php">All Task</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-light navbar-brand" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px;">
        Categories task 
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="Work.php">Work</a></li>
          <li><a class="dropdown-item" href="Study.php">Study</a></li>
          <li><a class="dropdown-item " href="Personal_Affairs.php">Personal Affairs</a></li>
        </ul>
      </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Welcome, <?php echo $username; ?>!</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="user_information.php">User Information</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item " href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
  <div class="profile">
    <h2 class="text-center mt-5">Personal Affairs Tasks</h2>
    <div class="row mt-3">
      <div class="col-md-8 offset-md-2">
        <div class="text-center mt-4">
          <p class="lead">No tasks found.</p>
          <a href="add_task.php" class="btn btn-primary btn-lg">Add Task</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    }
} else {
    // Redirect to login page if session variables are not set
    header('Location:login.php');
    exit();
}
?>
