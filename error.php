<?php
// محاولة الاتصال بقاعدة البيانات
$conn = mysqli_connect('localhost','root','','final_php');

// التحقق من نجاح الاتصال
if (!$conn) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                <strong>Error:</strong> Connection failed: <?php echo mysqli_connect_error(); ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit(); // إيقاف التنفيذ إذا فشل الاتصال
}

// تنفيذ الاستعلام
$sql = "SELECT * FROM tasks";
$result = mysqli_query($conn, $sql);

// التحقق من نجاح تنفيذ الاستعلام
if (!$result) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                <strong>Error:</strong> Error executing query: <?php echo mysqli_error($conn); ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit(); // إيقاف التنفيذ إذا فشل تنفيذ الاستعلام
}

// عرض البيانات
while ($row = mysqli_fetch_assoc($result)) {
    echo "Task Name: " . $row["task_name"] . "<br>";
}

// إغلاق الاتصال بقاعدة البيانات
mysqli_close($conn);
?>
