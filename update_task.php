<?php
session_start();
include('inc/connections.php');

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    if (isset($_POST['task_id'], $_POST['task_name'], $_POST['description'], $_POST['task_date'])) {
        $task_id = $_POST['task_id'];
        $task_name = $_POST['task_name'];
        $description = $_POST['description'];
        $task_date = $_POST['task_date'];

        // Prepare and execute the SQL query to update the task
        $stmt = mysqli_prepare($conn, "UPDATE task SET task_name = ?, description = ?, createdon = ? WHERE task_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $task_name, $description, $task_date, $task_id);
            $success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($success) {
                header('Location: index.php');
            } else {
                echo "Error updating task: " . mysqli_error($conn);
            }
        } else {
            echo "Error preparing update statement: " . mysqli_error($conn);
        }
    } else {
        echo "Incomplete data submitted.";
    }
} else {
    header('Location: login.php');
    exit();
}
?>
