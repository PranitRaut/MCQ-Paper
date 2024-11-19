<?php
session_start();
include('connection.php');

// Check if the student is logged in
if ($_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

// Get the student ID and exam ID from the URL
$exam_id = $_GET['exam_id'];
$student_id = $_SESSION['user_id'];

// Fetch the result for the student for the selected exam
$sql = "SELECT * FROM exam_attempts WHERE student_id = '$student_id' AND exam_id = '$exam_id'";
$result = $conn->query($sql);

// Check if the student has attempted the exam
if ($result->num_rows == 0) {
    echo "You have not attempted this exam.";
    exit();
}

// Fetch the result details
$row = $result->fetch_assoc();
$score = $row['score'];
$questions_answered = json_decode($row['questions_answered'], true);

// Get the total number of questions in the exam
$total_questions_sql = "SELECT COUNT(*) AS total_questions FROM questions WHERE exam_id = '$exam_id'";
$total_questions_res = $conn->query($total_questions_sql);
$total_questions_row = $total_questions_res->fetch_assoc();
$total_questions = $total_questions_row['total_questions'];

// Calculate pass/fail
$pass_percentage = 50; // Define pass percentage
$pass = $score >= ($total_questions * $pass_percentage / 100) ? 'Pass' : 'Fail';

// Display the result
echo "<h3>Exam Result for Exam ID: $exam_id</h3>";
echo "<p>Total Questions: $total_questions</p>";
echo "<p>Your Score: $score / $total_questions</p>";
echo "<p>Status: $pass</p>";

// Show answered questions and correct options
echo "<h4>Your Answers:</h4>";
foreach ($questions_answered as $question_id => $answer) {
    // Fetch the question details
    $question_sql = "SELECT question_text, correct_option FROM questions WHERE id = '$question_id'";
    $question_res = $conn->query($question_sql);
    $question_row = $question_res->fetch_assoc();

    echo "<p><strong>Question:</strong> " . $question_row['question_text'] . "<br>";
    echo "<strong>Your Answer:</strong> " . $answer . "<br>";
    echo "<strong>Correct Answer:</strong> " . $question_row['correct_option'] . "</p>";
}

?>
