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

    // Fetch the question details
    $question_sql = "SELECT * FROM questions WHERE id = ?";
    $stmt = $conn->prepare($question_sql);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $question = $result->fetch_assoc();
    } else {
        echo "Question not found!";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    // Update the question in the database
    $update_sql = "UPDATE questions SET question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_option = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssi", $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $question_id);
    $stmt->execute();

    header('Location: view_questions.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Edit Question</h2>
    <form method="POST">
        <div class="form-group">
            <label for="question_text">Question Text:</label>
            <textarea class="form-control" id="question_text" name="question_text" required><?php echo htmlspecialchars($question['question_text']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="option_a">Option A:</label>
            <input type="text" class="form-control" id="option_a" name="option_a" value="<?php echo htmlspecialchars($question['option_a']); ?>" required>
        </div>
        <div class="form-group">
            <label for="option_b">Option B:</label>
            <input type="text" class="form-control" id="option_b" name="option_b" value="<?php echo htmlspecialchars($question['option_b']); ?>" required>
        </div>
        <div class="form-group">
            <label for="option_c">Option C:</label>
            <input type="text" class="form-control" id="option_c" name="option_c" value="<?php echo htmlspecialchars($question['option_c']); ?>" required>
        </div>
        <div class="form-group">
            <label for="option_d">Option D:</label>
            <input type="text" class="form-control" id="option_d" name="option_d" value="<?php echo htmlspecialchars($question['option_d']); ?>" required>
        </div>
        <div class="form-group">
            <label for="correct_option">Correct Option:</label>
            <select class="form-control" id="correct_option" name="correct_option" required>
                <option value="A" <?php if ($question['correct_option'] == 'A') echo 'selected'; ?>>A</option>
                <option value="B" <?php if ($question['correct_option'] == 'B') echo 'selected'; ?>>B</option>
                <option value="C" <?php if ($question['correct_option'] == 'C') echo 'selected'; ?>>C</option>
                <option value="D" <?php if ($question['correct_option'] == 'D') echo 'selected'; ?>>D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Question</button>
    </form>
</div>
</body>
</html>
