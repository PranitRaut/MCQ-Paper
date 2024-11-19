<?php
session_start();
include('connection.php');

// Check if teacher is logged in
if ($_SESSION['role'] != 'teacher') {
    header('Location: login.php');
    exit();
}

// Get the teacher's ID from the session
$teacher_id = $_SESSION['user_id'];

// Fetch teacher's exams
$sql = "SELECT * FROM exams WHERE teacher_id = '$teacher_id'";
$result = $conn->query($sql);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_id = $_POST['exam_id'];
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    // Insert the question into the database
    $sql = "INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option) 
            VALUES ('$exam_id', '$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";

    if ($conn->query($sql) === TRUE) {
        echo "<script> window.alert('New question added successfully!');</script>";
    } else {
        echo "<script> window.alert('alert alert-danger'>Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Add New Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styling */
        #sidebar {
            width: 250px;
            height: 100vh;
            background-color: #ff66b2;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        #sidebar h2 {
            color: #fff;
            font-size: 22px;
            text-align: center;
            margin-bottom: 40px;
        }

        #sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #fff;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        #sidebar a:hover {
            background-color: #ff3385;
            color: white;
        }

        #main-content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }

        .section-title {
            font-size: 24px;
            color: #ff66b2;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            #sidebar {
                width: 200px;
            }

            #main-content {
                margin-left: 220px;
            }
        }

        .btn-primary {
            background: linear-gradient(to right, #ff6ec4, #f63a97);
            border: none;
            transition: transform 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #f63a97, #ff6ec4);
            transform: scale(1.05);
        }

        .h4 {

            font-family: 'Roboto', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, #ff6ec4, #f63a97);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2);
            margin-top: 10px;

        }
    </style>

</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <h2>Teacher Dashboard</h2>
        <a href="teacher_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="student_list.php"><i class="fas fa-users"></i> Registered Students</a>
        <a href="result_list.php"><i class="fas fa-chart-line"></i> Student Results</a>
        <a href="add_exam.php"><i class="fas fa-file-alt"></i> Add Exam</a>
        <a href="add_questions.php"><i class="fas fa-edit"></i> Add Questions</a>
        <a href="view_questions.php"><i class="fas fa-question-circle"></i> View Questions</a>
        <a href="logout.php"><i class="fas fa-power-off"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div id="main-content">

        <!-- Back Button -->
        <a href="teacher_dashboard.php" class="btn btn-primary"
            style="position: absolute; top: 20px; right: 20px; z-index: 1000;">Back to Dashboard</a>


        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-header">
                     <h4 class="h4">Add New Question</h4>

                </div>
                <div class="card-body">
                    <!-- Form to add a new question -->
                    <form method="POST">
                        <div class="form-group">
                            <label for="exam_id">Select Exam</label>
                            <select name="exam_id" id="exam_id" class="form-control" required>
                                <?php
                                $result->data_seek(0); // Reset the result pointer
                                while ($exam = $result->fetch_assoc()) {
                                    echo "<option value='" . $exam['id'] . "'>" . $exam['exam_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="question_text">Question Text</label>
                            <textarea name="question_text" id="question_text" class="form-control" rows="4"
                                placeholder="Enter the question here" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="option_a">Option A</label>
                            <input type="text" name="option_a" id="option_a" class="form-control"
                                placeholder="Enter Option A" required>
                        </div>

                        <div class="form-group">
                            <label for="option_b">Option B</label>
                            <input type="text" name="option_b" id="option_b" class="form-control"
                                placeholder="Enter Option B" required>
                        </div>

                        <div class="form-group">
                            <label for="option_c">Option C</label>
                            <input type="text" name="option_c" id="option_c" class="form-control"
                                placeholder="Enter Option C" required>
                        </div>

                        <div class="form-group">
                            <label for="option_d">Option D</label>
                            <input type="text" name="option_d" id="option_d" class="form-control"
                                placeholder="Enter Option D" required>
                        </div>

                        <div class="form-group">
                            <label for="correct_option">Correct Option</label>
                            <select name="correct_option" id="correct_option" class="form-control" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Add Question</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>