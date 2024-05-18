<?php
// افتح الجلسة
session_start();

// تضمين ملف الاتصال بقاعدة البيانات
include('inc/connections.php');

// التحقق من تسجيل الدخول
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // إذا تم تحديد معرف المهمة من الرابط
    if (isset($_GET['task_id'])) {
        $task_id = $_GET['task_id'];

        // استعلام SQL لاسترداد تفاصيل المهمة
        $stmt = mysqli_prepare($conn, "SELECT * FROM task WHERE task_id = ?");

        // التحقق من صحة استعلام SQL
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $task_id);
            $stmt_exec = mysqli_stmt_execute($stmt);

            // التحقق من نجاح الاستعلام
            if ($stmt_exec) {
                $result = mysqli_stmt_get_result($stmt);

                // التحقق مما إذا كان هناك مهمة مطابقة
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .card-body {
            padding: 20px;
        }

        .note-content {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Task Details
                    </div>
                    <br>
                    <div class="card-body">
                        <!-- رابط إضافة ملاحظة -->
                        <a href="addnot.php?task_id=<?php echo $task_id; ?>" class="btn btn-primary mb-3">Add Note</a>
                        <?php if (mysqli_num_rows($result) > 0) { ?>
                            <!-- تفاصيل المهمة -->
                            <h3><?php echo $row['task_name']; ?></h3>
                            <p><?php echo $row['description']; ?></p>

                            <?php
                            // استعلام SQL لاسترداد الملاحظات المرتبطة بالمهمة
                            $notes_stmt = mysqli_prepare($conn, "SELECT * FROM notes WHERE task_id = ?");
                            mysqli_stmt_bind_param($notes_stmt, "i", $task_id);
                            mysqli_stmt_execute($notes_stmt);
                            $notes_result = mysqli_stmt_get_result($notes_stmt);

                            // عرض الملاحظات إذا وجدت
                            if (mysqli_num_rows($notes_result) > 0) {
                                echo "<table class=\"table\">";
                                echo "<thead><tr><th>Note</th><th>Date</th><th>Action</th></tr></thead>";
                                echo "<tbody>";
                                // داخل اللوب لعرض الملاحظات
                                while ($note_row = mysqli_fetch_assoc($notes_result)) {
                                    echo "<tr>";
                                    echo "<td>" . $note_row['note'] . "</td>";
                                    echo "<td>" . $note_row['activity_date'] . "</td>";
                                    echo "<td>
                                        <button type=\"button\" class=\"btn btn-danger\" onclick=\"location.href='delete_note.php?note_id=" . $note_row['note_id'] . "'\">Delete</button>
                                    </td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                            } else {
                                echo "<p>No notes available.</p>";
                            }
                            ?>
                        <?php } ?>
                    </div>
                    <a href="index.php" class="text-center d-block">back to home</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
                } else {
                    // إعادة توجيه المستخدم إلى صفحة أخرى أو عرض رسالة خطأ
                    header('Location: index.php');
                    exit();
                }
            } else {
                // في حالة فشل تنفيذ الاستعلام
                echo "Failed to execute SQL statement: " . mysqli_stmt_error($stmt);
            }
        } else {
            // في حالة فشل استعلام SQL
            echo "Failed to prepare SQL statement: " . mysqli_error($conn);
        }
    } else {
        // إعادة توجيه المستخدم إلى صفحة أخرى أو عرض رسالة خطأ
        header('Location: index.php');
        exit();
    }
} else {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن قد قام بتسجيل الدخول بعد
    header('Location: login.php');
    exit();
}
?>
