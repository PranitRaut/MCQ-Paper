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

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            #sidebar {
                width: 200px;
            }

            #main-content {
                margin-left: 220px;
                padding: 10px;
            }

            table,
            th,
            td {
                font-size: 14px;
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
            margin-top: 20px;

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


        <!-- Registered Students Section -->
        <div class="section-title">
            <h2 class="h2">Registered Students</h2>
        </div>
        <table class="table table-bordered">
            <thead style="background: linear-gradient(to right, #ff6ec4, #f63a97); color: white; text-align: center;">
                <tr>
                    <th style="font-weight: bold;">Student ID</th>
                    <th style="font-weight: bold;">Name</th>
                    <th style="font-weight: bold;">Email</th>
                    <th style="font-weight: bold;">Batch</th>
                </tr>
            </thead>

            <tbody>
                <?php

                // Fetch students for each exam
                $students_sql = "SELECT * FROM students";
                $students_stmt = $conn->prepare($students_sql);
                $students_stmt->execute();
                $students_result = $students_stmt->get_result();

                // Display students for this exam
                while ($student = $students_result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($student['id']) . "</td>
                            <td>" . htmlspecialchars($student['name']) . "</td>
                            <td>" . htmlspecialchars($student['email']) . "</td>
                            <td>" . htmlspecialchars($student['batch']) . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS, Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>