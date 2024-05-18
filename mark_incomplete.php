<?php
session_start();
include('inc/connections.php');

// التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // التحقق من وجود معرف المهمة المرسل
    if(isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];

        // استعلام SQL لتحديث حالة المهمة إلى غير مكتملة
        $update_stmt = mysqli_prepare($conn, "UPDATE task SET priority = 0 WHERE user_id = ? AND task_id = ?");
        mysqli_stmt_bind_param($update_stmt, "ii", $id, $task_id);

        // تنفيذ الاستعلام
        if(mysqli_stmt_execute($update_stmt)) {
            // إعادة توجيه المستخدم إلى الصفحة الرئيسية مع رسالة نجاح
            header('Location: index.php?status=marked_incomplete');
            exit();
        } else {
            // في حالة فشل التحديث، إعادة التوجيه مع رسالة خطأ
            header('Location: index.php?status=update_failed');
            exit();
        }
    } else {
        // إعادة التوجيه إذا لم يتم تحديد معرف المهمة
        header('Location: index.php?status=task_id_missing');
        exit();
    }
} else {
    // إعادة التوجيه إذا لم يتم تسجيل الدخول
    header('Location: login.php');
    exit();
}
?>
