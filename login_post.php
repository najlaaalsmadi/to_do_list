<?php
/*session_start();
include('inc/connections.php');
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username=stripcslashes(strtolower($_POST['username']));
    $md5_pass=md5($_POST('password'));
    $username=filter_input(INPUT_POST,'username');
    //$password=stripcslashes(strtolower($_POST['password']));
    $username = htmlentities(mysqli_real_escape_string($conn, $_POST['username']));
    $password = htmlentities(mysqli_real_escape_string($conn, $_POST['password']));


 if(empty($username)) {
        $user_error = "<p class='error'>Please enter username </p>";
        $err_s = 1;
    } 
    if(empty($password)) {
        $pass_error = "<p class='error'>Please insert password </p>";
        $err_s = 1;
        include("login.php");
    } 
}
if(!isset($err_s))
{
$sql="SELECT id,username FROM users WHERE username='$username' AND md5_pass='$md5_pass'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
if($row['username']===$username && $row['password']===$password){
    $_SESSION['username']=$row['username'];
    $_SESSION['id']=$row['id'];
    header('Loction:index.php');
    exit();
}
}*/

session_start();
include('inc/connections.php');

$user_error = ""; // إعطاء القيمة الافتراضية للمتغير لتجنب ظهور الخطأ
$err_s = 0; // إعطاء القيمة الافتراضية للمتغير لتجنب ظهور الخطأ

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if(isset($_POST['keep'])) {
        $keep = htmlentities(mysqli_real_escape_string($conn, $_POST['keep']));
        if($keep == 1) {
            $username = htmlentities(mysqli_real_escape_string($conn, $_POST['username']));
            $password = htmlentities(mysqli_real_escape_string($conn, $_POST['password']));
            // تعيين مدة الكوكيز إلى 3 أيام
            $cookie_expiry = time() + 3 * 24 * 60 * 60;
            setcookie('username', $username, $cookie_expiry, "/");
            setcookie('password', $password, $cookie_expiry, "/");
        }
    }
    
    
    if(empty($username)) {
        $user_error = "<p class='error'>Please enter username </p>";
        $err_s = 1;
    } 
    if(empty($password)) {
        $pass_error = "<p class='error'>Please insert password </p>";
        $err_s = 1;
        include("login.php");
    } 

    // التحقق مما إذا كان هناك أخطاء في المتغيرات أو لا
    if($err_s == 0) {
        $md5_pass = md5($password); // تشفير كلمة المرور
        $sql = "SELECT id,username FROM users WHERE username='$username' AND md5_pass='$md5_pass' limit 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row) { // التحقق مما إذا كان هناك بيانات متطابقة
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            header('Location: index.php'); // توجيه المستخدم إلى صفحة الرئيسية
            exit();
        } else {
            $user_error = "<p class='error'>Invalid username or password</p>";
            include("login.php");
            exit();
        }
    }
}



?>