<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['role'])) {
    // Get the role before destroying the session
    $role = $_SESSION['role'];
    
    // Unset all session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
    
    // Redirect based on the role
    if ($role == 'admin' || $role == 'teacher') {
        header('Location: login.php');
    } elseif ($role == 'student') {
        header('Location: login_student.php');
    } else {
        // In case role is not set or invalid, redirect to default login page
        header('Location: login.php');
    }
    exit();
} else {
    // If no session is active, redirect to login page
    header('Location: login.php');
    exit();
}
?>
