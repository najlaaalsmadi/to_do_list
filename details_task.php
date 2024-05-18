<?php
// قم بتضمين ملف الاتصال بقاعدة البيانات هنا

// قم بفحص معرف المهمة المرسل عبر الطلب
if(isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // استعلم عن قاعدة البيانات لاسترداد تفاصيل المهمة
    // قم بتعديل الاستعلام والجدول والحقول حسب هيكل قاعدة البيانات الخاصة بك
    $query = "SELECT * FROM tasks WHERE id = $task_id";
    $result = mysqli_query($connection, $query);

    if($result && mysqli_num_rows($result) > 0) {
        $task = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Task Details</title>
        </head>
        <body>
            <h1>Task Details</h1>
            <p><strong>Title:</strong> <?php echo $task['title']; ?></p>
            <p><strong>Due Date:</strong> <?php echo $task['due_date']; ?></p>
            <p><strong>Priority:</strong> <?php echo $task['priority']; ?></p>
            <p><strong>Description:</strong> <?php echo $task['description']; ?></p>
        </body>
        </html>
        <?php
    } else {
        echo "Task not found.";
    }
} else {
    echo "Task ID not provided.";
}
?>
