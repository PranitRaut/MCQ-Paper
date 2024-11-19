<?php
session_start();
include('connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];  // Plain text password, will hash it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password
    $batch = $_POST['batch']; // Get batch field

    // Create a student ID (can be manual or auto-generated)
    $student_id = generateStudentID(); // Function to generate student ID

    // Insert student details into the database
    $sql = "INSERT INTO students (id, name, email, password, batch) VALUES ('$student_id', '$name', '$email', '$hashed_password', '$batch')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to login page after successful registration
        header("Location: login_student.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Function to generate a student ID
function generateStudentID() {
    global $conn;
    $query = "SELECT MAX(id) as max_id FROM students";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $max_id = $row['max_id'];

    return "S-" . ($max_id + 1);  // Generate ID as "S-1001", "S-1002", etc.
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #b19cd9, #d8bfd8); /* Light purple gradient */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .register-form {
            background: linear-gradient(to bottom right, rgba(191, 156, 217, 0.9), rgba(216, 191, 216, 0.9));
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            border: 2px solid transparent;
            background-clip: padding-box;
            border-image: linear-gradient(135deg, #b19cd9, #d8bfd8) 1;
        }
        .form-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #6a4c9c;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
        }
        .btn-primary {
            background: linear-gradient(135deg, #9a7fd1, #7b4b99);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #7b4b99, #9a7fd1);
        }
        .form-label {
            color: #6a4c9c;
        }
        .alert {
            margin-top: 1rem;
            text-align: center;
        }
        .login-link {
            margin-top: 1rem;
            text-align: center;
        }
        .login-link a {
            color: #9a7fd1;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <h2 class="form-title">Student Registration</h2>
        <form method="POST" action="register_student.php">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="batch" class="form-label">Batch</label>
                <input type="text" class="form-control" id="batch" name="batch" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login_student.php">Login here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
