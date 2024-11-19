<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header('Location: admin_dashboard.php');
            } elseif ($row['role'] == 'teacher') {
                $_SESSION['username'] = $row['username'];

                header('Location: teacher_dashboard.php');
            } else {
                header('Location: student_dashboard.php');
            }
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "No user found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e90ff, #87ceeb);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-form {
            background: linear-gradient(to bottom right, rgba(30, 144, 255, 0.9), rgba(135, 206, 235, 0.9));
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            border: 2px solid transparent;
            background-clip: padding-box;
            border-image: linear-gradient(135deg, #1e90ff, #87ceeb) 1;
        }
        .form-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .register-link {
            margin-top: 1rem;
            text-align: center;
        }
        .register-link a {
            color: white;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e90ff, #87ceeb);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #87ceeb, #1e90ff);
        }
        .form-label {
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2 class="form-title">Login</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
