<?php
session_start();
include('connection.php');

// Check if student is logged in
if ($_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

// Get the student ID and batch from the session
$student_id = $_SESSION['user_id'];

// Fetch the student's batch
$batchQuery = "SELECT batch FROM students WHERE id = '$student_id'";
$batchResult = $conn->query($batchQuery);

if ($batchResult && $batchResult->num_rows > 0) {
    $studentBatch = $batchResult->fetch_assoc()['batch'];
} else {
    echo "Error fetching student batch.";
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

        .h1 {

            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            background: linear-gradient(to right, #007bff, #0056b3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
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
            <!-- Welcome Message -->
            <h1 class="h1">
                Welcome to Student Dashboard, <?php echo $_SESSION["name"]; ?>
            </h1>

            <!-- Summary Cards -->
            <div class="row text-white">
                <?php
                // Fetch total exams count for the student's batch
                $examCountSql = "SELECT COUNT(*) as total_exams 
                                 FROM exams 
                                 WHERE batch = '$studentBatch'";
                $examCountResult = $conn->query($examCountSql);
                $totalExams = $examCountResult->fetch_assoc()['total_exams'];

                // Fetch total results count
                $resultCountSql = "SELECT COUNT(*) as total_results 
                                   FROM exam_attempts 
                                   WHERE student_id = '$student_id'";
                $resultCountResult = $conn->query($resultCountSql);
                $totalResults = $resultCountResult->fetch_assoc()['total_results'];
                ?>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm text-center"
                        style="background: linear-gradient(to bottom, #007bff, #0056b3); color: white;">
                        <div class="card-body">
                            <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                            <h5>Total Exams</h5>
                            <p class="h3"><?php echo $totalExams; ?></p>
                            <a href="exams.php" class="btn btn-light btn-sm">View Exams</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm text-center"
                        style="background: linear-gradient(to bottom, #28a745, #1e7e34); color: white;">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-3x mb-3"></i>
                            <h5>Total Results</h5>
                            <p class="h3"><?php echo $totalResults; ?></p>
                            <a href="results.php" class="btn btn-light btn-sm">View Results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>