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
    <title>Religion-Statistics</title>
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
                <li class="active">Religion-Statistics</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>STATISTICS-RELIGIONS PAGE</h1>
        </section>

        <!-- Form container -->
        <div class="form-container">
            <form action="#">
                <!-- School Year and Term -->
                <div class="form-group" style="display: flex; justify-content:left;">
                    <div>
                        <label for="year" class="text-sm font-medium text-gray-700">School Year</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="year1" name="year1" placeholder="Enter" class="form-input px-3 py-2 border border-gray-300 rounded-md">
                            <span class="mt-2">to</span>
                            <input type="text" id="year2" name="year2" placeholder="Enter" class="form-input px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div>
                        <label for="term" class="text-sm font-medium text-gray-700" style="margin-left: 15px;">Semester</label>
                        <select id="term" name="term" class="form-select px-3 py-2 border border-gray-300 rounded-md" style="margin-left: 10px ;">
                            <option value="">1st Sem</option>
                            <option value="">2nd Sem</option>
                        </select>
                    </div>
                </div>

                <!-- Date -->
                <div class="form-group" style="display: flex; justify-content: space-between; gap: 20px;">
                    <div style="flex: 1;">
                        <label for="date" class="text-sm font-medium text-gray-700">Date as of: </label>
                        <input type="date" id="date" name="date" placeholder="date" class="form-input w-16 px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>
                <!-- Level -->
                <div class="form-group" style="display: flex; justify-content: space-between; gap: 20px;">
                    <div style="flex: 1;">
                        <label for="yearlevel" class="text-sm font-medium text-gray-700">Level</label>
                        <select id="yearlevel" name="yearlevel" class="form-select px-3 py-2 border border-gray-300 rounded-md w-full">
                            <option value="">All</option>
                            <option value="">1st Year</option>
                            <option value="">2nd Year</option>
                            <option value="">3rd Year</option>
                            <option value="">4th Year</option>
                            <option value="">5th Year</option>
                            <option value="">6th Year</option>
                        </select>
                    </div>
                </div>

                <!-- Proceed Button -->
                <div class="flex justify-center mt-4">
                    <button type="button" onclick="redirectToReligion()" class="bg-blue-900 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">Proceed</button>
                </div>
            </form>
        </div>


        <!-- Navbar script -->
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

            function redirectToReligion() {
                event.preventDefault(); // Prevent form from submitting (in case of form submission)
                window.location.href = 'ReligionPage.php'; // Redirect to religion_page.html
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

    /* Button styles */
    .form-actions button {
        padding: 12px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

</html>