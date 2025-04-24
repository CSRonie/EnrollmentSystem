<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require '../../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Building Manager']);
var_dump($_SESSION); // Check if role_as is set properly
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
    <title>Schedule Document</title>
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
                <li><a href="#">Rooms Monitoring</a></li>
                <li><a href="#">Room Schedule Manager</a></li>
                <li class="active">Scheduling page</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>Class Schedule Details</h1>
        </section>

        <div class="flex items-center">
            <h1 class="text-lg font-semibold">
                Room Number: <span class="font-bold">B235</span>
                <span class="mr-16"></span>
                Location: <span class="font-bold">IS Building</span>
            </h1>
        </div>
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold">
                Section: <span class="font-bold">BSIT-3</span>
                <span class="mr-24"></span>
                Year/Term: <span class="font-bold">2024-2025/1st Semester</span>
            </h1>

            <div class="flex items-center">
                <a href="#"
                    class="bg-red-600 text-white p-1 md:p-2 text-sm md:text-lg rounded-full flex items-center">
                    <i class="bi bi-printer mr-2 text-lg"></i> <!-- Larger icon -->
                    Print
                </a>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">

            <div style="background-color: #174069;" class="text-white p-3 text-center font-bold text-xl rounded-t-md">
                Class Details
            </div>


            <table class="min-w-full table-auto border-collapse">
                <thead style="background-color: #174069;" class="text-white">
                    <tr>
                        <th class="px-4 py-2 border border-orange-500 text-left" style="width: 200px;">Monday</th>
                        <th class="px-4 py-2 border border-orange-500 text-left" style="width: 200px;">Tuesday</th>
                        <th class="px-4 py-2 border border-orange-500 text-left" style="width: 200px;">Wednesday</th>
                        <th class="px-4 py-2 border border-orange-500 text-left" style="width: 200px;">Thursday</th>
                        <th class="px-4 py-2 border border-orange-500 text-left" style="width: 200px;">Friday</th>
                        <th class="px-4 py-2 border border-orange-500 text-left" style="width: 200px;">Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white">
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300">
                            7:00 am to 10:00 am
                            1BSCS-2
                            Numerical Methods
                            (CCS123-18)</td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                        </td>
                    </tr>
                    <tr class="bg-white">
                        <td class="px-4 py-2 border border-gray-300">
                            8:00 am to 10:00 am
                            1BSCS-1
                            Intermediate Programming
                            (CCC121-18)</td>
                        <td class="px-4 py-2 border border-gray-300">
                            8:00 am to 10:00 am
                            1BSIT-2
                            Intermediate Programming
                            (CCC121-18)</td>
                        <td class="px-4 py-2 border border-gray-300">
                            8:00 am to 10:00 am
                            1BSIT-5 FREE
                            Intermediate Programming
                            (CCC121-18)</td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300">
                            8:00 am to 10:00 am
                            2BSIT-4 FREE
                            Operating Systems
                            (CIT222-18)</td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                    </tr>
                    <tr class="bg-white">
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300">
                            1:00 pm to 2:30 pm
                            2BSIT-4 FREE
                            Quantitative Methods
                            (CIS223-18)
                            1:00 pm to 2:30 pm
                            2BSIT-4 FREE
                            Quantitative Methods
                            (CIT225-18)
                        </td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300">
                            1:00 pm to 4:00 pm
                            3BSIT-2
                            Capstone Project 1
                            (CIT321-18)</td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                        <td class="px-4 py-2 border border-gray-300"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="border-b-4 border-black my-4"></div>

        <div class="fixed bottom-6 right-6">
            <a href="search.php" type="submit" style="background-color: #aaa;" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Back
            </a>
        </div>

        <script>
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
<style scoped>
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

    /* 201 File Section */
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
</style>