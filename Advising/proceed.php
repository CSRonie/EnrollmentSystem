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
            <!-- Row 1: Student Status, Student ID, Student Name -->
            <div class="form-row">
                <div class="form-group">
                    <label for="student-status">Student Status:</label>
                    <span class="static-text" id="student-status">Active</span> <!-- Static Text -->
                </div>

                <div class="form-group">
                    <label for="student-id">Student ID:</label>
                    <span class="static-text" id="student-id">2021012345</span> <!-- Static Text -->
                </div>

                <div class="form-group">
                    <label for="student-name">Student Name:</label>
                    <span class="static-text" id="student-name">John Doe</span> <!-- Static Text -->
                </div>
            </div>

            <!-- Row 2: Checkbox for Irregular -->
            <div class="form-row">
                <div class="form-group">
                    <input type="checkbox" id="irregular-check">
                    <label for="irregular-check">Check if Irregular</label>
                </div>
            </div>

            <!-- Row 3: Course and Major (merged on same row) -->
            <div class="form-row form-row-double">
                <div class="form-group">
                    <label>Course:</label>
                    <span class="static-text">Bachelor of Science in Information Technology</span> <!-- Static Text -->
                </div>

                <div class="form-group">
                    <label>Major:</label>
                    <span class="static-text">Software Engineering</span> <!-- Static Text -->
                </div>
            </div>

            <!-- Row 4: Year Level Entry, Current Year, School Year Term (merged on same row) -->
            <div class="form-row form-row-triple">
                <div class="form-group">
                    <label for="year-level">Year Level Entry:</label>
                    <span class="static-text" id="year-level">2nd</span> <!-- Static Text -->
                </div>

                <div class="form-group">
                    <label>Cur. Year:</label>
                    <span class="static-text">2018 - 2019</span> <!-- Static Text -->
                </div>

                <div class="form-group">
                    <label>School Year Term:</label>
                    <span class="static-text">2023 - 2024, Summer</span> <!-- Static Text -->
                </div>
            </div>
            <!--Subject Available-->
            <section class="section-header text-sm mt-6">
                <h1>SUBJECT LIST ALLOWED TO ADD</h1>
            </section>
            <div class="flex items-center">
                <h1>
                    <label for="student-status">Maximum units the Student can take:</label>
                    <span class="static-text font-bold mr-20" id="student-status">18.0</span> <!-- Static Text -->

                    <label for="student-load">Total Student Load:</label>
                    <span class="static-text font-bold mr-20" id="student-load">3.0</span> <!-- Static Text -->

                    <!-- New text label and dropdown -->
                    <label for="schedule-type">Block:</label>
                    <select id="schedule-type" class="ml-4 px-4 py-2 border border-gray-300 rounded">
                        <option value="default"></option>
                        <option value="option1">3BSIT-1</option>
                        <option value="option2">3BSIT-2</option>
                    </select>
                </h1>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead style="background-color: #174069;" class="text-white">
                        <tr>
                            <th class="py-2 px-4 border">YEAR</th>
                            <th class="py-2 px-4 border">TERM</th>
                            <th class="py-2 px-4 border" style="width: 350px;">SUBJECT CODE</th>
                            <th class="py-2 px-4 border" style="width: 800px;">SUBJECT TITLE</th>
                            <th class="py-2 px-4 border">LEC/LAB UNITS</th>
                            <th class="py-2 px-4 border" style="width: 200px;">UNITS TO TAKE</th>
                            <th class="py-2 px-4 border" style="width: 300px;">SECTION</th>
                            <th class="py-2 px-4 border" style="width: 500px;">SCHEDULE</th>
                            <th class="py-2 px-4 border">SELECT</th>
                            <th class="py-2 px-4 border">ASSIGN SECTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">4</td>
                            <td class="py-2 px-4 border text-center">2</td>
                            <td class="py-2 px-4 border text-center">CIT321-18</td>
                            <td class="py-2 px-4 border text-center">Capstone Project 1</td>
                            <td class="py-2 px-4 border text-center">3.0/0.0</td>
                            <td class="py-2 px-4 border text-center">3.0</td>
                            <td class="py-2 px-4 border text-center">3BSIT-2</td>
                            <td class="py-2 px-4 border text-center">W 9:00AM-12:00PM</td>
                            <td class="py-2 px-4 border text-center"><input type="checkbox"></td>
                            <td class="py-2 px-4 border text-center">
                                <a href="#" onclick="openPopup()">
                                    <i class="bi bi-calendar-check cursor-pointer"></i> <!-- Added cursor pointer -->
                                </a>
                            </td>
                        </tr>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">4</td>
                            <td class="py-2 px-4 border text-center">2</td>
                            <td class="py-2 px-4 border text-center">CIT322-18</td>
                            <td class="py-2 px-4 border text-center">Integrative Programming and Technologies</td>
                            <td class="py-2 px-4 border text-center">2.0/0.0</td>
                            <td class="py-2 px-4 border text-center">2.0</td>
                            <td class="py-2 px-4 border text-center">3BSIT-2</td>
                            <td class="py-2 px-4 border text-center">TH 9:00AM-12:00PM</td>
                            <td class="py-2 px-4 border text-center"><input type="checkbox"></td>
                            <td class="py-2 px-4 border text-center">
                                <a href="#" onclick="openPopup()">
                                    <i class="bi bi-calendar-check cursor-pointer"></i> <!-- Added cursor pointer -->
                                </a>
                            </td>
                        </tr>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">4</td>
                            <td class="py-2 px-4 border text-center">2</td>
                            <td class="py-2 px-4 border text-center">CIT322-18</td>
                            <td class="py-2 px-4 border text-center">Integrative Programming and Technologies</td>
                            <td class="py-2 px-4 border text-center">2.0/0.0</td>
                            <td class="py-2 px-4 border text-center">2.0</td>
                            <td class="py-2 px-4 border text-center">3BSIT-2</td>
                            <td class="py-2 px-4 border text-center">TH 9:00AM-12:00PM</td>
                            <td class="py-2 px-4 border text-center"><input type="checkbox"></td>
                            <td class="py-2 px-4 border text-center">
                                <a href="#" onclick="openPopup()">
                                    <i class="bi bi-calendar-check cursor-pointer"></i> <!-- Added cursor pointer -->
                                </a>
                            </td>
                        </tr>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">4</td>
                            <td class="py-2 px-4 border text-center">2</td>
                            <td class="py-2 px-4 border text-center">CIT322-18</td>
                            <td class="py-2 px-4 border text-center">Integrative Programming and Technologies</td>
                            <td class="py-2 px-4 border text-center">2.0/0.0</td>
                            <td class="py-2 px-4 border text-center">2.0</td>
                            <td class="py-2 px-4 border text-center">3BSIT-2</td>
                            <td class="py-2 px-4 border text-center">TH 9:00AM-12:00PM</td>
                            <td class="py-2 px-4 border text-center"><input type="checkbox"></td>
                            <td class="py-2 px-4 border text-center">
                                <a href="#" onclick="openPopup()">
                                    <i class="bi bi-calendar-check cursor-pointer"></i> <!-- Added cursor pointer -->
                                </a>
                            </td>
                        </tr>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">4</td>
                            <td class="py-2 px-4 border text-center">2</td>
                            <td class="py-2 px-4 border text-center">CIT322-18</td>
                            <td class="py-2 px-4 border text-center">Integrative Programming and Technologies</td>
                            <td class="py-2 px-4 border text-center">2.0/0.0</td>
                            <td class="py-2 px-4 border text-center">2.0</td>
                            <td class="py-2 px-4 border text-center"></td>
                            <td class="py-2 px-4 border text-center"></td>
                            <td class="py-2 px-4 border text-center"><input type="checkbox"></td>
                            <td class="py-2 px-4 border text-center">
                                <a href="#" onclick="openPopup()">
                                    <i class="bi bi-calendar-check cursor-pointer"></i> <!-- Added cursor pointer -->
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bottom-btn-group flex justify-end text-center mt-6"> <!-- Added flex and justify-end -->
                <a href="Main.php" style="background-color: #174069;"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 shadow-lg rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Save
                </a>
            </div>

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

        function openPopup() {
            // URL of the page you want to open
            const url = 'popup.php'; // Replace with your popup page URL
            const options = 'width=1200,height=800,resizable=yes,scrollbars=yes'; // Customize the dimensions
            window.open(url, 'PopupWindow', options);
        }
    </script>
