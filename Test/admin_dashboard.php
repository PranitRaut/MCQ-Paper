<?php
session_start();
include('connection.php');

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
}

// Fetch counts
$students_count = $conn->query("SELECT COUNT(*) AS total_students FROM students")->fetch_assoc()['total_students'];
$teachers_count = $conn->query("SELECT COUNT(*) AS total_teachers FROM users WHERE role = 'teacher'")->fetch_assoc()['total_teachers'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, #ff9800, #ffc107);
            color: white;
            position: fixed;
            width: 250px;
            padding: 20px 0;
            transition: all 0.3s;
        }

        .sidebar h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            font-size: 1rem;
            font-weight: bold;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 200px; /* Increased card height */
            padding: 20px;
        }

        .card-header {
            font-weight: bold;
            font-size: 1.5rem; /* Increased font size */
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1.1rem; /* Slightly larger text */
        }

        .card h3 {
            font-size: 2.5rem; /* Larger number display */
            margin-top: 10px;
        }

        .card-icon {
            font-size: 3.5rem; /* Larger icons */
            color: #ffc107;
            margin-right: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
            }

            .card-header,
            .card h3 {
                text-align: center;
            }

            .card-body {
                text-align: center;
            }

            .card-icon {
                margin: 0 auto 10px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3 class="text-center">Admin Panel</h3>
            <a href="#" class="active">Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1 class="mb-4">Welcome to Admin Dashboard</h1>

            <!-- Cards -->
            <div class="row">
                <!-- Total Students Card -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-people card-icon"></i>
                            <div>
                                <h5 class="card-header">Total Students</h5>
                                <p class="card-text">Number of registered students.</p>
                                <h3><?php echo $students_count; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Teachers Card -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-person-badge card-icon"></i>
                            <div>
                                <h5 class="card-header">Total Teachers</h5>
                                <p class="card-text">Number of registered teachers.</p>
                                <h3><?php echo $teachers_count; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
