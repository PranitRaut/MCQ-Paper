<?php
session_start();
include('connection.php');

if (isset($_POST['submit'])) {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if student exists in the database
    $sql = "SELECT * FROM students WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch student data
        $student = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $student['password'])) {
            // Set session variables
            $_SESSION['role'] = 'student';
            $_SESSION['user_id'] = $student['id'];
            $_SESSION['name'] = $student['name'];

            // Redirect to student dashboard
            header('Location: student_dashboard.php');
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No student found with this email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ffd6d6, #ffbaba);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-form {
            background: linear-gradient(to bottom right, rgba(255, 182, 182, 0.9), rgba(255, 202, 202, 0.9));
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            border: 2px solid transparent;
            background-clip: padding-box;
            border-image: linear-gradient(135deg, #ffd6d6, #ffbaba) 1;
        }
        .form-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ff4d4d;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff7f7f, #ff4d4d);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #ff4d4d, #ff7f7f);
        }
        .form-label {
            color: #ff4d4d;
        }
        .alert {
            margin-top: 1rem;
            text-align: center;
        }
        .register-link {
            margin-top: 1rem;
            text-align: center;
        }
        .register-link a {
            color: #ff4d4d;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2 class="form-title">Student Login</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login_student.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register_student.php">Register here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
