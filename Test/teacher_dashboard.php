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
        /* Basic styling for the page */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f4f7fc;
        }

        /* Sidebar styling */
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

        /* Main content section */
        #main-content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
            overflow-x: auto;
        }

        h1,
        h3 {
            color: #333;
        }

        .section-title {
            font-size: 24px;
            color: #ff66b2;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
        }

        /* Cards Section */
        .card-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .card {
            width: 30%;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: 0.3s;
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            text-align: center;
            padding: 20px;
        }

        .card-body i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #ff66b2;
        }

        .card-title {
            font-size: 22px;
            color: #333;
        }

        .card-text {
            font-size: 16px;
            color: #777;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            #sidebar {
                width: 200px;
            }

            #main-content {
                margin-left: 220px;
                padding: 10px;
            }

            .card {
                width: 45%;
            }
        }

        @media screen and (max-width: 480px) {
            .card {
                width: 100%;
            }
        }

        .h1 {

            font-family: 'Roboto', sans-serif;
            font-size: 2.8rem;
            font-weight: 700;
            text-align: center;
            color: #ffffff;
            background: linear-gradient(to right, #ff6ec4, #f63a97);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
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
        <h1 class="h1">
            Welcome to the Teacher Dashboard, <?php echo $_SESSION["username"]; ?>
        </h1>

        <!-- Dashboard Cards Section -->
        <div class="card-container">
            <!-- Total Registered Students Card -->
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-users"></i>
                    <h5 class="card-title">Total Registered Students</h5>
                    <?php
                    // Fetch the total number of students registered in the students table
                    $students_sql = "
            SELECT COUNT(*) AS student_count
            FROM students";
                    $students_result = $conn->query($students_sql);
                    $students_count = $students_result->fetch_assoc()['student_count'];
                    ?>
                    <p class="card-text"><?php echo $students_count; ?> Students</p>
                    <a href="student_list.php" class="btn btn-link">View Students</a>
                </div>
            </div>


            <!-- Total Exam Results Card -->
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-chart-line"></i>
                    <h5 class="card-title">Total Student Results</h5>
                    <?php
                    // Fetch the total number of exam results for exams created by the logged-in teacher
                    $results_sql = "
                    SELECT COUNT(*) AS result_count
                    FROM exam_attempts
                    WHERE exam_id IN (SELECT id FROM exams WHERE teacher_id = ?)";
                    $stmt = $conn->prepare($results_sql);
                    $stmt->bind_param("i", $teacher_id);
                    $stmt->execute();
                    $results_result = $stmt->get_result();
                    $results_count = $results_result->fetch_assoc()['result_count'];
                    ?>
                    <p class="card-text"><?php echo $results_count; ?> Results</p>
                    <a href="result_list.php" class="btn btn-link">View Results</a>
                </div>
            </div>

            <!-- Total Exams Card -->
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-file-alt"></i>
                    <h5 class="card-title">Total Exams</h5>
                    <?php
                    // Fetch the total number of exams created by the logged-in teacher
                    $exams_count_sql = "
                    SELECT COUNT(*) AS exam_count
                    FROM exams
                    WHERE teacher_id = ?";
                    $stmt = $conn->prepare($exams_count_sql);
                    $stmt->bind_param("i", $teacher_id);
                    $stmt->execute();
                    $exams_count_result = $stmt->get_result();
                    $exams_count = $exams_count_result->fetch_assoc()['exam_count'];
                    ?>
                    <p class="card-text"><?php echo $exams_count; ?> Exams</p>
                    <a href="add_exam.php" class="btn btn-link">Add Exam</a>
                </div>
            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>