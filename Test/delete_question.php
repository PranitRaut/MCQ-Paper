<?php
session_start();
include('connection.php');

// Check if teacher is logged in
if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $question_id = $_GET['id'];

    // Delete the question from the database
    $delete_sql = "DELETE FROM questions WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();

    header('Location: view_questions.php');
    exit();
} else {
    echo "No question ID provided!";
    exit();
}
?>
