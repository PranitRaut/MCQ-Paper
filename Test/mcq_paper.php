<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Include Bootstrap JS and CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    include('connection.php');

    // Check if the student is logged in
    if ($_SESSION['role'] != 'student') {
        header('Location: login_student.php');
        exit();
    }

    // Get the selected exam ID
    $exam_id = $_GET['exam_id'];
    $student_id = $_SESSION['user_id'];

    // Check if the student has already attempted this exam
    $sql_check_attempt = "SELECT * FROM exam_attempts WHERE exam_id = '$exam_id' AND student_id = '$student_id'";
    $result_check_attempt = $conn->query($sql_check_attempt);

    // If the student has already attempted the exam, show an alert and redirect to the student dashboard
    if ($result_check_attempt->num_rows > 0) {
        echo "<script>alert('You have already given this exam.'); window.location.href = 'student_dashboard.php';</script>";
        exit();
    }

    // Get the exam questions for the selected paper
    $sql = "SELECT * FROM questions WHERE exam_id = '$exam_id'";
    $result = $conn->query($sql);

    // Check if there are any questions
    if ($result->num_rows == 0) {
        echo "No questions available for this exam.";
        exit();
    }

    // Get the total number of questions for the exam
    $total_questions = $result->num_rows;

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $answers = $_POST['answers']; // Array of answers submitted by student
        $score = 0;
        // Calculate score
        foreach ($answers as $question_id => $answer) {
            // Fetch the correct option for the question
            $sql = "SELECT correct_option FROM questions WHERE id = '$question_id'";
            $res = $conn->query($sql);
            $row = $res->fetch_assoc();

            // Check if the student's answer matches the correct answer
            if (isset($answer) && $answer == $row['correct_option']) {
                $score++; // Increment score for correct answer
            }
        }

        // Calculate the pass/fail status based on 50% of the total questions
        $passing_score = ceil($total_questions / 2); // 50% of total questions (rounded up)
        $status = ($score >= $passing_score) ? "Pass" : "Fail";

        // Store the result in the exam_attempts table
        $sql = "INSERT INTO exam_attempts (student_id, exam_id, score, questions_answered) 
            VALUES ('$student_id', '$exam_id', '$score', '" . json_encode($answers) . "')";
        $conn->query($sql);

        // Set a cookie to prevent re-accessing the exam
        setcookie('exam_attempted', $exam_id, time() + 3600, "/");  // Cookie expires in 1 hour
    
        // Show the result
        echo "<div class='container mt-5'>
<div class='card shadow-lg p-4 mb-5'>
    <h3 class='display-4 text-center text-primary'>Exam Result for Exam ID: $exam_id</h3>
    <div class='card-body'>
        <p class='lead text-center'>Your Score: <span class='text-success'>$score</span> / $total_questions</p>
        <p class='lead text-center'>Status: <span class='text-" . ($status == 'Pass' ? 'success' : 'danger') . "'>
            " . ($status == 'Pass' ? "🎉 Pass" : "😞 Fail") .
            "</span></p>
        <hr class='my-4'>
        <h4 class='text-center'>Your Answers:</h4>";


        foreach ($answers as $question_id => $answer) {
            // Fetch the question details
            $question_sql = "SELECT question_text, correct_option FROM questions WHERE id = '$question_id'";
            $question_res = $conn->query($question_sql);
            $question_row = $question_res->fetch_assoc();

            echo "<div class='card mb-3 p-4 shadow-sm'>
                <h5><strong>Question:</strong> " . $question_row['question_text'] . "</h5>
                <p><strong>Your Answer:</strong> <span class='badge bg-info'>$answer</span></p>
                <p><strong>Correct Answer:</strong> <span class='badge bg-success'>" . $question_row['correct_option'] . "</span></p>
              </div>";
        }

        echo "</div></div></div>";
        exit();
    }

    ?>

    <!-- Display the questions -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4 text-primary">Exam Paper: Exam ID - <?php echo $exam_id; ?></h2>
                <form id="exam-form" method="POST">
                    <div class="card p-4 shadow-sm">
                        <h4 class="mb-4 text-center">Instructions: Please answer all the questions.</h4>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="question-box mb-4 p-4 border border-primary rounded shadow">
                                <h5 class="mb-3 font-weight-bold"><?php echo $row['question_text']; ?></h5>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="answers[<?php echo $row['id']; ?>]"
                                        value="A" id="question_<?php echo $row['id']; ?>_A">
                                    <label class="form-check-label"
                                        for="question_<?php echo $row['id']; ?>_A"><?php echo $row['option_a']; ?></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="answers[<?php echo $row['id']; ?>]"
                                        value="B" id="question_<?php echo $row['id']; ?>_B">
                                    <label class="form-check-label"
                                        for="question_<?php echo $row['id']; ?>_B"><?php echo $row['option_b']; ?></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="answers[<?php echo $row['id']; ?>]"
                                        value="C" id="question_<?php echo $row['id']; ?>_C">
                                    <label class="form-check-label"
                                        for="question_<?php echo $row['id']; ?>_C"><?php echo $row['option_c']; ?></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="answers[<?php echo $row['id']; ?>]"
                                        value="D" id="question_<?php echo $row['id']; ?>_D">
                                    <label class="form-check-label"
                                        for="question_<?php echo $row['id']; ?>_D"><?php echo $row['option_d']; ?></label>
                                </div>
                            </div>
                        <?php endwhile; ?>

                        <button type="submit" class="btn btn-success btn-lg w-100 mt-4">Submit Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Timer for 1 minute (60 seconds)
        let timeLeft = 60; // 1 minute
        const timerDisplay = document.createElement("div");
        timerDisplay.className = "text-center text-danger";
        timerDisplay.innerHTML = `<h3>Time Left: <span id="timer">01:00</span></h3>`;
        document.body.insertBefore(timerDisplay, document.body.firstChild);

        // Function to update the timer every second
        let timerInterval = setInterval(function () {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            document.getElementById("timer").textContent = `${minutes}:${seconds}`;
            timeLeft--;

            // If time is up, submit the form
            if (timeLeft < 0) {
                clearInterval(timerInterval);
                markUnansweredAsIncorrect();
                submitForm(); // Programmatically submit the form
            }
        }, 1000);

        // Mark unanswered questions as incorrect
        function markUnansweredAsIncorrect() {
            const form = document.getElementById("exam-form");

            // Iterate over each question and check if the radio button is not selected
            form.querySelectorAll('.question-box').forEach((questionBox) => {
                const questionId = questionBox.getAttribute('data-question-id');
                const selectedOption = form.querySelector(`input[name="answers[${questionId}]"]:checked`);

                // If no option is selected, set the hidden field to "incorrect"
                if (!selectedOption) {
                    const hiddenInput = document.querySelector(`#hidden_answer_${questionId}`);
                    if (hiddenInput) {
                        hiddenInput.value = "incorrect";
                    }
                }
            });
        }

        // Function to programmatically submit the form
        function submitForm() {
            document.getElementById("exam-form").submit();
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>