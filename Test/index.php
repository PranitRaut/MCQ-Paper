<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCQ Exam Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #495057;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 15px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center; /* Centering the content */
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header .logo {
            font-size: 24px;
            font-weight: 700;
            margin-right: 20px;
        }

        header nav {
            display: flex;
            justify-content: center; /* Centering the school name */
            flex-grow: 1;
        }

        header nav h1 {
            font-size: 30px;
            font-weight: 500;
            text-align: center;
        }

        header .search-bar {
            display: flex;
            align-items: center;
            background-color: white;
            padding: 5px 10px;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header .search-bar input {
            border: none;
            outline: none;
            padding: 8px;
            font-size: 16px;
            border-radius: 10px;
        }

        header .search-bar button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 10px;
            cursor: pointer;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .center {
            text-align: center;
            margin-bottom: 40px;
        }

        .center h2 {
            font-size: 32px;
            color: #343a40;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .center p {
            font-size: 18px;
            color: #6c757d;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }

        .quick-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
        }

        .quick-links a {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .quick-links a:hover {
            background-color: #218838;
        }

        footer {
    background-color: #343a40;
    color: white;
    text-align: center;
    padding: 15px;
    position: fixed; /* Fixed position */
    bottom: 0;
    width: 100%;
    z-index: 1000; /* Ensure the footer stays on top */
}


        footer p {
            margin: 0;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            header nav {
                flex-direction: column;
                gap: 10px;
            }

            .search-bar {
                width: 100%;
                margin-top: 10px;
            }
        }
        
    </style>
</head>
<body>
    <header>
        <div class="logo"></div>
        <nav>
            <h1>Vidya Mandir School, Dahisar</h1>
        </nav>
    </header>

    <div class="container">
        <div class="center">
            <h2>Welcome to the MCQ Exam Dashboard</h2>
            <p>Empowering educators and students to make exams more efficient and effective. Teachers can create, manage, and review exams while students can easily take exams and track their progress in real-time. It's time to make learning and evaluation more interactive and engaging.</p>
        </div>

        <div class="quick-links">
            <a href="login.php">Go to Teacher Dashboard</a>
            <a href="login_student.php">Go to Student Dashboard</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 MCQ Exam Platform. All rights reserved.</p>
    </footer>
</body>
</html>
