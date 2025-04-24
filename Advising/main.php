<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Faculty']);

if (file_exists('../includes/db_connection.php')) {
    require_once '../includes/db_connection.php';
} else {
    die('Database connection file not found!');
}
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header("Location: http://localhost/capst/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advising Student</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Load Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Load Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <nav id="navbar-placeholder">
        <p>Loading navbar...</p>
    </nav>
    <div class="main-content" id="mainContent">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Enrollment</a></li>
                <li><a href="#">Advising</a></li>
                <li class="active">Advise Student</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>ADVISING STUDENT</h1>
        </section>

        <div class="form-container">
            <form>
                <!-- Student ID -->
                <div class="form-group">
                    <label for="student-id">Student ID:</label>
                    <input type="text" id="student-id" placeholder="Enter Student ID">
                </div>

                <!-- School Year: From and To -->
                <div class="form-group">
                    <label for="school-year">School Year:</label>
                    <input type="text" id="school-year-from" placeholder="From">
                    <span> - </span>
                    <input type="text" id="school-year-to" placeholder="To">
                </div>

                <!-- Term -->
                <div class="form-group">
                    <label for="term" class="block font-bold text-sm mb-2">TERM</label>
                    <select id="term" class="p-2 border border-gray-300 rounded">
                        <option>Select Term</option>
                        <option>Term 1</option>
                        <option>Term 2</option>
                    </select>
                </div>

                <!-- Student Preview (Static for now) -->
                <div class="form-group full-width">
                    <label for="student-preview">Student:</label>
                    <input type="text" id="student-preview" placeholder="Student Preview" readonly>
                </div>

                <!-- Proceed Button -->
                <div class="flex justify-center mb-20">
                    <a href="Proceed.php" type="submit" style="background-color: #174069;"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Proceed
                    </a>
                </div>

                <!-- Bottom Buttons: Search Student and Search Subject -->
                <div class="bottom-btns flex justify-center items-center mt-10 space-x-96">
                    <div class="bottom-btn-group text-center">
                        <p class="text-gray-600 font-semibold mb-2 text-lg">Can’t find Student ID?</p>
                        <a href="Student.php" type="submit" style="background-color: #174069;"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 shadow-lg rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Search Student
                        </a>
                    </div>
                    <div class="bottom-btn-group text-center">
                        <p class="text-gray-600 font-semibold mb-2 text-lg">List of Subjects</p>
                        <a href="Subject.php" style="background-color: #174069;"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 shadow-lg rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Search Subject
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="border-b-4 border-black my-4"></div>

    <script>
        // Load navbar dynamically
        (function loadNavbar() {
            fetch('../Components/Navbar.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Navbar.html does not exist or is inaccessible');
                    }
                    return response.text();
                })
                .then(html => {
                    document.getElementById('navbar-placeholder').innerHTML = html;
                    // Dynamically load app.js if not already loaded
                    if (!document.querySelector('script[src="../../Components/app.js"]')) {
                        const script = document.createElement('script');
                        script.src = '../Components/app.js';
                        script.defer = true;
                        document.body.appendChild(script);
                    }
                })
                .catch(error => {
                    console.error('Error loading navbar:', error);
                    document.getElementById('navbar-placeholder').innerHTML =
                        '<p style="color: red; text-align: center;">Navbar could not be loaded.</p>';
                });
        })();
    </script>

</body>

</html>


<!-- CSS styling -->
<style scoped>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f8fa;
        margin: 0;
        padding: 0;
    }

    /* Breadcrumb styles */
    .breadcrumb-nav {
        margin: 0;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .breadcrumb {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        padding: 0;
    }

    .breadcrumb li {
        margin-right: 10px;
    }

    .breadcrumb li a {
        color: #174069;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb li a:hover {
        color: #20568B;
    }

    .breadcrumb li.active {
        color: orange;
        pointer-events: none;
    }

    .breadcrumb li::after {
        content: ">";
        margin-left: 10px;
        color: #174069;
    }

    .breadcrumb li:last-child::after {
        content: "";
    }

    /* Section Header */
    .section-header {
        background-color: #174069;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .section-header h1 {
        color: white;
        margin: 0;
    }

    /* Form Container */
    .form-container {
        max-width: 900px;
        margin: 20px auto;
        background-color: #f4f8fc;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Form Group Layout */
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .form-group label {
        width: 130px;
        font-weight: bold;
    }

    .form-group input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 250px;
        margin-right: 10px;
    }

    .form-group span {
        margin-right: 10px;
        font-size: 18px;
    }

    /* Full Width for Student Preview */
    .full-width input {
        width: calc(100% - 150px);
        /* Full width minus label width */
    }

    /* Responsive */
    @media (max-width: 600px) {
        .form-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-group input {
            width: 100%;
        }

        .bottom-btns {
            flex-direction: column;
            align-items: center;
        }

        .bottom-btn-group {
            margin-bottom: 15px;
        }
    }
</style>