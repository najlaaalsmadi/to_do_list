<?php
/*session_start();
include('inc/connections.php');

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    if(isset($_GET['add_note'])) {
        // الحصول على بيانات الجلسة
        $user_id = $_SESSION['id'];
        $username = $_SESSION['username'];

        // استلام البيانات من النموذجo
        $note = $_GET['title'];
        $task_month = $_GET['task_month'];
        $task_day = $_GET['task_day'];
        $task_year = $_GET['task_year'];

        // توليد التاريخ كامل
        $activity_date = "$task_year-$task_month-$task_day";

        // تحضير الاستعلام SQL لإدراج البيانات
        $stmt = mysqli_prepare($conn, "INSERT INTO notes (user_id, note, activity_date) VALUES (?, ?, ?)");
        
        // فحص نجاح تحضير الاستعلام
        if($stmt) {
            // ربط المتغيرات ببيانات الاستعلام
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $note, $activity_date);

            // تنفيذ الاستعلام
            $success = mysqli_stmt_execute($stmt);

            if($success) {
                // تمت إضافة البيانات بنجاح
                header('Location:Add_Note.php');


            } else {
                // فشلت عملية إضافة البيانات
                echo "Failed to add note.";
            }
        } else {
            // فشل في تحضير الاستعلام
            echo "Error preparing SQL statement.";
        }
    } else {
        // لم يتم تقديم النموذج بشكل صحيح
        echo "Form data not submitted.";
    }
} else {
    // المستخدم غير مسجل الدخول
    header('Location:login.php');
    exit();
}*/
?>
<?php
session_start();
include('inc/connections.php');

if(isset($_SESSION['id'], $_SESSION['username'], $_GET['add_note'], $_GET['title'], $_GET['task_month'], $_GET['task_day'], $_GET['task_year'], $_GET['task_id'])) {
    // الحصول على بيانات الجلسة
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // استلام البيانات من النموذج
    $note = $_GET['title'];
    $task_id = $_GET['task_id'];
    $task_month = $_GET['task_month'];
    $task_day = $_GET['task_day'];
    $task_year = $_GET['task_year'];

    // تحقق من صحة المدخلات
    if(empty($note) || empty($task_month) || empty($task_day) || empty($task_year) || empty($task_id)) {
        echo "All fields are required.";
        exit();
    }

    // توليد التاريخ كامل
    $activity_date = "$task_year-$task_month-$task_day";

    // تحضير الاستعلام SQL لإدراج البيانات
    $stmt = mysqli_prepare($conn, "INSERT INTO notes (user_id, task_id, note, activity_date) VALUES (?, ?, ?, ?)");
    
    // فحص نجاح تحضير الاستعلام
    if($stmt) {
        // ربط المتغيرات ببيانات الاستعلام
        mysqli_stmt_bind_param($stmt, "iiss", $user_id, $task_id, $note, $activity_date);

        // تنفيذ الاستعلام
        $success = mysqli_stmt_execute($stmt);

        // التحقق من نجاح الإضافة
        if($success) {
            // تمت إضافة البيانات بنجاح
            header('Location:Add_Note.php');
            exit();
        } else {
            // فشلت عملية إضافة البيانات
            echo "Failed to add note.";
        }
    } else {
        // فشل في تحضير الاستعلام
        echo "Error preparing SQL statement.";
    }
} else {
    // المتغيرات المطلوبة غير متوفرة أو لم يتم تقديم النموذج بشكل صحيح
    echo "Form data not submitted or incomplete.";
}
?>


