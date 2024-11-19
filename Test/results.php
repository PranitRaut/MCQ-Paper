<?php
session_start();
include('connection.php');

// Check if student is logged in
if ($_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

// Get the student ID from the session
$student_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(to bottom, #007bff, #0056b3);
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #003a7f;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Custom table styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th {
            background: #007bff;
            color: white;
            text-align: left;
            padding: 12px;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(to right, #007bff, #0056b3);
            border: none;
            transition: transform 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0056b3, #003a7f);
            transform: scale(1.05);
        }

        .table-container {
            overflow-x: auto;
        }

        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
        }

        .h3 {

            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            background: linear-gradient(to right, #007bff, #0056b3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center text-white">Student Dashboard</h4>
        <a href="student_dashboard.php"
            class="<?php echo (basename($_SERVER['PHP_SELF']) == 'student_dashboard.php') ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="exams.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'exams.php') ? 'active' : ''; ?>">
            <i class="fas fa-clipboard-list"></i> Exams
        </a>
        <a href="results.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'results.php') ? 'active' : ''; ?>">
            <i class="fas fa-chart-line"></i> Results
        </a>
        <a href="logout.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'logout.php') ? 'active' : ''; ?>">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <!-- Back Button -->
            <a href="student_dashboard.php" class="btn btn-primary"
                style="position: fixed; top: 20px; right: 20px; z-index: 1000;">Back to Dashboard</a>

            <h3 class="h3">Your Results</h3>
            <?php

            // Display student's results for exams they have taken
            
            $results_sql = "SELECT e.exam_name, r.score
                            FROM exam_attempts r
                            JOIN exams e ON r.exam_id = e.id
                            WHERE r.student_id = '$student_id'";
            $results_result = $conn->query($results_sql);

            if ($results_result->num_rows > 0) {
                echo "<table class='table table-bordered table-responsive-sm'>";
                echo "<tr><th>Exam Name</th><th>Marks</th><th>Status</th></tr>";

                // Loop through the results and display them
                while ($result_row = $results_result->fetch_assoc()) {
                    // Passing score logic: If score is >= 50% of the total questions
                    $exam_name = $result_row['exam_name'];

                    // Fetch total questions for this exam (for passing score calculation)
                    $exam_sql = "SELECT * FROM questions WHERE exam_id = (SELECT id FROM exams WHERE exam_name = '$exam_name')";
                    $exam_result = $conn->query($exam_sql);
                    $total_questions_for_exam = $exam_result->num_rows;
                    $passing_score_for_exam = ceil($total_questions_for_exam * 0.5);

                    $status = ($result_row['score'] >= $passing_score_for_exam) ? "Pass" : "Fail";  // Check against dynamic passing score
                    echo "<tr>";
                    echo "<td>" . $result_row['exam_name'] . "</td>";
                    echo "<td>" . $result_row['score'] . "</td>";
                    echo "<td>" . $status . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "You haven't taken any exams yet.";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS & jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>