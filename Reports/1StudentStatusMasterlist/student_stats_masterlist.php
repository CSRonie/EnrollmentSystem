<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Faculty', 'Registrar']);

if (file_exists('../../includes/db_connection.php')) {
    require_once '../../includes/db_connection.php';
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
    <title>Student Status Masterlist</title>
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
                <li><a href="#">Reports</a></li>
                <li class="active">Student Status Masterlist</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>Student Status Masterlist</h1>
        </section>

        <!-- Form container -->
        <div class="form-container">
            <form>
                <!-- Student Status -->
                <div class="mb-6">
                    <label for="student-status" class="block font-bold text-sm mb-1">STUDENT STATUS</label>
                    <select id="student-status" class="w-full p-3 border border-gray-300 rounded" style="width: 400px;">
                        <option value="" disabled selected>Select Student Status</option>
                        <option value="1">Enrolled</option>
                        <option value="2">Not Enrolled</option>
                    </select>
                </div>

                <h4 class="font-bold mb-4" style="margin-top: 25px; margin-bottom: 15px; margin-left: -15px;">SHOW BY:</h4>

                <!-- College -->
                <div class="mb-6">
                    <label for="college" class="block font-bold text-sm mb-1">COLLEGE</label>
                    <select id="college" class="w-full p-3 border border-gray-300 rounded">
                        <option value="" disabled selected>Select College</option>
                        <option value="CICS">College of Informatics and Computing Studies</option>
                        <option value="COA">College of Accountancy</option>
                    </select>
                </div>

                <!-- Program -->
                <div class="mb-6">
                    <label for="program" class="block font-bold text-sm mb-1">PROGRAM</label>
                    <select id="program" class="w-full p-3 border border-gray-300 rounded">
                        <option value="" disabled selected>Select College Program</option>
                        <option value="BSIT">Bachelor of Science in Information Technology</option>
                        <option value="COA">Accountancy</option>
                    </select>
                </div>

                <!-- School Year and Semester -->
                <div class="mb-4 flex items-center space-x-2">
                    <div class="flex-1">
                        <label for="year-term-from" class="block font-bold text-sm mb-2">SCHOOL YEAR</label>
                        <div class="flex items-center">
                            <input type="text" id="year-term-from" placeholder="Enter" class="w-full p-2 border border-gray-300 rounded">
                            <span class="mx-2 font-bold">TO</span>
                            <input type="text" id="year-term-to" placeholder="Enter" class="w-full p-2 border border-gray-300 rounded">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="term" class="block font-bold text-sm mb-1">SEMESTER</label>
                    <select id="term" class="w-full p-3 border border-gray-300 rounded" style="width: 200px;">
                        <option value="" disabled selected>Select Semester Term</option>
                        <option>1st Semester</option>
                        <option>2nd Semester</option>
                    </select>
                </div>

                <!-- Proceed Button -->
                <div class="flex justify-center">
                    <a href="enrolled_stud_masterlist.php" type="submit" style="background-color: #174069;"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Search
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Load navbar dynamically
        (function loadNavbar() {
            fetch('../../Components/Navbar.php')
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
                        script.src = '../../Components/app.js';
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

        function showAdditionalFields() {
            // Display the hidden information section
            document.getElementById("additional-fields-status").style.display = "block";
        }
    </script>
</body>

</html>


<!-- CSS styling -->
<style scoped>
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

    /* Form styles */
    .form-container {
        width: 50%;
        margin: 40px auto;
        background-color: #f4f8fc;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Button styles */
    .form-actions button {
        padding: 12px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>