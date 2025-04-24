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
    header("Location: http://localhost/capst/index.php");
    exit();
}

// Fetch rooms
$roomsQuery = "SELECT id, room_number FROM rooms WHERE status IS NULL OR status != 'Unavailable'";
$roomsResult = $conn->query($roomsQuery);

// Fetch programs
$programsQuery = "SELECT course_code, course_name FROM courses";
$programsResult = $conn->query($programsQuery);

// Fetch curriculum years (this depends on the program selected, should be handled via JavaScript)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Schedule Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="main-content" id="mainContent">
        <section class="section-header text-sm md:text-xl">
            <h1>SCHEDULING PAGE</h1>
        </section>

        <div class="form-container">
            <form>
                <!-- Program Offered -->
                <div class="mb-4">
                    <label for="program-offered" class="block font-bold text-sm mb-2">PROGRAM OFFERED<span class="text-red-500">*</span></label>
                    <select id="program-offered" class="w-full p-2 border border-gray-300 rounded">
                        <option value="" disabled selected>Select Program</option>
                        <?php while ($row = $programsResult->fetch_assoc()): ?>
                            <option value="<?= $row['course_code']; ?>"><?= $row['course_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Curriculum Year -->
                <div class="mb-4 flex items-center space-x-2">
                    <div class="flex-1">
                        <label for="year-term-from" class="block font-bold text-sm mb-2">CURRICULUM YEAR</label>
                        <div class="flex items-center">
                            <select id="year-term-from" class="w-full p-2 border border-gray-300 rounded">
                                <option value="" disabled selected>Select Year</option>
                            </select>
                            <span class="mx-2 font-bold">TO</span>
                            <select id="year-term-to" class="w-full p-2 border border-gray-300 rounded">
                                <option value="" disabled selected>Select Year</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Room Number -->
                <div class="mb-4">
                    <label for="room-number" class="block font-bold text-sm mb-2">ROOM NUMBER</label>
                    <select id="room-number" class="w-full p-2 border border-gray-300 rounded">
                        <option value="" disabled selected>Select Room</option>
                    </select>
                </div>
                <!-- Date and Time Picker -->
                <div class="mb-4">
                    <label for="schedule-datetime" class="block font-bold text-sm mb-2">SCHEDULE DATE & TIME<span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="schedule-datetime" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <!-- Proceed Button -->
                <div class="flex justify-center">
                    <a href="index.php" type="submit" style="background-color: #174069;"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 shadow-lg">
                        Proceed
                    </a>
                </div>
            </form>
        </div>
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

        // const programOfferedDropdown = document.getElementById('program-offered');
        // const yearFromDropdown = document.getElementById('year-term-from');
        // const yearToDropdown = document.getElementById('year-term-to');

        // const curriculumYears = {
        //     BSCS: [{
        //             from: "2004",
        //             to: "2005"
        //         },
        //         {
        //             from: "2012",
        //             to: "2013"
        //         },
        //         {
        //             from: "2018",
        //             to: "2019"
        //         }
        //     ],
        //     BSEE: [{
        //             from: "1998",
        //             to: "1999"
        //         },
        //         {
        //             from: "2002",
        //             to: "2003"
        //         },
        //         {
        //             from: "2007",
        //             to: "2008"
        //         },
        //         {
        //             from: "2012",
        //             to: "2013"
        //         },
        //         {
        //             from: "2018",
        //             to: "2019"
        //         }
        //     ],
        //     BSECE: [{
        //             from: "1998",
        //             to: "1999"
        //         },
        //         {
        //             from: "2002",
        //             to: "2003"
        //         },
        //         {
        //             from: "2007",
        //             to: "2008"
        //         },
        //         {
        //             from: "2012",
        //             to: "2013"
        //         },
        //         {
        //             from: "2018",
        //             to: "2019"
        //         }
        //     ],
        //     GameDev: [{
        //             from: "2015",
        //             to: "2016"
        //         },
        //         {
        //             from: "2018",
        //             to: "2019"
        //         }
        //     ],
        //     Entrep: [{
        //             from: "2014",
        //             to: "2015"
        //         },
        //         {
        //             from: "2018",
        //             to: "2019"
        //         }
        //     ],
        //     BSIE: [{
        //             from: "1998",
        //             to: "1999"
        //         },
        //         {
        //             from: "2002",
        //             to: "2003"
        //         },
        //         {
        //             from: "2007",
        //             to: "2008"
        //         },
        //         {
        //             from: "2012",
        //             to: "2013"
        //         },
        //         {
        //             from: "2018",
        //             to: "2019"
        //         }
        //     ],
        //     BSIS: [{
        //             from: "2015",
        //             to: "2016"
        //         },
        //         {
        //             from: "2018",
        //             to: "2019"
        //         }
        //     ],
        //     BSIT: [{
        //             from: "2015",
        //             to: "2016"
        //         },
        //         {
        //             from: "2019",
        //             to: "2020"
        //         },
        //         {
        //             from: "2020",
        //             to: "2021"
        //         }
        //     ]
        // };

        // programOfferedDropdown.addEventListener('change', function() {
        //     const selectedProgram = this.value;

        //     yearFromDropdown.innerHTML = '<option value="" disabled selected>Select</option>';
        //     yearToDropdown.innerHTML = '<option value="" disabled selected>Select</option>';

        //     if (curriculumYears[selectedProgram]) {
        //         curriculumYears[selectedProgram].forEach(year => {

        //             const optionFrom = document.createElement('option');
        //             optionFrom.value = year.from;
        //             optionFrom.textContent = year.from;
        //             yearFromDropdown.appendChild(optionFrom);

        //             // Populate "Year To" dropdown
        //             const optionTo = document.createElement('option');
        //             optionTo.value = year.to;
        //             optionTo.textContent = year.to;
        //             yearToDropdown.appendChild(optionTo);
        //         });
        //     }
        // });


        document.addEventListener('DOMContentLoaded', function() {
            const programOffered = document.getElementById('program-offered');
            const curriculumYearFrom = document.getElementById('year-term-from');
            const curriculumYearTo = document.getElementById('year-term-to');
            const roomNumber = document.getElementById('room-number');

            programOffered.addEventListener('change', function() {
                const selectedProgram = this.value;

                // Clear existing options
                curriculumYearFrom.innerHTML = '<option value="" disabled selected>Select Year</option>';
                curriculumYearTo.innerHTML = '<option value="" disabled selected>Select Year</option>';
                roomNumber.innerHTML = '<option value="" disabled selected>Select Room</option>';

                if (selectedProgram) {
                    // Fetch curriculum years
                    fetch(`../RoomScheduleManager/pd/fetch_curriculum_year.php?course_code=${encodeURIComponent(selectedProgram)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(year => {
                                    const optionFrom = document.createElement('option');
                                    optionFrom.value = year.start;
                                    optionFrom.textContent = year.start;

                                    const optionTo = document.createElement('option');
                                    optionTo.value = year.end || year.start; // Use end if available, otherwise use start
                                    optionTo.textContent = year.end || year.start;

                                    curriculumYearFrom.appendChild(optionFrom);
                                    curriculumYearTo.appendChild(optionTo);
                                });
                            } else {
                                const noDataOption = document.createElement('option');
                                noDataOption.value = '';
                                noDataOption.textContent = 'No curriculum years available';
                                curriculumYearFrom.appendChild(noDataOption);
                                curriculumYearTo.appendChild(noDataOption);
                            }
                        });

                    // Fetch rooms
                    fetch(`../RoomScheduleManager/pd/fetch_room.php?course_code=${encodeURIComponent(selectedProgram)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(room => {
                                    const option = document.createElement('option');
                                    option.value = room.id;
                                    option.textContent = room.number;

                                    roomNumber.appendChild(option);
                                });
                            } else {
                                const noDataOption = document.createElement('option');
                                noDataOption.value = '';
                                noDataOption.textContent = 'No rooms available';
                                roomNumber.appendChild(noDataOption);
                            }
                        });
                }
            });
        });
    </script>

    </div>
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
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 80%;
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