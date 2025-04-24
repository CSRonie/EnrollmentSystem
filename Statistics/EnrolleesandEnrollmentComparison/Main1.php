<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Registrar']);

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
    <title>Enrollees and Enrollment-Statistics</title>
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
                <li><a href="#">Statistics</a></li>
                <li class="active">Enrollees and Enrollment Comparison</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>STATISTICS-ENROLLEES AND ENROLLMENT COMPARISON PAGE</h1>
        </section>

        <!-- Form container -->
        <div class="form-container">
            <form action="#">
                <div class="form-group" style="align-items: center;">
                    <label for="student-status">STUDENT STATUS</label>
                    <select id="student-status" style="width: 250px;">
                        <option value="" disabled selected>Select Student Status</option>
                        <option value="1">All</option>
                        <option value="2">Change Program</option>
                        <option value="3">Cross Enrollee</option>
                        <option value="4">New Student</option>
                        <option value="5">Old Student</option>
                        <option value="6">Second Program</option>
                        <option value="7">Second Program(Old Student)</option>
                        <option value="8">Transferee</option>
                    </select>

                    <h4 style="margin-top: 25px; margin-bottom: 15px; margin-left: 50px;"><b>SHOW BY:</b></h4>
                    <div class="form-show" style="margin-left: 70px; margin-right: 70px;">
                        <label for="college" style="justify-content: center;">College / Department</label>
                        <select id="college">
                            <option value="" disabled selected>Select College / Department</option>
                            <option value="CICS">College of Informatics and Computing Studies</option>
                            <option value="COA">College of Accountancy</option>
                        </select>

                        <label for="course">Program</label>
                        <select id="course">
                            <option value="" disabled selected>Select Program</option>
                            <option value="">BSIT</option>
                            <option value="">BSIS</option>
                        </select>

                        <label for="major">Major</label>
                        <select id="major">
                            <option value="" disabled selected>Select Major</option>
                        </select>

                        <label for="year-level">Year Level</label>
                        <select id="year-level">
                            <option value="" disabled selected>Select Year Level</option>
                            <option value="freshman">1st Year</option>
                            <option value="sophomore">2nd Year</option>
                            <option value="junior">3rd Year</option>
                            <option value="senior">4th Year</option>
                        </select>

                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>

                        <label for="age">Age</label>
                        <input type="number" id="age" placeholder="Enter Age" min="15">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="form-actions mt-8 flex justify-center">
                    <button type="button" id="show-student-status" class="bg-blue-900 text-white rounded-md">No. of Students based on Status</button>
                    <button type="button" id="show-enrollment-comparison" class="ml-4 bg-blue-900 text-white rounded-md">Enrollment Comparison</button>
                </div>

                <!-- Additional input fields for No. of Students based on Status, initially hidden -->
                <div id="additional-fields-status" class="mt-4" style="display: none; font-size: 14px;">
                    <div class="flex flex-wrap gap-4 justify-center">
                        <div>
                            <label for="from-date">From</label>
                            <input type="date" id="from-date" class="border p-2 rounded-md w-full">
                        </div>
                        <div>
                            <label for="to-date">To</label>
                            <input type="date" id="to-date" class="border p-2 rounded-md w-full">
                        </div>
                        <div>
                            <label for="semester">Semester</label>
                            <select id="semester" class="border p-2 rounded-md w-full">
                                <option value="" disabled selected>Select Semester</option>
                                <option value="1st">1st Sem</option>
                                <option value="2nd">2nd Sem</option>
                                <option value="summer">Summer</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 justify-center mt-4">
                        <div>
                            <label for="sy-from">Offering SY From</label>
                            <input type="text" id="sy-from" placeholder="Enter start school year" class="border p-2 rounded-md w-full">
                        </div>
                        <div>
                            <label for="sy-to">Offering SY To</label>
                            <input type="text" id="sy-to" placeholder="Enter end school year" class="border p-2 rounded-md w-full">
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs text-center mt-2">(Keep SY From or SY To empty to ignore SY offering info)</p>
                    <div class="flex justify-center mt-4">
                        <button type="button" onclick="redirectToEnrollees()" class="bg-blue-900 text-white rounded-md p-2">Proceed</button>
                    </div>
                </div>

                <!-- Additional input fields for Enrollment Comparison, initially hidden -->
                <div id="additional-fields-comparison" class="mt-4" style="display: none; font-size: 14px;">
                    <div class="flex flex-wrap gap-4 justify-center">
                        <div>
                            <label for="previous-year">Previous Year</label>
                            <input type="text" id="previous-year" placeholder="Enter previous year" class="border p-2 rounded-md w-full">
                        </div>
                        <div>
                            <label for="previous-term">Previous Semester</label>
                            <select id="previous-term" class="border p-2 rounded-md w-full">
                                <option value="" disabled selected>Select Previous Semester</option>
                                <option value="1st">1st Sem</option>
                                <option value="2nd">2nd Sem</option>
                                <option value="summer">Summer</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <div>
                            <label for="current-year">Current Year</label>
                            <input type="text" id="current-year" placeholder="Enter current year" class="border p-2 rounded-md w-full">
                        </div>
                        <div>
                            <label for="current-term">Current Semester</label>
                            <select id="current-term" class="border p-2 rounded-md w-full">
                                <option value="" disabled selected>Select Current Semester</option>
                                <option value="1st">1st Sem</option>
                                <option value="2nd">2nd Sem</option>
                                <option value="summer">Summer</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-center mt-4">
                        <button type="button" onclick="redirectToComparison()" class="bg-blue-900 text-white rounded-md p-2">Proceed</button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            // Show/hide logic for additional input fields
            document.getElementById('show-student-status').addEventListener('click', function() {
                const additionalFieldsStatus = document.getElementById('additional-fields-status');
                const additionalFieldsComparison = document.getElementById('additional-fields-comparison');
                additionalFieldsStatus.style.display = additionalFieldsStatus.style.display === 'none' ? 'block' : 'none';
                additionalFieldsComparison.style.display = 'none'; // Hide the other section
            });

            document.getElementById('show-enrollment-comparison').addEventListener('click', function() {
                const additionalFieldsComparison = document.getElementById('additional-fields-comparison');
                const additionalFieldsStatus = document.getElementById('additional-fields-status');
                additionalFieldsComparison.style.display = additionalFieldsComparison.style.display === 'none' ? 'block' : 'none';
                additionalFieldsStatus.style.display = 'none'; // Hide the other section
            });

            // Redirect to enrollees page when "Proceed" button is clicked
            function redirectToEnrollees() {
                window.location.href = 'EnrolleesPage.php';
            }

            // Redirect to enrollees page when "Proceed" button is clicked
            function redirectToComparison() {
                window.location.href = 'EnrollmentComparison.php';
            }

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
        width: 80%;
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
        margin-top: 5px;
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