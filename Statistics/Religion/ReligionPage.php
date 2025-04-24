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
    <title>Religion Page</title>
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
                <li><a href="Main5.php">Religion</a></li>
                <li class="active">Religion-Statistics</li>

            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>STATISTICS-RELIGION PAGE</h1>
        </section>

        <!-- Table -->
        <div class="container mx-auto mt-10">
            <div class="overflow-x-auto mt-9" id="printableTable">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th colspan="1" rowspan="2" class="py-2 px-6">College Programs</th>
                            <th colspan="3">NEW</th>
                            <th colspan="3">OLD</th>
                            <th rowspan="2" class="py-1 px-6">Total INC</th>
                            <th rowspan="2" class="py-1 px-6">Total Non-INC</th>
                            <th rowspan="2" class="py-1 px-6">Grand Total</th>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm ">
                            <th>INC</th>
                            <th>Non-INC</th>
                            <th>Total</th>
                            <th>INC</th>
                            <th>Non-INC</th>
                            <th>Total</th>
                        </tr>
                        </tr>
                    </thead>
                    <tr class="uppercase text-sm leading-normal">
                        <th colspan="10" class="py-2 px-4 text-left text-white" style="background-color: #174069;">COLLEGE OF INFORMATICS AND COMPUTING STUDIES</th>
                    </tr>
                    <tbody class="text-gray-600 text-sm">
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">Bachelor of Science in Information Technology</td>
                            <td>40</td>
                            <td>0</td>
                            <td>40</td>
                            <td>40</td>
                            <td>0</td>
                            <td>40</td>
                            <td>80</td>
                            <td>0</td>
                            <td>80</td>

                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">Bachelor of Science in Information System</td>
                            <td>30</td>
                            <td>10</td>
                            <td>40</td>
                            <td>39</td>
                            <td>1</td>
                            <td>40</td>
                            <td>79</td>
                            <td>1</td>
                            <td>80</td>
                        </tr>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                            <th class="text-right"><b>Subtotal:</b></th>
                            <th class="text-center lowercase"><b>70</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>10</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>80</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>79</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>1</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>80</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>159</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>1</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>160</b></th> <!-- Example subtotal value -->
                        </tr>

                        <!-- Add more rows as needed -->
                    </tbody>
                    <tr class="uppercase text-sm leading-normal">
                        <th colspan="10" class="py-2 px-4 text-left text-white" style="background-color: #174069;">COLLEGE OF ACCOUNTANCY</th>
                    </tr>
                    <tbody class="text-gray-600 text-sm">
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">Bachelor of Science in Accountancy</td>
                            <td>40</td>
                            <td>0</td>
                            <td>40</td>
                            <td>40</td>
                            <td>0</td>
                            <td>40</td>
                            <td>80</td>
                            <td>0</td>
                            <td>80</td>

                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">Bachelor of Science in Accounting Information System</td>
                            <td>30</td>
                            <td>10</td>
                            <td>40</td>
                            <td>39</td>
                            <td>1</td>
                            <td>40</td>
                            <td>79</td>
                            <td>1</td>
                            <td>80</td>
                        </tr>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                            <th class="text-right"><b>Subtotal:</b></th>
                            <th class="text-center lowercase"><b>70</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>10</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>80</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>79</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>1</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>80</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>159</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>1</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>160</b></th> <!-- Example subtotal value -->
                        </tr>

                        <!-- Add more rows as needed -->
                    </tbody>
                    <tr class="uppercase text-sm leading-normal">
                        <th colspan="10" class="py-2 px-4 text-left text-white" style="background-color: #174069;">COLLEGE OF AGRICULTURE</th>
                    </tr>
                    <tbody class="text-gray-600 text-sm">
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">Bachelor of Science in Agriculture</td>
                            <td>40</td>
                            <td>0</td>
                            <td>40</td>
                            <td>40</td>
                            <td>0</td>
                            <td>40</td>
                            <td>80</td>
                            <td>0</td>
                            <td>80</td>
                        </tr>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                            <th class="text-right"><b>Subtotal:</b></th>
                            <th class="text-center lowercase"><b>40</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>0</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>40</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>40</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>0</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>40</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>80</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>0</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>80</b></th> <!-- Example subtotal value -->
                        </tr>
                        <tr class="bg-gray-200 text-red-700 uppercase text-sm">
                            <th class="text-right"><b>GRAND TOTAL: </b></th>
                            <th class="text-center lowercase"><b>180</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>20</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>200</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>198</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>3</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>200</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>398</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>3</b></th> <!-- Example subtotal value -->
                            <th class="text-center lowercase"><b>400</b></th> <!-- Example subtotal value -->
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center mt-6">
                <a href="Main5.php" class="bg-blue-900 text-white rounded-md p-2">Back</a>
                <button onclick="printOnlyTable()" class="ml-4 bg-red-500 text-white rounded-md p-2">Print</button>
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

            function printOnlyTable() {
                // Get the content of the table
                var printContents = document.getElementById('printableTable').innerHTML;

                // Save the current page content
                var originalContents = document.body.innerHTML;

                // Replace the body content with the table
                document.body.innerHTML = printContents;

                // Print the page (now only the table is displayed)
                window.print();

                // Restore the original page content after printing
                document.body.innerHTML = originalContents;

                // Reload the page to restore the JavaScript functionality
                location.reload();
            }
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

    table,
    th,
    td {
        border: 1px solid black;
        /* Black border for all table cells */
    }

    th,
    td {
        padding: 10px;
        /* Adds padding for better readability */
        text-align: center;
    }
</style>
</body>

</html>