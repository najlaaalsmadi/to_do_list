<?php
session_start();
include('inc/connections.php');

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // Prepare and execute the SQL query to fetch tasks for the current user
    $stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are any tasks
    if(mysqli_num_rows($result) > 0) {
?>




<?php


// التأكد من وجود معرف المهمة في الطلب
if(isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // استعداد وتنفيذ الاستعلام لاسترداد تفاصيل المهمة
    $stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE task_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $task_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // التأكد من وجود المهمة في قاعدة البيانات
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
        }
        .container {
            padding-top: 50px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="index.php">To Do List</a>
    <a class="navbar-brand" href="notifications.php">Notifications</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
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
    <h1 class="mt-5">Edit Task</h1>
    <form action="update_task.php" method="POST">
        <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo $row['task_name']; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"><?php echo $row['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="task_date" class="form-label">Task Date</label>
            <input type="date" class="form-control" id="task_date" name="task_date" value="<?php echo $row['createdon']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    } else {
        echo "Task not found.";
    }
} else {
    echo "Invalid task ID.";
}
?>
<?php
    } else {
        // If there are no tasks, display a message
        echo "No tasks found.";
    }

} else {
    header('Location:login.php');
    exit();
}
?>
