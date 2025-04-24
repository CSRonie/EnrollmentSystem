<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require '../../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Building Manager']);
var_dump($_SESSION); // Check if role_as is set properly
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Room</title>
    <!-- Load Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Load Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Load Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar placeholder -->
    <div id="navbar-placeholder"></div>

    <!-- Main content -->
    <div class="main-content p-6" id="mainContent">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Enrollment</a></li>
                <li><a href="#">Room Listing ang Reserve</a></li>
                <li class="active">Reserve Room</li>
            </ul>
        </nav>

        <section class="section-header mb-20">
            <h1 class="text-2xl font-semibold">Reserve Room</h1>
        </section>

        <div class="form-container">

            <form action="#">
                <div class="grid grid-cols-2 md:grid-cols-2">

                    <!-- Left Column -->
                    <div class="left-column flex-1">
                        <div class="form-group mb-4">
                            <label for="schoolYear" class="block font-bold text-sm">SCHOOL YEAR<span class="text-red-500">*</span></label>
                            <div class="flex space-x-2">
                                <input type="text" id="year" class="p-2 border border-gray-300 rounded" placeholder="Enter">
                                <input type="text" id="year" class="p-2 border border-gray-300 rounded" placeholder="Enter">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start-date">ACTIVITY DATE<span class="text-red-500">*</span></label>
                            <div class="date-picker">
                                <input type="date" id="start-date" placeholder="Start Date">
                                <input type="date" id="end-date" placeholder="End Date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="room-number">ROOM NUMBER<span class="text-red-500">*</span></label>
                            <input type="text" id="room-number" class="form-control" placeholder="Enter" list="room-numbers">
                            <datalist id="room-numbers">
                                <option value="101">
                                <option value="102">
                                <option value="103">
                                <option value="104">
                                <option value="105">
                                <option value="106">
                                <option value="107">
                                <option value="108">
                                <option value="109">
                                <option value="110">
                                <option value="111">
                            </datalist>
                        </div>
                        <div class="form-group mb-3">
                            <label for="notes" class="form-label">Others</label>
                            <textarea id="notes" class="form-control custom-textarea" rows="5" placeholder="Enter any additional details"></textarea>
                        </div>
                    </div>

                    <div class="right-column">
                        <div class="form-group">
                            <label for="term">TERM<span class="text-red-500">*</span></label>
                            <select id="term">
                                <option value="" disabled selected>Select Term</option>
                                <option value="1st-Semester">1st Semester</option>
                                <option value="2nd-Semester">2nd Semester</option>
                                <option value="summer">Summer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="start-sched">RESERVATION TIME<span class="text-red-500">*</span></label>
                            <div class="schedule-time">
                                <input type="time" id="start-time" placeholder="Start time">
                                <input type="time" id="end-time" placeholder="End time">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions mt-8 flex justify-center space-x-4">
                    <a href="resave.php" class="px-6 py-2 bg-blue-900 text-white rounded-md">SAVE</a>
                    <a href="CreateReserve.php" class="px-6 py-2 bg-blue-900 text-white rounded-md">REFRESH</a>
                </div>


                <div class="fixed bottom-6 right-6">
                    <a href="tableList.php" type="submit" style="background-color: #aaa;"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Back
                    </a>
                </div>
                <script>
                    fetch('../../Components/Navbar.php')
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('navbar-placeholder').innerHTML = data;
                            // Load navbar script after inserting HTML
                            var script = document.createElement('script');
                            script.src = '../../Components/app.js';
                            document.body.appendChild(script);
                        });
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

    .section-header {
        background-color: #174069;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .section-header h1 {
        color: white;
        font-size: 24px;
        margin: 0;
    }

    .form-container {
        width: 100%;
        background-color: #f4f8fc;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;

    }


    .form-group {
        margin-top: 20px;
        margin-bottom: 15px;
        margin-left: 40px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 60%;
        max-width: 400px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 5px;
    }

    .custom-textarea {
        width: 150%;
        margin-top: 5px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #000;
        border-radius: 4px;
        background-color: #ffffff;
    }
</style>