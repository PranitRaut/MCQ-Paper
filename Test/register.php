<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // 'teacher' or 'admin'

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login.php after successful registration
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ffd6c3, #ffa488);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .register-form {
            background: linear-gradient(to bottom right, rgba(255, 214, 195, 0.9), rgba(255, 164, 136, 0.9));
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            border: 2px solid transparent;
            background-clip: padding-box;
            border-image: linear-gradient(135deg, #ffd6c3, #ffa488) 1;
        }
        .form-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ff7a50;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff9b73, #ff7a50);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #ff7a50, #ff9b73);
        }
        .form-label {
            color: #ff7a50;
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
            color: #ff7a50;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <h2 class="form-title">Register</h2>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success" role="alert">
                <?= $success; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
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
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
