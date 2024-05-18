<?php
session_start();
include('inc/connections.php');

// تحقق من وجود جلسة نشطة
if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // تحضير الاستعلام لاسترداد بيانات المستخدم
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // جلب بيانات المستخدم
    if($data = mysqli_fetch_array($result)) {
        // تحقق من وجود البيانات المطلوبة
        if(isset($_GET['title']) && isset($_GET['description']) && isset($_GET['task_date']) ){
            // تحضير البيانات
            $title = $_GET['title'];
            $description = $_GET['description'];
            $task_date = $_GET['task_date'] ; // تجميع التاريخ في صيغة صحيحة

            // استعداد وتنفيذ الاستعلام لإضافة البيانات
            $stmt = mysqli_prepare($conn, "INSERT INTO task (task_name, description, createdon, user_id) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $task_date, $data['id']);
            mysqli_stmt_execute($stmt);

            // التحقق من نجاح الإضافة
            if(mysqli_stmt_affected_rows($stmt) > 0) {
                // تمت الإضافة بنجاح
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                // توجيه المستخدم إلى صفحة index.php بعد إضافة المهمة
                header('Location: index.php');
                exit();
            } else {
                // فشلت عملية الإضافة
                echo "Failed to add task.";
            }

            // إغلاق الاستعلام
            mysqli_stmt_close($stmt);
        } else {
            // إذا لم يتم إرسال البيانات بشكل صحيح
            echo "Please fill all the required fields.";
        }
    } else {
        // في حالة عدم توافق بيانات المستخدم
        echo "User data not found.";
    }

    // إغلاق الاتصال بقاعدة البيانات
    mysqli_close($conn);
} else {
    // إذا لم يتم بدء الجلسة
    header('Location:login.php');
    exit();
}
?>
