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

// Fetch the student's batch
$student_batch_query = "SELECT batch FROM students WHERE id = '$student_id'";
$student_batch_result = $conn->query($student_batch_query);
if ($student_batch_result->num_rows > 0) {
    $student_batch_row = $student_batch_result->fetch_assoc();
    $student_batch = $student_batch_row['batch'];
} else {
    echo "<p class='text-danger'>Error fetching student's batch.</p>";
    exit();
}
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
        /* Custom styles for sidebar */
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

        .sidebar .logout-btn {
            color: white;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
        }

        .sidebar .logout-btn:hover {
            background-color: #4f9f99;
            /* Hover effect for logout */
            color: white;
        }

        .sidebar i {
            margin-right: 10px;
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

            <!-- Available Exams -->
            <h3 class="custom-h3">Available Exams</h3>
            <?php
            // Fetching exams matching the student's batch
            $sql = "SELECT * FROM exams WHERE batch = '$student_batch'";
            $result = $conn->query($sql);

            echo "<form id='examForm' method='GET'>";
            echo "<table class='table table-bordered table-responsive-sm'>";
            echo "<tr><th>Exam Name</th><th>Exam Description</th><th>Select</th></tr>";

            // Loop through the available exams and display them
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['exam_name'] . "</td>";
                    echo "<td>" . $row['exam_description'] . "</td>";
                    echo "<td><input type='radio' id='exam_id' name='exam_id' value='" . $row['id'] . "' required></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No exams available for your batch.</td></tr>";
            }

            echo "</table>";
            echo "<button type='submit' class='btn btn-primary'>Choose Exam</button>";
            echo "</form>";

            // If the exam is selected, redirect to mcq_paper.php with exam_id
            if (isset($_GET['exam_id'])) {
                $exam_id = $_GET['exam_id'];

                // Get the total number of questions for the exam
                $sql = "SELECT * FROM questions WHERE exam_id = '$exam_id'";
                $result = $conn->query($sql);
                $total_questions = $result->num_rows;
                $passing_score = ceil($total_questions * 0.5);  // 50% of total questions
            
                // Redirect to mcq_paper.php with exam_id in the URL
                header("Location: mcq_paper.php?exam_id=$exam_id&passing_score=$passing_score");
                exit();
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS & jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // If no exam is selected, an alert will be shown
        document.getElementById('examForm').onsubmit = function (event) {
            var selectedExam = document.querySelector('input[name="exam_id"]:checked');

            if (!selectedExam) {
                event.preventDefault();  // Prevent form submission if no exam is selected
                alert("Please select an exam.");
            }
        };
    </script>
    <style>
        .custom-h3 {

            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            background: linear-gradient(to right, #007bff, #0056b3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }
    </style>
</body>

</html>