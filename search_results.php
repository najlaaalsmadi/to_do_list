<?php
session_start();
include('inc/connections.php');

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
        echo '<tr><th>Task Name</th><th>Task Date</th><th>Task Description</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['task_name'] . '</td>';
            echo '<td>' . $row['createdon'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
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
