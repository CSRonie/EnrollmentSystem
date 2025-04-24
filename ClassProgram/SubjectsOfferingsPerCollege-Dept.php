<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Faculty', 'Registrar']);

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
    <title>Subject Offerings Per College</title>
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
    <div id="navbar-placeholder"></div>
    <div class="main-content" id="mainContent">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Enrollment</a></li>
                <li><a href="#">Class Programs</a></li>
                <li class="active">Subject Offering Per College/Department</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>SUBJECT OFFERING PAGE FOR AY : 0000-0000, SEMESTER</h1>
        </section>

        <!-- Form container -->
        <div class="form-container">
            <form action="#">
                <!-- Two-column layout for form fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left column inputs -->
                    <div>
                        <div class="flex">
                            <div class="form-group" style="flex-grow: 1;">
                                <label for="sy">School Offering Year</label>
                                <input type="text" id="sy" placeholder="Enter" required>
                            </div>
                            <div class="label label-input" style="flex-grow: 0.2;">
                                <span>-</span>
                                <input type="text" id="sy2" placeholder="Enter" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="showby">Show By:</label>
                        </div>
                        <div class="form-group">
                            <label for="collegeoffered">College Offered</label>
                            <select id="collegeoffered">
                                <option value="" disabled selected>Select</option>
                                <option value="A">College of Accountancy</option>
                                <option value="B">College of Infomatics and Computing Studies</option>
                                <option value="C">College of Law</option>
                                <option value="D">Integrated School-Junior High School</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject (Enter Sub Code to Select Subject)</label>
                            <input type="text" id="subjectinput">
                        </div>
                    </div>
                    <!-- Right column inputs -->
                    <div>
                        <div class="form-group" style="flex-grow: 0.4;">
                            <label for="semester">Semester</label>
                            <select id="semester" required>
                                <option value="" disabled selected>Select</option>
                                <option value="1">1st Sem</option>
                                <option value="2">2nd Sem</option>
                                <option value="3">3rd Sem</option>
                                <option value="4">4th Sem</option>
                                <option value="5">Summer</option>
                            </select>
                        </div>
                        <div class="empty-row"></div>
                        <div class="form-group">
                            <label for="department">Department</label>
                            <select id="department">
                                <option value="" disabled selected>Select</option>
                                <option value="A">Department 1</option>
                                <option value="B">Department 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subjectselect">(Updates Depending on Input Subject)</label>
                            <select id="collegeoffered">
                                <option value="" disabled selected>Select</option>
                                <option value="A">Subject 1</option>
                                <option value="B">Subject 2</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ADD Button -->
                <div class="form-actions mt-8 flex justify-center">
                    <button type="submit" class="px-6 py-2 bg-blue-900 text-white rounded-md">Proceed</button>
                </div>

                <!-- Table below the ADD Button -->

                <section class="section-header text-sm mt-6">
                    <h1>SUBJECT OFFERED BY COLLEGE</h1>
                </section>
                <table class="min-w-full border border-gray-300">
                    <thead style="background-color: #174069;" class="text-white">
                        <tr>
                            <th class="py-2 px-4 border">COLLEGE OFFERED</th>
                            <th class="py-2 px-4 border">OFFERED BY DEPARTMENT</th>
                            <th class="py-2 px-4 border">SUBJECT CODE</th>
                            <th class="py-2 px-4 border">DESCRIPTION</th>
                            <th class="py-2 px-4 border">UNITS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">CICS</td>
                            <td class="py-2 px-4 border text-center">ALL</td>
                            <td class="py-2 px-4 border text-center">CCL121-18</td>
                            <td class="py-2 px-4 border text-center">Intermediate Programming</td>
                            <td class="py-2 px-4 border text-center">2.0</td>
                        </tr>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                        </tr>
                        <tr class="text-gray-700 bg-white">
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                            <td class="py-2 px-4 border text-center">-----</td>
                        </tr>
                    </tbody>
                </table>
        </div>
        </form>
    </div>



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

        function updateEndYear() {
            const currYearSelect = document.getElementById('currYear');
            const endYearInput = document.getElementById('curryear-end');
            const selectedOption = currYearSelect.options[currYearSelect.selectedIndex];

            if (selectedOption) {
                // Extract the year from the text content
                const startYear = parseInt(selectedOption.textContent);

                if (!isNaN(startYear)) {
                    endYearInput.value = startYear + 1; // Set end year as start year + 1
                } else {
                    endYearInput.value = ""; // Clear if the year is not a number
                }
            } else {
                endYearInput.value = ""; // Clear if no selection
            }
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

    .label input,
    .label select {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        /* Ensure inputs take up full width inside their containers */
    }

    .flex {
        font-weight: bold;
        display: flex;
        gap: 5px;
        /* Maintain close proximity between elements */
        flex-wrap: nowrap;
        /* Prevent wrapping */
        width: 100%;
        /* Ensure the flex container is responsive */
    }


    .ml-1 {
        margin-left: 0;
        /* Remove any additional left margin */
        flex-grow: 1;
        /* Allow input fields to grow as needed */
    }

    .flex-grow {
        flex-grow: 1;
    }

    .empty-row {
        height: 37px;
        /* Adjust the height as needed */
    }

    /* Checkboxes */
    .checkbox-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
    }

    .checkbox-container input {
        margin-right: 5px;
    }

    /* Button styles */
    .form-actions button {
        padding: 12px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .custom-table {
        width: 100%;
        /* Make the table full width */
        border-collapse: collapse;
        /* Remove spacing between cells */
        margin: 20px 0;
        /* Space around the table */
    }

    /* Header styling */
    .custom-table th,
    .custom-table td {
        border: 1px solid #ccc;
        /* Light border for cells */
        padding: 8px;
        /* Padding for cell content */
        text-align: left;
    }

    /* Hover effect for rows */
    .custom-table tbody tr:hover {
        background-color: #f4f8fc;
        /* Light background on hover */
    }

    /* Optional: Responsive design for smaller screens */
    @media (max-width: 600px) {
        .custom-table {
            font-size: 14px;
            /* Smaller font size on mobile */
        }
    }

    /* Checkbox alignment */
    .custom-table input[type="checkbox"] {
        transform: scale(1.2);
        /* Enlarge checkboxes */
        margin: 0 auto;
        /* Center the checkboxes */
        cursor: pointer;
        /* Change cursor to pointer */
    }

    /* Expandable heading styling - matching the table headers */
    .custom-table .expandable-heading {
        cursor: pointer;
        background-color: #f2f2f2;
        font-weight: bold;
        padding: 8px;
        border: 1px solid #ccc;
        /* Same border as other headers */
        text-align: left;
    }

    /* Remove arrows */
    .custom-table .expandable-heading:after {
        content: '';
        /* Remove arrow */
    }

    .custom-table.expanded .expandable-heading:after {
        content: '';
        /* Remove arrow */
    }

    /* Expandable content hidden by default */
    .custom-table .expandable-content {
        display: none;
    }

    /* Expandable content when table is expanded */
    .custom-table.expanded .expandable-content {
        display: table-row-group;
    }

    /* Centered header style */
    .headerbody {
        text-align: center;
        /* Center text horizontally */
        padding: 20px;
        /* Padding around header */
        font-size: 24px;
        /* Header font size */
        width: 100%;
        /* Full width */
        margin: 0 auto;
        /* Center the container */
    }

    /* Remove margin from section header to combine with table */
    .section-header {
        margin-bottom: 0;
        /* Remove margin below section header */
    }

    /* Optional: Space above the table for better separation */
    .custom-table {
        margin-top: 10px;
        /* Adjust margin for separation */
    }
</style>