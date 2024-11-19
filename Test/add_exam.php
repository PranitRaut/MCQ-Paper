<?php
session_start();
include('connection.php');

// Check if teacher is logged in
if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

// Get the teacher's ID from the session
$teacher_id = $_SESSION['user_id'];

// Fetch teacher's exams
$exams_sql = "SELECT * FROM exams WHERE teacher_id = ?";
$stmt = $conn->prepare($exams_sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$exam_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        #sidebar {
            width: 250px;
            height: 100vh;
            background-color: #ff66b2;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        #sidebar h2 {
            color: #fff;
            font-size: 22px;
            text-align: center;
            margin-bottom: 40px;
        }

        #sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #fff;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        #sidebar a:hover {
            background-color: #ff3385;
            color: white;
        }

        #main-content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control,
        textarea {
            border-radius: 5px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        }

        .message {
            font-size: 1.2rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        .message.error {
            color: #dc3545;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            #sidebar {
                width: 200px;
            }

            #main-content {
                margin-left: 220px;
                padding: 10px;
            }

            .form-container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }

        @media screen and (max-width: 576px) {
            #sidebar {
                position: static;
                width: 100%;
                height: auto;
                padding: 10px;
            }

            #main-content {
                margin-left: 0;
                width: 100%;
            }

            .container {
                padding: 10px;
            }

            .form-container {
                padding: 15px;
            }

            h1 {
                font-size: 1.2rem;
            }

            .btn {
                font-size: 14px;
                padding: 8px 15px;
            }
        }

        .h2 {

            font-family: 'Roboto', sans-serif;
            font-size: 2.8rem;
            font-weight: 700;
            background: linear-gradient(to right, #ff6ec4, #f63a97);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2);
            margin-top: 5px;

        }

        .btn-primary {
            background: linear-gradient(to right, #ff6ec4, #f63a97);
            border: none;
            transition: transform 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #f63a97, #ff6ec4);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
    <h2>Teacher Dashboard</h2>
    <a href="teacher_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="student_list.php"><i class="fas fa-users"></i> Registered Students</a>
    <a href="result_list.php"><i class="fas fa-chart-line"></i> Student Results</a>
    <a href="add_exam.php"><i class="fas fa-file-alt"></i> Add Exam</a>
    <a href="add_questions.php"><i class="fas fa-edit"></i> Add Questions</a>
    <a href="view_questions.php"><i class="fas fa-question-circle"></i> View Questions</a>
    <a href="logout.php"><i class="fas fa-power-off"></i> Logout</a>
</div>

<!-- Main Content -->
<div id="main-content">
        <!-- Back Button -->
        <a href="teacher_dashboard.php" class="btn btn-primary"
            style="position: fixed; top: 20px; right: 20px; z-index: 1000;">Back to Dashboard</a>

<div class="container">
    <div class="form-container">
    <h2 class="h2">Add New Exam</h2>


        <!-- Display success/error message -->
        <?php if (isset($message)): ?>
            <div class="message <?php echo isset($message_class) ? $message_class : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Exam Form -->
        <form method="POST" action="add_exam.php">
            <div class="mb-3">
                <label for="exam_name" class="form-label">Exam Name:</label>
                <input type="text" class="form-control" name="exam_name" id="exam_name" required>
            </div>

            <div class="mb-3">
                <label for="exam_description" class="form-label">Exam Description:</label>
                <textarea class="form-control" name="exam_description" id="exam_description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="batch" class="form-label">Batch:</label>
                <input type="text" class="form-control" name="batch" id="batch" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Add Exam</button>
        </form>
    </div>
</div>


<?php

// Get the teacher's ID from the session
$teacher_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $exam_description = $_POST['exam_description'];
    $batch = $_POST['batch'];

    // Insert the exam into the database
    $sql = "INSERT INTO exams (teacher_id, exam_name, exam_description, batch) 
            VALUES ('$teacher_id', '$exam_name', '$exam_description', '$batch')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Exam added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

?>
</div>

<!-- Bootstrap JS, Popper.js -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