</body>

</html>

<style>
    /* General Body Styles */
    body {
        font-family: 'Poppins', Arial, sans-serif;
        background-color: #f7f8fa;
        margin: 0;
        padding: 0;
    }

    /* Breadcrumb styles */
    .breadcrumb-nav {
        margin: 10px 0;
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
        padding: 15px;
        text-align: center;
        margin-bottom: 15px;
    }

    .section-header h1 {
        color: white;
        margin: 0;
        font-size: 24px;
    }

    /* Form Container */
    .form-container {
        max-width: 1400px;
        margin: 20px auto;
        background-color: #f4f8fc;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Form Row */
    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    /* Double row (for Course and Major) */
    .form-row-double {
        display: flex;
        justify-content: space-between;
    }

    /* Triple row (for Year Level Entry, Cur. Year, and School Year Term) */
    .form-row-triple {
        display: flex;
        justify-content: space-between;
    }

    /* Form Group */
    .form-group {
        display: flex;
        flex-direction: column;
        margin-right: 10px;
        flex: 1;
    }

    .form-group label {
        margin-bottom: 5px;
        font-weight: 600;
    }

    .form-group input,
    .form-group select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    /* Static Text (no bold) */
    .form-group .static-text {
        font-weight: normal;
    }

    /* Special Elements */
    .course-info,
    .cur-year,
    .school-year-term {
        font-size: 16px;
    }

    /* Checkbox Style */
    .form-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 5px;
    }

    /* Placeholder Content */
    .placeholder-content {
        height: 150px;
        border: 1px solid #ccc;
        background-color: white;
        border-radius: 4px;
        overflow-y: auto;
        padding: 10px;
    }

    /* Adjustments for smaller screens */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .form-group {
            margin-right: 0;
        }

        .section-header h1 {
            font-size: 20px;
        }
    }
</style>