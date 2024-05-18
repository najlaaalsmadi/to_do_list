<?php
session_start();
include('inc/connections.php');

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // التأكد من وجود بيانات مرسلة
    if(isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];

        // استعداد وتنفيذ الاستعلام لحذف المهمة
        $stmt = mysqli_prepare($conn, "DELETE FROM task WHERE task_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $task_id);
        mysqli_stmt_execute($stmt);

        // التحقق من نجاح الحذف
        if(mysqli_stmt_affected_rows($stmt) > 0) {
            // تم الحذف بنجاح
            // إغلاق الاستعلام والاتصال بقاعدة البيانات
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            // توجيه المستخدم إلى صفحة index.php بعد حذف المهمة
            header('Location: index.php', true, 302);
            die();
        } else {
            // فشلت عملية الحذف
            echo "Failed to delete task.";
        }
    } else {
        // إذا لم يتم إرسال معرف المهمة بشكل صحيح
        echo "Invalid task ID.";
    }
} else {
    header('Location:index.php');
    exit();
}
?>