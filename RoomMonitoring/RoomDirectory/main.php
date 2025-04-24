<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require '../../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Registrar', 'Building Manager']);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_room_id'])) {
    $deleteRoomId = intval($_POST['delete_room_id']); // Ensure it's an integer to prevent SQL injection

    // Check if the room exists (optional, for validation)
    $checkQuery = "SELECT id FROM rooms WHERE id = $deleteRoomId";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Delete the room from the database
        $deleteQuery = "DELETE FROM rooms WHERE id = $deleteRoomId";
        if ($conn->query($deleteQuery) === TRUE) {
            $deleteSuccess = true; // Set a success flag
        } else {
            $deleteError = "Failed to delete the room. Error: " . $conn->error;
        }
    } else {
        $deleteError = "Room not found or already deleted.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Load Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Load Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../../styles.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

    <nav id="navbar-placeholder">
        <p>Loading navbar...</p>
    </nav>
    <div class="main-content" id="mainContent">
        <?php if (isset($deleteSuccess) && $deleteSuccess): ?>
            <div class="alert alert-success">
                Room deleted successfully.
            </div>
        <?php elseif (isset($deleteError)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($deleteError); ?>
            </div>
        <?php endif; ?>


        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Enrollment</a></li>
                <li><a href="#">Rooms Monitoring</a></li>
                <li><a href="create.php">Room Directory Creator</a></li>
                <li class="active">List of Existing Rooms</li>
            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>LIST OF EXISTING ROOMS</h1>
        </section>

        <div class="flex items-center justify-between">
            <!-- Left section: Title, chevron, and pen icon -->
            <div class="flex items-center">
                <h1>
                    <button class="bi bi-arrow-clockwise"></button>
                    To Filter room display enter room number starts with
                    <input type="text" class="border rounded px-2 py-1 text-sm" placeholder="Room number" />
                    and click REFRESH to reload the page.
                </h1>
            </div>
            <div class="flex items-center justify-end ">
                <a href="create.php" style="background-color: #174069;"
                    class="bg-blue-900 text-white p-1 md:p-2 text-xs md:text-md flex items-center">+ Add Record
                </a>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full table-auto border-collapse" id="rooms-table">
                <thead style="background-color: #174069;" class="text-white">
                    <tr>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Building</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Floor</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Room #</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Late Inspection Date</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Description</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Type of Room</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Status/Remarks</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">For Subject Assignment</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 200px;">Total of Capacity (No. of Students)</th>
                        <th class="px-4 py-2 border-b-4 border-orange-500 text-left" style="width: 100px;">Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <script>
                        $(document).ready(function() {
                            // Fetch room data from fetch_room.php using AJAX
                            $.ajax({
                                url: 'http://localhost/capst/RoomMonitoring/RoomDirectory/fetch_room.php', // Your API URL
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        var rooms = response.data;
                                        var tableBody = $('#rooms-table tbody');
                                        tableBody.empty(); // Clear existing rows before adding new ones

                                        // Loop through each room in the response data and create a new row for the table
                                        rooms.forEach(function(room) {
                                            var row = '<tr class="bg-white">';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + room.building_code + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + room.floor + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + room.room_number + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + (room.last_inspection_date ? room.last_inspection_date : '') + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + room.description + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + room.room_type + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + room.status + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">';
                                            row += (room.no_subject ? '<a href="#" class="bi bi-x" style="color: red;"></a>' : '<a href="#" class="bi bi-check" style="color: green;"></a>');
                                            row += '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">' + room.room_capacity + '</td>';
                                            row += '<td class="px-4 py-2 border border-gray-300">';
                                            row += '<a href="view.php?id=' + room.id + '" class="bi bi-pencil icon-link" title="Edit"></a>';
                                            row += '<form method="POST" onsubmit="return confirm(\'Are you sure you want to delete this room?\');" style="display: inline-block;">';
                                            row += '<input type="hidden" name="delete_room_id" value="' + room.id + '">';
                                            row += '<button type="submit" class="bi bi-trash icon-link" title="Delete"></button>';
                                            row += '</form>';
                                            row += '</td>';
                                            row += '</tr>';

                                            // Append the new row to the table body
                                            tableBody.append(row);
                                        });
                                    } else {
                                        alert('No rooms found.');
                                    }
                                },
                                error: function() {
                                    alert('Error fetching room data.');
                                }
                            });
                        });
                    </script>
                </tbody>
            </table>
        </div>
        <div class="border-b-4 border-black my-4"></div>

        <!-- Load Navbar and Script -->
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
    .navbar {
        background-image: url('../../images/cover.png');
    }

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
        margin: 0;
    }

    .icon-link {
        margin-right: 15px;
        text-decoration: none;
        color: #000000;
    }
</style>