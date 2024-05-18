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


if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // Prepare and execute the SQL query to fetch required tasks for the current user
    // Prepare and execute the SQL query to fetch required tasks for the current user, ordered by title
$required_tasks_stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ? AND priority = 0 ORDER BY task_name");
mysqli_stmt_bind_param($required_tasks_stmt, "i", $id);
mysqli_stmt_execute($required_tasks_stmt);
$required_tasks_result = mysqli_stmt_get_result($required_tasks_stmt);


    // Prepare and execute the SQL query to fetch completed tasks for the current user
    $completed_tasks_stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ? AND priority = 1");
    mysqli_stmt_bind_param($completed_tasks_stmt, "i", $id);
    mysqli_stmt_execute($completed_tasks_stmt);
    $completed_tasks_result = mysqli_stmt_get_result($completed_tasks_stmt);

    // Check if there are any required tasks
    if(mysqli_num_rows($required_tasks_result) > 0 || mysqli_num_rows($completed_tasks_result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>To Do List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .search-form {
        margin-bottom: 20px;
    }
    .search-form input[type="text"] {
        width: 60%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }
    .search-form select {
        width: 30%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .search-form button {
        padding: 8px 15px;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
    }
    .search-form button:hover {
        background-color: #0056b3;
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
<?php

if(isset($_GET['search'])) {
    $search = $_GET['search'];

    // Prepare SQL query to search for tasks by name or date
    $sql = "SELECT * FROM task WHERE user_id = ? AND (task_name LIKE ? OR createdon LIKE ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Add values to the prepared statement
    $search_term = "%$search%";
    mysqli_stmt_bind_param($stmt, "iss", $id, $search_term, $search_term);

    // Execute the query
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are search results
    
    if(mysqli_num_rows($result) > 0) {
        // Display the search results in a table
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr><th>Task Name</th><th>Task Date</th><th>Task Description</th><th>Action</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['task_name'] . '</td>';
            echo '<td>' . $row['createdon'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            if($row['priority'] == 0) {
              echo "<td>
              <button type=\"button\" class=\"btn btn-primary\" onclick=\"location.href='mark_completed.php?task_id=" . $row['task_id'] . "'\">Complete</button> | 
              <button type=\"button\" class=\"btn btn-success\" onclick=\"location.href='edit_task.php?task_id=" . $row['task_id'] . "'\">Edit</button> | 
              <button type=\"button\" class=\"btn btn-danger\" onclick=\"location.href='delete_task.php?task_id=" . $row['task_id'] . "'\">Delete</button>
              <button type=\"button\" class=\"btn btn-secondary\" onclick=\"location.href='Add_Note.php?task_id=" . $row['task_id'] . "'\">All Note</button>

              </td>";
     
          } else {
              echo "<td>

                    <button type=\"button\" class=\"btn btn-warning\" onclick=\"location.href='mark_incomplete.php?task_id=" . $row['task_id'] . "'\">Retrieve</button>              | 
                    <button type=\"button\" class=\"btn btn-danger\" onclick=\"location.href='delete_task.php?task_id=" . $row['task_id'] . "'\">Delete</button>
                    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"location.href='Add_Note.php?task_id=" . $row['task_id'] . "'\">All Note</button>

                    </td>";
          }
          
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        // If there are no search results, display a message
        echo "<div class=\"alert alert-info\" role=\"alert\">No matching tasks found.</div>";
    }
}

// قراءة قيمة الفرز من النموذج
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_asc';

// استخدام قيمة الفرز في الاستعلام SQL
if ($sort === 'date_asc') {
    // فرز حسب التاريخ بترتيب تصاعدي
    $required_tasks_stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ? AND priority = 0 ORDER BY createdon ASC");
} elseif ($sort === 'date_desc') {
    // فرز حسب التاريخ بترتيب تنازلي
    $required_tasks_stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ? AND priority = 0 ORDER BY createdon DESC");
} elseif ($sort === 'priority_asc') {
    // فرز حسب الأولوية بترتيب تصاعدي
    $required_tasks_stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ? AND priority = 0 ORDER BY priority ASC");
} elseif ($sort === 'priority_desc') {
    // فرز حسب الأولوية بترتيب تنازلي
    $required_tasks_stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE user_id = ? AND priority = 0 ORDER BY priority DESC");
}
?>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="profile">
      <div class="card-header">
      <div class="d-flex justify-content-center mb-3">
  <div class="btn-group" role="group" aria-label="Basic outlined example">
    <button type="button" class="btn btn-outline-primary" id="showCompleteTasks">Show Completed Tasks</button>
    <button type="button" class="btn btn-outline-primary" id="showIncompleteTasks">Show Incomplete Tasks</button>
  </div>
</div>                    
</div>
        <a href="add_task.php" class="btn btn-primary mb-3">Add Task</a>
        <!-- Search section on the page -->
        <form class="search-form mb-3" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search for a task...">
            <select id="sort" class="form-select" name="sort" aria-label="Sort By">
              <option value="date_asc">&#xf073; Date (Oldest First)</option>
              <option value="date_desc">&#xf074; Date (Newest First)</option>
              <option value="priority_asc">&#xf077; Priority (Low to High)</option>
              <option value="priority_desc">&#xf078; Priority (High to Low)</option>
            </select>
            <button class="btn btn-outline-secondary" type="submit">Search</button>
          </div>
        </form>
        <!-- Links section -->


   


        <!-- Display tasks -->
        <div class="muted">
          
          <div class="table-responsive">
            <table class="table table-hover" id="completedTasksTable">
              <thead>
                <tr>
                  <th scope="col">Task</th>
                  <th scope="col">Task Date</th>
                  <th scope="col">Task Description</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody id="sortableTableBody">
                <?php
                // Loop through each required task and display them in the table rows
                while($row = mysqli_fetch_assoc($required_tasks_result)) {
                   echo "<tr>";
                   echo "<td>" . $row['task_name'] . "</td>";
                   echo "<td>" . $row['createdon'] . "</td>";
                   echo "<td>" . $row['description'] . "</td>";
                   echo "<td>
                   <button type=\"button\" class=\"btn btn-primary\" onclick=\"location.href='mark_completed.php?task_id=" . $row['task_id'] . "'\">Complete</button> | 
                   <button type=\"button\" class=\"btn btn-success\" onclick=\"location.href='edit_task.php?task_id=" . $row['task_id'] . "'\">Edit</button> | 
                   <button type=\"button\" class=\"btn btn-danger\" onclick=\"location.href='delete_task.php?task_id=" . $row['task_id'] . "'\">Delete</button>|
                   <button type=\"button\" class=\"btn btn-secondary\" onclick=\"location.href='Add_Note.php?task_id=" . $row['task_id'] . "'\">All Note</button>
                   </td>";          
                   echo "</tr>"; 
                }
                ?>
              </tbody>
            </table>
          </div>

         <!-- <h2 class="text-success">Completed tasks</h2>-->
          <div class="table-responsive">
            <table class="table table-hover" id="incompleteTasksTable" style="display:none;">
           
              <thead>
                <tr>
                  <th scope="col">Task</th>
                  <th scope="col">Task Date</th>
                  <th scope="col">Task Description</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Loop through each completed task and display them in the table rows
                while($row = mysqli_fetch_assoc($completed_tasks_result)) {
                   echo "<tr>";
                   echo "<td><del>" . $row['task_name'] . "</del></td>";
                   echo "<td><del>" . $row['createdon'] . "</del></td>";
                   echo "<td><del>" . $row['description'] . "</del></td>";
                   echo "<td>
                    <button type=\"button\" class=\"btn btn-warning\" onclick=\"location.href='mark_incomplete.php?task_id=" . $row['task_id'] . "'\">Retrieve</button>              | 
                    <button type=\"button\" class=\"btn btn-danger\" onclick=\"location.href='delete_task.php?task_id=" . $row['task_id'] . "'\">Delete</button>
                    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"location.href='Add_Note.php?task_id=" . $row['task_id'] . "'\">All Note</button>

                    </td>";
                   echo "</tr>"; 
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

</body>
</html>

<?php
    } else {
        // If there are no tasks, display a message
        header('Location: add_task.php');
      }

} else {
    header('Location:login.php');
    exit();
}
?>


<?php
    } else {
        // If there are no tasks, display a message
        header('Location: add_task.php');
      }

} else {
    header('Location:login.php');
    exit();
}
?>
<script>
document.getElementById("showCompleteTasks").addEventListener("click", function() {
  document.getElementById("completedTasksTable").style.display = "table";
  document.getElementById("incompleteTasksTable").style.display = "none";
});

document.getElementById("showIncompleteTasks").addEventListener("click", function() {
  document.getElementById("completedTasksTable").style.display = "none";
  document.getElementById("incompleteTasksTable").style.display = "table";
});
</script>
<script>
  var sortableTable = new Sortable(document.getElementById('sortableTableBody'), {
    animation: 150, // animation duration in milliseconds
    ghostClass: 'bg-primary', // class applied to the ghost element
    onUpdate: function (evt) {
      // Callback function when sorting is completed
      var item = evt.item; // dragged element
      // You can perform any necessary actions here, such as updating the database
    }
  });
</script>
