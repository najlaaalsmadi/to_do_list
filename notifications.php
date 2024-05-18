<?php
session_start();
include('inc/connections.php');

// Initialize notifications variable
$notifications = '';
$numNotifications = 0;

// Set $numNotifications to zero
$numNotifications = 0;

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
  $id = $_SESSION['id'];
  $username = $_SESSION['username'];

  // Prepare and execute the SQL query
  $stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Fetch user data
  if($data = mysqli_fetch_array($result)) {
    // Get current date
    $currentDate = date('Y-m-d'); // Change to current date

    // SQL query to fetch tasks that are due tomorrow
    $sql = "SELECT * FROM task WHERE createdon = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "si", $currentDate, $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      // Check if there are tasks due tomorrow
      $numNotifications = mysqli_num_rows($result); // Get the number of notifications

      if ($numNotifications > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          // Append notifications to the variable
          $notifications .= "<tr>";
          $notifications .= "<td>" . $row['task_name'] . "</td>";
          $notifications .= "<td>" . $row['createdon'] . "</td>";
          $notifications .= "<td>" . $row['description'] . "</td>";
          $notifications .= "</tr>";
        }
      } else {
        // If no tasks due tomorrow, set a message
        $notifications = "<tr><td colspan='2'>No tasks due tomorrow.</td></tr>";
      }

      mysqli_stmt_close($stmt);
    } else {
      // If error in preparing SQL statement
      $notifications = "<tr><td colspan='2'>Error in preparing SQL statement: " . mysqli_error($conn) . "</td></tr>";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Notifications (<?php echo $numNotifications; ?>)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      p{
        color: green;
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
    <a class="navbar-brand" href="notifications.php">Notifications (<?php echo $numNotifications; ?>)</a>
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
<br>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-1">
            <div class="profile mt-5">
                <h2 class="text-center mb-4">Notifications</h2>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Task Date </th>
                            <th scope="col">Task Description </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php echo $notifications; ?>
                    </tbody>
                </table>
                <p class="text-sucess text-center">These tasks are important for today.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
