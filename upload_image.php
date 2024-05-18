<?php
include_once('inc/connections.php'); // تغيير الشرطة إلى انقطاع السطر

$error = ""; // إنشاء المتغير $error وتعيينه إلى قيمة فارغة

if(empty($_FILES['file']['name'])){ // استخدم $_FILES بدلاً من $_POST للتحقق من الملف المرفق
    $error = "Please choose a photo to upload!"; // تغيير رسالة الخطأ
    include_once('user_information.php');
} else {
    session_start();
}

if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if(isset($_POST['upload'])){ // تغيير الشرطة إلى انقطاع السطر
        $file = $_FILES['file'];
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_ext = explode('.',$file_name);
        $file_actual_ext = strtolower(end($file_ext));
        $allowed = array('jpg','jpeg','png','svg'); // تصحيح الأنواع المسموح بها

        if(in_array($file_actual_ext,$allowed)) {
            if($file_error === 0){
                if($file_size < 3000000){
                    $file_new_name = uniqid('',true).'.'.$file_actual_ext;
                    $target = 'img/'.$file_new_name;
                    $sql = "UPDATE users SET profile_picture ='$file_new_name' WHERE username='$username'";
                    mysqli_query($conn,$sql);
                    move_uploaded_file($file_tmp,$target);
                    header("Location: user_information.php"); // تصحيح مكان وضع رابط الإعادة التوجيه
                    exit(); // توقف التنفيذ بعد عملية الإعادة التوجيه
                } else {
                    $error = "Your photo is too big!";
                    include_once('user_information.php');
                }
            } else {
                $error = "Error in uploading photo!";
                include_once('user_information.php');
            }
        } else {
            $error = 'You cannot upload files of this type!';
            include_once('user_information.php');
        }
    }
}
?>
