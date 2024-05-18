<?php
// تحقق من وجود معرف المهمة في عنوان الصفحة
if(isset($_GET['task_id'])) {
    // استدعاء ملف الاتصال بقاعدة البيانات
    include('inc/connections.php');
    
    // استلام معرف المهمة من عنوان الصفحة
    $task_id = $_GET['task_id'];
    
    // تحديث قيمة الأولوية في قاعدة البيانات لتعبر عن أن المهمة تمت
    $update_stmt = mysqli_prepare($conn, "UPDATE task SET priority = 1 WHERE task_id = ?");
    mysqli_stmt_bind_param($update_stmt, "i", $task_id);
    mysqli_stmt_execute($update_stmt);
    
    // إعادة توجيه المستخدم إلى صفحة العرض (index.php) بعد الانتهاء
    header('Location: index.php');
    exit();
} else {
    // في حالة عدم وجود معرف المهمة في عنوان الصفحة، قم بإعادة توجيه المستخدم إلى صفحة العرض (index.php)
    header('Location: index.php');
    exit();
}
?>
