<?php
// افتح الجلسة
session_start();

// تضمين ملف الاتصال بقاعدة البيانات
include('inc/connections.php');

// التحقق من تسجيل الدخول
if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // التحقق من وجود معرف الملاحظة في الرابط
    if(isset($_GET['note_id'])) {
        $note_id = $_GET['note_id'];

        // استعلام SQL لحذف الملاحظة
        $stmt = mysqli_prepare($conn, "DELETE FROM notes WHERE note_id = ?");
        
        // التحقق من صحة استعلام SQL
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $note_id);
            $stmt_exec = mysqli_stmt_execute($stmt);
            
            // التحقق من نجاح الاستعلام
            if($stmt_exec) {
                // إعادة توجيه المستخدم إلى صفحة تفاصيل المهمة أو أي صفحة أخرى
                header('Location:index.php');
                exit();
            } else {
                // في حالة فشل تنفيذ الاستعلام
                echo "Failed to delete note.";
            }
        } else {
            // في حالة فشل استعلام SQL
            echo "Failed to prepare SQL statement.";
        }
    } else {
        // في حالة عدم وجود معرف الملاحظة في الرابط
        echo "Note ID not provided.";
    }
} else {
    // في حالة عدم تسجيل الدخول
    header('Location: login.php');
    exit();
}
?>
